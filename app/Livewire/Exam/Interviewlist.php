<?php

namespace App\Livewire\Exam;

use App\Jobs\SendOralCodeEmailJob;
use App\Models\AssignedOral;
use App\Models\Candidate;
use App\Models\OralQuestion;
use App\Models\OralScore;
use App\Models\OralScoreSkill;
use App\Models\Venue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str; 
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Models\Position;
use App\Models\PositionSkill;

class Interviewlist extends Component
{
    use WithPagination;
    public $editMode, $viewMode;

    public $archive = false;

    public $candidateSearchMain = '';
    public $candidateSearchModal = '';
    public $filterStatus = 'all'; 
    public $title, $skill_id, $status;
    public $assigned_date, $assigned_time, $venue_id, $candidate_id, $candidate_name, $access_code, $draft_status = 'draft';

    public $venues = [];
    public $selectedcandidate, $assignedoralId;

    public $selected_candidate_name;

    public function render()
    {

        return view('livewire.exam.interviewlist', [
            'assignedOrals' => $this->loadAssignedOrals(),
            'candidates' => $this->getCandidates(),
            'selectedcandidate' => $this->selectedcandidate,            
        ]);
    }

    protected $listeners = ['deleteSkill'];

    public function mount()
    {
        $user = auth()->user();

        if(!$user->can('read reference')){
            abort(403);
        }

        $this->venues = Venue::all();
    }
    
    public function updatingFilterStatus()
    {
        $this->resetPage(); 
    }

    public function updatedCandidateSearchMain()
    {
        $this->resetPage('assignedoralsPage');
    }

    public function updatedCandidateSearchModal()
    {
        $this->resetPage('candidateModalPage');
    }

    public function rules()
    {

    }

    public function loadAssignedOrals()
    {
        
        return AssignedOral::with(['candidate', 'venue'])
            ->selectRaw('assigned_orals.*, 
                        DATEDIFF(CURRENT_DATE, CONCAT(assigned_orals.assigned_date, " ", assigned_orals.assigned_time)) AS aging_days')
            ->when($this->candidateSearchMain, function ($query) {
                $query->whereHas('candidate', function ($q) {
                    $q->where('fullname', 'like', '%' . $this->candidateSearchMain . '%');
                });
            })
            ->when($this->filterStatus !== 'all', function ($query) {
                $query->where('draft_status', $this->filterStatus);
            })
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'assignedoralsPage');
    }

    public function createAssignedOral()
    {
        try {
            $this->access_code = $this->generateUniqueAccessCode();
            $newAssignedId = null;

            DB::transaction(function () use (&$newAssignedId) {
                $assignedoral = new AssignedOral();
                $assignedoral->candidate_id = $this->selectedcandidate['id'];
                $assignedoral->venue_id = $this->venue_id;
                $assignedoral->assigned_date = $this->assigned_date;
                $assignedoral->assigned_time = $this->assigned_time;
                $assignedoral->draft_status = $this->draft_status;
                $assignedoral->access_code = $this->access_code;
                $assignedoral->save();

                $newAssignedId = $assignedoral->id;

                $oralScore = new OralScore();
                $oralScore->assigned_oral_id = $assignedoral->id;
                $oralScore->save();

                $candidate = Candidate::findOrFail($this->selectedcandidate['id']);
                $position = Position::find($candidate->position_id);

                if ($position && in_array($position->item, [8, 10])) {
                    Log::info('Candidate\'s position item is 8 or 10', [
                        'candidate_id' => $candidate->id,
                        'position_id' => $position->id,
                        'item' => $position->item,
                    ]);
                }

                
                //emailing
                if (isset($assignedoral) && isset($candidate)) {
                    SendOralCodeEmailJob::dispatch($assignedoral, $candidate);
                }
            });

            // $this->clear();
            return redirect()->route('exam.oralscheduledquestions', $newAssignedId);
        } catch (\Exception $e) {
            Log::error('Error creating assigned oral: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'data' => [
                    'candidate' => $this->selectedcandidate,
                    'venue_id' => $this->venue_id,
                    'assigned_date' => $this->assigned_date,
                    'assigned_time' => $this->assigned_time,
                    'draft_status' => $this->draft_status,
                ]
            ]);

            $this->dispatch('error', 'An error occurred while creating the schedule.');
        }
    }

    public function updateOralQuestion($assignedInterviewId)
    {
        return redirect()->route('exam.oralscheduledquestionsupdate', $assignedInterviewId);
    }

    private function loadDropdownData()
    {
        $this->venues = Venue::all();
    }

    protected function generateUniqueAccessCode()
    {
        do {
            $code = Str::upper(Str::random(5));
        } while (AssignedOral::where('access_code', $code)->exists());

        return $code;
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
        $this->loadDropdownData();
    }

    private function loadAssignedOralData($assignedOralId, $mode = 'edit')
    {
        $this->loadDropdownData();

        $assigned_oral = AssignedOral::with('candidate')->findOrFail($assignedOralId);

        $this->fill([
            'selected_candidate_id' => $assigned_oral->candidate_id,
            'selected_candidate_name' => $assigned_oral->candidate->fullname ?? '',
            'draft_status' => $assigned_oral->draft_status,
            'assigned_date' => $assigned_oral->assigned_date,
            'assigned_time' => $assigned_oral->assigned_time,
            'venue_id' => $assigned_oral->venue_id,
            'assignedoralId' => $assigned_oral->id,
        ]);

        $this->assigned_oral_id = $assigned_oral->id;

        $this->editMode = false;
        $this->viewMode = false;

        if ($mode === 'edit') {
            $this->editMode = true;
        } elseif ($mode === 'view') {
            $this->viewMode = true;
        }

        $this->dispatch('show-assignedOralModal');
    }

    public function readAssignedOral($assignedOralId)
    {
        $this->loadAssignedOralData($assignedOralId, 'edit');
    }

    public function viewAssignedOral($assignedOralId)
    {
        $this->loadAssignedOralData($assignedOralId, 'view');
    }

    public function selectCandidates()
    {
        $this->dispatch('show-candidatesModal');
    }

    public function backToPosition()
    {
        $this->dispatch('hide-candidatesModal');
    }

    public function addCandidate($candidateId)
    {
        $candidate = Candidate::find($candidateId);
    
        if ($candidate) {
            $this->selectedcandidate = [
                'id' => $candidate->id,
                'fullname' => $candidate->fullname,
            ];
        }

        $this->dispatch('hide-candidatesModal');
    }

    public function getCandidates()
    {
        return Candidate::query()
            ->when($this->candidateSearchModal, function ($query) {
                $query->where('fullname', 'like', '%' . $this->candidateSearchModal . '%');
            })
            ->paginate(5, ['*'], 'candidateModalPage');
    }


    public function updateAssignedOral()
    {
        DB::transaction(function () {  
            $assignedoral = AssignedOral::findOrFail($this->assignedoralId);
            
            $assignedoral->venue_id = $this->venue_id;
            $assignedoral->assigned_date = $this->assigned_date;
            $assignedoral->assigned_time = $this->assigned_time;
            $assignedoral->draft_status = $this->draft_status;
            $assignedoral->save();

        });

        $this->clear();
        $this->dispatch('hide-assignedOralModal');
        $this->dispatch('success', 'assigned oral updated successfully.');
    }

    public function showAddEditModal()
    {
        $this->clear();
        if (!$this->editMode) { 
            $this->status = 'yes'; 
        }
        $this->dispatch('show-assignedOralModal');
    }
}

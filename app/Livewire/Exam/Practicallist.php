<?php

namespace App\Livewire\Exam;

use App\Jobs\SendPracticalCodeEmailJob;
use App\Models\AssignedPractical;
use App\Models\Candidate;
use App\Models\PracticalScenario;
use App\Models\PracticalScore;
use App\Models\PracticalScoreSkill;
use App\Models\PracticalScoreSkillScenario;
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

class Practicallist extends Component
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
    public $selectedcandidate, $assignedpracticalId;

    public $selected_candidate_name;

    public function render()
    {

        return view('livewire.exam.practicallist', [
            'assignedpracticals' => $this->loadAssignedPracticals(),
            'candidates' => $this->getCandidates(),
            'selectedcandidate' => $this->selectedcandidate,            
        ]);
    }
    
    public function updatingFilterStatus()
    {
        $this->resetPage(); 
    }

    

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedCandidateSearchMain()
    {
        $this->resetPage('assignedpracticalsPage');
    }

    public function updatedCandidateSearchModal()
    {
        $this->resetPage('candidateModalPage');
    }

    public function rules()
    {

    }

    public function loadAssignedPracticals()
    {
        
        return AssignedPractical::with(['candidate', 'venue'])
            ->selectRaw('assigned_practicals.*, 
                        DATEDIFF(CURRENT_DATE, CONCAT(assigned_practicals.assigned_date, " ", assigned_practicals.assigned_time)) AS aging_days')
            ->when($this->candidateSearchMain, function ($query) {
                $query->whereHas('candidate', function ($q) {
                    $q->where('first_name', 'like', '%' . $this->candidateSearchMain . '%')
                    ->orWhere('family_name', 'like', '%' . $this->candidateSearchMain . '%');
                });
            })
            ->when($this->filterStatus !== 'all', function ($query) {
                $query->where('draft_status', $this->filterStatus);
            })
            ->orderByDesc('created_at')
            ->paginate(10, ['*'], 'assignedpracticalsPage');
    }

    public function createAssignedPractical()
    {
        try {
            $this->access_code = $this->generateUniqueAccessCode();
            $newAssignedId = null;

            DB::transaction(function () use (&$newAssignedId) {
                $assignedpractical = new AssignedPractical();
                $assignedpractical->candidate_id = $this->selectedcandidate['id'];
                $assignedpractical->venue_id = $this->venue_id;
                $assignedpractical->assigned_date = $this->assigned_date;
                $assignedpractical->assigned_time = $this->assigned_time;
                $assignedpractical->draft_status = $this->draft_status;
                $assignedpractical->access_code = $this->access_code;
                $assignedpractical->save();

                $newAssignedId = $assignedpractical->id;

                $practicalScore = new PracticalScore();
                $practicalScore->assigned_practical_id = $assignedpractical->id;
                $practicalScore->save();

                $candidate = Candidate::findOrFail($this->selectedcandidate['id']);

                if ($assignedpractical->draft_status === 'published' && isset($candidate)) {
                    SendPracticalCodeEmailJob::dispatch($assignedpractical, $candidate);
                }
            });

            // $this->clear();
            return redirect()->route('exam.practicalscheduledscenarios', $newAssignedId);
        } catch (\Exception $e) {
            Log::error('Error creating assigned practical: ' . $e->getMessage(), [
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

    public function updatePracticalScenario($assignedPracticalId)
    {
        return redirect()->route('exam.practicalscheduledscenariosupdate', $assignedPracticalId);
    }



    private function loadDropdownData()
    {
        $this->venues = Venue::all();
    }

    protected function generateUniqueAccessCode()
    {
        do {
            $code = Str::upper(Str::random(5));
        } while (AssignedPractical::where('access_code', $code)->exists());

        return $code;
    }



    public function clear()
    {
        $this->reset();
        $this->resetValidation();
        $this->loadDropdownData();
    }

    private function loadAssignedPracticalData($assignedPracticalId, $mode = 'edit')
    {
        $this->loadDropdownData();

        $assigned_practical = AssignedPractical::with('candidate')->findOrFail($assignedPracticalId);

        $this->fill([
            'selected_candidate_id' => $assigned_practical->candidate_id,
            'selected_candidate_name' => $assigned_practical->candidate->fullname ?? '',
            'draft_status' => $assigned_practical->draft_status,
            'assigned_date' => $assigned_practical->assigned_date,
            'assigned_time' => $assigned_practical->assigned_time,
            'venue_id' => $assigned_practical->venue_id,
            'assignedpracticalId' => $assigned_practical->id,
        ]);

        $this->assigned_practical_id = $assigned_practical->id;

        $this->editMode = false;
        $this->viewMode = false;

        if ($mode === 'edit') {
            $this->editMode = true;
        } elseif ($mode === 'view') {
            $this->viewMode = true;
        }

        $this->dispatch('show-assignedPracticalModal');
    }

    public function readAssignedPractical($assignedPracticalId)
    {
        $this->loadAssignedPracticalData($assignedPracticalId, 'edit');
    }

    public function viewAssignedPractical($assignedPracticalId)
    {
        $this->loadAssignedPracticalData($assignedPracticalId, 'view');
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
                $query->where(function ($q) {
                    $q->where('first_name', 'like', '%' . $this->candidateSearchModal . '%')
                    ->orWhere('family_name', 'like', '%' . $this->candidateSearchModal . '%');
                });
            })
            ->paginate(5, ['*'], 'candidateModalPage');
    }

    


    public function updateAssignedPractical()
    {
        DB::transaction(function () {  
            $assignedpractical = AssignedPractical::findOrFail($this->assignedpracticalId);
            $this->updatecandidate_id = $assignedpractical->candidate_id;
            $assignedpractical->venue_id = $this->venue_id;
            $assignedpractical->assigned_date = $this->assigned_date;
            $assignedpractical->assigned_time = $this->assigned_time;
            $assignedpractical->draft_status = $this->draft_status;
            $assignedpractical->save();

            $candidate = Candidate::findOrFail($this->updatecandidate_id);

            if ($assignedpractical->draft_status === 'published' && isset($candidate)) {
                SendPracticalCodeEmailJob::dispatch($assignedpractical, $candidate);
            }
        });

        $this->clear();
        $this->dispatch('hide-assignedPracticalModal');
        $this->dispatch('success', 'assignedpractical updated successfully.');
    }

    public function showAddEditModal()
    {
        $this->clear();
        if (!$this->editMode) { 
            $this->status = 'yes'; 
        }
        $this->dispatch('show-assignedPracticalModal');
    }
}

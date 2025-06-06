<?php

namespace App\Livewire\Exam;

use App\Jobs\SendAssessmentCodeEmailJob;
use App\Models\AssignedAssessment;
use App\Models\Candidate;
use App\Models\Venue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str; 
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Models\AssessmentScore;
use App\Models\Position;
use App\Models\AssessmentScoreSkill;
use App\Models\PositionSkill;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentScoreSkillQuestion;

class Assessmentlist extends Component
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
    public $selectedcandidate, $assigned_assessment_id, $updatecandidate_id;
    public $selected_candidate_name;

    public function render()
    {
        return view('livewire.exam.assessmentlist', [
            'assignedassessments' => $this->loadAssignedAssessments(),
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
        $this->resetPage('assignedassessmentsPage');
    }

    public function updatedCandidateSearchModal()
    {
        $this->resetPage('candidateModalPage');
    }

    public function rules()
    {

    }

    public function toggleArchive()
    {
        $this->archive = !$this->archive;
    }

   public function loadAssignedAssessments()
    {
        return AssignedAssessment::with(['candidate', 'venue'])
            ->selectRaw('assigned_assessments.*, 
                        DATEDIFF(CURRENT_DATE, CONCAT(assigned_assessments.assigned_date, " ", assigned_assessments.assigned_time)) AS aging_days')
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
            ->paginate(10, ['*'], 'assignedassessmentsPage');
    }


    public function createAssignedAssessment()
    {
        try {
            $this->access_code = $this->generateUniqueAccessCode();

            DB::transaction(function () {
                $assignedassessment = new AssignedAssessment();
                $assignedassessment->candidate_id = $this->selectedcandidate['id'];
                $assignedassessment->venue_id = $this->venue_id;
                $assignedassessment->assigned_date = $this->assigned_date;
                $assignedassessment->assigned_time = $this->assigned_time;
                $assignedassessment->draft_status = $this->draft_status;
                $assignedassessment->access_code = $this->access_code;
                $assignedassessment->save();

                if ($assignedassessment->draft_status !== 'draft') {
                    $this->createAssessmentScores($assignedassessment);
                }

                //emailing
                $candidate = Candidate::findOrFail($this->selectedcandidate['id']);

                if ($assignedassessment->draft_status === 'published' && isset($candidate)) {
                    SendAssessmentCodeEmailJob::dispatch($assignedassessment, $candidate);
                }
            });

           

            $this->clear();
            $this->dispatch('hide-assignedAssessmentModal');
            $this->dispatch('success', 'Schedule Created Successfully');

        } catch (\Exception $e) {
            Log::error('Error creating assigned assessment: ' . $e->getMessage(), [
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

    private function createAssessmentScores(AssignedAssessment $assignedassessment)
    {
        $assessmentScore = new AssessmentScore();
        $assessmentScore->assigned_assessment_id = $assignedassessment->id;
        $assessmentScore->save();

        $candidate = Candidate::findOrFail($this->updatecandidate_id);

        $position = Position::find($candidate->position_id);

        if ($position && in_array($position->item, [8, 10])) {
            Log::info("Candidate's position item is 8 or 10", [
                'candidate_id' => $candidate->id,
                'position_id' => $position->id,
                'item' => $position->item,
            ]);
        }

        $positionSkills = PositionSkill::where('position_id', $candidate->position_id)->get();
        $totalDuration = 0;

        foreach ($positionSkills as $skill) {
            $assessmentScoreSkill = AssessmentScoreSkill::create([
                'assessment_scores_id' => $assessmentScore->id,
                'position_skill_id' => $skill->id,
            ]);

            $distribution = match ($skill->competency_level) {
                'basic' => ['basic' => 5, 'intermediate' => 2, 'advanced' => 1],
                'intermediate' => ['basic' => 2, 'intermediate' => 4, 'advanced' => 2],
                'advanced' => ['basic' => 1, 'intermediate' => 2, 'advanced' => 5],
                default => ['basic' => 0, 'intermediate' => 0, 'advanced' => 0],
            };

            foreach ($distribution as $level => $count) {
                $questions = AssessmentQuestion::where('position_skill_id', $skill->id)
                    ->where('competency_level', $level)
                    ->inRandomOrder()
                    ->limit($count)
                    ->get();

                foreach ($questions as $question) {
                    AssessmentScoreSkillQuestion::create([
                        'assessment_score_skill_id' => $assessmentScoreSkill->id,
                        'assessmentquestion_id' => $question->id,
                    ]);

                    $totalDuration += $question->duration;
                }
            }
        }

        $assessmentScore->total_duration = $totalDuration;
        $assessmentScore->save();
    }


    private function loadDropdownData()
    {
        $this->venues = Venue::all();
    }

    protected function generateUniqueAccessCode()
    {
        do {
            $code = Str::upper(Str::random(5));
        } while (AssignedAssessment::where('access_code', $code)->exists());

        return $code;
    }

    public function clear()
    {
        $this->reset();
        $this->resetValidation();
        $this->loadDropdownData();
    }

    private function loadAssignedAssessmentData($assignedAssessmentId, $mode = 'edit')
    {
        $this->loadDropdownData();

        $assigned_assessment = AssignedAssessment::with('candidate')->findOrFail($assignedAssessmentId);

        $this->fill([
            'selected_candidate_id' => $assigned_assessment->candidate_id,
            'selected_candidate_name' => $assigned_assessment->candidate->fullname ?? '',
            'draft_status' => $assigned_assessment->draft_status,
            'assigned_date' => $assigned_assessment->assigned_date,
            'assigned_time' => $assigned_assessment->assigned_time,
            'venue_id' => $assigned_assessment->venue_id,
            'assignedoralId' => $assigned_assessment->id,
        ]);

        $this->assigned_assessment_id = $assigned_assessment->id;

        $this->editMode = false;
        $this->viewMode = false;

        if ($mode === 'edit') {
            $this->editMode = true;
        } elseif ($mode === 'view') {
            $this->viewMode = true;
        }

        $this->dispatch('show-assignedAssessmentModal');
    }

    public function readAssignedAssessment($assignedAssessmentId)
    {
        $this->loadAssignedAssessmentData($assignedAssessmentId, 'edit');
    }

    public function viewAssignedAssessment($assignedAssessmentId)
    {
        $this->loadAssignedAssessmentData($assignedAssessmentId, 'view');
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


    


    public function updateAssignedAssessment()
    {
        DB::transaction(function () {  
            $assignedassessment = AssignedAssessment::where('id', $this->assigned_assessment_id)->firstOrFail(); 
            $this->updatecandidate_id = $assignedassessment->candidate_id;
            $assignedassessment->venue_id = $this->venue_id;
            $assignedassessment->assigned_date = $this->assigned_date;
            $assignedassessment->assigned_time = $this->assigned_time;
            $assignedassessment->draft_status = $this->draft_status;
            $assignedassessment->save();

            $candidate = Candidate::findOrFail($this->updatecandidate_id);

            if ($assignedassessment->draft_status === 'published' && isset($candidate)) {
                $this->createAssessmentScores($assignedassessment);
                SendAssessmentCodeEmailJob::dispatch($assignedassessment, $candidate);
            }
            
        });

        $this->clear();
        $this->dispatch('hide-assignedAssessmentModal');
        $this->dispatch('success', 'assignedassessment updated successfully.');
    }

    public function showAddEditModal()
    {
        $this->clear();
        if (!$this->editMode) { 
            $this->status = 'yes'; 
        }
        $this->dispatch('show-assignedAssessmentModal');
    }
}

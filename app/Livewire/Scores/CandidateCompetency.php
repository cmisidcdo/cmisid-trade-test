<?php

namespace App\Livewire\Scores;

use App\Models\AssignedOral;
use App\Models\AssignedPractical;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\AssessmentScore;

class CandidateCompetency extends Component
{
    public $editMode;

    public $archive = false;

    public $search;
    public $filterStatus = 'all'; 
    public $title, $skill_id, $status;
    public $assigned_date, $dateFinished, $timeFinished, $candidateName, $candidate_id, $assessorName, $access_code, $draft_status = 'draft';

    public $venues = [], $assessmentscoreskills = [];
    public $selectedcandidate;

    public $assessmentScoreId; 

    public function render()
    {
        return view('livewire.scores.candidate-competency', [
            'assessmentScores' => $this->loadTestsStatus(),    
        ]);
    }

    public function loadTestsStatus()
    {
        $assessmentScores = AssessmentScore::with('assignedAssessment') 
            ->when($this->search, function ($query) {
                $query->whereHas('candidate', function ($q) {
                    $q->where('fullname', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus !== 'all', function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderByDesc('created_at')
            ->get();
        
        if ($assessmentScores->isEmpty()) {
            \Log::info('No assessment scores found.');
            return collect();
        }
    
        \Log::info('Assessment Scores:', $assessmentScores->map(function ($item) {
            return $item->toArray();
        })->toArray());
        
        $assessmentScores->each(function ($assessmentScore) {
            $assignedAssessment = $assessmentScore->assignedAssessment;
            $candidateId = $assignedAssessment ? $assignedAssessment->candidate_id : null;
    
            if ($candidateId) {
                $assessmentScore->candidate_id = $candidateId; 
                $assignedPractical = AssignedPractical::where('candidate_id', $candidateId)->first();

                if ($assignedPractical) {
                    $practicalScore = $assignedPractical->practicalScore()->first();

                    $practicalStatus = $practicalScore ? $practicalScore->status : 'N/A';
                } else {
                    $practicalStatus = 'N/A';
                }
            
                $assignedOral = AssignedOral::where('candidate_id', $candidateId)->first();
            
                
                if ($assignedOral) {
                    $oralScore = $assignedOral->oralScore()->first();

                    $oralStatus = $oralScore ? $oralScore->status : 'N/A';
                } else {
                    $oralStatus = 'N/A';
                }
            
                $assessmentScore->assessmentstatus = $assessmentScore->status ?? 'N/A';
                $assessmentScore->practicalstatus = $practicalStatus;   
                $assessmentScore->oralstatus = $oralStatus;
            } else {

                $assessmentScore->assessmentstatus = 'N/A';
                $assessmentScore->practicalstatus = 'N/A';
                $assessmentScore->oralstatus = 'N/A';
            }
            
        });
    
        return $assessmentScores;
    }

    public function readAssessmentScore($assessmentscoreId)
    {
        $assessmentscore = AssessmentScore::with('candidate') 
            ->findOrFail($assessmentscoreId);
        $this->fill([
            'candidateName' => $assessmentscore->candidate?->fullname ?? 'N/A',
            'assessorName' => 'N/A', 
            'dateFinished' => $assessmentscore->date_finished ?? 'N/A',
            'timeFinished' => $assessmentscore->time_finished ?? 'N/A',
            'status' => $assessmentscore->status ?? 'N/A',
            'assessmentscoreskills' => $assessmentscore->assessmentScoreSkills, 
        ]);

        $this->editMode = true;

        $this->dispatch('show-assessmentScoreModal');
    }

    public function seeResults($candidate_id)
    {
        return redirect()->route('scores.candidatecompetencyresults', $candidate_id);
    }
}

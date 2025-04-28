<?php

namespace App\Livewire\Scores;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\AssessmentScore;



class AssessmentScores extends Component
{
    public $editMode;

    public $archive = false;

    public $search;
    public $filterStatus = 'all'; 
    public $title, $skill_id, $status;
    public $assigned_date, $assessmentScores, $dateFinished, $timeFinished, $candidateName, $candidate_id, $assessorName, $access_code, $draft_status = 'draft';

    public $venues = [], $assessmentscoreskills = [];
    public $selectedcandidate;

    public $assessmentScoreId; 

    public function render()
    {
        return view('livewire.scores.assessment-scores', [
            'assessmentscores' => $this->loadAssessmentScores(),    
        ]);
    }

    public function loadAssessmentScores()
    {
        return AssessmentScore::with('candidate')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhereHas('candidate', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->filterStatus !== 'all', function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderByDesc('created_at')
            ->paginate(10);
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

}

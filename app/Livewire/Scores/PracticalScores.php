<?php

namespace App\Livewire\Scores;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\PracticalScore;

class PracticalScores extends Component
{
    public $editMode;

    public $archive = false;

    public $search;
    public $filterStatus = 'all'; 
    public $title, $skill_id, $status;
    public $assigned_date, $practicalScores, $dateFinished, $timeFinished, $candidateName, $candidate_id, $assessorName, $access_code, $draft_status = 'draft';

    public $venues = [], $practicalscoreskills = [];
    public $selectedcandidate;

    public $practicalScoreId; 

    public function render()
    {
        return view('livewire.scores.practical-scores', [
            'practicalscores' => $this->loadPracticalScores(),    
        ]);
    }

    public function loadPracticalScores()
    {
        return PracticalScore::with('candidate')
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

    public function readPracticalScore($practicalscoreId)
    {
        $practicalscore = PracticalScore::with('candidate') 
            ->findOrFail($practicalscoreId);
        $this->fill([
            'candidateName' => $practicalscore->candidate?->fullname ?? 'N/A',
            'assessorName' => 'N/A', 
            'dateFinished' => $practicalscore->date_finished ?? 'N/A',
            'timeFinished' => $practicalscore->time_finished ?? 'N/A',
            'status' => $practicalscore->status ?? 'N/A',
            'practicalscoreskills' => $practicalscore->practicalScoreSkills, 
        ]);

        $this->editMode = true;

        $this->dispatch('show-practicalScoreModal');
    }

}

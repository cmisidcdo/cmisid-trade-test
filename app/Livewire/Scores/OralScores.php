<?php

namespace App\Livewire\Scores;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\OralScore;

class OralScores extends Component
{
    public $editMode;

    public $archive = false;

    public $search;
    public $filterStatus = 'all'; 
    public $title, $skill_id, $status;
    public $assigned_date, $oralScores, $dateFinished, $timeFinished, $candidateName, $candidate_id, $assessorName, $access_code, $draft_status = 'draft';

    public $venues = [], $oralscoreskills = [];
    public $selectedcandidate;

    public $oralScoreId; 

    public function render()
    {
        return view('livewire.scores.oral-scores', [
            'oralscores' => $this->loadOralScores(),    
        ]);
    }

    public function loadOralScores()
    {
        return OralScore::with('candidate')
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

    public function readOralScore($oralscoreId)
    {
        $oralscore = OralScore::with('candidate') 
            ->findOrFail($oralscoreId);
        $this->fill([
            'candidateName' => $oralscore->candidate?->fullname ?? 'N/A',
            'assessorName' => 'N/A', 
            'dateFinished' => $oralscore->date_finished ?? 'N/A',
            'timeFinished' => $oralscore->time_finished ?? 'N/A',
            'status' => $oralscore->status ?? 'N/A',
            'oralscoreskills' => $oralscore->oralScoreSkills, 
        ]);

        $this->editMode = true;

        $this->dispatch('show-oralScoreModal');
    }

}

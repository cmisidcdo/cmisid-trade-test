<?php

namespace App\Livewire\Scores;

use App\Models\PracticalScoreSkill;
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

    public $venues = [], $evaluation = [], $practicalscoreskills = [];
    public $selectedcandidate;

    public $practicalScoreId, $practical_skillId; 
    public $skillname;

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

    public function evaluateSkill($practicalskillId)
    {
        $practical_scoreskill = PracticalScoreSkill::findOrFail($practicalskillId);
        $this->practical_skillId = $practicalskillId;
        $this->evaluation = [
            'task_completion' => $practical_scoreskill->task_completion ?? '',
            'problem_solving' => $practical_scoreskill->problem_solving ?? '',
            'accuracy_precision' => $practical_scoreskill->accuracy ?? '',
            'efficiency_time' => $practical_scoreskill->efficiency ?? '',
            'recommendation' => $practical_scoreskill->recommendation ?? '',
            'comment' => $practical_scoreskill->comment ?? '',
        ];

        $this->skillname = optional($practical_scoreskill->position_skill->skill)->title ?? 'N/A';

        $this->dispatch('show-evaluationModal');
    }

    public function submitEvaluation()
    {
        $this->validate([
            'evaluation.task_completion' => 'required|integer|min:1|max:10',
            'evaluation.problem_solving' => 'required|integer|min:1|max:10',
            'evaluation.accuracy_precision' => 'required|integer|min:1|max:10',
            'evaluation.efficiency_time' => 'required|integer|min:1|max:10',
            'evaluation.recommendation' => 'nullable|string|max:255',
            'evaluation.comment' => 'nullable|string|max:255',
        ]);

        $score = PracticalScoreSkill::findOrFail($this->practical_skillId);

        $average_score = round((
            $this->evaluation['task_completion'] +
            $this->evaluation['problem_solving'] +
            $this->evaluation['accuracy_precision'] +
            $this->evaluation['efficiency_time']
        ) / 4, 2);

        $score->update([
            'task_completion' => $this->evaluation['task_completion'],
            'problem_solving' => $this->evaluation['problem_solving'],
            'accuracy' => $this->evaluation['accuracy_precision'],
            'efficiency' => $this->evaluation['efficiency_time'],
            'score' => $average_score,
            'recommendation' => $this->evaluation['recommendation'],
            'comment' => $this->evaluation['comment'],
        ]);

        $this->dispatch('hide-evaluationModal');
        session()->flash('message', 'Evaluation submitted successfully.');
    }



}

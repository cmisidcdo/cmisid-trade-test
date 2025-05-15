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

    public $practicalScoreId, $practical_skillId, $practicalscore, $practicalscoreskill;
    public $skillname;

    public function render()
    {
        return view('livewire.scores.practical-scores', [
            'practicalscores' => $this->loadPracticalScores(),    
        ]);
    }

    public function loadPracticalScores()
    {
        return PracticalScore::with(['candidate', 'assigned_practical'])
            ->when($this->search, function ($query) {
                $query->whereHas('candidate', function ($q) {
                    $q->where('fullname', 'like', '%' . $this->search . '%');
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
        return redirect()->route('scores.practicalscoresevaluation', $practicalscoreId);
    }

    public function readNote($practicalscoreId)
    {
        $practicalscore = PracticalScore::with('practicalScoreSkills.position_skill.skill')
                                        ->find($practicalscoreId);

        if (!$practicalscore) {
            session()->flash('error', 'Practical Score not found!');
            return redirect()->route('some.route');
        }

        $this->practicalscore = $practicalscore;

        $this->dispatch('show-noteModal');
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

        $this->finalizePracticalScore($this->practicalScoreId);
        $this->readPracticalScore($this->practicalScoreId);
        $this->dispatch('hide-evaluationModal');
        $this->dispatch('success', 'Evaluation submitted successfully.');
    }       

    public function finalizePracticalScore($practical_score_id)
    {
        $practicalScoreSkills = PracticalScoreSkill::where('practical_score_id', $practical_score_id)->get();

        if ($practicalScoreSkills->contains(fn($skill) => is_null($skill->score))) {
            return;
        }

        $averageScore = round($practicalScoreSkills->avg('score'), 2);

        PracticalScore::where('id', $practical_score_id)->update([
            'total_score' => $averageScore,
        ]);
    }


    public function showScenarios($practicalskillId)
    {
        try {
            $this->practicalscoreskill = PracticalScoreSkill::with('practicalScoreSkillScenarios.practical_scenarios')->findOrFail($practicalskillId);

            $this->dispatch('show-scenarioModal');
        } catch (\Exception $e) {
            Log::error('Error fetching practicalScoreSkill: ' . $e->getMessage(), [
                'practicalskill_id' => $practicalskillId ?? null,
            ]);
            abort(500, 'Something went wrong.');
        }
    }
}

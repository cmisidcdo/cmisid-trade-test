<?php

namespace App\Livewire\Scores;

use App\Models\PracticalScore;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\PracticalScoreSkill;
use Carbon\Carbon;

class PracticalScoresEvaluation extends Component
{
     public $practicalscoreId;
    public $candidateName;
    public $assessorName;
    public $dateFinished;
    public $timeFinished;
    public $status;
    public $totalDuration = 0;
    public $startTime = null;
    public $practicalStarted = false;

    public $venues = [], $evaluation = [], $practicalscoreskills = [], $practicalscoreskill;
    public $selectedcandidate;

    public $practicalScoreId, $practical_skillId, $skillname, $practicalscore, $remainingTime, $total_duration; 

   public function mount($practicalscoreId)
    {
        $this->practicalscoreId = $practicalscoreId;
        
        $this->loadPracticalScoreData($practicalscoreId);

        if($this->practicalscore->started_at)
        {
            $this->dispatch('startCountdown');
        }
    }


    public function loadPracticalScoreData($practicalscoreId)
    {
        $practicalscore = PracticalScore::with(['candidate', 'user'])->findOrFail($practicalscoreId);
        $this->practicalscore = $practicalscore;
        $totalDuration = $practicalscore->total_duration;

        $this->totalDuration = $practicalscore->total_duration;

         $startedAt = Carbon::parse($practicalscore->started_at);

        $elapsedSeconds = $startedAt->diffInSeconds(now(), false);

        $remainingTime = $totalDuration - $elapsedSeconds;

        $this->remainingTime = max($remainingTime, 0);

        $this->fill([
            'candidateName' => $practicalscore->candidate?->fullname ?? 'N/A',
            'assessorName' => $practicalscore->user?->name ?? 'N/A',
            'dateFinished' => $practicalscore->date_finished ?? 'N/A',
            'timeFinished' => $practicalscore->time_finished ?? 'N/A',
            'status' => $practicalscore->status ?? 'N/A',
            'practicalscoreskills' => $practicalscore->practicalScoreSkills,
        ]);
    }   

    public function render()
    {
        return view('livewire.scores.practical-scores-evaluation');
    }

    public function startPractical()
    {
        $this->practicalStarted = true;
        if ($this->practicalscore) {
            $this->practicalscore->update([
                'started_at' => now(),
                'status' => 'ongoing',
            ]);
        }
        $this->status = $this->practicalscore->status;
        $this->dispatch('startCountdown');
    }

    public function completePractical()
    {
        $now = now();
        $this->practicalStarted = false;
        $this->practicalCompleted = true;
        if ($this->practicalscore) {
            $this->practicalscore->update([
                'status' => 'done',
                'date_finished' => $now->toDateString(), 
                'time_finished' => $now->toTimeString(),
            ]);
        }
        $this->status = $this->practicalscore->status;
        $this->dateFinished = $this->practicalscore->date_finished;
        $this->timeFinished = $this->practicalscore->time_finished;
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

        $this->finalizePracticalScore($this->practicalscoreId);
        $this->loadPracticalScoreData($this->practicalscoreId);
        $this->dispatch('hide-evaluationModal');
        $this->dispatch('success', 'Evaluation submitted successfully.');
    }

    public function finalizePracticalScore($practical_score_id)
    {
       $practicalScoreSkills = PracticalScoreSkill::where('practical_score_id', $practical_score_id)->get();
        $assessor_id = auth()->id();
        if ($practicalScoreSkills->contains(fn($skill) => is_null($skill->score))) {
            return;
        }

        $averageScore = round($practicalScoreSkills->avg('score'), 2);

        PracticalScore::where('id', $practical_score_id)->update([
            'total_score' => $averageScore,
             'user_id' => $assessor_id,
        ]);
    }

    public function showScenarios($practicalskillId)
    {
        try {
            $this->practicalscoreskill = PracticalScoreSkill::with('practicalScoreSkillScenarios.practical_scenarios')->findOrFail($practicalskillId);

            $this->dispatch('show-scenarioModal');
        } catch (\Exception $e) {
            Log::error('Error fetching PracticalScoreSkill: ' . $e->getMessage(), [
                'practicalskill_id' => $practicalskillId ?? null,
            ]);
            abort(500, 'Something went wrong.');
        }
    }
    
}

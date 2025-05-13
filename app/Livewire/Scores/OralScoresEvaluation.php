<?php

namespace App\Livewire\Scores;

use App\Models\OralScore;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\OralScoreSkill;
use Carbon\Carbon;

class OralScoresEvaluation extends Component
{
    public $oralscoreId;
    public $candidateName;
    public $assessorName;
    public $dateFinished;
    public $timeFinished;
    public $status;

    public $totalDuration = 0;
    public $startTime = null;
    public $pausedAt = null;

    public $interviewStarted = false;
    public $interviewPaused = false;


    public $venues = [], $evaluation = [], $oralscoreskills = [], $oralscoreskill;
    public $selectedcandidate;

    public $oralScoreId, $oral_skillId, $skillname, $oralscore, $remainingTime, $total_duration; 

   public function mount($oralscoreId)
    {
        $this->oralscoreId = $oralscoreId;
        
        $this->loadOralScoreData($oralscoreId);
    }


    public function loadOralScoreData($oralscoreId)
    {
        $oralscore = OralScore::with(['candidate', 'user'])->findOrFail($oralscoreId);
        $this->totalDuration = $oralscore->total_duration;
        $this->fill([
            'candidateName' => $oralscore->candidate?->fullname ?? 'N/A',
            'assessorName' => $oralscore->user?->name ?? 'N/A',
            'dateFinished' => $oralscore->date_finished ?? 'N/A',
            'timeFinished' => $oralscore->time_finished ?? 'N/A',
            'status' => $oralscore->status ?? 'N/A',
            'oralscoreskills' => $oralscore->oralScoreSkills,
        ]);
    }   

    public function render()
    {
        return view('livewire.scores.oral-scores-evaluation');
    }

    public function readNote($oralscoreId)
    {
        $oralscore = OralScore::with('oralScoreSkills.position_skill.skill')
                                        ->find($oralscoreId);

        if (!$oralscore) {
            session()->flash('error', 'oral Score not found!');
            return redirect()->route('some.route');
        }

        $this->oralscore = $oralscore;

        $this->dispatch('show-noteModal');
    }

    public function startInterview()
    {
        $this->interviewStarted = true;
        $this->interviewPaused = false;
    }

    public function pauseInterview()
    {
        $this->interviewPaused = true;
    }

    public function completeInterview()
    {
        $this->interviewStarted = false;
        $this->interviewCompleted = true;
        $this->status = 'Completed';
    }


    public function evaluateSkill($oralskillId)
    {
        $oral_scoreskill = OralScoreSkill::findOrFail($oralskillId);
        $this->oral_skillId = $oralskillId;
        $this->evaluation = [
            'knowledge' => $oral_scoreskill->knowledge ?? '',
            'problem_solving' => $oral_scoreskill->problem_solving ?? '',
            'completeness' => $oral_scoreskill->completeness ?? '',
            'recommendation' => $oral_scoreskill->recommendation ?? '',
            'comment' => $oral_scoreskill->comment ?? '',
        ];

        $this->skillname = optional($oral_scoreskill->position_skill->skill)->title ?? 'N/A';

        $this->dispatch('show-evaluationModal');
    }

    public function submitEvaluation()
    {
        $this->validate([
            'evaluation.knowledge' => 'required|integer|min:1|max:10',
            'evaluation.problem_solving' => 'required|integer|min:1|max:10',
            'evaluation.completeness' => 'required|integer|min:1|max:10',
            'evaluation.recommendation' => 'nullable|string|max:255',
            'evaluation.comment' => 'nullable|string|max:255',
        ]);
        $score = OralScoreSkill::findOrFail($this->oral_skillId);
    
        $average_score = round((
            $this->evaluation['knowledge'] +
            $this->evaluation['problem_solving'] +
            $this->evaluation['completeness']
        ) / 3, 2);

        \Log::info('Submitting oral evaluation', [
            'oral_skill_id' => $this->oral_skillId,
            'scores' => [
                'knowledge' => $this->evaluation['knowledge'],
                'problem_solving' => $this->evaluation['problem_solving'],
                'completeness' => $this->evaluation['completeness'],
                'average' => $average_score
            ],
            'recommendation' => $this->evaluation['recommendation'],
            'comment' => $this->evaluation['comment']
        ]);

        $score->update([
            'knowledge' => $this->evaluation['knowledge'],
            'problem_solving' => $this->evaluation['problem_solving'],
            'completeness' => $this->evaluation['completeness'], 
            'score' => $average_score,
            'recommendation' => $this->evaluation['recommendation'],
            'comment' => $this->evaluation['comment'],
        ]);

        $this->finalizeOralScore($this->oralscoreId);
        $this->loadOralScoreData($this->oralscoreId);
        $this->dispatch('hide-evaluationModal');
        $this->dispatch('success', 'Evaluation submitted successfully.');
    }

    public function finalizeOralScore($oral_score_id)
    {
        $oralScoreSkills = OralScoreSkill::where('oral_score_id', $oral_score_id)->get();
        $assessor_id = auth()->id();

        Log::info('Finalizing Oral Score', [
            'oral_score_id' => $oral_score_id,
            'assessor_id' => $assessor_id,
            'skills_count' => $oralScoreSkills->count(),
            'null_scores_exist' => $oralScoreSkills->contains(fn($skill) => is_null($skill->score)),
        ]);

        if ($oralScoreSkills->contains(fn($skill) => is_null($skill->score))) {
            Log::warning("Oral score {$oral_score_id} has incomplete skill scores.");
            return;
        }

        $averageScore = round($oralScoreSkills->avg('score'), 2);

        $updated = OralScore::where('id', $oral_score_id)->update([
            'total_score' => $averageScore,
            'user_id' => $assessor_id,
        ]);

        Log::info('Oral Score updated', [
            'oral_score_id' => $oral_score_id,
            'updated' => $updated,
            'average_score' => $averageScore,
        ]);
    }

    public function showQuestions($oralskillId)
    {
        try {
            $this->oralscoreskill = OralScoreSkill::with('oralScoreSkillQuestions.oral_questions')->findOrFail($oralskillId);

            $this->dispatch('show-questionModal');
        } catch (\Exception $e) {
            Log::error('Error fetching OralScoreSkill: ' . $e->getMessage(), [
                'oralskill_id' => $oralskillId ?? null,
            ]);
            abort(500, 'Something went wrong.');
        }
    }
}

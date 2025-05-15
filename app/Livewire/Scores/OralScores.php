<?php

namespace App\Livewire\Scores;

use App\Models\OralScoreSkill;
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

    public $venues = [], $evaluation = [], $oralscoreskills = [], $oralscoreskill;
    public $selectedcandidate;

    public $oralScoreId, $oral_skillId, $skillname, $oralscore; 

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

    public function readOralScore($oralscoreId)
    {
        return redirect()->route('scores.oralscoresevaluation', $oralscoreId);
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

        $this->finalizeOralScore($this->oralScoreId);
        $this->readOralScore($this->oralScoreId);
        $this->dispatch('hide-evaluationModal');
        $this->dispatch('success', 'Evaluation submitted successfully.');
    }

    public function finalizeOralScore($oral_score_id)
    {
        $oralScoreSkills = OralScoreSkill::where('oral_score_id', $oral_score_id)->get();

        if ($oralScoreSkills->contains(fn($skill) => is_null($skill->score))) {
            return;
        }

        $averageScore = round($oralScoreSkills->avg('score'), 2);

        OralScore::where('id', $oral_score_id)->update([
            'total_score' => $averageScore,
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

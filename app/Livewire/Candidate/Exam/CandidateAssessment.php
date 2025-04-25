<?php

namespace App\Livewire\Candidate\Exam;

use Livewire\Component;
use App\Models\AssignedAssessment;
use App\Models\AssessmentScore;
use App\Models\AssessmentScoreSkill;
use App\Models\AssessmentScoreSkillQuestion;
use App\Models\PositionSkill;
use App\Models\Candidate;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\AQChoice;
use Illuminate\Support\Facades\Log;

class CandidateAssessment extends Component
{
    public $assessment;
    public $score;

    public $duration, $remainingTime, $formattedTime;

    public $questionsWithChoices = [];
    public $selectedAnswers = [];

    public function mount()
    {

        $candidateId = Session::get('candidate_id');

        $assignedAssessment = AssignedAssessment::where('candidate_id', $candidateId)->first();

        if (!$assignedAssessment) {
            abort(404, 'Assigned assessment not found.');
        }

        $this->assessment = $assignedAssessment;

        $score = AssessmentScore::where('assigned_assessment_id', $assignedAssessment->id)->first();
        $this->score = $score;
        if (!$score) {
            abort(404, 'Assessment score not found.');
        }

        if ($score->status === 'pending') {
            $score->update([
                'status' => 'ongoing',
                'started_at' => now(),
            ]);
        }

        $startedAt = Carbon::parse($score->started_at);

        $totalDuration = $score->total_duration;

        $elapsedSeconds = $startedAt->diffInSeconds(now(), false);

        $remainingTime = $totalDuration - $elapsedSeconds;

        $this->remainingTime = max($remainingTime, 0);

        $this->duration = $score->total_duration ?? null;

        $scoreSkillQuestions = AssessmentScoreSkillQuestion::with('assessmentquestion.choices')
            ->whereIn('assessment_score_skill_id', function ($query) use ($score) {
                $query->select('id')
                    ->from('assessment_scores_skills')
                    ->where('assessment_scores_id', $score->id);
            })->get();

        $this->questionsWithChoices = $scoreSkillQuestions->map(function ($item) {
            if (!$item->assessmentquestion) return null;
        
            return [
                'score_skill_question_id' => $item->id,
                'question_text' => $item->assessmentquestion->question,
                'competency_level' => $item->assessmentquestion->competency_level,
                'assessment_score_skill_id' => $item->assessment_score_skill_id,
                'choices' => $item->assessmentquestion->choices->map(function ($choice) {
                    return [
                        'id' => $choice->id,
                        'choice_text' => $choice->choice_text,
                       
                    ];
                }),
            ];
        })->filter()->values();
        
    }

    // public function submitAnswers()
    // {
        
    //     foreach ($this->selectedAnswers as $scoreSkillQuestionId => $choiceId) {
    //         try {
    //             $scoreQuestion = AssessmentScoreSkillQuestion::find($scoreSkillQuestionId);

    //             if (!$scoreQuestion) {
    //                 Log::warning("Score question not found for ID: $scoreSkillQuestionId");
    //                 continue;
    //             }

    //             $isCorrect = AQChoice::where('id', $choiceId)->value('is_answer');

    //             if ($isCorrect === null) {
    //                 Log::warning("Choice ID: $choiceId not found or does not have 'is_answer'");
    //             }

    //             $scoreQuestion->update([
    //                 'answer' => $choiceId,
    //                 'is_correct' => $isCorrect ? 1 : 0,
    //             ]);
    //         } catch (\Exception $e) {
    //             Log::error("Error updating score for score skill question ID: $scoreSkillQuestionId", [
    //                 'choice_id' => $choiceId,
    //                 'error' => $e->getMessage(),
    //             ]);
    //         }
    //     }

    //     try {
    //         $this->score->update([
    //             'status' => 'done',
    //             'time_finished' => now()->toTimeString(),
    //             'date_finished' => now()->toDateString(),
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error("Error updating score status to 'done'", [
    //             'score_id' => $this->score->id ?? 'unknown',
    //             'error' => $e->getMessage(),
    //         ]);
    //     }

    //     $this->dispatch('success', 'Answers Submitted Successfully!');
    // }

    public function submitAnswers()
    {
        $skillScores = []; 
        $totalQuestions = 0;
        $correctAnswers = 0;

        foreach ($this->selectedAnswers as $scoreSkillQuestionId => $choiceId) {
            try {
                $scoreQuestion = AssessmentScoreSkillQuestion::find($scoreSkillQuestionId);

                if (!$scoreQuestion) {
                    Log::warning("Score question not found for ID: $scoreSkillQuestionId");
                    continue;
                }

                $question = $scoreQuestion->assessmentquestion;

                $isCorrect = AQChoice::where('id', $choiceId)->value('is_answer');

                if ($isCorrect === null) {
                    Log::warning("Choice ID: $choiceId not found or missing 'is_answer'");
                }

                $assessmentScoreSkillId = $scoreQuestion->assessment_score_skill_id;

                $scoreQuestion->update([
                    'answer' => $choiceId,
                    'is_correct' => $isCorrect ? 1 : 0,
                ]);

                $competencyLevel = $question->competency_level ?? 'basic';
                $points = match ($competencyLevel) {
                    'basic' => 1,
                    'intermediate' => 2,
                    'advance' => 3,
                    default => 1,
                };

                if (!isset($skillScores[$assessmentScoreSkillId])) {
                    $skillScores[$assessmentScoreSkillId] = [
                        'earned_points' => 0,
                        'total_points' => 0
                    ];
                }

                $skillScores[$assessmentScoreSkillId]['total_points'] += $points;

                if ($isCorrect) {
                    $skillScores[$assessmentScoreSkillId]['earned_points'] += $points;
                    $correctAnswers++;
                }

                $totalQuestions++;

            } catch (\Exception $e) {
                Log::error("Error processing question ID: $scoreSkillQuestionId", [
                    'choice_id' => $choiceId,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $totalScore = 0;
        $totalSkills = count($skillScores);

        foreach ($skillScores as $skillScoreId => $data) {
            $assessmentScoreSkill = AssessmentScoreSkill::find($skillScoreId);

            if (!$assessmentScoreSkill) {
                continue;
            }

            $scorePercent = $data['total_points'] > 0
                ? ($data['earned_points'] / $data['total_points']) * 100
                : 0;

            $assessmentScoreSkill->update([
                'skill_score' => $scorePercent,
            ]);

            $totalScore += $scorePercent;
        }

        if ($totalSkills > 0) {
            $averageScore = $totalScore / $totalSkills;
            try {
                $this->score->update([
                    'total_score' => $averageScore, 
                    'status' => 'done',
                    'time_finished' => now()->toTimeString(),
                    'date_finished' => now()->toDateString(),
                ]);
            } catch (\Exception $e) {
                Log::error("Failed to finalize assessment score", [
                    'score_id' => $this->score->id ?? 'unknown',
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->dispatch('success', 'Answers Submitted Successfully!');
    }



    public function render()
    {
        return view('livewire.candidate.exam.candidate-assessment')
            ->layout('components.layouts.candidate-exam');
    }
}

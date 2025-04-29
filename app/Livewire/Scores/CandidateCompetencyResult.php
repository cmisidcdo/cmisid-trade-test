<?php

namespace App\Livewire\Scores;

use App\Models\AssessmentScore;
use App\Models\AssessmentScoreSkill;
use App\Models\AssignedAssessment;
use App\Models\AssignedOral;
use App\Models\AssignedPractical;
use App\Models\Candidate;
use App\Models\OralScore;
use App\Models\OralScoreSkill;
use App\Models\PositionSkill;
use App\Models\PracticalScore;
use App\Models\PracticalScoreSkill;
use Livewire\Component;

class CandidateCompetencyResult extends Component
{

    public $candidateId;
    public $fullname;
    public $applied_position;
    public $skillScores = [];

    
    public function mount($candidateId)
    {
        $this->candidateId = $candidateId;

        $candidate = Candidate::find($candidateId);

        if ($candidate) {
            $this->fullname = $candidate->fullname;
            $this->applied_position = optional($candidate->position)->title ?? 'N/A';
        } else {
            $this->fullname = 'N/A';
            $this->applied_position = 'N/A';
        }

        $this->loadCandidateSkillScores();
    }

    public function loadCandidateSkillScores()
    {
        $candidate = Candidate::with('position')->find($this->candidateId);
        if (!$candidate || !$candidate->position_id) return;

        $positionSkills = PositionSkill::with('skill')
            ->where('position_id', $candidate->position_id)
            ->get();

        $assignedAssessment = AssignedAssessment::where('candidate_id', $this->candidateId)->first();
        $assignedPractical = AssignedPractical::where('candidate_id', $this->candidateId)->first();
        $assignedOral = AssignedOral::where('candidate_id', $this->candidateId)->first();

        $assessmentScore = AssessmentScore::where('assigned_assessment_id', $assignedAssessment->id ?? null)->first();
        $practicalScore = PracticalScore::where('assigned_practical_id', $assignedPractical->id ?? null)->first();
        $oralScore = OralScore::where('assigned_oral_id', $assignedOral->id ?? null)->first();

        foreach ($positionSkills as $positionSkill) {
            $assessment = AssessmentScoreSkill::where('assessment_scores_id', $assessmentScore->id ?? null)
                        ->where('position_skill_id', $positionSkill->id)
                        ->value('skill_score');

            $practicalRaw = PracticalScoreSkill::where('practical_score_id', $practicalScore->id ?? null)
                        ->where('position_skill_id', $positionSkill->id)
                        ->value('score');

            $oralRaw = OralScoreSkill::where('oral_score_id', $oralScore->id ?? null)
                        ->where('position_skill_id', $positionSkill->id)
                        ->value('score');

            $practical = is_null($practicalRaw) ? 'N/A' : round(($practicalRaw / 5) * 100, 2);
            $oral = is_null($oralRaw) ? 'N/A' : round(($oralRaw / 5) * 100, 2);

            $scores = [];
            if (!is_null($assessment)) $scores[] = $assessment;
            if (is_numeric($practical)) $scores[] = $practical;
            if (is_numeric($oral)) $scores[] = $oral;

            $average = count($scores) ? round(array_sum($scores) / count($scores), 2) : 'N/A';
            $interpretation = is_numeric($average) ? $this->getInterpretation($average) : 'N/A';

            $this->skillScores[] = [
                'skill_name' => $positionSkill->skill->title ?? 'N/A',
                'competency_level' => ucfirst($positionSkill->competency_level),
                'assessment' => $assessment ?? 'N/A',
                'practical' => $practical,
                'oral' => $oral,
                'average' => $average,
                'interpretation' => $interpretation,
            ];
        }
    }


    public function getInterpretation($avg)
    {
        return match (true) {
            $avg >= 90 => 'Excellent',
            $avg >= 80 => 'Very Good',
            $avg >= 70 => 'Good',
            $avg >= 60 => 'Fair',
            default => 'Noob',
        };
    }


    public function render()
    {
        return view('livewire.scores.candidate-competency-result');
    }
}

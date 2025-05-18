<?php

namespace App\Livewire\Scores;

use App\Models\AssessmentScoreSkill;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\AssessmentScore;



class AssessmentScores extends Component
{
    public $editMode;

    public $archive = false;
    public $skill_name;
    public $skill_score;

    public $search;
    public $filterStatus = 'all'; 
    public $title, $skill_id, $status;
    public $assigned_date, $assessmentScores, $dateFinished, $timeFinished, $candidateName, $candidate_id, $assessorName, $access_code, $draft_status = 'draft';

    public $venues = [], $assessmentscoreskills = [];

    public $selectedSkillQuestions = [];
    public $selectedcandidate;

    public $assessmentScoreId, $assessmentSkillScoreId; 

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

    public function readAssessmentScore($assessmentscoreId)
    {
        $assessmentscore = AssessmentScore::with('candidate') 
            ->findOrFail($assessmentscoreId);
        $this->fill([
            'candidateName' => $assessmentscore->candidate?->fullname ?? 'N/A',
            'assessorName' => $assessmentscore->user?->name ?? 'N/A', 
            'dateFinished' => $assessmentscore->date_finished ?? 'N/A',
            'timeFinished' => $assessmentscore->time_finished ?? 'N/A',
            'status' => $assessmentscore->status ?? 'N/A',
            'assessmentscoreskills' => $assessmentscore->assessmentScoreSkills, 
        ]);

        $this->editMode = true;

        $this->dispatch('show-assessmentScoreModal');
    }

    public function saveSkillScore()
    {
        $this->validate([
            'skill_score' => 'required|numeric|min:0|max:100',
        ]);

        $assessmentSkillScore = AssessmentScoreSkill::findOrFail($this->assessmentSkillScoreId);
        $assessmentSkillScore->skill_score = $this->skill_score;
        $assessmentSkillScore->save();

        $assessmentScore = $assessmentSkillScore->assessmentScore;

        if ($assessmentScore) {
            $average = $assessmentScore->assessmentScoreSkills()
                ->whereNotNull('skill_score')
                ->avg('skill_score');

            $assessmentScore->total_score = round($average, 2); 
            $assessmentScore->user_id = auth()->id(); 
            $assessmentScore->save();

            $this->assessmentscoreskills = $assessmentScore->assessmentScoreSkills()->with('position_skill')->get();
            $this->assessorName = $assessmentScore->user?->name ?? 'N/A'; 
        }

        $this->dispatch('success', 'Skill score updated.');
        $this->dispatch('hide-assessmentSkillScoreModal');
    }



    public function readSkillScore($assessmentskillscoreId)
    {
        $assessmentSkillScore = AssessmentScoreSkill::findOrFail($assessmentskillscoreId);
        $this->assessmentSkillScoreId = $assessmentskillscoreId;
        $this->fill([
            'skill_score' => $assessmentSkillScore->skill_score ?? '',
            'skill_name' => $assessmentSkillScore->skill->title ?? '',
        ]);
        $this->dispatch('show-assessmentSkillScoreModal');
    }

    public function readSkillQuestions($assessmentScoreSkillId)
    {
        $assessmentScoreSkill = AssessmentScoreSkill::with([
            'skillQuestions.assessmentquestion.choices'
        ])->findOrFail($assessmentScoreSkillId);

        $this->selectedSkillQuestions = $assessmentScoreSkill->skillQuestions;

        $this->dispatch('show-assessmentSkillQuestionsModal');
    }


}

<?php

namespace App\Livewire\Test\Assessment;

use Livewire\Component;
use App\Models\Position;
use App\Models\Skill;
use App\Models\AQChoice;
use App\Models\AssessmentQuestion;
use App\Models\PositionSkill;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ViewQuestions extends Component
{
    public $positions = [];

    
    public $skills = [];

    public $choices = [['text' => '', 'status' => 'incorrect']];
    
    public $position_skill, $position_skill_id, $position, $position_id, $title, $skill, $skill_id, $question, $duration = 0, $status, $vduration;
    public $points = 1;

    public $hours = 0, $minutes = 0, $seconds = 0;
    public $assessmentquestion_id;
    public $deletedQuestions = [];


    public $questions = [
        [
            'question' => '',
            'points' => 1,
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0,
            'choices' => [
                ['text' => '', 'status' => 'correct'],
                ['text' => '', 'status' => 'incorrect'],
            ],
        ]
    ];
    

    public function mount()
    {
        $this->position_id = request()->query('position_id');
        $this->skill_id = request()->query('skill_id');
        
        if ($this->position_id && $this->skill_id) {
            $this->position = Position::find($this->position_id);
            $this->skill = Skill::find($this->skill_id);
            
            $this->position_skill = PositionSkill::where('position_id', $this->position_id)
                ->where('skill_id', $this->skill_id)
                ->first();
            
            if ($this->position_skill) {
                $this->position_skill_id = $this->position_skill->id;
                
                $this->loadAssessmentQuestions($this->position_skill_id);
            }
        }
    }

    public function loadAssessmentQuestions($position_skill_id)
    {
        $this->questions = AssessmentQuestion::where('position_skill_id', $position_skill_id)
            ->with('choices')
            ->get()
            ->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                    'points' => $question->points,
                    'hours' => floor($question->duration / 3600),
                    'minutes' => floor(($question->duration % 3600) / 60),
                    'seconds' => $question->duration % 60,
                    'choices' => $question->choices->map(function ($choice) {
                        return [
                            'text' => $choice->choice_text,
                            'status' => $choice->is_answer ? 'correct' : 'incorrect',
                        ];
                    })->toArray(),
                ];
            })->toArray();
    }
        
    public function render()
    {
        return view('livewire.test.assessment.view-questions');
    }


}

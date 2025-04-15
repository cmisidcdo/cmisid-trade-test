<?php

namespace App\Livewire\Test\Oral;

use Livewire\Component;
use App\Models\Position;
use App\Models\Skill;
use App\Models\OralQuestion;
use App\Models\PositionSkill;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ViewOralQuestions extends Component
{
    public $positions = [];

    
    public $skills = [];
    
    public $position_skill, $position_skill_id, $position, $position_id, $title, $skill, $skill_id, $question, $duration = 0, $status, $vduration;
    public $points = 1, $archive;

    public $hours = 0, $minutes = 0, $seconds = 0;
    public $oralquestion_id, $existing_file;




    public $questions = [
        [
            'question' => '',
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0,
        ]
    ];
    
    public function render()
    {
        return view('livewire.test.oral.view-oral-questions');
    }

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
                
                $this->loadOralQuestions($this->position_skill_id);
            }
        }
    }

    public function loadOralQuestions($position_skill_id)
    {
        $query = OralQuestion::query();

        if ($this->archive) {
            $query->onlyTrashed();
        }

        $this->questions = $query->where('position_skill_id', $position_skill_id)
            ->get()
            ->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                    'description' => $question->description,
                    'hours' => floor($question->duration / 3600),
                    'minutes' => floor(($question->duration % 3600) / 60),
                    'seconds' => $question->duration % 60,
                    'existing_file' => $question->file_path ?? null,
                ];
            })->toArray();
    }

    public function toggleArchive()
    {
        $this->archive = !$this->archive;

        if ($this->position_skill_id) {
            $this->loadOralQuestions($this->position_skill_id);
        }
    }
}

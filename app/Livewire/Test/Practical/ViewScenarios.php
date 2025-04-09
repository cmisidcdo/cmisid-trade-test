<?php

namespace App\Livewire\Test\Practical;

use Livewire\Component;
use App\Models\Position;
use App\Models\Skill;
use App\Models\AQChoice;
use App\Models\PracticalScenario;
use App\Models\PositionSkill;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class ViewScenarios extends Component
{
    public function render()
    {
        return view('livewire.test.practical.view-scenarios');
    }

    public $positions = [];

    
    public $skills = [];
    
    public $position_skill, $position_skill_id, $position, $position_id, $title, $skill, $skill_id, $scenario, $duration = 0, $status, $vduration;
    public $points = 1;

    public $hours = 0, $minutes = 0, $seconds = 0;
    public $practicalscenario_id, $existing_file;




    public $scenarios = [
        [
            'scenario' => '',
            'hours' => 0,
            'minutes' => 0,
            'seconds' => 0,
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
                
                $this->loadPracticalScenarios($this->position_skill_id);
            }
        }
    }

    public function loadPracticalScenarios($position_skill_id)
    {
        $this->scenarios = PracticalScenario::where('position_skill_id', $position_skill_id)
            ->get()
            ->map(function ($scenario) {
                return [
                    'id' => $scenario->id,
                    'scenario' => $scenario->scenario,
                    'description' => $scenario->description,
                    'hours' => floor($scenario->duration / 3600),
                    'minutes' => floor(($scenario->duration % 3600) / 60),
                    'seconds' => $scenario->duration % 60,
                    'existing_file' => $scenario->file_path ?? null,
                ];
            })->toArray();
    }
}

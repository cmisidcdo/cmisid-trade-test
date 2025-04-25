<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticalScoreSkillScenario extends Model
{
    protected $table = 'practical_score_skill_scenarios'; 
    protected $guarded = [];

    public function practical_scenarios()
    {
        return $this->belongsTo(PracticalScenario::class, 'practical_scenario_id');
    }

    public function practicalScoreSkill()
    {
        return $this->belongsTo(PracticalScoreSkill::class, 'practical_score_skill_id');
    }

}

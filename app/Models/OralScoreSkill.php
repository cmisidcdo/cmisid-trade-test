<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OralScoreSkill extends Model
{
    protected $table = 'oral_scores_skills'; 
    protected $guarded = [];

    public function position_skill()
    {
        return $this->belongsTo(PositionSkill::class);
    }

    public function getSkillAttribute()
    {
        return $this->position_skill?->skill;
    }

    public function oralScore()
    {
        return $this->belongsTo(OralScore::class, 'oral_score_id');
    }
}

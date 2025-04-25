<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PracticalScoreSkill extends Model
{
    protected $table = 'practical_scores_skills'; 
    protected $guarded = [];

    public function position_skill()
    {
        return $this->belongsTo(PositionSkill::class);
    }

    public function getSkillAttribute()
    {
        return $this->position_skill?->skill;
    }

    public function practicalScore()
    {
        return $this->belongsTo(PracticalScore::class, 'practical_score_id');
    }


}

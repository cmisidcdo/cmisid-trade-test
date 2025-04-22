<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentScoreSkill extends Model
{
    protected $table = 'assessment_scores_skills'; 
    protected $guarded = [];

    public function assessmentScore()
    {
        return $this->belongsTo(AssessmentScore::class, 'assessment_scores_id');
    }

    public function position_skill()
    {
        return $this->belongsTo(PositionSkill::class);
    }

    public function getSkillAttribute()
    {
        return $this->position_skill?->skill;
    }
}

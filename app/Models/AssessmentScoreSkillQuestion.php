<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentScoreSkillQuestion extends Model
{
    protected $table = 'assessment_scores_skills_questions'; 
    protected $guarded = [];

    public function assessmentquestion()
    {
        return $this->belongsTo(AssessmentQuestion::class, 'assessmentquestion_id');
    }
}

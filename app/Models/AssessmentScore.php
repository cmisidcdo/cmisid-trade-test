<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class AssessmentScore extends Model
{
    protected $table = 'assessment_scores'; 
    protected $guarded = [];

    public function assignedassessment()
    {
        return $this->belongsTo(AssignedAssessment::class, 'assigned_assessment_id');
    }

    public function candidate(): HasOneThrough
    {
        return $this->hasOneThrough(
            Candidate::class,              
            AssignedAssessment::class,     
            'id',                         
            'id',                         
            'assigned_assessment_id',     
            'candidate_id'              
        );
    }

    public function assessmentScoreSkills()
    {
        return $this->hasMany(AssessmentScoreSkill::class, 'assessment_scores_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}

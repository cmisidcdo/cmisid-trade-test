<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class OralScore extends Model
{
    protected $table = 'oral_scores'; 
    protected $guarded = [];

    public function assigned_oral()
    {
        return $this->belongsTo(AssignedOral::class, 'assigned_oral_id');
    }

    public function candidate(): HasOneThrough
    {
        return $this->hasOneThrough(
            Candidate::class,              
            AssignedOral::class,     
            'id',                         
            'id',                         
            'assigned_oral_id',     
            'candidate_id'              
        );
    }

    public function oralScoreSkills()
    {
        return $this->hasMany(OralScoreSkill::class, 'oral_score_id');
    }
}

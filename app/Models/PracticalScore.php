<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class PracticalScore extends Model
{
    protected $table = 'practical_scores'; 
    protected $guarded = [];

    public function assigned_practical()
    {
        return $this->belongsTo(AssignedPractical::class, 'assigned_practical_id');
    }

    public function candidate(): HasOneThrough
    {
        return $this->hasOneThrough(
            Candidate::class,              
            AssignedPractical::class,     
            'id',                         
            'id',                         
            'assigned_practical_id',     
            'candidate_id'              
        );
    }

    public function practicalScoreSkills()
    {
        return $this->hasMany(PracticalScoreSkill::class, 'practical_score_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

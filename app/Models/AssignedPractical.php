<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedPractical extends Model
{
    protected $table = 'assigned_practicals'; 
    protected $guarded = [];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function practicalScore()
    {
        return $this->hasOne(PracticalScore::class);
    }
}

<?php

namespace App\Models;
use App\Models\Candidate;
use App\Models\Venue;

use Illuminate\Database\Eloquent\Model;

class AssignedAssessment extends Model
{
    protected $table = 'assigned_assessments'; 
    protected $guarded = [];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}

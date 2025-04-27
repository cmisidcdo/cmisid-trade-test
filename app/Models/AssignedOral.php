<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedOral extends Model
{
    protected $table = 'assigned_orals'; 
    protected $guarded = [];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function oralScore()
    {
        return $this->hasOne(OralScore::class);
    }
}

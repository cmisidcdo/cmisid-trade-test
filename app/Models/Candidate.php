<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidate extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'candidates'; 
    protected $guarded = [];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
    
    public function priorityGroup()
    {
        return $this->belongsTo(PriorityGroup::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PositionSkill extends Model
{
    protected $table = 'position_skills'; 
    protected $guarded = [];

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

}

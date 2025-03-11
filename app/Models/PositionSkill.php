<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PositionSkill extends Model
{
    protected $table = 'position_skills'; 
    protected $guarded = [];
}

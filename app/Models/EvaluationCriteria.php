<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluationCriteria extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'evaluation_criterias'; 
    protected $guarded = [];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AssessmentQuestion extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

    protected $table = 'assessmentquestions'; 
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()
            ->useLogName('assessment_questions_management')
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();

        if ($this->exists && is_null($this->deleted_at)) {
            $logOptions->logExcept(['updated_at', 'deleted_at']);
        }

        return $logOptions;
    }

    public function skill()
    {
        return $this->hasOneThrough(
            Skill::class,
            PositionSkill::class,
            'id',                 
            'id',                 
            'position_skill_id',  
            'skill_id'         
        );
    }

    public function choices()
    {
        return $this->hasMany(AQChoice::class, 'question_id');
    }

    public function positionSkill()
    {
        return $this->belongsTo(PositionSkill::class, 'position_skill_id');
    }

    public function position()
    {
        return $this->hasOneThrough(
            Position::class,
            PositionSkill::class,
            'id',              
            'id',             
            'position_skill_id',
            'position_id'      
        );
    }



}

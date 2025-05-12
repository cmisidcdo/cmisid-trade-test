<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Candidate extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()
            ->useLogName('candidate_management')
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();

        if ($this->exists && is_null($this->deleted_at)) {
            $logOptions->logExcept(['updated_at', 'deleted_at']);
        }

        return $logOptions;
    }

    public function assignedAssessments()
    {
        return $this->hasMany(AssignedAssessment::class);
    }

    public function assignedPracticals()
    {
        return $this->hasMany(AssignedPractical::class);
    }

    public function assignedOrals()
    {
        return $this->hasMany(AssignedOral::class);
    }


}   

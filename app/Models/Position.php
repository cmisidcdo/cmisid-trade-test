<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Position extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

    protected $table = 'positions'; 
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()
            ->useLogName('position_management')
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();

        if ($this->exists && is_null($this->deleted_at)) {
            $logOptions->logExcept(['updated_at', 'deleted_at']);
        }

        return $logOptions;
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'position_skills')  
            ->withPivot('competency_level')
            ->withTimestamps()
            ->withTrashed();
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

}

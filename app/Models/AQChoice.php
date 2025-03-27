<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AQChoice extends Model
{
    use  HasFactory, LogsActivity;

    protected $table = 'aq_choices'; 
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()
            ->useLogName('assessment_questions_management')
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();

        return $logOptions;
    }
}

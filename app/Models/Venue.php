<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Venue extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

    protected $table = 'venues'; 
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()
            ->useLogName('venue_management')
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();

        if ($this->exists && is_null($this->deleted_at)) {
            $logOptions->logExcept(['updated_at', 'deleted_at']);
        }

        return $logOptions;
    }

}

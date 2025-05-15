<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Symfony\Component\Translation\Test\IncompleteDsnTestTrait;

class PriorityGroup extends Model
{
   use SoftDeletes, HasFactory, LogsActivity;

   protected $table = 'priority_groups'; 
   protected $guarded = [];

   public function getActivitylogOptions(): LogOptions
   {
       $logOptions = LogOptions::defaults()
           ->useLogName('prioritygroup_management')
           ->logAll()
           ->logOnlyDirty()
           ->dontSubmitEmptyLogs();

       if ($this->exists && is_null($this->deleted_at)) {
           $logOptions->logExcept(['updated_at', 'deleted_at']);
       }

       return $logOptions;
   }

   public function candidates()
   {
       return $this->hasMany(Candidate::class);
   }
}

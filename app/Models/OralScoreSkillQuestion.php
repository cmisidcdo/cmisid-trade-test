<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OralScoreSkillQuestion extends Model
{
    protected $table = 'oral_score_skill_questions'; 
    protected $guarded = [];

    public function oral_questions()
    {
        return $this->belongsTo(OralQuestion::class, 'oral_question_id');
    }

    public function oralScoreSkill()
    {
        return $this->belongsTo(OralScoreSkill::class, 'oral_score_skill_id');
    }
}

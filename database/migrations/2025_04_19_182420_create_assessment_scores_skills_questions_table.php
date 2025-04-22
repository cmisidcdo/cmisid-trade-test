<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assessment_scores_skills_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_score_skill_id')
                  ->constrained('assessment_score_skills')
                  ->onDelete('cascade')
                  ->name('fk_ass_score_skill'); 

            $table->foreignId('assessmentquestion_id')
                  ->constrained('assessmentquestions')
                  ->onDelete('cascade');

            $table->integer('answer')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_scores_skills_questions');
    }
};

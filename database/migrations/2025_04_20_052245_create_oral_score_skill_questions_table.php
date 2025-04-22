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
        Schema::create('oral_score_skill_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oral_score_skill_id')
                    ->constrained('oral_score_skills')
                    ->onDelete('cascade')
                    ->name('fk_ass_score_skill'); 

            $table->foreignId('oral_question_id')
                    ->constrained('oral_questions')
                    ->onDelete('cascade');

            $table->tinyInteger('knowledge')->nullable();
            $table->tinyInteger('completeness')->nullable();
            $table->tinyInteger('problem_solving')->nullable();
            $table->decimal('final_score', 3, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oral_score_skill_questions');
    }
};

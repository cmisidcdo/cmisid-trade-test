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
        Schema::create('practical_scores_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practical_score_id')->constrained('practical_scores')->onDelete('cascade');
            $table->foreignId('position_skill_id')->constrained('position_skills')->onDelete('cascade');
            $table->decimal('score', 3, 2)->nullable();
            $table->tinyInteger('task_completion')->nullable();
            $table->tinyInteger('accuracy')->nullable();
            $table->tinyInteger('problem_solving')->nullable();
            $table->tinyInteger('efficiency')->nullable();
            $table->string('recommendation')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practical_scores_skills');
    }
};

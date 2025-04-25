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
        Schema::create('assessment_scores_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_scores_id')->constrained('assessment_scores')->onDelete('cascade');
            $table->foreignId('position_skill_id')->constrained('position_skills')->onDelete('cascade');
            $table->integer('skill_score')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_scores_skills');
    }
};

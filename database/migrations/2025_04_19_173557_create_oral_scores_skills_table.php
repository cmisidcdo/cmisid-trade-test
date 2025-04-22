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
        Schema::create('oral_scores_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oral_score_id')->constrained('oral_scores')->onDelete('cascade');
            $table->foreignId('position_skill_id')->constrained('position_skills')->onDelete('cascade');
            $table->tinyInteger('score')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oral_scores_skills');
    }
};

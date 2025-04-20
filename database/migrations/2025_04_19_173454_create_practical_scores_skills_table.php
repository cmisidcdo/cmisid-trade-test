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
            $table->foreignId('practical_scores_id')->constrained('practical_scores')->onDelete('cascade');
            $table->foreignId('positon_skill_id')->constrained('position_skills')->onDelete('cascade');
            $table->integer('score')->default(0);
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

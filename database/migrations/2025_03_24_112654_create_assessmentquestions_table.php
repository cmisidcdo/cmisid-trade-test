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
        Schema::create('assessmentquestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_skill_id')->constrained('position_skills')->onDelete('cascade');
            $table->string('question');
            $table->integer('duration');
            $table->enum('competency_level', ['basic', 'intermediate', 'advanced']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessmentquestions');
    }
};

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
        Schema::create('practical_score_skill_scenarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practical_score_skill_id')
                    ->constrained('practical_score_skills')
                    ->onDelete('cascade')
                    ->name('fk_pes_score_skill'); 

            $table->foreignId('practical_scenario_id')
                    ->constrained('practical_scenarios')
                    ->onDelete('cascade');
            
            $table->tinyInteger('task_completion')->nullable();
            $table->tinyInteger('accuracy')->nullable();
            $table->tinyInteger('problem_solving')->nullable();
            $table->tinyInteger('efficiency')->nullable();
            $table->decimal('final_score', 3, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practical_score_skill_scenarios');
    }
};

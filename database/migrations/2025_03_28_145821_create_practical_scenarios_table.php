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
        Schema::create('practical_scenarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('position_skill_id')->constrained('position_skills')->onDelete('cascade');
            $table->string('scenario');
            $table->string('description');
            $table->integer('duration');
            $table->string('file_path')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practical_scenarios');
    }
};

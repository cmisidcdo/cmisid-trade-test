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
        Schema::create('assigned_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained()->onDelete('cascade');
            $table->string('access_code');
            $table->date('assigned_date');
            $table->time('assigned_time');
            $table->foreignId('venue_id')->constrained()->onDelete('cascade');
            $table->enum('assessment_status', ['ongoing', 'done'])->default('ongoing');
            $table->enum('draft_status', ['draft', 'published'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_assessments');
    }
};

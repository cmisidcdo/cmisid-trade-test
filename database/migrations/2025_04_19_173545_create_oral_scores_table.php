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
        Schema::create('oral_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assigned_oral_id')->constrained('assigned_orals')->onDelete('cascade');
            $table->date('date_finished')->nullable();
            $table->time('time_finished')->nullable();
            $table->decimal('total_score', 5, 2)->nullable();
            $table->integer('total_duration')->nullable();
            $table->enum('status', ['pending', 'ongoing', 'done'])->default('pending');
            $table->timestamp('started_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oral_scores');
    }
};

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
        Schema::create('aq_choices', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('question_id')->constrained('assessmentquestions')->onDelete('cascade');
            $table->string('choice_text');
            $table->boolean('is_answer')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aq_choices');
    }
};

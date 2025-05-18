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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_initial')->nullable();
            $table->string('family_name');
            $table->string('extension')->nullable();
            $table->string('email')->unique();
            $table->string('contactno')->unique();
            $table->text('attachments')->nullable();
            $table->string('remarks')->nullable();
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade');
            $table->foreignId('office_id')->constrained('offices')->onDelete('cascade');
            $table->foreignId('priority_group_id')->constrained('priority_groups')->onDelete('cascade');
            $table->softDeletes();
            $table->date('endorsement_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};

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
        Schema::create('readmission_letters', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->foreignId('letter_type_id')->constrained()->restrictOnDelete();
            $table->date('date');
            $table->foreignId('student_id')->constrained()->restrictOnDelete();
            $table->foreignId('readmission_academic_session_id')->constrained('academic_sessions')->restrictOnDelete();
            $table->foreignId('readmission_condition_id')->constrained()->restrictOnDelete();
            $table->string('meeting_number')->nullable();
            $table->date('meeting_date')->nullable();
            $table->foreignId('signatory_id')->constrained()->restrictOnDelete();
            $table->enum('language', ['en', 'bm'])->default('en');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('readmission_letters');
    }
};

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
        Schema::create('loa_letters', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->foreignId('letter_type_id')->constrained()->restrictOnDelete();
            $table->date('date');
            $table->foreignId('student_id')->constrained()->restrictOnDelete();
            $table->foreignId('leave_academic_session_id')->constrained('academic_sessions')->restrictOnDelete();
            $table->string('meeting_number')->nullable();
            $table->date('meeting_date')->nullable();
            $table->enum('status', ['approved', 'rejected'])->default('approved');
            $table->enum('reason_type', ['medical', 'maternity', 'other']);
            $table->string('other_reason_note')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('loa_letters');
    }
};

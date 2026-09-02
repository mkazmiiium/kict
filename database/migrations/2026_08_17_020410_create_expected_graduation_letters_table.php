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
        Schema::create('expected_graduation_letters', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->foreignId('letter_type_id')->constrained()->restrictOnDelete();
            $table->date('date');
            $table->foreignId('student_id')->constrained()->restrictOnDelete();
            $table->foreignId('current_academic_session_id')->nullable()->constrained('academic_sessions')->restrictOnDelete();
            $table->foreignId('joined_academic_session_id')->constrained('academic_sessions')->restrictOnDelete();
            $table->string('graduation_semester_text');
            $table->boolean('include_cgpa')->default(false);
            $table->foreignId('cgpa_academic_session_id')->nullable()->constrained('academic_sessions')->restrictOnDelete();
            $table->decimal('cgpa', 3, 2)->nullable();
            $table->text('endorsing_body_text')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('body_text');
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
        Schema::dropIfExists('expected_graduation_letters');
    }
};

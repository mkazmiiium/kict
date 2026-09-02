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
        Schema::dropIfExists('iap_expected_graduation_letters');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('iap_expected_graduation_letters', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->foreignId('letter_type_id')->constrained()->restrictOnDelete();
            $table->date('date');
            $table->foreignId('student_id')->constrained()->restrictOnDelete();
            $table->foreignId('iap_academic_session_id');
            $table->date('iap_completion_date');
            $table->foreignId('joined_academic_session_id');
            $table->string('expected_graduation_text');
            $table->text('endorsing_body_text')->nullable();
            $table->string('contact_email')->nullable();
            $table->text('body_text');
            $table->foreignId('signatory_id')->constrained()->restrictOnDelete();
            $table->enum('language', ['en', 'bm'])->default('en');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('iap_academic_session_id', 'iap_letters_iap_session_foreign')
                ->references('id')->on('academic_sessions')->restrictOnDelete();
            $table->foreign('joined_academic_session_id', 'iap_letters_joined_session_foreign')
                ->references('id')->on('academic_sessions')->restrictOnDelete();
        });
    }
};

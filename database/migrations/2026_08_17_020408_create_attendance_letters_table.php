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
        Schema::create('attendance_letters', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->unique();
            $table->foreignId('letter_type_id')->constrained()->restrictOnDelete();
            $table->date('date');
            $table->foreignId('student_id')->constrained()->restrictOnDelete();
            $table->decimal('attendance_percentage', 5, 2)->default(80.00);
            $table->text('body_text');
            $table->foreignId('signatory_id')->constrained()->restrictOnDelete();
            $table->enum('language', ['en', 'bm'])->default('bm');
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
        Schema::dropIfExists('attendance_letters');
    }
};

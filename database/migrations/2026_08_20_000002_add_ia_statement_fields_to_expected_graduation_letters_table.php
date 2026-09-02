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
        Schema::table('expected_graduation_letters', function (Blueprint $table) {
            $table->boolean('include_ia_statement')->default(false)->after('cgpa');
            $table->foreignId('ia_academic_session_id')->nullable()->after('include_ia_statement')
                ->constrained('academic_sessions')->restrictOnDelete();
            $table->date('ia_completion_date')->nullable()->after('ia_academic_session_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expected_graduation_letters', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ia_academic_session_id');
            $table->dropColumn(['include_ia_statement', 'ia_completion_date']);
        });
    }
};

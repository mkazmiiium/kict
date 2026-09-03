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
        Schema::table('provisional_records', function (Blueprint $table) {
            $table->string('meeting_number')->nullable()->after('cgpa');
            $table->date('meeting_date')->nullable()->after('meeting_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provisional_records', function (Blueprint $table) {
            $table->dropColumn(['meeting_number', 'meeting_date']);
        });
    }
};

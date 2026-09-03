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
        Schema::table('reinstate_records', function (Blueprint $table) {
            $table->string('meeting_number')->nullable()->after('date');
            $table->date('meeting_date')->nullable()->after('meeting_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reinstate_records', function (Blueprint $table) {
            $table->dropColumn(['meeting_number', 'meeting_date']);
        });
    }
};

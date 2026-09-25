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
        Schema::table('proposals', function (Blueprint $table) {
            $table->boolean('needs_sponsorship_letter')->default(false)->after('ddsdce_remark');
            $table->boolean('needs_invitation_letter')->default(false)->after('needs_sponsorship_letter');
            $table->boolean('needs_appointment_letter')->default(false)->after('needs_invitation_letter');
            $table->boolean('needs_approval_letter')->default(true)->after('needs_appointment_letter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn(['needs_sponsorship_letter', 'needs_invitation_letter', 'needs_appointment_letter', 'needs_approval_letter']);
        });
    }
};

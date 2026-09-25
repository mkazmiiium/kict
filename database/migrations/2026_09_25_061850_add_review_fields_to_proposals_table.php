<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->text('ddsdce_remark')->nullable()->after('status');
        });

        // "rejected" is renamed to "make_correction" — DDSDCE sends the proposal
        // back with a remark instead of a terminal rejection, and ICTSS can still
        // edit and resubmit it.
        DB::statement("UPDATE proposals SET status = 'draft' WHERE status = 'rejected'");
        DB::statement("ALTER TABLE proposals MODIFY status ENUM('draft', 'under_review', 'approved', 'make_correction') NOT NULL DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE proposals SET status = 'draft' WHERE status = 'make_correction'");
        DB::statement("ALTER TABLE proposals MODIFY status ENUM('draft', 'under_review', 'approved', 'rejected') NOT NULL DEFAULT 'draft'");

        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('ddsdce_remark');
        });
    }
};

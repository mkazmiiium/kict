<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_g_decentraliseds', function (Blueprint $table) {
            $table->id();
            $table->string('course_id');
            $table->string('staff_id');
            $table->date('booking_date');
            $table->string('booking_slot');
            $table->string('student_capacity');
            $table->timestamps();
            $table->string('program_id');
            $table->string('sections');
            $table->string('assessment_type');
            $table->string('assessment_time');
            $table->string('deleted')->default('no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_g_decentraliseds');
    }
};

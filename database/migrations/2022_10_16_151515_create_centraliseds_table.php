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
        Schema::create('centraliseds', function (Blueprint $table) {
            $table->id();
            $table->string('course_id');
            $table->string('staff_id');
            // $table->date('booking_date');
            // $table->string('booking_slot');
            $table->string('student_capacity');
            $table->timestamps();
            $table->string('program_id');
            $table->string('sections');
            // $table->string('assessment_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('centraliseds');
    }
};

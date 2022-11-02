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
        Schema::create('p_g_centraliseds', function (Blueprint $table) {
            $table->id();
            $table->string('course_id');
            $table->string('staff_id');
            $table->string('student_capacity');
            $table->timestamps();
            $table->string('program_id');
            $table->string('sections');
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
        Schema::dropIfExists('pg_centraliseds');
    }
};

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
        Schema::create('kulliyyahs', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_bm')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_no')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kulliyyahs');
    }
};

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
        Schema::create('proposal_budget_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained()->cascadeOnDelete();
            $table->enum('category', ['stadd_trust_fund', 'student_activities_programme', 'sponsorships_participants_fee']);
            $table->string('particular');
            $table->decimal('price_per_unit', 12, 2)->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->decimal('amount', 12, 2)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_budget_items');
    }
};

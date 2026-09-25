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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('society_term_id')->nullable()->constrained('society_terms')->nullOnDelete();
            $table->text('introduction')->nullable();
            $table->text('background')->nullable();
            $table->text('objectives')->nullable();
            $table->text('impact_sustainability')->nullable();
            $table->text('impact_care_compassion')->nullable();
            $table->text('impact_respect')->nullable();
            $table->text('impact_innovation')->nullable();
            $table->text('impact_prosperity')->nullable();
            $table->text('impact_trust')->nullable();
            $table->date('programme_date')->nullable();
            $table->string('venue')->nullable();
            $table->string('organizer')->nullable();
            $table->text('participants')->nullable();
            $table->boolean('no_budget_required')->default(false);
            $table->decimal('financial_implication_amount', 12, 2)->nullable();
            $table->string('funding_source')->nullable();
            $table->string('prepared_by_name')->nullable();
            $table->string('prepared_by_position')->nullable();
            $table->date('prepared_by_date')->nullable();
            $table->foreignId('checked_by_signatory_proposal_id')->nullable()->constrained('signatories_proposal')->nullOnDelete();
            $table->date('checked_by_date')->nullable();
            $table->foreignId('reviewed_by_signatory_id')->nullable()->constrained('signatories')->nullOnDelete();
            $table->date('reviewed_by_date')->nullable();
            $table->foreignId('recommended_by_signatory_proposal_id')->nullable()->constrained('signatories_proposal')->nullOnDelete();
            $table->date('recommended_by_date')->nullable();
            $table->foreignId('approved_by_signatory_proposal_id')->nullable()->constrained('signatories_proposal')->nullOnDelete();
            $table->date('approved_by_date')->nullable();
            $table->enum('status', ['draft', 'under_review', 'approved', 'rejected'])->default('draft');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};

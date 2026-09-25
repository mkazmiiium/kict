<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('final_document_path')->nullable()->after('ddsdce_remark');
            $table->string('final_document_original_filename')->nullable()->after('final_document_path');
            $table->foreignId('final_document_uploaded_by')->nullable()->after('final_document_original_filename')->constrained('users')->nullOnDelete();
            $table->timestamp('final_document_uploaded_at')->nullable()->after('final_document_uploaded_by');
        });
    }

    public function down(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropConstrainedForeignId('final_document_uploaded_by');
            $table->dropColumn(['final_document_path', 'final_document_original_filename', 'final_document_uploaded_at']);
        });
    }
};

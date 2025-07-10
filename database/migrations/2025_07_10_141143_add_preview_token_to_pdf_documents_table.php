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
        if (Schema::hasTable('pdf_documents')) {
            Schema::table('pdf_documents', function (Blueprint $table) {
                $table->string('preview_token', 20)->nullable()->unique()->after('file_path');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pdf_documents')) {
            Schema::table('pdf_documents', function (Blueprint $table) {
                if (Schema::hasColumn('pdf_documents', 'preview_token')) {
                    $table->dropColumn('preview_token');
                }
            });
        }
    }
};

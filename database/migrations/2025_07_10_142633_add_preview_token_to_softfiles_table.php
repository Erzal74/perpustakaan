<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('softfiles', function (Blueprint $table) {
            $table->string('preview_token', 20)->nullable()->unique()->after('file_path');
        });
    }

    public function down(): void
    {
        Schema::table('softfiles', function (Blueprint $table) {
            $table->dropColumn('preview_token');
        });
    }
};

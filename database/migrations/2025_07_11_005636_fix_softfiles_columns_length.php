<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('softfiles', function (Blueprint $table) {
            $table->string('isbn', 20)->nullable()->change();
            $table->string('issn', 20)->nullable()->change();
            $table->string('edition', 50)->nullable()->change();
            $table->string('genre', 100)->nullable()->change();
            $table->string('author', 100)->nullable()->change();
            $table->string('publisher', 100)->nullable()->change();
        });
    }

    public function down()
    {
        // Opsional: kembalikan ke nilai default jika diperlukan
        Schema::table('softfiles', function (Blueprint $table) {
            $table->string('isbn')->nullable()->change();
            $table->string('issn')->nullable()->change();
            $table->string('edition')->nullable()->change();
            $table->string('genre')->nullable()->change();
            $table->string('author')->nullable()->change();
            $table->string('publisher')->nullable()->change();
        });
    }
};

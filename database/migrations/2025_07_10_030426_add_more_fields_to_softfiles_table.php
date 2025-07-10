<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('softfiles', function (Blueprint $table) {
            $table->string('edition')->nullable();
            $table->string('author')->nullable();
            $table->string('genre')->nullable();
            $table->string('isbn')->nullable();
            $table->string('issn')->nullable();
            $table->string('publisher')->nullable();
            $table->year('publication_year')->nullable();
            $table->string('original_filename')->nullable();
        });
    }

    public function down()
    {
        Schema::table('softfiles', function (Blueprint $table) {
            $table->dropColumn([
                'edition',
                'author',
                'genre',
                'isbn',
                'issn',
                'publisher',
                'publication_year',
                'original_filename'
            ]);
        });
    }
};
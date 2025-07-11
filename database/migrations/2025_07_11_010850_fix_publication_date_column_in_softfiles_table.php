<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('softfiles', function (Blueprint $table) {
            $table->date('new_publication_date')->nullable();
        });

        DB::statement("UPDATE softfiles SET new_publication_date =
                    CASE
                        WHEN publication_date IS NOT NULL THEN
                            TO_DATE(publication_date || '-01', 'YYYY-MM-DD')
                        ELSE NULL
                    END");

        Schema::table('softfiles', function (Blueprint $table) {
            $table->dropColumn('publication_date');
            $table->renameColumn('new_publication_date', 'publication_date');
        });
    }

    public function down()
    {
        Schema::table('softfiles', function (Blueprint $table) {
            $table->string('old_publication_date', 7)->nullable();
        });

        DB::statement("UPDATE softfiles SET old_publication_date =
                    TO_CHAR(publication_date, 'YYYY-MM')");

        Schema::table('softfiles', function (Blueprint $table) {
            $table->dropColumn('publication_date');
            $table->renameColumn('old_publication_date', 'publication_date');
        });
    }
};

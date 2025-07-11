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
            $table->date('publication_date')->nullable()->after('publisher');
        });

        // Pindahkan data
        DB::statement("UPDATE softfiles SET publication_date =
                    CASE
                        WHEN publication_year IS NOT NULL THEN
                            TO_DATE(publication_year::text || '-01-01', 'YYYY-MM-DD')
                        ELSE NULL
                    END");

        Schema::table('softfiles', function (Blueprint $table) {
            $table->dropColumn('publication_year');
        });
    }

    public function down()
    {
        Schema::table('softfiles', function (Blueprint $table) {
            $table->year('publication_year')->nullable()->after('publisher');
        });

        // Kembalikan data (untuk PostgreSQL)
        DB::statement("UPDATE softfiles SET publication_year =
                    EXTRACT(YEAR FROM publication_date)::integer");

        Schema::table('softfiles', function (Blueprint $table) {
            $table->dropColumn('publication_date');
        });
    }
};

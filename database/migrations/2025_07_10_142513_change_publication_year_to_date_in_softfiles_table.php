<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahkan ini

return new class extends Migration
{
    public function up()
    {
        Schema::table('softfiles', function (Blueprint $table) {
            $table->string('publication_date', 7)->nullable()->after('publisher'); // Format YYYY-MM
        });

        // Pindahkan data
        DB::statement("UPDATE softfiles SET publication_date =
                    CASE
                        WHEN publication_year IS NOT NULL THEN
                            publication_year::text || '-01'
                        ELSE NULL
                    END");

        Schema::table('softfiles', function (Blueprint $table) {
            $table->dropColumn('publication_year');
        });
    }

    public function down()
    {
        Schema::table('softfiles', function (Blueprint $table) {
            // Kembalikan kolom tahun
            $table->year('publication_year')->nullable()->after('publisher');
        });

        // Kembalikan data (untuk PostgreSQL)
        DB::statement("UPDATE softfiles SET publication_year =
                    EXTRACT(YEAR FROM publication_date)::integer");

        // Hapus kolom date
        Schema::table('softfiles', function (Blueprint $table) {
            $table->dropColumn('publication_date');
        });
    }
};

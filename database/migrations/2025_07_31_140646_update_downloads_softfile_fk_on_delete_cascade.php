<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('downloads', function (Blueprint $table) {
            // Hapus foreign key constraint lama
            $table->dropForeign(['softfile_id']);

            // Tambahkan constraint baru dengan cascade
            $table->foreign('softfile_id')
                    ->references('id')
                    ->on('softfiles')
                    ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('downloads', function (Blueprint $table) {
            // Hapus constraint cascade
            $table->dropForeign(['softfile_id']);

            // Kembalikan ke constraint biasa (restrict)
            $table->foreign('softfile_id')
                    ->references('id')
                    ->on('softfiles')
                    ->onDelete('restrict'); // atau bisa dihapus onDelete-nya jika default
        });
    }
};


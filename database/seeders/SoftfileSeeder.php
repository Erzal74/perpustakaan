<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SoftfileSeeder extends Seeder
{
    public function run()
    {
        $genres = ['Teknologi', 'Bisnis', 'Fiksi', 'Sejarah', 'Pendidikan'];
        $publishers = ['Gramedia', 'Elex Media', 'Andi Publisher', 'Deepublish', 'Pustaka Pelajar'];

        $data = [];

        for ($i = 1; $i <= 100; $i++) {
            $judul = "Buku Ke-" . $i;
            $author = "Penulis " . chr(64 + ($i % 26 ?: 1)); // A-Z
            $edition = rand(1, 5);
            $genre = $genres[array_rand($genres)];
            $publisher = $publishers[array_rand($publishers)];
            $tahun = rand(2015, 2025);

            $data[] = [
                'title' => $judul,
                'author' => $author,
                'edition' => $edition,
                'genre' => $genre,
                'publisher' => $publisher,
                'publication_date' => $tahun . '-01-01',
                'file_path' => "softfiles/buku_ke_$i.pdf",
                'original_filename' => "buku_ke_$i.pdf",
                'preview_token' => Str::random(20),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('softfiles')->insert($data);
    }
}
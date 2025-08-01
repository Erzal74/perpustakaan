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
        $formats = ['pdf', 'doc', 'csv', 'txt', 'zip']; // emboh = zip (bisa diganti)

        $data = [];

        foreach ($formats as $i => $format) {
            $index = $i + 1;
            $judul = "Buku Ke-" . $index;
            $author = "Penulis " . chr(65 + $i); // A, B, C, ...
            $edition = rand(1, 5);
            $genre = $genres[array_rand($genres)];
            $publisher = $publishers[array_rand($publishers)];
            $tahun = rand(2015, 2025);
            $filename = "buku_ke_$index.$format";

            $data[] = [
                'title' => $judul,
                'author' => $author,
                'edition' => $edition,
                'genre' => $genre,
                'publisher' => $publisher,
                'publication_date' => $tahun . '-01-01',
                'file_path' => "softfiles/$filename",
                'original_filename' => $filename,
                'preview_token' => Str::random(20),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('softfiles')->insert($data);
    }
}

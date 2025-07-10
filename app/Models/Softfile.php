<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Softfile extends Model
{
    protected $fillable = [
        'title',
        'description',
        'file_path',
        'edition',
        'author',
        'genre',
        'isbn',
        'issn',
        'publisher',
        'publication_date', // Diubah dari publication_year ke publication_date
        'original_filename'
    ];

    // Tambahkan cast untuk memastikan format date
    protected $casts = [
        'publication_date' => 'string', // Format bulan dan tahun saja
    ];

    // Jika Anda perlu akses tahun saja sebagai attribute
    public function getPublicationYearAttribute()
    {
        return $this->publication_date ? date('Y', strtotime($this->publication_date)) : null;
    }
}

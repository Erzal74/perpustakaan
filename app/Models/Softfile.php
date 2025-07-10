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
        'publication_date', // Disimpan sebagai date lengkap, tapi hanya ditampilkan bulan-tahun
        'original_filename',
    ];

    protected $casts = [
        'publication_date' => 'date', // Disimpan sebagai date
    ];

    /**
     * Ambil hanya tahun dari publication_date.
     */
    public function getPublicationYearAttribute()
    {
        return $this->publication_date ? $this->publication_date->format('Y') : null;
    }

    /**
     * Ambil bulan dan tahun dari publication_date (opsional).
     */
    public function getPublicationMonthYearAttribute()
    {
        return $this->publication_date ? $this->publication_date->format('F Y') : null;
    }

    /**
     * Relasi ke dokumen PDF terkait softfile ini.
     */
    public function pdfDocuments()
    {
        return $this->hasMany(PdfDocument::class);
    }
}

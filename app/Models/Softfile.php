<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // ✅ Impor yang benar

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
        'publication_date',
        'original_filename',
    ];

    protected $casts = [
        'publication_date' => 'date',
    ];

    public function getPublicationYearAttribute()
    {
        return $this->publication_date ? $this->publication_date->format('Y') : null;
    }

    public function getPublicationMonthYearAttribute()
    {
        return $this->publication_date ? $this->publication_date->format('F Y') : null;
    }

    public function pdfDocument()
    {
        return $this->hasOne(PdfDocument::class);
    }

    public function getPreviewTokenAttribute()
    {
        $pdfDocument = $this->pdfDocument;

        if (!$pdfDocument) {
            $pdfDocument = $this->pdfDocument()->create([
                'preview_token' => Str::random(40),
            ]);
        }

        return $pdfDocument->preview_token;
    }
}

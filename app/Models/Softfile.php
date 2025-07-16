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

    public function getFilePathAttribute($value)
    {
        // Hilangkan prefix yang tidak diperlukan
        $value = str_replace(['storage/app/public/', 'app/public/'], '', $value);

        // Bersihkan slash di awal/tengah
        $value = ltrim($value, '/\\');

        return $value;
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
    // Add this to your Softfile model
public function downloads()
{
    return $this->hasMany(Download::class);
}

public function downloadCount()
{
    return $this->downloads()->count();
}
}

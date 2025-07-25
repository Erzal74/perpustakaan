<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'category',
    ];

    protected $casts = [
        'publication_date' => 'date',
    ];

    protected $appends = [
        'publication_year',
        'file_size',
        'formatted_file_size',
        'publication_month_year',
        'preview_token',
    ];

    /**
     * Get the publication year attribute
     */
    public function getPublicationYearAttribute()
    {
        return $this->publication_date?->format('Y');
    }

    /**
     * Get the file size in bytes
     */
    public function getFileSizeAttribute()
    {
        if (empty($this->file_path)) {
            return 0;
        }

        try {
            return Storage::disk('public')->size($this->file_path);
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get human-readable file size
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = $bytes ? floor(log($bytes) / log(1024)) : 0;
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * Get formatted publication date
     */
    public function getPublicationMonthYearAttribute()
    {
        return $this->publication_date?->format('F Y');
    }

    /**
     * Clean file path attribute
     */
    public function getFilePathAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return ltrim(str_replace(['storage/app/public/', 'app/public/'], '', $value), '/\\');
    }

    /**
     * Relationship with PDF documents
     */
    public function pdfDocument()
    {
        return $this->hasOne(PdfDocument::class);
    }

    /**
     * Get or create preview token
     */
    public function getPreviewTokenAttribute()
    {
        return $this->pdfDocument()->firstOrCreate(
            ['softfile_id' => $this->id],
            ['preview_token' => Str::random(40)]
        )->preview_token;
    }

    /**
     * Relationship with downloads
     */
    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    /**
     * Get download count
     */
    public function downloadCount()
    {
        return $this->downloads()->count();
    }

    /**
     * Scope for popular files
     */
    public function scopePopular($query)
    {
        return $query->withCount('downloads')
                    ->orderBy('downloads_count', 'desc');
    }

    /**
     * Scope for recent files
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get file extension
     */
    public function getFileExtensionAttribute()
    {
        return strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION));
    }

    /**
     * Get file type icon
     */
    public function getFileTypeIconAttribute()
    {
        $extension = $this->file_extension;

        $icons = [
            'pdf' => 'file-pdf',
            'doc' => 'file-word',
            'docx' => 'file-word',
            'xls' => 'file-excel',
            'xlsx' => 'file-excel',
            'ppt' => 'file-powerpoint',
            'pptx' => 'file-powerpoint',
            'zip' => 'file-archive',
            'rar' => 'file-archive',
        ];

        return $icons[$extension] ?? 'file';
    }
}

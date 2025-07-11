<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PdfDocument extends Model
{
    protected $fillable = ['softfile_id', 'preview_token'];

    public function softfile()
    {
        return $this->belongsTo(Softfile::class);
    }
}

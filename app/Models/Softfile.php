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
        'publication_year',
        'original_filename'
    ];
}
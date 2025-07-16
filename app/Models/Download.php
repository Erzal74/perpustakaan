<?php
// app/Models/Download.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $fillable = ['softfile_id', 'user_id'];

    public function softfile()
    {
        return $this->belongsTo(Softfile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
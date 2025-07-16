<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecentlyViewed extends Model
{
    protected $fillable = ['user_id', 'softfile_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function softfile()
    {
        return $this->belongsTo(Softfile::class);
    }
}

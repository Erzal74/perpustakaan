<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    // Relasi yang sudah diperbaiki
    public function recentlyViewed()
    {
        return $this->belongsToMany(Softfile::class, 'recently_viewed')
                   ->withTimestamps()
                   ->latest();
    }
}
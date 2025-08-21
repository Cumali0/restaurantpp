<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Mass assignment için hangi alanların doldurulabileceğini belirtiyoruz
    protected $fillable = [
        'role_id',
        'name' ,
        'surname',
        'phone',
        'email',
        'password',
    ];

    // Gizli alanlar
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Tip dönüşümleri
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Role ile ilişki
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Kullanıcının rezervasyonları varsa ilişki
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

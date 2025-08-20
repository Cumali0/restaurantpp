<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    // Mass assignment için hangi alanların doldurulabileceğini belirtiyoruz
    protected $fillable = [
        'name',
        'capacity',
        'floor',
        'preprice',
    ];

    // Rezervasyonlar ile ilişki (eğer Reservation modelin varsa)
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

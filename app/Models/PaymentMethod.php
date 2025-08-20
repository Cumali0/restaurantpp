<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    // Mass assignment için hangi alanlar doldurulabilir
    protected $fillable = [
        'name',
        'is_active',
    ];
}

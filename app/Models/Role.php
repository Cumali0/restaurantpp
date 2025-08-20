<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Mass assignment için hangi alanların doldurulabileceğini belirtiyoruz
    protected $fillable = [
        'name',
    ];

    // Role ile kullanıcılar arasındaki ilişki
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

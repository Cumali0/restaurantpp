<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $table = 'reservations'; // tablo adı

    protected $fillable = [
        'user_id',
        'table_id',
        'name',
        'surname',
        'phone',
        'email',
        'datetime',
        'end_datetime',
        'people',
        'message',
        'status',
        'is_preorder',
        'preorder_token',
    ];

    /* 🔗 İlişkiler */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

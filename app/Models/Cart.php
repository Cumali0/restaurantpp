<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'token',
        'order_id',
        'total_price',
    ];

    /* 🔗 İlişkiler */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Cart → Reservation ilişkisi
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

}

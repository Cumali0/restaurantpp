<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'total_price',
        'status',
        'order_time',
    ];

    // Order → Reservation ilişkisi
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    // Order → OrderItems ilişkisi (bir siparişin birden fazla ürünü olabilir)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

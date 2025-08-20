<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

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
        'preorder_token',
    ];

    // Reservation → User ilişkisi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Reservation → Table ilişkisi
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'hotel_id',
        'room_number',
        'orderable_id',
        'orderable_type',
        'quantity',
        'order_number',
        'price',
        'status',
        'payment_method',
        'payment_id',
        'payment_status',
    ];

    public function orderable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }
}

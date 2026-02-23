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
        'date',
        'time',
        'type',
        'notes',
        'price',
        'status',
        'payment_method',
        'payment_id',
        'payment_status',
        'is_tour_leader',
        'excursion_day_id',
        'excursion_time_id',
        'offer_time_id',
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

    public function orderStatuses()
    {
        return $this->hasMany(OrderStatus::class);
    }

    public function excursionDay()
    {
        return $this->belongsTo(ExcursionDay::class, 'excursion_day_id', 'id');
    }

    public function excursionTime()
    {
        return $this->belongsTo(ExcursionTime::class, 'excursion_time_id', 'id');
    }

    public function offerTime()
    {
        return $this->belongsTo(OfferTime::class, 'offer_time_id', 'id');
    }

    public function statuses()
    {
        return $this->hasMany(OrderStatus::class);
    }

    public function lastStatus()
    {
        return $this->hasOne(OrderStatus::class)->latestOfMany();
    }

}

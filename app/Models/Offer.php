<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'name'        => 'array',
        'description' => 'array',
        'is_active'   => 'boolean',
        'start_date'  => 'date',
        'end_date'    => 'date',
    ];

    public function excursions()
    {
        return $this->belongsToMany(Excursion::class, 'excursion_offers')
            ->withPivot('excursion_time_id')
            ->withTimestamps();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function orders()
    {
        return $this->morphMany(Order::class, 'orderable');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function offerTimes()
    {
        return $this->hasMany(OfferTime::class, 'offer_id');
    }
}

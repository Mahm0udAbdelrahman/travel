<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'category_event_id',
        'image',
        'name',
        'city_id',
        'date',
        'description',
        'price',
        'is_active',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'is_active' => 'boolean',
        'category_event_id' => 'integer',
        'city_id' => 'integer',

    ];

    public function categoryEvent()
    {
        return $this->belongsTo(CategoryEvent::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
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
}

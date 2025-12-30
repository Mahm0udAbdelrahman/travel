<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Excursion extends Model
{
    protected $fillable = [
        'category_excursion_id',
        'image',
        'name',
        'city_id',
        'description',
        'price',
        'hours',
        'is_active',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'is_active' => 'boolean',
    ];

    public function categoryExcursion()
    {
        return $this->belongsTo(CategoryExcursion::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'excursion_offers');
    }
}

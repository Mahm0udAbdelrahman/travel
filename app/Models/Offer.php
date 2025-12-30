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
        'name'       => 'array',
        'description' => 'array',
        'is_active'   => 'boolean',
    ];

    public function excursions()
    {
        return $this->belongsToMany(Excursion::class, 'excursion_offers');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

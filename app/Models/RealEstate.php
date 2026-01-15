<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealEstate extends Model
{
    protected $fillable = [
        'category_real_estate_id',
        'image',
        'name',
        'city_id',
        'description',
        'price',
        'is_active',
    ];

    protected $casts = [
        'name'        => 'array',
        'description' => 'array',
        'is_active'   => 'boolean',
    ];

    public function categoryRealEstate()
    {
        return $this->belongsTo(CategoryRealEstate::class);
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
}

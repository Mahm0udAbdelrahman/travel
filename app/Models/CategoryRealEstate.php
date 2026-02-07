<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryRealEstate extends Model
{
       protected $fillable = ['name', 'image','is_active'];

    protected $casts = [
        'name' => 'array',
        'is_active' => 'boolean',
    ];

    public function realEstates()
    {
        return $this->hasMany(RealEstate::class);
    }


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

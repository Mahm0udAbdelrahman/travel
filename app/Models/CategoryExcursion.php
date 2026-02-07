<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryExcursion extends Model
{
     protected $fillable = ['name', 'image','is_active'];

    protected $casts = [
        'name' => 'array',
        'is_active' => 'boolean',
    ];

    public function excursions()
    {
        return $this->hasMany(Excursion::class);
    }


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

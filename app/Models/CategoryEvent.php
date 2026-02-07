<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryEvent extends Model
{
    protected $fillable = ['name', 'image','is_active'];
    protected $casts = [
        'name' => 'array',
        'is_active' => 'boolean',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }


    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

}

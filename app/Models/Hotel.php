<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = ['name', 'is_active'];

    protected $casts = [
        'name' => 'array',
        'is_active' => 'boolean',
    ];

     public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

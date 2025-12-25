<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Excursion extends Model
{
     protected $fillable = [
        'name',
        'image',
        'is_active',
    ];

    protected $casts = [
        'name' => 'array',
        'is_active' => 'boolean',
    ];
 public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

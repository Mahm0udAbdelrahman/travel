<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['name', 'is_active'];

     protected $casts = [
        'name'        => 'array',
        'is_active'   => 'boolean',
    ];

     public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function tourLeaders()
    {
        return $this->belongsToMany(User::class, 'tour_leader_files', 'file_id', 'user_id');
    }
}

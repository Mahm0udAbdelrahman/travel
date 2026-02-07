<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategoryExcursion extends Model
{
    protected $fillable = [
        'category_excursion_id',
        'image',
        'name',
        'is_active',
    ];

    protected $casts = [
        'category_excursion_id' => 'integer',
        'name'                  => 'array',
        'is_active'             => 'boolean',
    ];

    public function categoryExcursion()
    {
       return  $this->belongsTo(CategoryExcursion::class, 'category_excursion_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExcursionTime extends Model
{
    protected $fillable = [
        'excursion_day_id',
        'from_time',
        'to_time',
    ];
    public function day()
    {
        return $this->belongsTo(ExcursionDay::class, 'excursion_day_id');
    }

}

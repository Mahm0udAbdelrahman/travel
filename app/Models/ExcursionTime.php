<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExcursionTime extends Model
{
    protected $fillable = [
        'excursion_id',
        'from_time',
        'to_time',
    ];
    public function excursion()
    {
        return $this->belongsTo(Excursion::class, 'excursion_id');
    }

}

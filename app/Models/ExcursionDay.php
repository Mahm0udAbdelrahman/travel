<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExcursionDay extends Model
{
    protected $fillable =
    [
        'excursion_id',
        'day',
    ];
    public function excursion()
    {
        return $this->belongsTo(Excursion::class);
    }

    public function times()
    {
        return $this->hasMany(ExcursionTime::class);
    }

}

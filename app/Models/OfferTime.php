<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferTime extends Model
{
     protected $fillable = [
        'offer_id',
        'from_time',
        'to_time',
    ];
    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
}

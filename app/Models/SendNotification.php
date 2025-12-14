<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SendNotification extends Model
{
    protected $fillable =
    [
        'title',
        'body',
        'topic',
    ];
}

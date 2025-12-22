<?php
namespace App\Models;

use App\Enums\InquiryType;
use Illuminate\Database\Eloquent\Model;

class OrderAdditionalService extends Model
{
    protected $fillable = [
        'user_id',
        'additional_service_id',
        'date',
        'time',
        'type',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function additionalService()
    {
        return $this->belongsTo(AdditionalService::class);
    }

    protected $casts = [
        'type'                  => InquiryType::class,
        'user_id'               => 'integer',
        'additional_service_id' => 'integer',
    ];

}

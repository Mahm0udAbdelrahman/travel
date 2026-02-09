<?php
namespace App\Services\Api\User;

use App\Models\Offer;
use App\Traits\HasImage;

class OfferService
{
    use HasImage;
    public function __construct(public Offer $model)
    {}

    public function index()
    {
        $today = now()->toDateString();

        return $this->model
            ->with('excursions')
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->active()
            ->latest()
            ->paginate(10);
    }
}

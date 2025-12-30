<?php
namespace App\Services\Api;

use App\Models\Offer;
use App\Traits\HasImage;


class OfferService
{
    use HasImage;
    public function __construct(public Offer $model)
    {}

    public function index()
    {

        return $this->model->with('excursions')->active()->latest()->paginate(10);
    }

}

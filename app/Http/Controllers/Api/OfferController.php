<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResource;
use App\Services\Api\OfferService;

class OfferController extends Controller
{
    use HttpResponse;
    public function __construct(public OfferService $offerService) {}
    public function index(Request $request)
    {
        $offers = $this->offerService->index();
        return $this->paginatedResponse($offers, OfferResource::class);
    }

}

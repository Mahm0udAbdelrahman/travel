<?php

namespace App\Http\Controllers\Api\User;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\RealEstateResource;
use App\Services\Api\User\RealEstateService;

class RealEstateController extends Controller
{
    use HttpResponse;
    public function __construct(public RealEstateService $realEstateService) {}
    public function index(Request $request)
    {
        $real_estates = $this->realEstateService->index($request->query('category_real_estate_id'));
        return $this->paginatedResponse($real_estates, RealEstateResource::class);
    }
}

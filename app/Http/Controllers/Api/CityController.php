<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Services\Api\CityService;

class CityController extends Controller
{
    use HttpResponse;
    public function __construct(public CityService $cityService) {}
    public function index(Request $request)
    {
        $cities = $this->cityService->index();
        return $this->paginatedResponse($cities, CityResource::class); ;
    }

}

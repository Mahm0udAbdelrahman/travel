<?php

namespace App\Http\Controllers\Api\User;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\CityResource;
use App\Services\Api\User\CityService;

class CityController extends Controller
{
    use HttpResponse;
    public function __construct(public CityService $cityService) {}
    public function index()
    {
        $cities = $this->cityService->index();
        return $this->paginatedResponse($cities, CityResource::class);;
    }
}

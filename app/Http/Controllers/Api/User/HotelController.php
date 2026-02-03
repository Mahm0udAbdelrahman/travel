<?php

namespace App\Http\Controllers\Api\User;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Services\Api\User\HotelService;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\CategoryResource;

class HotelController extends Controller
{
    use HttpResponse;
    public function __construct(public HotelService $hotelService) {}
    public function index(Request $request)
    {
        $hotels = $this->hotelService->index();
        return $this->paginatedResponse($hotels, CategoryResource::class);
    }
}

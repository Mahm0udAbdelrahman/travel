<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\CategoryRealEstateService;
use App\Http\Resources\CategoryResource;

class CategoryRealEstateController extends Controller
{
    use HttpResponse;
    public function __construct(public CategoryRealEstateService $categoryRealEstateService) {}
    public function index(Request $request)
    {
        $categoryRealEstates = $this->categoryRealEstateService->index();
        return $this->paginatedResponse($categoryRealEstates, CategoryResource::class);
    }

}

<?php

namespace App\Http\Controllers\Api\User;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\User\CategoryRealEstateService;
use App\Http\Resources\User\CategoryResource;

class CategoryRealEstateController extends Controller
{
    use HttpResponse;
    public function __construct(public CategoryRealEstateService $categoryRealEstateService) {}
    public function index()
    {
        $categoryRealEstates = $this->categoryRealEstateService->index();
        return $this->paginatedResponse($categoryRealEstates, CategoryResource::class);
    }
}

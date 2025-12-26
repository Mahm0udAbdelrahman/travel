<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryExcursionResource;
use App\Services\Api\CategoryExcursionService;

class CategoryExcursionController extends Controller
{
    use HttpResponse;
    public function __construct(public CategoryExcursionService $categoryExcursionService) {}
    public function index(Request $request)
    {
        $categoryExcursions = $this->categoryExcursionService->index();
        return $this->paginatedResponse($categoryExcursions, CategoryExcursionResource::class);
    }

}

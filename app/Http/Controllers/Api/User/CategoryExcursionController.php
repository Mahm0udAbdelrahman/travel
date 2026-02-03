<?php

namespace App\Http\Controllers\Api\User;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\CategoryResource;
use App\Services\Api\User\CategoryExcursionService;

class CategoryExcursionController extends Controller
{
    use HttpResponse;
    public function __construct(public CategoryExcursionService $categoryExcursionService) {}
    public function index()
    {
        $categoryExcursions = $this->categoryExcursionService->index();
        return $this->paginatedResponse($categoryExcursions, CategoryResource::class);
    }
}

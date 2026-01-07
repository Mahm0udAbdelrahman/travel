<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\Api\SubCategoryExcursionService;

class SubCategoryExcursionController extends Controller
{
    use HttpResponse;
    public function __construct(public SubCategoryExcursionService $subcategoryExcursionService) {}
    public function index(Request $request)
    {
        $subcategoryExcursions = $this->subcategoryExcursionService->index();
        return $this->paginatedResponse($subcategoryExcursions, CategoryResource::class);
    }

}

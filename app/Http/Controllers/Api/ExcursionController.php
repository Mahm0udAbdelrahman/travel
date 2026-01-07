<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExcursionResource;
use App\Services\Api\ExcursionService;

class ExcursionController extends Controller
{
    use HttpResponse;
    public function __construct(public ExcursionService $excursionService) {}
    public function index(Request $request)
    {
        $excursions = $this->excursionService->index($request->query('category_excursion_id'),$request->query('sub_category_excursion_id'));
        return $this->paginatedResponse($excursions, ExcursionResource::class);
    }

}

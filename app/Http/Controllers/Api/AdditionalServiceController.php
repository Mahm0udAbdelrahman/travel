<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdditionalServiceResource;
use App\Services\Api\AdditionalServiceService;

class AdditionalServiceController extends Controller
{
    use HttpResponse;
    public function __construct(public AdditionalServiceService $additionalServiceService) {}
    public function index(Request $request)
    {
        $additionalServices = $this->additionalServiceService->index();
        return $this->paginatedResponse($additionalServices, AdditionalServiceResource::class);
    }

}

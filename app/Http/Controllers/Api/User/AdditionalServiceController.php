<?php

namespace App\Http\Controllers\Api\User;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\AdditionalServiceResource;
use App\Services\Api\User\AdditionalServiceService;

class AdditionalServiceController extends Controller
{
    use HttpResponse;
    public function __construct(public AdditionalServiceService $additionalServiceService) {}
    public function index()
    {
        $additionalServices = $this->additionalServiceService->index();
        return $this->paginatedResponse($additionalServices, AdditionalServiceResource::class);
    }
}

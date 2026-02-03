<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Resources\User\FavoriteResource;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Favorite\FavoriteRequest;
use App\Services\Api\User\FavoriteService;
use App\Http\Resources\User\RegisterResource;

class FavoriteController extends Controller
{
    use HttpResponse;

    public function __construct(public FavoriteService $favoriteService) {}

    public function index()
    {
        $favorite = $this->favoriteService->index();

        return $this->paginatedResponse($favorite, FavoriteResource::class);
    }

    public function store(FavoriteRequest $request)
    {
        $favorite = $this->favoriteService->store($request->validated());
        return $this->okResponse($favorite, __('favorite', [], Request()->header('Accept-language')));
    }
}

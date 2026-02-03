<?php

namespace App\Http\Controllers\Api\User;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\EventResource;
use App\Services\Api\User\EventService;

class EventController extends Controller
{
    use HttpResponse;
    public function __construct(public EventService $eventService) {}
    public function index()
    {
        $events = $this->eventService->index();
        return $this->paginatedResponse($events, EventResource::class);
    }
}

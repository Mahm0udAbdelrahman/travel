<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Services\Api\EventService;

class EventController extends Controller
{
    use HttpResponse;
    public function __construct(public EventService $eventService) {}
    public function index(Request $request)
    {
        $events = $this->eventService->index();
        return $this->paginatedResponse($events, EventResource::class);
    }

}

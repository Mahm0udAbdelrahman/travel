<?php
namespace App\Http\Controllers\Api\TourLeader;

use App\Http\Controllers\Controller;
use App\Http\Resources\TourLeader\HotelTourLeaderResource;
use App\Services\Api\TourLeader\HotelTourLeaderService;
use App\Traits\HttpResponse;
use App\Http\Requests\Api\TourLeader\SendNotification\SendNotificationRequest;
class HotelTourLeaderController extends Controller
{
    use HttpResponse;

    public function __construct(public HotelTourLeaderService $hotelTourLeaderService)
    {
    }

    public function index()
    {
        $data = $this->hotelTourLeaderService->index();

        return $this->okResponse(new HotelTourLeaderResource($data), 'Hotel Tour Leader retrieved successfully');
    }

    public function sendNotification(SendNotificationRequest $request)
    {
        $this->hotelTourLeaderService->sendNotification($request->validated());

        return $this->okResponse([], 'Notification sent successfully');
    }

}

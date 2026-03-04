<?php
namespace App\Http\Controllers\Api\TourLeader;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TourLeader\Order\OrderRequest;
use App\Services\Api\TourLeader\OrderService;
use App\Traits\HttpResponse;
use App\Http\Resources\TourLeader\HotelTourLeaderResource;
use App\Services\Api\TourLeader\HotelTourLeaderService;

class HotelTourLeaderController extends Controller {
    use HttpResponse;

    public function __construct( public HotelTourLeaderService $hotelTourLeaderService ) {
    }

    public function index() {
        $data = $this->hotelTourLeaderService->index();

        return $this->okResponse( new HotelTourLeaderResource( $data ), 'Hotel Tour Leader retrieved successfully' );
    }

}

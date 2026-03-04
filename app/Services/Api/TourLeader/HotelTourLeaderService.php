<?php
namespace App\Services\Api\TourLeader;

class HotelTourLeaderService {
    public function index() {
        return auth()->user()->load( [ 'files', 'hotels.customers' ] );
    }
}

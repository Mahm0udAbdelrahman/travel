<?php
namespace App\Services\Api\TourLeader;

use App\Helpers\SendNotificationHelper;
use App\Models\User;

class HotelTourLeaderService
{
    public function index()
    {
        return auth()->user()->load(['files', 'hotels.customers']);
    }

    public function sendNotification(array $data)
    {
        $newNotification = new SendNotificationHelper();

        $query = User::whereNotNull('fcm_token');

        if (! empty($data['user_id'])) {
            $query->where('id', $data['user_id']);
        }

        if (! empty($data['user_ids'])) {
            $query->whereIn('id', $data['user_ids']);
        }
        
        $query->chunk(300, function ($users) use ($data, $newNotification) {

            $fcmTokens = $users->pluck('fcm_token')->toArray();

            $newNotification->sendNotification([
                "title_en" => $data['title_en'],
                "body_en"  => $data['body_en'],
                "image"    => null,
            ], $fcmTokens);
        });

        return true;
    }
}

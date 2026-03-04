<?php
namespace App\Http\Resources\TourLeader;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HotelTourLeaderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'files'  => $this->files->map(function ($file) {
                return [
                    'id'   => $file->id,
                    'name' => $file->name['en'] ?? $file->name,
                ];
            }),
            'hotels' => $this->hotels->map(function ($hotel) {
                return [
                    'id'        => $hotel->id,
                    'name'      => $hotel->name['en'] ?? $hotel->name,
                    'customers' => $hotel->customers->map(function ($customer) {
                        return [
                            'id'          => $customer->id,
                            'name'        => $customer->name,
                            'email'       => $customer->email,
                            'phone'       => $customer->phone,
                            'image'       => $customer->image,
                            'room_number' => $customer->room_number,

                        ];
                    }),
                ];
            }),
        ];
    }
}

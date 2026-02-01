<?php

namespace App\Services\Api;

use App\Models\Favorite;

class FavoriteService
{

    public function __construct(public Favorite $model) {}
    public function index()
    {
        $userId = auth()->user()->id;
        return $this->model->with('favoritable')
            ->where('user_id', $userId)
            ->latest()->paginate(10);
    }

    public function store($data)
    {
        $map = [
            'real_estate'        => \App\Models\RealEstate::class,
            'event'              => \App\Models\Event::class,
            'excursion'          => \App\Models\Excursion::class,
            'offer'              => \App\Models\Offer::class,
            'additional_service' => \App\Models\AdditionalService::class,
        ];

        if (!isset($map[$data['type_model']])) {
            return ['status' => false, 'message' => 'نوع المنتج غير صالح'];
        }

        $model = $map[$data['type_model']]::findOrFail($data['id']);

        $favorite = $this->model->where([
            'user_id' => auth()->id(),
            'favoritable_id' => $model->id,
            'favoritable_type' => get_class($model),
        ])->first();

        if ($favorite) {
            $favorite->delete();
            return ['status' => true, 'message' => 'Removed from favorites'];
        }

        $this->model->create([
            'user_id' => auth()->id(),
            'favoritable_id' => $model->id,
            'favoritable_type' => get_class($model),
            'is_favorite' => true,
        ]);

        return ['status' => true, 'message' => 'Added to favorites'];
    }


    public function deleteFavorite($id)
    {
        return $this->model->find($id)->delete($id);
    }
}

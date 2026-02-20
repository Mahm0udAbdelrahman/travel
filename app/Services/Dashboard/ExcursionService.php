<?php
namespace App\Services\Dashboard;

use App\Models\CategoryExcursion;
use App\Models\City;
use App\Models\Excursion;
use App\Models\SubCategoryExcursion;
use App\Traits\HasImage;
use Illuminate\Support\Facades\DB;

class ExcursionService
{
    use HasImage;
    public function __construct(public Excursion $model)
    {}

    public function index()
    {

        return $this->model->latest()->paginate(10);
    }

    public function getCategoryExcursions()
    {
        return CategoryExcursion::active()->get();
    }
    public function getSubCategoryExcursions()
    {
        return SubCategoryExcursion::active()->get();
    }
    public function getCities()
    {
        return City::active()->get();
    }

    public function store($data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'excursion');
        }
        $days = $data['days'] ?? [];
        unset($data['days']);

        $excursion = $this->model->create($data);

        foreach ($days as $dayData) {

            $times = $dayData['times'] ?? [];
            unset($dayData['times']);

            $day = $excursion->days()->create($dayData);

            foreach ($times as $time) {
                $day->times()->create($time);
            }
        }

        $orderData = [
            'excursion_id'      => $excursion->id,
            'user_id'           => $data['user_id'],
            'supplier_id'       => $data['supplier_id'] ?? null,
            'representative_id' => $data['representative_id'] ?? null,
            'status'            => 'completed',
            'price'             => $data['price'],
            'date'              => $data['date'],
            'created_at'        => now(),
        ];
        $db = app('firebase.firestore')->database();

        $orderRef = $db->collection('orders')->add($orderData);
        $orderId  = $orderRef->id();

        $db->collection('users')
            ->document($data['user_id'])
            ->collection('orders')
            ->document($orderId)
            ->set([
                'order_id' => $orderId,
                'status'   => $data['status'],
                'price'    => $data['price'],
                'date'     => $data['date'],
            ]);

        return $excursion->load('days.times');
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $excursion = $this->show($id);

            if (isset($data['image'])) {
                $data['image'] = $this->saveImage($data['image'], 'excursion');
            }

            $days = $data['days'] ?? [];
            unset($data['days']);

            $excursion->update($data);

            $excursion->days()->delete();

            foreach ($days as $dayData) {

                $times = $dayData['times'] ?? [];
                unset($dayData['times']);

                $day = $excursion->days()->create($dayData);

                foreach ($times as $time) {
                    $day->times()->create($time);
                }
            }

            return $excursion->load('days.times');
        });
    }

    public function destroy($id)
    {
        $excursion = $this->show($id);

        $excursion->delete();

        return $excursion;
    }

    public function bulkDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

}

<?php
namespace App\Services\Dashboard;

use App\Models\Order;
use App\Traits\HasImage;

class OrderService
{
    use HasImage;
    public function __construct(public Order $model)
    {}

public function index($request)
{
    $query = $this->model->latest();

    if ($request->filled('hotel_id')) {
        $query->where('hotel_id', $request->hotel_id);
    }

    if ($request->filled('orderable_type')) {
        $query->where('orderable_type', $request->orderable_type);

        if ($request->orderable_type === \App\Models\Excursion::class) {
            $query->whereHasMorph('orderable', [\App\Models\Excursion::class], function ($q) use ($request) {
                if ($request->filled('category_id')) {
                    $q->where('category_excursion_id', $request->category_id);
                }
                if ($request->filled('subcategory_id')) {
                    $q->where('sub_category_excursion_id', $request->subcategory_id);
                }
            });
        }
    }

    // if ($request->filled('from_date')) $query->whereDate('date', '>=', $request->from_date);
    if ($request->filled('to_date')) $query->whereDate('date', '<=', $request->to_date);
    if ($request->filled('status')) $query->where('status', $request->status);

    return $query->paginate(10)->withQueryString();
}

    public function store($data)
    {

        return $this->model->create($data);

    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        $order = $this->show($id);

        $order->update($data);

        return $order;
    }

    public function destroy($id)
    {
        $order = $this->show($id);

        $order->delete();

        return $order;
    }

    public function bulkDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

}

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

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

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

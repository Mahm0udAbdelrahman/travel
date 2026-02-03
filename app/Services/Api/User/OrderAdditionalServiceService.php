<?php

namespace App\Services\Api\User;

use App\Models\OrderAdditionalService;

class OrderAdditionalServiceService
{
    public function __construct(public OrderAdditionalService $model) {}

    public function store($data)
    {
        $data['user_id'] = auth()->id();
        return $this->model->create($data);
    }
}

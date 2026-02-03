<?php

namespace App\Services\Api\User;

use App\Models\Event;

class EventService
{
    public function __construct(public Event $model) {}

    public function index()
    {
        return $this->model->active()->latest()->paginate(10);
    }
}

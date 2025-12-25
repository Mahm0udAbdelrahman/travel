<?php
namespace App\Services\Api;

use App\Models\Event;
use App\Traits\HasImage;

class EventService
{
    use HasImage;
    public function __construct(public Event $model)
    {}

    public function index()
    {
        return $this->model->where('is_active','1')->latest()->paginate(10);
    }



}

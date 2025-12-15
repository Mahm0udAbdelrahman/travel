<?php
namespace App\Services\Api;

use App\Models\AdditionalService;
use App\Traits\HasImage;

class AdditionalServiceService
{
    use HasImage;
    public function __construct(public AdditionalService $model)
    {}

    public function index()
    {
        return $this->model->where('is_active','1')->latest()->paginate(10);
    }



}

<?php
namespace App\Services\Dashboard;

use App\Models\City;
use App\Models\Event;
use App\Traits\HasImage;
use App\Models\CategoryEvent;

class EventService
{
    use HasImage;
    public function __construct(public Event $model)
    {}

    public function index()
    {

        return $this->model->latest()->paginate(10);
    }

    public function getCategoryEvents()
    {
        return CategoryEvent::all();
    }
    public function getCities()
    {
        return City::all();
    }

    public function store($data)
    {
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'Event');
        }

        return $this->model->create($data);

    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {
        $event = $this->show($id);
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'Event');
        }

        $event->update($data);

        return $event;

    }

    public function destroy($id)
    {
        $event = $this->show($id);

        $event->delete();

        return $event;
    }

    public function bulkDelete($ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

}

<?php
namespace App\Services\Dashboard;

use App\Models\File;
use App\Models\User;
use App\Traits\HasImage;

class FileService
{
    use HasImage;
    public function __construct(public File $model)
    {}

    public function index()
    {

        return $this->model->latest()->paginate(10);
    }

    public function getTourLeaders()
    {
        return User::whereDoesntHave('roles')
            ->where('is_active', '!=', 0)
            ->whereNotIn('type', ['customer', 'supplier'])
            ->get();
    }

    public function store($data)
    {

        $file = $this->model->create($data);
        $file->tourLeaders()->attach($data['tour_leader_ids'] ?? []);
        return $file;
    }

    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    public function update($id, $data)
    {

        $file = $this->show($id);

        $file->update($data);

        $file->tourLeaders()->sync($data['tour_leader_ids'] ?? []);

        return $file;

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

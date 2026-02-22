<?php
namespace App\Services\Dashboard;

use App\Models\User;
use App\Traits\HasImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    use HasImage;
    public function __construct(public User $user)
    {}

    public function index($request)
    {


         $query = $this->user->whereNot('id', auth()->user()->id)->latest();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        return $query->paginate(10)->withQueryString();
    }

    public function create()
    {
        return Role::select(['id', 'name'])->get();
    }

    public function store($data)
    {
        $data['password'] = Hash::make($data['password']);

        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'user');
        } else {
            $data['image'] = asset('public/default/default.png');
        }
        $data['email_verified_at'] = Carbon::now();
        if (! str_starts_with($data['phone'], '+2')) {
            $data['phone'] = '+2' . $data['phone'];
        }

        $user = $this->user->create($data);

        return $user;
    }

    public function show($id)
    {
        return $this->user->findOrFail($id);
    }

    public function update($id, $data)
    {
        $user = $this->user->findOrFail($id);

        $data['password'] = $data['password'] ? Hash::make($data['password']) : $user->password;
        if (isset($data['image'])) {
            $data['image'] = $this->saveImage($data['image'], 'user');
        } else {
            $data['image'] = $user->image;
        }
        $user->update($data);

        return $user;

    }

    public function destroy($id)
    {
        $user = $this->user->findOrFail($id);

        $user->delete();

        return $user;
    }

    public function bulkDelete($ids)
    {
        return $this->user->whereIn('id', $ids)->delete();
    }

}

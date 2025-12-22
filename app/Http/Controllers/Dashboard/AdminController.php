<?php

namespace App\Http\Controllers\Dashboard;

use App\Traits\HasImage;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Dashboard\Admin\{StoreAdminRequest, UpdateAdminRequest};
use App\Services\Dashboard\AdminService;

class AdminController extends Controller
{
    public function __construct(public AdminService $adminService) {}
    use HasImage;
    public function index(Request $request)
    {
        $admins = $this->adminService->index();
        return view('dashboard.pages.admins.index', compact('admins'));
    }
    public function create()
    {
        $roles = $this->adminService->create();
        return view('dashboard.pages.admins.create', compact('roles'));
    }

    public function store(StoreAdminRequest $storeAdminRequest)
    {

        $data = $storeAdminRequest->validated();
        $this->adminService->store($data);

        Session::flash('message', ['type' => 'success', 'text' => __('Admin created successfully')]);
        return redirect()->route('Admin.admins.index');
    }

    public function show($id)
    {
        $admin = $this->adminService->show($id);
        return view('dashboard.pages.admins.show', compact('admin'));
    }

    public function edit(User $admin)
    {
       $roles = $this->adminService->create();
        return view('dashboard.pages.admins.edit', compact('admin', 'roles'));
    }

    public function update($id, UpdateAdminRequest $updateAdminRequest)
    {

        $data = $updateAdminRequest->validated();
        $this->adminService->update($id, $data);
        Session::flash('message', ['type' => 'success', 'text' => __('Admin updated successfully')]);
        return redirect()->route('Admin.admins.index');
    }

    public function destroy(string $id)
    {
        $this->adminService->destroy($id);

        return redirect()->route('Admin.admins.index')->with('success', 'Admin Successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->adminService->bulkDelete($request->ids);

        return redirect()->back()->with('success', 'Admin deleted successfully');
    }
}

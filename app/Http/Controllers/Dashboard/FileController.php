<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Services\Dashboard\FileService;
use App\Http\Requests\Dashboard\File\{StoreFileRequest, UpdateFileRequest};

class FileController extends Controller
{
    public function __construct(public FileService $fileService) {}
    public function index(Request $request)
    {
        $files = $this->fileService->index();
        return view('dashboard.pages.files.index', compact('files'));
    }
    public function create()
    {
        $tourLeaders = $this->fileService->getTourLeaders();
        return view('dashboard.pages.files.create', compact('tourLeaders'));
    }

    public function store(StoreFileRequest $storeFileRequest)
    {

        $data = $storeFileRequest->validated();
        $this->fileService->store($data);
        Session::flash('message', ['type' => 'success', 'text' => __('File created successfully')]);
        return redirect()->route('Admin.files.index');
    }

    public function show($id)
    {
        $file = $this->fileService->show($id);
        return view('dashboard.pages.files.show', compact('file'));
    }

    public function edit($id)
    {
         $file = $this->fileService->show($id);
        $tourLeaders = $this->fileService->getTourLeaders();
        return view('dashboard.pages.files.edit', compact('file', 'tourLeaders'));
    }

    public function update($id, UpdateFileRequest $updateFileRequest)
    {

        $data = $updateFileRequest->validated();
        $this->fileService->update($id, $data);
        Session::flash('message', ['type' => 'success', 'text' => __('File updated successfully')]);
        return redirect()->route('Admin.files.index');
    }

    public function destroy(string $id)
    {
        $this->fileService->destroy($id);

        return redirect()->route('Admin.files.index')->with('success', 'File Successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->fileService->bulkDelete($request->ids);

        return redirect()->back()->with('success', 'File deleted successfully');
    }
}

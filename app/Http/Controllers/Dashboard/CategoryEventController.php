<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Dashboard\CategoryEvent\{StoreCategoryEventRequest, UpdateCategoryEventRequest};
use App\Services\Dashboard\CategoryEventService;

class CategoryEventController extends Controller
{
    public function __construct(public CategoryEventService $categoryEventService) {}
    public function index(Request $request)
    {
        $category_events  = $this->categoryEventService->index();
        return view('dashboard.pages.category_events.index', compact('category_events'));
    }
    public function create()
    {
        return view('dashboard.pages.category_events.create');
    }

    public function store(StoreCategoryEventRequest $storeCategoryEventRequest)
    {

        $data = $storeCategoryEventRequest->validated();
        $this->categoryEventService->store($data);
        Session::flash('message', ['type' => 'success', 'text' => __('CategoryEvent created successfully')]);
        return redirect()->route('Admin.category_events.index');
    }

    public function show($id)
    {
        $categoryEvent = $this->categoryEventService->show($id);
        return view('dashboard.pages.category_events.show', compact('categoryEvent'));
    }

    public function edit($id)
    {
         $category_event = $this->categoryEventService->show($id);

        return view('dashboard.pages.category_events.edit', compact('category_event'));
    }

    public function update($id, UpdateCategoryEventRequest $updateCategoryEventRequest)
    {

        $data = $updateCategoryEventRequest->validated();
        $this->categoryEventService->update($id, $data);
        Session::flash('message', ['type' => 'success', 'text' => __('CategoryEvent updated successfully')]);
        return redirect()->route('Admin.category_events.index');
    }

    public function destroy(string $id)
    {
        $this->categoryEventService->destroy($id);

        return redirect()->route('Admin.category_events.index')->with('success', 'CategoryEvent Successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->categoryEventService->bulkDelete($request->ids);

        return redirect()->back()->with('success', 'CategoryEvent deleted successfully');
    }
}

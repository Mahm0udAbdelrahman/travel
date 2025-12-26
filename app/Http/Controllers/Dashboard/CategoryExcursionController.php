<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Dashboard\CategoryExcursion\{StoreCategoryExcursionRequest, UpdateCategoryExcursionRequest};
use App\Services\Dashboard\CategoryExcursionService;

class CategoryExcursionController extends Controller
{
    public function __construct(public CategoryExcursionService $categoryExcursionService) {}
    public function index(Request $request)
    {
        $category_excursions  = $this->categoryExcursionService->index();
        return view('dashboard.pages.category_excursions.index', compact('category_excursions'));
    }
    public function create()
    {
        return view('dashboard.pages.category_excursions.create');
    }

    public function store(StoreCategoryExcursionRequest $storeCategoryExcursionRequest)
    {

        $data = $storeCategoryExcursionRequest->validated();
        $this->categoryExcursionService->store($data);
        Session::flash('message', ['type' => 'success', 'text' => __('CategoryExcursion created successfully')]);
        return redirect()->route('Admin.category_excursions.index');
    }

    public function show($id)
    {
        $categoryExcursion = $this->categoryExcursionService->show($id);
        return view('dashboard.pages.category_excursions.show', compact('categoryExcursion'));
    }

    public function edit($id)
    {
         $categoryExcursion = $this->categoryExcursionService->show($id);

        return view('dashboard.pages.category_excursions.edit', compact('categoryExcursion'));
    }

    public function update($id, UpdateCategoryExcursionRequest $updateCategoryExcursionRequest)
    {

        $data = $updateCategoryExcursionRequest->validated();
        $this->categoryExcursionService->update($id, $data);
        Session::flash('message', ['type' => 'success', 'text' => __('CategoryExcursion updated successfully')]);
        return redirect()->route('Admin.category_excursions.index');
    }

    public function destroy(string $id)
    {
        $this->categoryExcursionService->destroy($id);

        return redirect()->route('Admin.category_excursions.index')->with('success', 'CategoryExcursion Successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->categoryExcursionService->bulkDelete($request->ids);

        return redirect()->back()->with('success', 'CategoryExcursion deleted successfully');
    }
}

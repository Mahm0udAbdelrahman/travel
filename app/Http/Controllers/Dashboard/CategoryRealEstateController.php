<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Dashboard\CategoryRealEstate\{StoreCategoryRealEstateRequest, UpdateCategoryRealEstateRequest};
use App\Services\Dashboard\CategoryRealEstateService;

class CategoryRealEstateController extends Controller
{
    public function __construct(public CategoryRealEstateService $categoryRealEstateService) {}
    public function index(Request $request)
    {
        $category_real_estates  = $this->categoryRealEstateService->index();
        return view('dashboard.pages.category_real_estates.index', compact('category_real_estates'));
    }
    public function create()
    {
        return view('dashboard.pages.category_real_estates.create');
    }

    public function store(StoreCategoryRealEstateRequest $storeCategoryRealEstateRequest)
    {

        $data = $storeCategoryRealEstateRequest->validated();
        $this->categoryRealEstateService->store($data);
        Session::flash('message', ['type' => 'success', 'text' => __('CategoryRealEstate created successfully')]);
        return redirect()->route('Admin.category_real_estates.index');
    }

    public function show($id)
    {
        $categoryRealEstate = $this->categoryRealEstateService->show($id);
        return view('dashboard.pages.category_real_estates.show', compact('categoryRealEstate'));
    }

    public function edit($id)
    {
         $category_real_estate = $this->categoryRealEstateService->show($id);

        return view('dashboard.pages.category_real_estates.edit', compact('category_real_estate'));
    }

    public function update($id, UpdateCategoryRealEstateRequest $updateCategoryRealEstateRequest)
    {

        $data = $updateCategoryRealEstateRequest->validated();
        $this->categoryRealEstateService->update($id, $data);
        Session::flash('message', ['type' => 'success', 'text' => __('CategoryRealEstate updated successfully')]);
        return redirect()->route('Admin.category_real_estates.index');
    }

    public function destroy(string $id)
    {
        $this->categoryRealEstateService->destroy($id);

        return redirect()->route('Admin.category_real_estates.index')->with('success', 'CategoryRealEstate Successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->categoryRealEstateService->bulkDelete($request->ids);

        return redirect()->back()->with('success', 'CategoryRealEstate deleted successfully');
    }
}

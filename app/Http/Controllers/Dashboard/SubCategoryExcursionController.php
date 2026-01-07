<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Http\Requests\Dashboard\SubCategoryExcursion\StoreSubCategoryExcursionRequest;

use App\Http\Requests\Dashboard\SubCategoryExcursion\UpdateSubCategoryExcursionRequest;
use App\Services\Dashboard\SubCategoryExcursionService;use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubCategoryExcursionController extends Controller
{
    public function __construct(public SubCategoryExcursionService $subCategoryExcursionService)
    {}
    public function index(Request $request)
    {
        $sub_category_excursions = $this->subCategoryExcursionService->index();
        return view('dashboard.pages.sub_category_excursions.index', compact('sub_category_excursions'));
    }
    public function create()
    {
        $category_excursions = $this->subCategoryExcursionService->getCategoryExcursions();
        return view('dashboard.pages.sub_category_excursions.create', compact('category_excursions'));
    }

    public function store(StoreSubCategoryExcursionRequest $storeCategoryExcursionRequest)
    {

        $data = $storeCategoryExcursionRequest->validated();
        $this->subCategoryExcursionService->store($data);
        Session::flash('message', ['type' => 'success', 'text' => __('CategoryExcursion created successfully')]);
        return redirect()->route('Admin.sub_category_excursions.index');
    }

    public function show($id)
    {
        $subcategoryExcursion = $this->subCategoryExcursionService->show($id);
        return view('dashboard.pages.sub_category_excursions.show', compact('subcategoryExcursion'));
    }

    public function edit($id)
    {
        $subcategoryExcursion = $this->subCategoryExcursionService->show($id);
        $category_excursions  = $this->subCategoryExcursionService->getCategoryExcursions();
        return view('dashboard.pages.sub_category_excursions.edit', compact('subcategoryExcursion', 'category_excursions'));
    }

    public function update($id, UpdateSubCategoryExcursionRequest $updateCategoryExcursionRequest)
    {

        $data = $updateCategoryExcursionRequest->validated();
        $this->subCategoryExcursionService->update($id, $data);
        Session::flash('message', ['type' => 'success', 'text' => __('SubCategoryExcursion updated successfully')]);
        return redirect()->route('Admin.sub_category_excursions.index');
    }

    public function destroy(string $id)
    {
        $this->subCategoryExcursionService->destroy($id);

        return redirect()->route('Admin.sub_category_excursions.index')->with('success', 'SubCategoryExcursion Successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->subCategoryExcursionService->bulkDelete($request->ids);

        return redirect()->back()->with('success', 'SubCategoryExcursion deleted successfully');
    }
}

<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Excursion\StoreExcursionRequest;
use App\Http\Requests\Dashboard\Excursion\UpdateExcursionRequest;
use App\Models\SubCategoryExcursion;
use App\Services\Dashboard\ExcursionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ExcursionController extends Controller
{
    public function __construct(public ExcursionService $excursionService)
    {}
    public function index(Request $request)
    {
        $excursions = $this->excursionService->index();
        return view('dashboard.pages.excursions.index', compact('excursions'));
    }
    public function create()
    {

        $category_excursions     = $this->excursionService->getCategoryExcursions();
        $sub_category_excursions = $this->excursionService->getSubCategoryExcursions();
        $cities                  = $this->excursionService->getCities();
        return view('dashboard.pages.excursions.create', compact('category_excursions', 'cities', 'sub_category_excursions'));
    }

    public function store(StoreExcursionRequest $storeCityRequest)
    {

        $data = $storeCityRequest->validated();
        $this->excursionService->store($data);

        Session::flash('message', ['type' => 'success', 'text' => __('City created successfully')]);
        return redirect()->route('Admin.excursions.index');
    }

    public function show($id)
    {
        $excursion = $this->excursionService->show($id);
        return view('dashboard.pages.excursions.show', compact('excursion'));
    }

    public function edit($id)
    {
        $excursion = $this->excursionService->show($id);

        $category_excursions = $this->excursionService->getCategoryExcursions();
        $cities              = $this->excursionService->getCities();

        return view('dashboard.pages.excursions.edit', compact('excursion', 'category_excursions', 'cities'));
    }

    public function update($id, UpdateExcursionRequest $updateCityRequest)
    {

        $data = $updateCityRequest->validated();
        $this->excursionService->update($id, $data);
        Session::flash('message', ['type' => 'success', 'text' => __('Excursion updated successfully')]);
        return redirect()->route('Admin.excursions.index');
    }

    public function destroy(string $id)
    {
        $this->excursionService->destroy($id);

        return redirect()->route('Admin.excursions.index')->with('success', 'Excursion Successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->excursionService->bulkDelete($request->ids);

        return redirect()->back()->with('success', 'Excursion deleted successfully');
    }

    public function getSubCategories($categoryId)
    {
        $subCategories = SubCategoryExcursion::where('category_excursion_id', $categoryId)
            ->get();

        return response()->json($subCategories);
    }

}

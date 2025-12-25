<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Dashboard\RealEstate\{StoreRealEstateRequest, UpdateRealEstateRequest};
use App\Services\Dashboard\RealEstateService;

class RealEstateController extends Controller
{
    public function __construct(public RealEstateService $realEstateService) {}
    public function index(Request $request)
    {
        $real_estates = $this->realEstateService->index();
        return view('dashboard.pages.real_estates.index', compact('real_estates'));
    }
    public function create()
    {
        $category_real_estates = $this->realEstateService->getCategoryRealEstates();
        $cities = $this->realEstateService->getCities();

        return view('dashboard.pages.real_estates.create', compact('category_real_estates', 'cities'));
    }

    public function store(StoreRealEstateRequest $storeRealEstateRequest)
    {

        $data = $storeRealEstateRequest->validated();
        $this->realEstateService->store($data);
        Session::flash('message', ['type' => 'success', 'text' => __('RealEstate created successfully')]);
        return redirect()->route('Admin.real_estates.index');
    }

    public function show($id)
    {
        $realEstate = $this->realEstateService->show($id);
        return view('dashboard.pages.real_estates.show', compact('realEstate'));
    }

    public function edit($id)
    {
         $real_estate = $this->realEstateService->show($id);
         $category_real_estates = $this->realEstateService->getCategoryRealEstates();
         $cities = $this->realEstateService->getCities();

        return view('dashboard.pages.real_estates.edit', compact('real_estate', 'category_real_estates', 'cities'));
    }

    public function update($id, UpdateRealEstateRequest $updateRealEstateRequest)
    {

        $data = $updateRealEstateRequest->validated();
        $this->realEstateService->update($id, $data);
        Session::flash('message', ['type' => 'success', 'text' => __('RealEstate updated successfully')]);
        return redirect()->route('Admin.real_estates.index');
    }

    public function destroy(string $id)
    {
        $this->realEstateService->destroy($id);

        return redirect()->route('Admin.real_estates.index')->with('success', 'RealEstate Successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->realEstateService->bulkDelete($request->ids);

        return redirect()->back()->with('success', 'RealEstate deleted successfully');
    }
}

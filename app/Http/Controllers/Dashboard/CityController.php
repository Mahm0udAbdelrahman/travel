<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Dashboard\City\{StoreCityRequest, UpdateCityRequest};
use App\Services\Dashboard\CityService;

class CityController extends Controller
{
    public function __construct(public CityService $cityService) {}
    public function index(Request $request)
    {
        $cities = $this->cityService->index();
        return view('dashboard.pages.cities.index', compact('cities'));
    }
    public function create()
    {
        return view('dashboard.pages.cities.create');
    }

    public function store(StoreCityRequest $storeCityRequest)
    {

        $data = $storeCityRequest->validated();
        $this->cityService->store($data);

        Session::flash('message', ['type' => 'success', 'text' => __('City created successfully')]);
        return redirect()->route('Admin.cities.index');
    }

    public function show($id)
    {
        $city = $this->cityService->show($id);
        return view('dashboard.pages.cities.show', compact('city'));
    }

    public function edit($id)
    {
         $city = $this->cityService->show($id);

        return view('dashboard.pages.cities.edit', compact('city'));
    }

    public function update($id, UpdateCityRequest $updateCityRequest)
    {

        $data = $updateCityRequest->validated();
        $this->cityService->update($id, $data);
        Session::flash('message', ['type' => 'success', 'text' => __('City updated successfully')]);
        return redirect()->route('Admin.cities.index');
    }

    public function destroy(string $id)
    {
        $this->cityService->destroy($id);

        return redirect()->route('Admin.cities.index')->with('success', 'City Successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->cityService->bulkDelete($request->ids);

        return redirect()->back()->with('success', 'City deleted successfully');
    }
}

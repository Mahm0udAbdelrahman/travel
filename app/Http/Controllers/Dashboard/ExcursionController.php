<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Dashboard\Excursion\{StoreExcursionRequest, UpdateExcursionRequest};
use App\Services\Dashboard\ExcursionService;

class ExcursionController extends Controller
{
    public function __construct(public ExcursionService $excursionService) {}
    public function index(Request $request)
    {
        $excursions = $this->excursionService->index();
        return view('dashboard.pages.excursions.index', compact('excursions'));
    }
    public function create()
    {
        return view('dashboard.pages.excursions.create');
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

        return view('dashboard.pages.excursions.edit', compact('excursion'));
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
}

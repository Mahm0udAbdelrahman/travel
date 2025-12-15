<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Dashboard\AdditionalService\{StoreAdditionalServiceRequest, UpdateAdditionalServiceRequest};
use App\Services\Dashboard\AdditionalServiceService;

class AdditionalServiceController extends Controller
{
    public function __construct(public AdditionalServiceService $additionalServiceService) {}
    public function index(Request $request)
    {
        $additional_services = $this->additionalServiceService->index();
        return view('dashboard.pages.additional_services.index', compact('additional_services'));
    }
    public function create()
    {
        return view('dashboard.pages.additional_services.create');
    }

    public function store(StoreAdditionalServiceRequest $storeCityRequest)
    {

        $data = $storeCityRequest->validated();
        $this->additionalServiceService->store($data);

        Session::flash('message', ['type' => 'success', 'text' => __('City created successfully')]);
        return redirect()->route('Admin.additional_services.index');
    }

    public function show($id)
    {
        $additional_service = $this->additionalServiceService->show($id);
        return view('dashboard.pages.additional_services.show', compact('additional_service'));
    }

    public function edit($id)
    {
         $additional_service = $this->additionalServiceService->show($id);

        return view('dashboard.pages.additional_services.edit', compact('additional_service'));
    }

    public function update($id, UpdateAdditionalServiceRequest $updateCityRequest)
    {

        $data = $updateCityRequest->validated();
        $this->additionalServiceService->update($id, $data);
        Session::flash('message', ['type' => 'success', 'text' => __('additional_service updated successfully')]);
        return redirect()->route('Admin.additional_services.index');
    }

    public function destroy(string $id)
    {
        $this->additionalServiceService->destroy($id);

        return redirect()->route('Admin.additional_services.index')->with('success', 'additional_service Successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->additionalServiceService->bulkDelete($request->ids);

        return redirect()->back()->with('success', 'additional_service deleted successfully');
    }
}

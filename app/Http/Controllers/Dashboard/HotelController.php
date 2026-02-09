<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Dashboard\Hotel\{StoreHotelRequest, UpdateHotelRequest};
use App\Services\Dashboard\HotelService;

class HotelController extends Controller
{
    public function __construct(public HotelService $hotelService) {}
    public function index(Request $request)
    {
        $hotels  = $this->hotelService->index();
        return view('dashboard.pages.hotels.index', compact('hotels'));
    }
    public function create()
    {
        $tourLeaders = $this->hotelService->getTourLeaders();
        return view('dashboard.pages.hotels.create', compact('tourLeaders'));
    }

    public function store(StoreHotelRequest $storeHotelRequest)
    {

        $data = $storeHotelRequest->validated();
        $this->hotelService->store($data);
        Session::flash('message', ['type' => 'success', 'text' => __('Hotel created successfully')]);
        return redirect()->route('Admin.hotels.index');
    }

    public function show($id)
    {
        $data = $this->hotelService->show($id);
        return view('dashboard.pages.hotels.show', $data);
    }

    public function edit($id)
    {
         $hotel = $this->hotelService->show($id);
        $tourLeaders = $this->hotelService->getTourLeaders();
        return view('dashboard.pages.hotels.edit', compact('hotel', 'tourLeaders'));
    }

    public function update($id, UpdateHotelRequest $updateHotelRequest)
    {

        $data = $updateHotelRequest->validated();
        $this->hotelService->update($id, $data);
        Session::flash('message', ['type' => 'success', 'text' => __('Hotel updated successfully')]);
        return redirect()->route('Admin.hotels.index');
    }

    public function destroy(string $id)
    {
        $this->hotelService->destroy($id);

        return redirect()->route('Admin.hotels.index')->with('success', 'Hotel Successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->hotelService->bulkDelete($request->ids);

        return redirect()->back()->with('success', 'Hotel deleted successfully');
    }
}

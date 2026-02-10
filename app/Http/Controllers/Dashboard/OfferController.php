<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Services\Dashboard\OfferService;
use App\Http\Requests\Dashboard\Offer\{StoreOfferRequest, UpdateOfferRequest};

class OfferController extends Controller
{
    public function __construct(public OfferService $offerService) {}
    public function index(Request $request)
    {
        $offers = $this->offerService->index();
        return view('dashboard.pages.offers.index', compact('offers'));
    }
    public function create()
    {

            $excursions = $this->offerService->getExcursions();
            $categoryExcursions = $this->offerService->getCategoryExcursions();
        return view('dashboard.pages.offers.create', compact('excursions', 'categoryExcursions'));
    }

    public function store(StoreOfferRequest $storeOfferRequest)
    {

        $data = $storeOfferRequest->validated();
        $this->offerService->store($data);
        Session::flash('message', ['type' => 'success', 'text' => __('Offer created successfully')]);
        return redirect()->route('Admin.offers.index');
    }

    public function show($id)
    {
        $offer = $this->offerService->show($id);
        return view('dashboard.pages.offers.show', compact('offer'));
    }

    public function edit($id)
    {
         $offer = $this->offerService->show($id);

        $excursions = $this->offerService->getExcursions();
        $categoryExcursions = $this->offerService->getCategoryExcursions();

        return view('dashboard.pages.offers.edit', compact('offer','excursions', 'categoryExcursions'));
    }

    public function update($id, UpdateOfferRequest $updateOfferRequest)
    {

        $data = $updateOfferRequest->validated();
        $this->offerService->update($id, $data);
        Session::flash('message', ['type' => 'success', 'text' => __('Offer updated successfully')]);
        return redirect()->route('Admin.offers.index');
    }

    public function destroy(string $id)
    {
        $this->offerService->destroy($id);

        return redirect()->route('Admin.offers.index')->with('success', 'Offer Successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->offerService->bulkDelete($request->ids);

        return redirect()->back()->with('success', 'Offer deleted successfully');
    }
}

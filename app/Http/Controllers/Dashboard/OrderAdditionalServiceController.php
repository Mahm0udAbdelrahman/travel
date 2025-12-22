<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\OrderAdditionalServiceService;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class OrderAdditionalServiceController extends Controller
{
    use HttpResponse;
    public function __construct(public OrderAdditionalServiceService $orderAdditionalServiceService)
    {}
    public function index()
    {
        $order_additional_services = $this->orderAdditionalServiceService->index();
        return view('dashboard.pages.order_additional_services.index', compact('order_additional_services'));
    }
    public function create()
    {
        return view('dashboard.pages.order_additional_services.create');
    }

    public function show($id)
    {
        $order_additional_service = $this->orderAdditionalServiceService->show($id);
        return view('dashboard.pages.order_additional_services.show', compact('order_additional_service'));
    }

    public function edit($id)
    {
        $order_additional_service = $this->orderAdditionalServiceService->show($id);

        return view('dashboard.pages.order_additional_services.edit', compact('order_additional_service'));
    }

    public function destroy(string $id)
    {
        $this->orderAdditionalServiceService->destroy($id);

        return redirect()->route('Admin.order_additional_services.index')->with('success', 'order additional_service Successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
        ]);

        $this->orderAdditionalServiceService->bulkDelete($request->ids);

        return redirect()->back()->with('success', 'order additional_service deleted successfully');
    }
}

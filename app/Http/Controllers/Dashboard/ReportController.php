<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AdditionalService;
use App\Models\CategoryExcursion;
use App\Models\Event;
use App\Models\Excursion;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\RealEstate;
use App\Models\SubCategoryExcursion;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {

        $suppliers = User::whereIn('id', function ($q) {
            $q->select('user_id')->from('order_statuses');
        })->get();

        $representatives = User::whereIn('id', function ($q) {
            $q->select('user_id')
                ->from('tour_leader_hotels')
                ->whereIn('hotel_id', function ($q2) {
                    $q2->select('hotel_id')->from('orders');
                });
        })->get();

        $orders = Order::query()

            ->when($request->supplier_id, function ($q) use ($request) {
                $q->whereHas('orderStatuses', function ($os) use ($request) {
                    $os->where('user_id', $request->supplier_id);
                });
            })

            ->when($request->representative_id, function ($q) use ($request) {
                $q->whereHas('hotel.tourLeaders', function ($tl) use ($request) {
                    $tl->where('user_id', $request->representative_id);
                });
            })
            ->when($request->hotel_id, fn($q) =>
                $q->where('hotel_id', $request->hotel_id)
            )

            ->when($request->user_type, fn($q) =>
                $q->whereHas('user', fn($u) =>
                    $u->where('type', $request->user_type)
                )
            )

            ->when($request->orderable_type, function ($q) use ($request) {
                $map = [
                    'excursion'          => Excursion::class,
                    'real_estate'        => RealEstate::class,
                    'event'              => Event::class,
                    'additional_service' => AdditionalService::class,
                ];

                if (isset($map[$request->orderable_type])) {
                    $q->where('orderable_type', $map[$request->orderable_type]);
                }
            })

            ->when(
                $request->orderable_type === 'excursion' && $request->category_id,
                fn($q) =>
                $q->whereHasMorph(
                    'orderable',
                    [Excursion::class],
                    fn($ex) =>
                    $ex->where('category_excursion_id', $request->category_id)
                )
            )

            ->when(
                $request->orderable_type === 'excursion' && $request->sub_category_id,
                fn($q) =>
                $q->whereHasMorph(
                    'orderable',
                    [Excursion::class],
                    fn($ex) =>
                    $ex->where('sub_category_excursion_id', $request->sub_category_id)
                )
            )

            ->when($request->from, fn($q) =>
                $q->whereDate('date', '>=', $request->from)
            )
            ->when($request->to, fn($q) =>
                $q->whereDate('date', '<=', $request->to)
            )

            ->with(['user', 'hotel', 'orderable', 'lastStatus'])
            ->latest();
        if ($request->has('export')) {
            $ordersForExport = $orders->get();
            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\OrdersExport($ordersForExport), 'Orders_Report.xlsx');
        }
        $orders = $orders->paginate(20);

        return view('dashboard.pages.reports.index', [
            'orders'          => $orders,
            'hotels'          => Hotel::active()->get(),
            'categories'      => CategoryExcursion::active()->get(),
            'subCategories'   => SubCategoryExcursion::active()->get(),
            'suppliers'       => $suppliers,
            'representatives' => $representatives,
        ]);
    }
}

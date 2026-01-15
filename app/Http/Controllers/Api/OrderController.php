<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\OrderRequest;
use App\Models\Order;
use App\Services\Api\OrderService;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use HttpResponse;
    public function __construct(public OrderService $OrderService)
    {}
    public function store(OrderRequest $request)
    {
        return $this->OrderService->store($request->validated());
    }

    public function handleCallback(Request $request)
    {
        \Log::info('OPay Callback Received:', $request->all());

        $payload = $request->all();

        // التأكد من أن حالة الدفع ناجحة
        // OPay ترسل الحالة غالباً في حقل status أو payload['data']['status']
        if (isset($payload['data']['status']) && $payload['data']['status'] === 'SUCCESS') {

            $order = Order::where('order_number', $payload['data']['reference'])->first();

            if ($order) {
                $order->update([
                    'status' => 'paid', // تحديث حالة الطلب
                ]);

                return response()->json(['code' => '00000', 'message' => 'SUCCESS']);
            }
        }

        return response()->json(['code' => '00001', 'message' => 'Order Not Found or Failed']);
    }

    /**
     * handleReturn
     * هنا يعود المستخدم بعد انتهاء العملية (لإظهار صفحة "شكراً لك")
     */
    public function handleReturn(Request $request)
    {
        // يمكنك التحقق من حالة الطلب هنا لإظهار رسالة نجاح أو فشل للمستخدم
        return response()->json([
            'message' => 'تمت العودة من بوابة الدفع، جاري معالجة طلبك.',
        ]);
    }

}

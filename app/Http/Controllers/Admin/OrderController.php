<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\OrderService;

/**
 * Order Controller
 * @author IR Salvador
 * @since 2023.07.25
 */
class OrderController extends Controller
{
    private OrderService $orderService;
    public function __construct()
    {
        $this->orderService = new OrderService();
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $orders = $this->orderService->getAllOrders();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsShipped(Request $request)
    {
        $orderId = $this->orderService->markAsShipped($request);
        return response()->json(['message' => 'Order: ' . $orderId . ' has been marked as shipped.']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelOrder(Request $request)
    {
        $order = $this->orderService->cancelOrder($request);
        return response()->json(['message' => 'Order: ' . $order->id . ' has been cancelled.']);
    }
}

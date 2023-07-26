<?php

namespace App\Services;

use App\Models\Order;

/**
 * Order Service
 * @author IR Salvador
 * @since 2023.07.26
 */
class OrderService
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllOrders()
    {
        return Order::all();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function markAsShipped($request)
    {
        $orderId = $request->input('order_id');
        $order = Order::find($orderId);
        $order->shipped = 1;
        $order->save();

        return $order->id;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function cancelOrder($request)
    {
        $orderId = $request->input('order_id');
        $order = Order::find($orderId);
        $order->cancelled = 1;
        $order->save();

        return $order;
    }
}

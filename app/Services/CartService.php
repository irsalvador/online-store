<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Cart Service
 * @author IR Salvador
 * @since 2023.07.26
 */
class CartService
{
    /**
     * @param Request $request
     * @return void
     */
    public function saveItemToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = $request->session()->get('cart', []);

        $product = Product::find($productId)->toArray();
        if (isset($cart[$productId]) === true) {
            $cart[$productId]['quantity'] += 1;
            $cart[$productId]['name'] = $product['name'];
            $cart[$productId]['price'] = $product['price'];
        } else {
            $cart[$productId] = [
                'quantity' => 1,
                'name'     => $product['name'],
                'price'    => $product['price']
            ];
        }

        $request->session()->put('cart', $cart);
    }

    /**
     * @return \Closure|mixed|object|null
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface\
     */
    public function viewCartDetails()
    {
        return session()->get('cart', []);
    }

    /**
     * @param object $cart
     * @return float|int
     */
    public function computeTotalPriceInCart(array $cart)
    {
        $total_price = 0;
        foreach ($cart as $item) {
            $total_price += $item['price'] * $item['quantity'];
        }

        return $total_price;
    }

    /**
     * @return void
     */
    public function clearCartContent()
    {
        session()->forget('cart');
    }

    /**
     * @param Request $request
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function removeItemFromCart(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }
        session()->put('cart', $cart);
    }

    /**
     * @param Request $request
     * @return void
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function checkoutCart(Request $request)
    {
        $cart = session()->get('cart', []);

        $totalPrice = 0;
        $itemsBreakDown = [];
        foreach ($cart as $item) {
            $totalPrice += $item['quantity'] * $item['price'];
            $itemsBreakDown[] = $item;
        }

        $order = new Order();
        $order->user_id = auth()->user()->id; // Assuming the user is authenticated
        $order->order_details = serialize($itemsBreakDown);
        $order->total_amount = $totalPrice;
        $order->save();

        session()->forget('cart');
    }
}

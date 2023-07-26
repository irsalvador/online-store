<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CartService;

/**
 * Cart Controller
 * @author IR Salvador
 * @since 2023.07.25
 */
class CartController extends Controller
{
    private CartService $cartService;

    public function __construct()
    {
        $this->cartService = new CartService();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addToCart(Request $request)
    {
        $this->cartService->saveItemToCart($request);
        return response()->json(['message' => 'Product added to cart successfully']);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function viewCart()
    {
        $cart = $this->cartService->viewCartDetails();
        $total_price = $this->cartService->computeTotalPriceInCart($cart);
        return view('customer.cart.view', compact('cart', 'total_price'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearCart()
    {
        $this->cartService->clearCartContent();
        return response()->json(['message' => 'Cart hs been cleared!']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function removeItem(Request $request)
    {
        $this->cartService->removeItemFromCart($request);
        return response()->json(['message' => 'Item removed from the cart successfully.']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function placeOrder(Request $request)
    {
        $this->cartService->checkoutCart($request);
        return response()->json(['message' => 'Successfully checkout.']);
    }
}


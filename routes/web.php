<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Admin\OrderController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::redirect('/', '/login');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/view', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::delete('/cart/clear/item', [CartController::class, 'removeItem'])->name('cart.item.clear');
Route::post('/cart/checkout', [CartController::class, 'placeOrder'])->name('cart.checkout');

Route::middleware('auth', 'isAdmin')->prefix('admin')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('products/{product}/confirm-delete', [ProductController::class, 'confirmDelete'])->name('products.destroy-confirm');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::get('orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::put('orders/ship', [OrderController::class, 'markAsShipped'])->name('admin.orders.markAsShipped');
    Route::put('orders/cancel', [OrderController::class, 'cancelOrder'])->name('admin.orders.cancel');
});

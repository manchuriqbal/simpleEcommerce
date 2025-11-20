<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'landing_page'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [App\Http\Controllers\OrderController::class, 'place_order'])->name('order.place_order');
    Route::get('/order-success', [App\Http\Controllers\OrderController::class, 'order_success'])->name('order.success');
});


Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::post('/add-to-cart/{productId}', [App\Http\Controllers\CartController::class, 'addToCart'])->name('addToCart');
Route::delete('/cart/{productId}/delete', [App\Http\Controllers\CartController::class, 'delete'])->name('cart.delete');
Route::get('/cart/delete', [App\Http\Controllers\CartController::class, 'clearCart'])->name('cart.clearCart');
Route::patch('/cart/{cart}/decrement', [App\Http\Controllers\CartController::class, 'decrement'])->name('cart.decrement');
Route::patch('/cart/{cart}/increment', [App\Http\Controllers\CartController::class, 'increment'])->name('cart.increment');

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

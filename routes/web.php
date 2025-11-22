<?php

use App\Http\Controllers\ProfileController;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'landing_page'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [App\Http\Controllers\OrderController::class, 'place_order'])->name('order.place_order');
    Route::get('/order-success/{order_code}/', [App\Http\Controllers\OrderController::class, 'order_success'])->name('order.success');

    Route::get('/me', [App\Http\Controllers\ProfileController::class, 'me'])->name('profile.me');
});


// Authenticate Cart Routes
Route::name('cart.')->middleware(['auth'])->group(function () {
    Route::get('/cart', [App\Http\Controllers\Cart\AuthCartController::class, 'index'])->name('index');
    Route::post('/add-to-cart/{productId}', [App\Http\Controllers\Cart\AuthCartController::class, 'addToCart'])->name('add');
    Route::delete('/cart/{productId}', [App\Http\Controllers\Cart\AuthCartController::class, 'delete'])->name('delete');
    Route::get('/cart/clear', [App\Http\Controllers\Cart\AuthCartController::class, 'clearCart'])->name('clear');
    Route::patch('/cart/{productId}/decrement', [App\Http\Controllers\Cart\AuthCartController::class, 'decrement'])->name('decrement');
    Route::patch('/cart/{productId}/increment', [App\Http\Controllers\Cart\AuthCartController::class, 'increment'])->name('increment');
});

// Session Cart Routes
Route::prefix('guest')->name('guest.cart.')->middleware(['guest'])->group(function () {
    Route::get('/cart', [App\Http\Controllers\Cart\GuestCartController::class, 'index'])->name('index');
    Route::post('/add-to-cart/{productId}', [App\Http\Controllers\Cart\GuestCartController::class, 'addToCart'])->name('add');
    Route::delete('/cart/{productId}', [App\Http\Controllers\Cart\GuestCartController::class, 'delete'])->name('delete');
    Route::get('/cart/clear', [App\Http\Controllers\Cart\GuestCartController::class, 'clearCart'])->name('clear');
    Route::patch('/cart/{productId}/decrement', [App\Http\Controllers\Cart\GuestCartController::class, 'decrement'])->name('decrement');
    Route::patch('/cart/{productId}/increment', [App\Http\Controllers\Cart\GuestCartController::class, 'increment'])->name('increment');
});


Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'landing_page'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
// Route::post('/add-to-cart/{productId}', [App\Http\Controllers\CartController::class, 'addToCart'])->name('addToCart');
// Route::delete('/cart/{productId}/delete', [App\Http\Controllers\CartController::class, 'delete'])->name('cart.delete');
// Route::get('/cart/delete', [App\Http\Controllers\CartController::class, 'clearCart'])->name('cart.clearCart');
// Route::patch('/cart/{cart}/decrement', [App\Http\Controllers\CartController::class, 'decrement'])->name('cart.decrement');
// Route::patch('/cart/{cart}/increment', [App\Http\Controllers\CartController::class, 'increment'])->name('cart.increment');
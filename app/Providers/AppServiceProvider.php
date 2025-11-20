<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        View::composer('*', function ($view) {
            $user = auth()->user();
            $carts = Session()->get('cart', []);

            $cartCount = 0;

            if ($carts) {
                $cartCount = count($carts);
            }

            $view->with('cartCount', $cartCount);
        });
        View::composer('*', function ($view) {
            $user = auth()->user();

            $view->with('user', $user);
        });
    }
}

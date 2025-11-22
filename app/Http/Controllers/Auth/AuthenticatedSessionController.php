<?php

namespace App\Http\Controllers\Auth;


use App\Models\Cart;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function sessionCheck()
    // {
    //     try {
    //         DB::beginTransaction();
    //         // Authenticated
    //         $request->authenticate();
    //         $request->session()->regenerate();

    //         // Move Cart from session to Database
    //         $carts = Session::get('cart', []);
    //         if (empty($carts)) {
    //             return redirect()->route('home')->with('waring', 'there is no Cart!');
    //         }

    //         foreach ($carts as $cart) {

    //             Cart::updateOrCreate([
    //                 'product_id' => $cart['product_id'],
    //                 'quantity' => $cart['quantity'],
    //                 'user_id' => 1,
    //             ]);
    //         }
    //         Session::forget('cart');
    //         Session::flash('Success', 'Session Cart Clear and Add Database!');
    //         DB::commit();

    //        return redirect()->intended(route('home', absolute: false));

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error($e->getMessage());

    //         return back()->withInput()->withErrors(['error' => 'An error occurred. All changes were reverted.']);
    //     }
    // }

    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            // Authenticated
            $request->authenticate();
            $request->session()->regenerate();

            // Move Cart from session to Database
            $carts = Session::get('cart', []);

            if (!empty($carts)) {
                foreach ($carts as $cart) {

                    Cart::updateOrCreate(
                        [
                            'product_id' => $cart['product_id'],
                            'user_id' => auth()->user()->id,
                        ],
                        [
                            'quantity' => $cart['quantity'],
                        ]
                    );
                }
                Session::forget('cart');
                Session::flash('Success', 'Session Cart Clear and Add Database!');
            }
            DB::commit();

            if (empty($carts)) {
                return redirect()->route('home')->with('waring', 'there is no Cart!');
            }

            return redirect()->intended(route('home', absolute: false));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return back()->withInput()->withErrors(['error' => 'An error occurred. All changes were reverted.']);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

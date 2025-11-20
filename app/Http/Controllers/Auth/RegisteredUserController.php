<?php

namespace App\Http\Controllers\Auth;

use App\Models\Cart;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            DB::beginTransaction();
            // User Register and Authentication
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            Auth::login($user);

            // Move Cart from session to Database
            $carts = Session::get('cart', []);
            if (empty($carts)) {
                return redirect()->route('home')->with('waring', 'there is no Cart!');
            }

            foreach ($carts as $cart) {
                Cart::updateOrCreate([
                    'product_id' => $cart['product_id'],
                    'quantity' => $cart['quantity'],
                    'user_id' => auth()->user()->id,
                ]);
            }
            Session::forget('cart');
            Session::flash('Success', 'Session Cart Clear and Add Database!');
            DB::commit();

            return redirect(route('home', absolute: false));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred. All changes were reverted.']);
        }
    }

    // public function sessionCheck()
    // {
    //     try {
    //         DB::beginTransaction();
    //         // User Register and Authentication
    //         $user = User::create([
    //             'name' => $request->name,
    //             'email' => $request->email,
    //             'password' => Hash::make($request->password),
    //         ]);

    //         event(new Registered($user));

    //         Auth::login($user);

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

    //         return redirect(route('home', absolute: false));
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error($e->getMessage());

    //         return back()->withInput()->withErrors(['error' => 'An error occurred. All changes were reverted.']);
    //     }
    // }
}

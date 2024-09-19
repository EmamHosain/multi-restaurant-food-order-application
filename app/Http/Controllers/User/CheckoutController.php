<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function shopCheckout(Request $request)
    {
        $cart_items = session()->get('cart', []);

        if (Auth::check()) {
            if (count((array) $cart_items) > 0) {
                return view('frontend.checkout.view_checkout');
            } else {

                if (session()->has('client_id')) {
                    $client_id = session()->get('client_id');
                    return to_route('restuarant_details', $client_id);

                } else {
                    return to_route('index');
                }
            }

        } else {
            $notification = [
                'alert-type' => 'error',
                'message' => 'Login First!'
            ];
            return redirect()->route('login')->with($notification);
        }

    }
}

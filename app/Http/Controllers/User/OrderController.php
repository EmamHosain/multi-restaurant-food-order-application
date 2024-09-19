<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function cashOrder(Request $request)
    {
         $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        $cart = session()->get('cart', []);
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += ($item['price'] * $item['quantity']);
        }


        if (session()->has('coupon')) {
            $total_amount_with_discount = (session()->get('coupon')['discount_amount']);
        } else {
            $total_amount_with_discount = $totalAmount;
        }




        $order_id = Order::insertGetId([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone ?? null,
            'address' => $request->address ?? null,
            'payment_type' => 'Cash On Delivery',
            'payment_method' => 'Cash On Delivery',
            'currency' => 'USD',
            'amount' => $totalAmount,
            'total_amount' => $total_amount_with_discount,
            'invoice_no' => 'food' . mt_rand(10000000, 99999999),
            'order_date' => Carbon::now()->format('d F Y'),
            'order_month' => Carbon::now()->format('F'),
            'order_year' => Carbon::now()->format('Y'),
            'status' => 'Pending',
            'created_at' => Carbon::now(),
        ]);





        $carts = session()->get('cart', []);
        foreach ($carts as $cart) {
            OrderItem::insert([
                'order_id' => $order_id,
                'product_id' => $cart['id'],
                'client_id' => $cart['client_id'],
                'qty' => $cart['quantity'],
                'price' => $cart['price'],
                'created_at' => Carbon::now(),
            ]);
        }







        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        if (Session::has('cart')) {
            Session::forget('cart');
        }

        $notification = array(
            'message' => 'Order Placed Successfully',
            'alert-type' => 'success'
        );

        return view('frontend.checkout.thanks')->with($notification);

    }

    
}

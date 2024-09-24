<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class StripePaymentGatewayController extends Controller
{

    public function stripeOrder(Request $request)
    {

        $user = Auth::user();
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

        // secret key
        Stripe::setApiKey('sk_test_51Q2GSPRtEB0xQ8CuDWrXPK8kVhOgbWieuAAltozzkG6jxfq4siYVun3WA1MLGC8AilsH3fh1pSYlVglzgVM2LvQy003jWq8S3r');

        $token = $_POST['stripeToken'];

        $charge = Charge::create([
            'amount' => $totalAmount * 100,
            'currency' => 'usd',
            'description' => 'EasyFood  Delivery',
            'source' => $token,
            'metadata' => ['order_id' => '6735']
        ]);

        $order_id = Order::insertGetId([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,

            'payment_type' => $charge->payment_method,
            'payment_method' => 'Stripe',
            'currency' => $charge->currency,
            'transaction_id' => $charge->balance_transaction,
            'amount' => $totalAmount,
            'order_number' => $charge->metadata->order_id,
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
                'client_id' => $cart['client_id'],
                'order_id' => $order_id,
                'product_id' => $cart['id'],
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

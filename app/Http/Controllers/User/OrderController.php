<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

// dom pdf 
use Barryvdh\DomPDF\Facade\Pdf;
class OrderController extends Controller
{
    public function cashOrder(Request $request)
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

        $order_id = Order::insertGetId([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone ?? null,
            'address' => $user->address ?? null,
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



    public function getMyAllOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        return view('frontend.dashboard.order.order_list', [
            'allUserOrder' => $orders
        ]);
    }


    public function orderDetails($id)
    {
        $order = Order::with('user')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$order) {
            return redirect()->back()->with([
                'alert-type' => 'error',
                'message' => 'Invalid order!'
            ]);
        }

        $order_items = OrderItem::with('product')
            ->where('order_id', $order->id)
            ->orderByDesc('id')
            ->get();

        $total_price = 0;
        foreach ($order_items as $item) {
            $total_price += $item->price * $item->qty;
        }

        return view('frontend.dashboard.order.order_details', [
            'totalPrice' => $total_price,
            'order' => $order,
            'orderItem' => $order_items,
        ]);
    }


    public function downloadInvoice($id)
    {
        $order = Order::with('user')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$order) {
            return redirect()->back()->with([
                'alert-type' => 'error',
                'message' => 'Invalid order!'
            ]);
        }

        $order_items = OrderItem::with('product')
            ->where('order_id', $order->id)
            ->orderByDesc('id')
            ->get();

        $total_price = 0;
        foreach ($order_items as $item) {
            $total_price += $item->price * $item->qty;
        }

        // pdf generate start here



        $pdf = Pdf::loadView('frontend.dashboard.order.invoice_download', [
            'orderItem' => $order_items,
            'order' => $order,
            'totalPrice' => $total_price,
        ])->setPaper('a4')
        ->setOption([
            'tempDir'=> public_path(),
            'chroot'=> public_path(),
        ]);
        return $pdf->download('invoice.pdf');
        // pdf generate end here
    }

}

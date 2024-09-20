<?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderManageController extends Controller
{
    public function getAllClientsOrder()
    {
        $client_id = Auth::guard('client')->id();

        $order_items = OrderItem::with('order')
            ->where('client_id', $client_id)
            ->orderByDesc('id')
            ->get()
            ->groupBy('order_id');
        return view('client.backend.order.all_orders', [
            'orders' => $order_items
        ]);

    }


    public function orderDetails($id)
    {

        $order = Order::with('user')->find($id);

        $order_items = OrderItem::with('product')
            ->where('order_id', $order->id)
            ->orderByDesc('id')
            ->get();

        $total_price = 0;
        foreach ($order_items as $item) {
            $total_price += $item->price * $item->qty;
        }

        return view('client.backend.order.client_order_details', [
            'order' => $order,
            'order_items' => $order_items,
            'totalPrice' => $total_price,
        ]);

    }
}

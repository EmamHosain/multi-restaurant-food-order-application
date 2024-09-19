<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderManageController extends Controller
{
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

        return view('admin.backend.order.admin_order_details', [
            'order' => $order,
            'orderItem' => $order_items,
            'totalPrice' => $total_price,
        ]);

    }







    public function pendingOrders()
    {
        $orders = Order::where('status', 'Pending')->orderByDesc('id')->get();
        return view('admin.backend.order.pending_order', [
            'allData' => $orders
        ]);
    }
    
    public function confirmedOrders()
    {
        $orders = Order::where('status', 'Confirmed')->orderByDesc('id')->get();
        return view('admin.backend.order.confirm_order', [
            'allData' => $orders
        ]);
    }


    public function processingOrders()
    {
        $orders = Order::where('status', 'Processing')->orderByDesc('id')->get();
        return view('admin.backend.order.processing_order', [
            'allData' => $orders
        ]);
    }

   

    public function deliverdOrders()
    {
        $orders = Order::where('status', 'Deliverd')->orderByDesc('id')->get();
        return view('admin.backend.order.deliverd_order', [
            'allData' => $orders
        ]);
    }


    // pending to confirm order 
    public function pendintToConfirm(Order $order)
    {
        $order->update([
            'status' => 'Confirmed'
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Status updated successfully.'
        ];
        return redirect()->route('admin.confirmed_orders')->with($notification);
    }

    // confrim to processing order 
    public function confirmToProcessing(Order $order)
    {
        $order->update([
            'status' => 'Processing'
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Status updated successfully.'
        ];
        return to_route('admin.processing_orders')->with($notification);
    }


    // processing to deliverd order 
    public function processingToDeliverd(Order $order)
    {
        $order->update([
            'status' => 'Deliverd'
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Status updated successfully.'
        ];
        return to_route('admin.deliverd_orders')->with($notification);
    }
}

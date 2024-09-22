<?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function getReportPage()
    {
        return view('client.backend.report.all_report');
    }


    public function getAllReportByDate(Request $request)
    {
        // Validate the request
        $request->validate([
            'date' => 'required|date', // Ensures date is provided and in a valid date format
        ]);
        $client_id = Auth::guard('client')->id();

        $date = $request->date;
        $new_date = new \DateTime($date);
        $formated_date = $new_date->format('d F Y');

        $orders = Order::where('order_date', $formated_date)
            ->whereHas('orderItems', function ($query) use ($client_id) {
                $query->where('client_id', $client_id);
            })
            ->latest()
            ->get();


        $order_items = OrderItem::with(['order'])
            ->whereIn('order_id', $orders->pluck('id'))
            ->where('client_id', $client_id)
            ->orderByDesc('order_id')
            ->get()
            ->groupBy('order_id');

        // return response()->json($order_items);


        return view('client.backend.report.search_by_date', [
            'formatDate' => $formated_date,
            'order_items' => $order_items
        ]);
    }


    public function getAllReportByMonth(Request $request)
    {
        // Validate the request
        $request->validate([
            'month' => 'required|string',   //
            'year_name' => 'required|digits:4|integer|min:2015',  
        ]);

        $client_id = Auth::guard('client')->id();
        $month = $request->month;
        $year_name = $request->year_name;

        $orders = Order::where('order_month', $month)
            ->where('order_year', $year_name)
            ->whereHas('orderItems', function ($query) use ($client_id) {
                $query->where('client_id', $client_id);
            })
            ->latest()
            ->get();


        $order_items = OrderItem::with(['order'])
            ->whereIn('order_id', $orders->pluck('id'))
            ->where('client_id', $client_id)
            ->orderByDesc('order_id')
            ->get()
            ->groupBy('order_id');


        return view('client.backend.report.search_by_month', [
            'month' => $month,
            'year' => $year_name,
            'order_items' => $order_items
        ]);
    }

    public function getAllReportByYear(Request $request)
    {
        $request->validate([
            'year' => 'required|digits:4|integer|min:2000',
        ]);
        $client_id = Auth::guard('client')->id();
        $year_name = $request->year;

        $orders = Order::where('order_year', $year_name)
            ->whereHas('orderItems', function ($query) use ($client_id) {
                $query->where('client_id', $client_id);
            })
            ->latest()
            ->get();


        $order_items = OrderItem::with(['order'])
            ->whereIn('order_id', $orders->pluck('id'))
            ->where('client_id', $client_id)
            ->orderByDesc('order_id')
            ->get()
            ->groupBy('order_id');



        return view('client.backend.report.search_by_year', [
            'year' => $year_name,
            'order_items' => $order_items
        ]);
    }
}

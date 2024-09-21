<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function getAllReport()
    {
        return view('admin.backend.report.all_report');
    }

    public function getAllReportByDate(Request $request)
    {
        // Validate the request
        $request->validate([
            'date' => 'required|date', // Ensures date is provided and in a valid date format
        ]);


        $date = $request->date;
        $new_date = new \DateTime($date);
        $formated_date = $new_date->format('d F Y');
        $orders = Order::where('order_date', $formated_date)->orderByDesc('id')->get();

        return view('admin.backend.report.search_by_date', [
            'formatDate' => $formated_date,
            'orders' => $orders
        ]);
    }


    public function getAllReportByMonth(Request $request)
    {
        // dd($request->all());
        // Validate the request
        $request->validate([
            'month' => 'required|string',   // Ensure a month is selected
            'year_name' => 'required|digits:4|integer|min:2015',  // Ensure a valid year is selected
        ]);


        $month = $request->month;
        $year_name = $request->year_name;

        $orders = Order::where('order_month', $month)
            ->where('order_year', $year_name)
            ->orderByDesc('id')->get();

        return view('admin.backend.report.search_by_month', [
            'month' => $month,
            'year' => $year_name,
            'orders' => $orders
        ]);
    }

    public function getAllReportByYear(Request $request)
    {
        $request->validate([
            'year' => 'required|digits:4|integer|min:2000',
        ]);

        $year_name = $request->year;

        $orders = Order::where('order_year', $year_name)
            ->orderByDesc('id')->get();

        return view('admin.backend.report.search_by_year', [
            'year' => $year_name,
            'orders' => $orders
        ]);
    }
}

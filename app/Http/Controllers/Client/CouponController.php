<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index()
    {
        $id = Auth::guard('client')->id();
        $coupons = Coupon::where('client_id', $id)->get();
        return view('client.backend.coupon.all_coupon', ['coupons' => $coupons]);
    }
    public function create()
    {
        return view('client.backend.coupon.add_coupon');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'coupon_name' => 'required|string|max:255',
            'coupon_desc' => 'nullable|string',
            'validity_date' => 'required|date',
            'discount' => 'required|numeric|min:0',
        ]);

        // Create a new Coupon instance
        $coupon = new Coupon();
        $coupon->client_id = Auth::guard('client')->id();
        $coupon->coupon_name = strtoupper($request->input('coupon_name'));
        $coupon->coupon_desc = $request->input('coupon_desc');
        $coupon->validity_date = $request->input('validity_date');
        $coupon->discount = $request->input('discount');
        $coupon->created_at = Carbon::now();

        if ($request->input('status')) {
            $coupon->status = $request->input('status');
        }

        // Save the Coupon
        $coupon->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Coupon created successfully.'
        ];
        // Optionally, you can return a response or redirect
        return redirect()->route('client.all_coupons')->with($notification);
    }


    public function edit(Request $request, Coupon $coupon)
    {
        return view('client.backend.coupon.edit_coupon', [
            'coupon' => $coupon
        ]);
    }



    public function update(Request $request, Coupon $coupon)
    {
        // Validate the request data
        $request->validate([
            'coupon_name' => 'required|string|max:255',
            'coupon_desc' => 'nullable|string',
            'validity_date' => 'required|date',
            'discount' => 'required|numeric|min:0',
        ]);

        // Create a new Coupon instance
        $coupon->client_id = Auth::guard('client')->id();
        $coupon->coupon_name = strtoupper($request->input('coupon_name'));
        $coupon->coupon_desc = $request->input('coupon_desc');
        $coupon->validity_date = $request->input('validity_date');
        $coupon->discount = $request->input('discount');
        $coupon->created_at = Carbon::now();


        // Save the Coupon
        $coupon->save();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Coupon updated successfully.'
        ];
        // Optionally, you can return a response or redirect
        return redirect()->route('client.all_coupons')->with($notification);
    }

    public function destroy(Coupon $coupon)
    {
        $notification = [
            'alert-type' => 'success',
            'message' => 'Coupon deleted successfully.'
        ];
        $coupon->delete();
        // Optionally, you can return a response or redirect
        return redirect()->route('client.all_coupons')->with($notification);
    }
}

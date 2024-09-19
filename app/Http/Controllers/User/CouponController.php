<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function applyCoupon(Request $request)
    {
        $coupon = Coupon::where('coupon_name', $request->coupon_name)
            ->where('validity_date', '>=', Carbon::now()->format('Y-m-d'))
            ->where('status', 1)
            ->latest()->first();

        $cartItems = Session()->get('cart', []);
        $totalAmount = 0;
        $clientIds = [];

        foreach ($cartItems as $item) {
            $totalAmount += $item['price'];
            $product = Product::find($item['id']);
            array_push($clientIds, $product->client_id);
        }

        if (count((array) $cartItems) > 0) {
            if ($coupon) {

                if (count(array_unique($clientIds)) == 1 && $coupon->client_id == $clientIds[0]) {

                    $discount_amount = $totalAmount - ($totalAmount * $coupon->discount / 100);
                    session()->put('coupon', [
                        'coupon_name' => $coupon->coupon_name,
                        'discount' => $coupon->discount,
                        'discount_amount' => round($discount_amount),
                    ]);

                    $couponData = session()->get('coupon', []);
                    return response()->json([
                        'success' => 'coupon apply successfully.',
                        'coupon' => $couponData,
                    ]);


                } else {
                    return response()->json([
                        'error' => 'This coupon not valid for this restaurant.',
                    ]);
                }




            } else {
                return response()->json([
                    'error' => 'This coupon is not valid.',
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Please product add to cart first.',
            ]);
        }



    }


    public function removeCoupon()
    {
        // Check if a coupon is present in the session
        if (session()->has('coupon')) {
            // Remove the coupon from the session
            session()->forget('coupon');

            return response()->json([
                'success' => 'Coupon removed successfully.',
            ]);
        } else {
            return response()->json([
                'error' => 'No coupon found to remove.',
            ]);
        }
    }

}

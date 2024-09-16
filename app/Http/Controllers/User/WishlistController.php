<?php

namespace App\Http\Controllers\User;

use App\Models\Client;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function restuarantAddToWishList(Client $client)
    {

        if (Auth::check()) {
            $exits = Wishlist::where('user_id', Auth::id())->where('client_id', $client->id)->first();

            if (!$exits) {
                Wishlist::create([
                    'user_id' => Auth::id(),
                    'client_id' => $client->id,
                    'created_at' => Carbon::now(),
                ]);

                return response()->json([
                    'success' => 'Product add to wishlist successful.'
                ]);
            } else {
                return response()->json([
                    'error' => 'This product has already on your wishlist.'
                ]);
            }


        } else {


            return response()->json([
                'error' => 'Please Login First.'
            ]);

        }


    }




    public function getAllWishlists()
    {
        $wishlists = Wishlist::with('client')->where('user_id', Auth::id())->get();
        return view('frontend.dashboard.all_wishlist', compact('wishlists'));
    }

    public function removeWishlist($id)
    {
        Wishlist::where('user_id', Auth::id())->where('client_id', $id)->delete();
        $notification = [
            'message' => 'Removed successfully.',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($notification);
    }
}

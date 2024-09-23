<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function reviewStore(Request $request)
    {
        $client = $request->client_id;
        $request->validate([
            'comment' => 'required'
        ]);
        Review::insert([
            'client_id' => $client,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
            'rating' => $request->rating,
            'created_at' => Carbon::now(),
            'status' => 1
        ]);

        $notification = array(
            'message' => 'Review Will Approlve By Admin',
            'alert-type' => 'success'
        );
        $previousUrl = $request->headers->get('referer');
        $redirectUrl = $previousUrl ? $previousUrl . '#pills-reviews' : route('restuarant_details', ['id' => $client]) . '#pills-reviews';
        return redirect()->to($redirectUrl)->with($notification);
    }
}

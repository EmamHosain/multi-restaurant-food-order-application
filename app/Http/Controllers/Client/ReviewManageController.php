<?php

namespace App\Http\Controllers\Client;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewManageController extends Controller
{
    public function getReviews()
    {
        $reviews = Review::with('user', 'client')
            ->where('status', 1)
            ->where('client_id', Auth::guard('client')->id())
            ->latest()
            ->get();
        return view('client.backend.review.view_all_review', [
            'allreviews' => $reviews
        ]);
    }
}

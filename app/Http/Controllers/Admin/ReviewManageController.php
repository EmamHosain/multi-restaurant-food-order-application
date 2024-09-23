<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewManageController extends Controller
{
    public function getAllPendingReviews()
    {
        $reviews = Review::with(['user', 'client'])->where('status', 0)->latest()->get();
        return view('admin.backend.review.view_pending_review', [
            'pedingReview' => $reviews
        ]);
    }

    public function getAllAppropedReviews()
    {
        $reviews = Review::with(['user', 'client'])->where('status', 1)->latest()->get();

        return view('admin.backend.review.view_approve_review', [
            'approveReview' => $reviews
        ]);
    }

    public function ReviewChangeStatus(Request $request){
        $review = Review::find($request->review_id);
        $review->status = $request->status;
        $review->save();
        return response()->json(['success' => 'Status Change Successfully']);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Models\Menu;
use App\Models\Client;
use App\Models\Review;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home()
    {
        if (session()->has('client_id')) {
            session()->forget('client_id');
        }
        return view('frontend.index');
    }
    public function getRestuarantDetailsPage(Client $client)
    {

        session()->put('client_id', $client->id);

        // get all menu where menu's product in not empty
        $menus = Menu::with([
            'products' =>
                function ($query) use ($client) {
                    $query->where('client_id', $client->id);
                }
        ])
            ->where('client_id', $client->id)
            ->orderByDesc('id')
            ->get()
            ->filter(function ($menu) {
                return $menu->products->isNotEmpty();
            });

        $reviews = Review::where('client_id', $client->id)->get();
        $totalReviews = $reviews->count();
        $ratingSum = $reviews->sum('rating');
        $averageRating = $ratingSum > 0 ? $ratingSum / $totalReviews : 0;
        $roundedAverageRating = round($averageRating, 1);
        
        $ratingCounts = [
            '5' => $reviews->where('rating', 5)->count(),
            '4' => $reviews->where('rating', 4)->count(),
            '3' => $reviews->where('rating', 3)->count(),
            '2' => $reviews->where('rating', 2)->count(),
            '1' => $reviews->where('rating', 1)->count(),
        ];

        $ratingPercentages = array_map(function ($count) use ($totalReviews) {
            return $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }, $ratingCounts);

       
        return view('frontend.details_page', [
            'client' => $client,
            'menus' => $menus,
            'gallerys' => Gallery::where('client_id', $client->id)->orderByDesc('id')->get(),
            'reviews' => $reviews,
            'roundedAverageRating' => $roundedAverageRating,
            'totalReviews' => $totalReviews,
            'ratingCounts' => $ratingCounts,
            'ratingPercentages' => $ratingPercentages
        ]);
    }



}

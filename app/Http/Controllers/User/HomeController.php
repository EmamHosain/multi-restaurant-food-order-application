<?php

namespace App\Http\Controllers\User;

use App\Models\Gallery;
use App\Models\Menu;
use App\Models\Client;
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

        return view('frontend.details_page', [
            'client' => $client,
            'menus' => $menus,
            'gallerys' => Gallery::where('client_id', $client->id)->orderByDesc('id')->get(),
        ]);
    }



}

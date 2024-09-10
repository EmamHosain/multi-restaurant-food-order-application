<?php

namespace App\Http\Controllers\Client;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

// image intervention package 
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MenuController extends Controller
{
    public function index()
    {
        $id = Auth::guard('client')->id();
        $menus = Menu::where('client_id', $id)->orderByDesc('id')->get();
        return view('client.backend.menu.all_menu', compact('menus'));
    }
    public function create()
    {
        return view('client.backend.menu.add_menu');
    }

    public function store(Request $request)
    {

        $request->validate([
            'menu_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $menu = new Menu();
        $menu->menu_name = $request->input('menu_name');
        $menu->client_id = Auth::guard('client')->id();
        $menu->slug = Str::slug($request->input('menu_name'));

        if ($request->hasFile('image')) {
            // image intervention 
            $manager = new ImageManager(new Driver());
            // Store new photo and update user record
            $image = $request->file('image');
            $image_name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/menu/' . $image_name));
            $image_with_full_path = 'upload/menu/' . $image_name;
            // Only store the file name in the database
            $menu->image = $image_with_full_path;
        }

        $menu->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Menu created successfully.'
        ];
        return redirect()->route('client.all_menu')->with($notification);
    }



    public function edit(Request $request, Menu $menu)
    {
        $id = Auth::guard('client')->id();
        $menus = Menu::where('client_id', $id)->orderByDesc('id')->get();
        return view('client.backend.menu.edit_menu', [
            'menu' => $menus
        ]);
    }


    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'menu_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $menu->menu_name = $request->input('menu_name');
        $menu->slug = Str::slug($request->input('menu_name'));

        if ($request->hasFile('image')) {

            // delete old image
            if ($menu->image && file_exists(public_path($menu->image))) {
                unlink(public_path($menu->image));
            }




            // image intervention 
            $manager = new ImageManager(new Driver());
            // Store new photo and update user record
            $image = $request->file('image');
            $image_name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/menu/' . $image_name));
            $image_with_full_path = 'upload/menu/' . $image_name;
            // Only store the file name in the database
            $menu->image = $image_with_full_path;
        }

        $menu->save();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Menu updated successfully.'
        ];
        return redirect()->route('client.all_menu')->with($notification);
    }

    public function destroy(Menu $menu)
    {
        // delete old image
        if ($menu->image && file_exists(public_path($menu->image))) {
            unlink(public_path($menu->image));
        }
        $menu->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Menu deleted successfully.'
        ];
        return redirect()->back()->with($notification);
    }


}

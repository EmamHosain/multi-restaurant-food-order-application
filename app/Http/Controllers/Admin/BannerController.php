<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// image intervention package 
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::get();
        return view('admin.backend.banner.all_banner', [
            'banner' => $banners
        ]);
    }
    public function create()
    {
        return view('admin.backend.banner.add_banner');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'banner_image' => 'required|image|mimes:png,jpg,jpeg',
            'banner_url' => 'nullable|string|url'
        ]);

        if ($request->hasFile('banner_image')) {

            // image intervention 
            $manager = new ImageManager(new Driver());


            // Store new photo and update user record
            $image = $request->file('banner_image');
            $image_name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            $img = $manager->read($image);
            $img->resize(400, 400)->save(public_path('upload/banner/' . $image_name));
            $image_with_full_path = 'upload/banner/' . $image_name;
            // Only store the file name in the database
            $validatedData['banner_image'] = $image_with_full_path;
        }

        Banner::create($validatedData);

        $notification = [
            'alert-type' => 'success',
            'message' => 'Banner created successfully.'
        ];
        return redirect()->route('admin.all_banners')->with($notification);

    }

    public function edit(Banner $banner)
    {
        return view('admin.backend.banner.edit_banner', [
            'banner' => $banner
        ]);
    }

    public function update(Request $request, Banner $banner)
    {

        $validatedData = $request->validate([
            'banner_image' => 'required|image|mimes:png,jpg,jpeg',
            'banner_url' => 'nullable|string|url'
        ]);

        if ($request->hasFile('banner_image')) {

            // delete previous image 
            if ($banner->banner_image && file_exists(public_path($banner->banner_image))) {
                unlink(public_path($banner->banner_image));
            }


            // image intervention 
            $manager = new ImageManager(new Driver());


            // Store new photo and update user record
            $image = $request->file('banner_image');
            $image_name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            $img = $manager->read($image);
            $img->resize(400, 400)->save(public_path('upload/banner/' . $image_name));
            $image_with_full_path = 'upload/banner/' . $image_name;
            // Only store the file name in the database
            $validatedData['banner_image'] = $image_with_full_path;
        }

        $banner->update($validatedData);

        $notification = [
            'alert-type' => 'success',
            'message' => 'Banner updated successfully.'
        ];
        return redirect()->route('admin.all_banners')->with($notification);

    }


    public function destroy(Banner $banner)
    {
        // delete previous image 
        if ($banner->banner_image && file_exists(public_path($banner->banner_image))) {
            unlink(public_path($banner->banner_image));
        }
        $banner->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Banner deleted successfully.'
        ];
        return redirect()->route('admin.all_banners')->with($notification);
    }
}

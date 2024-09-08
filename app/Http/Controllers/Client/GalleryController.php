<?php

namespace App\Http\Controllers\Client;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;



// image intervention package 
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class GalleryController extends Controller
{
    public function index()
    {
        $client = Auth::guard('client')->user();
        $galleries = Gallery::where('client_id', $client->id)->orderByDesc('id')->get();
        return view('client.backend.gallery.all_gallery', [
            'galleries' => $galleries
        ]);
    }
    public function create()
    {
        return view('client.backend.gallery.add_gallery');
    }
    public function store(Request $request)
    {
        // Validate multiple image uploads
        $request->validate([
            'image' => 'required|array', // Ensure image field is an array
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Each image should be valid
        ]);

        // Handle multiple image uploads
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                // Generate a unique name for each image
                $image_name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

                $manager = new ImageManager(new Driver());
                $img = $manager->read($image);
                $img->resize(500, 350)->save(public_path('upload/gallery/' . $image_name));
                // Store image path in the database
                $image_with_full_path = 'upload/gallery/' . $image_name;
                Gallery::create([
                    'client_id' => Auth::guard('client')->id(),
                    'image' => $image_with_full_path
                ]);
            }
        }

        // Set a success notification
        $notification = [
            'alert-type' => 'success',
            'message' => 'Gallery images uploaded successfully.'
        ];

        // Redirect or return success message
        return redirect()->route('client.all_galleries')->with($notification);
    }

    public function edit(Request $request, Gallery $gallery)
    {
        return view('client.backend.gallery.edit_gallery', [
            'gallery' => $gallery
        ]);
    }






    public function update(Request $request, Gallery $gallery)
    {
        // Validate multiple image uploads
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);



        // Handle multiple image uploads
        if ($request->hasFile('image')) {

            // delete old image
            if ($gallery->image && file_exists(public_path($gallery->image))) {
                unlink(public_path($gallery->image));
            }




            $image = $request->file('image');
            // Generate a unique name for each image
            $image_name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->resize(500, 350)->save(public_path('upload/gallery/' . $image_name));
            // Store image path in the database
            $image_with_full_path = 'upload/gallery/' . $image_name;

            $gallery->update([
                'image' => $image_with_full_path
            ]);

        }

        // Set a success notification
        $notification = [
            'alert-type' => 'success',
            'message' => 'Gallery image updated successfully.'
        ];

        // Redirect or return success message
        return redirect()->route('client.all_galleries')->with($notification);
    }

    public function destroy(Gallery $gallery)
    {
        // delete old image
        if ($gallery->image && file_exists(public_path($gallery->image))) {
            unlink(public_path($gallery->image));
        }
        $gallery->delete();

        $notification = [
            'alert-type' => 'success',
            'message' => 'Gallery image deleted successfully.'
        ];
        return redirect()->back()->with($notification);
    }


}

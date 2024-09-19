<?php

namespace App\Http\Controllers\Client;


use App\Models\City;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

// image intervention package 
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ClientProfileController extends Controller
{
    public function getProfile()
    {
        $client = Auth::guard('client')->user();
        $cities = City::get();

        return view('client.client_profile', [
            'profileData' => $client,
            'cities' => $cities
        ]);
    }
    public function profileUpdate(Request $request)
    {
        // dd($request->all());
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|string|exists:clients,email',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg',
            'cover_photo' => 'nullable|image|mimes:jpg,png,jpeg,webp',

            'city_id' => 'nullable',
            'shop_info' => 'nullable|string',

        ]);

       
        // Get the authenticated Client user
        $id = Auth::guard('client')->id();
        $client = Client::find($id);


        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            // Check if an old photo exists and delete it
            if ($client->photo && file_exists(public_path($client->photo))) {
                unlink(public_path($client->photo)); // delete the old photo
            }

            // Store new photo and update user record
            $photo = $request->file('photo');

            $photo_name = time() . '-' . uniqid() . '.' . $photo->getClientOriginalExtension();

            // resize image 
            $manager = new ImageManager(new Driver());
            $img = $manager->read($photo);
            $img->resize(300, 300)->save(public_path('upload/client_images/' . $photo_name));


            // Only store the file name in the database
            $image_name_with_full_path = 'upload/client_images/' . $photo_name;
            $validatedData['photo'] = $image_name_with_full_path;
        }



        // Handle image upload
        if ($request->hasFile('cover_photo')) {
            // Check if an old photo exists and delete it
            if ($client->cover_photo && file_exists(public_path($client->cover_photo))) {
                unlink(public_path($client->cover_photo)); // delete the old photo
            }





            // Use image intervention for resizing and saving
            $image = $request->file('cover_photo');
            $image_name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Resize and store image
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->resize(400,400)->save(public_path('upload/cover_photo/' . $image_name));

            // $img->cover(1200, 360)->save(public_path('upload/cover_photo/' . $image_name));

            // Store image path in the database
            $validatedData['cover_photo'] = 'upload/cover_photo/' . $image_name;
        }

        $client->update($validatedData);


        // Redirect back with success message
        return redirect()->back()->with([
            'message' => 'Profile updated successfully.',
            'alert-type' => 'success',
        ]);
    }

    public function getUpdatePasswordPage()
    {
        $client = Auth::guard('client')->user();
        return view('client.client_change_Password', [
            'profileData' => $client
        ]);
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        $Client = Auth::guard('client')->user();

        $notification = [
            'message' => 'Password updated successfully.',
            'alert-type' => 'success',
        ];
        if (!Hash::check($request->old_password, $Client->password)) {
            $notification = [
                'message' => 'Invalid old password.',
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($notification);
        }


        if ($request->new_password === $request->confirm_password) {
            Client::whereId($Client->id)->update([
                'password' => Hash::make($request->new_password),
            ]);
            return redirect()->back()->with($notification);
        } else {
            throw ValidationException::withMessages([
                'new_password' => 'New password and confrim password must be the same.'
            ]);
        }
    }
}

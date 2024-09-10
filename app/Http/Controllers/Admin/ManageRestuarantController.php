<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;


// image intervention package 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ManageRestuarantController extends Controller
{
    public function allRestuarants()
    {
        $clients = Client::orderByDesc('id')->get();
        return view('admin.backend.restaurant.all_restaurant', [
            'client' => $clients
        ]);
    }

    public function getPendingRestuarants()
    {
        $clients = Client::where('status', '0')->orderByDesc('id')->get();
        return view('admin.backend.restaurant.pending_restuarant', [
            'client' => $clients
        ]);
    }


    public function getApprovedRestuarants()
    {
        $clients = Client::where('status', '1')->orderByDesc('id')->get();
        return view('admin.backend.restaurant.approve_restaurant', [
            'client' => $clients
        ]);
    }

    public function setInactiveClient(Client $client)
    {
        $client->update([
            'status' => '0'
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Status updated successfully.'
        ];
        return redirect()->back()->with($notification);

    }

    public function setActiveClient(Client $client)
    {
        $client->update([
            'status' => '1'
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Status updated successfully.'
        ];
        return redirect()->back()->with($notification);

    }

    public function create()
    {
        $cities = City::get();
        return view('admin.backend.restaurant.add_restuarant', [
            'cities' => $cities
        ]);
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:clients,email',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg',
            'cover_photo' => 'nullable|image|mimes:jpg,png,jpeg',
            'city_id' => 'nullable',
            'shop_info' => 'nullable|string',
            'status' => 'nullable|numeric|between:0,1',
            // New fields for password validation
            'password' => 'required|string|min:8|confirmed', // Password must be confirmed
        ]);

        $admin_id = Auth::guard('admin')->id();
        $validatedData['admin_id'] = $admin_id;

        // Hash the password before storing it
        $validatedData['password'] = Hash::make($request->password);

        if ($request->input('status')) {
            $validatedData['status'] = $request->input('status');
        } else {
            unset($validatedData['status']);
        }


        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo_name = time() . '-' . uniqid() . '.' . $photo->getClientOriginalExtension();

            // Resize image
            $manager = new ImageManager(new Driver());
            $img = $manager->read($photo);
            $img->resize(300, 300)->save(public_path('upload/client_images/' . $photo_name));

            // Only store the file name in the database
            $image_name_with_full_path = 'upload/client_images/' . $photo_name;
            $validatedData['photo'] = $image_name_with_full_path;
        }

        // Handle cover photo upload if provided
        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $image_name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Resize and store image
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->cover(1200, 360)->save(public_path('upload/cover_photo/' . $image_name));

            // Store image path in the database
            $validatedData['cover_photo'] = 'upload/cover_photo/' . $image_name;
        }

        // Create the client record in the database
        Client::create($validatedData);

        // Redirect back with success message
        return redirect()->route('admin.all_restuarants')->with([
            'message' => 'Restaurant created successfully.',
            'alert-type' => 'success',
        ]);
    }



    public function edit(Client $client)
    {

        return view('admin.backend.restaurant.edit_restuarant', [
            'cities' => City::get(),
            'client' => $client
        ]);
    }
    public function update(Request $request, Client $client)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|min:3',
            'email' => ['required', 'email', Rule::unique(Client::class)->ignore($client->id)],
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg',
            'cover_photo' => 'nullable|image|mimes:jpg,png,jpeg',
            'city_id' => 'nullable',
            'shop_info' => 'nullable|string',
            'status' => 'nullable|numeric|between:0,1',

            // Password validation
            'password' => 'nullable|string|min:8|confirmed', // Password is optional for updates
        ]);

        $admin_id = Auth::guard('admin')->id();
        $validatedData['admin_id'] = $admin_id;

        // Handle password update if provided
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            // Exclude the password field if not provided
            unset($validatedData['password']);
        }

        if ($request->input('status') == 1 || $request->input('status') == 0) {
            $validatedData['status'] = $request->input('status');
        } else {
            // Exclude the password field if not provided
            unset($validatedData['status']);
        }

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo_name = time() . '-' . uniqid() . '.' . $photo->getClientOriginalExtension();

            // Resize image
            $manager = new ImageManager(new Driver());
            $img = $manager->read($photo);
            $img->resize(300, 300)->save(public_path('upload/client_images/' . $photo_name));

            // Only store the file name in the database
            $validatedData['photo'] = 'upload/client_images/' . $photo_name;
        }

        // Handle cover photo upload if provided
        if ($request->hasFile('cover_photo')) {
            $image = $request->file('cover_photo');
            $image_name = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Resize and store image
            $manager = new ImageManager(new Driver());
            $img = $manager->read($image);
            $img->cover(1200, 360)->save(public_path('upload/cover_photo/' . $image_name));

            // Store image path in the database
            $validatedData['cover_photo'] = 'upload/cover_photo/' . $image_name;
        }

        // Update the client record in the database
        $client->update($validatedData);

        // Redirect back with success message
        return redirect()->route('admin.all_restuarants')->with([
            'message' => 'Restaurant updated successfully.',
            'alert-type' => 'success',
        ]);
    }


    public function destroy(Client $client)
    {

        if ($client->photo && file_exists($client->photo)) {
            unlink(public_path($client->photo));
        }
        if ($client->cover_photo && file_exists($client->cover_photo)) {
            unlink(public_path($client->cover_photo));
        }
        $client->delete();

        return redirect()->back()->with([
            'message' => 'Restaurant deleted successfully.',
            'alert-type' => 'success',
        ]);
    }


}

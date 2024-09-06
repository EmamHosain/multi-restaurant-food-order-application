<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profileUpdate(Request $request)
    {
        // dd($request->all());
        // Validate incoming request data
        $id = Auth::guard('web')->user()->id;
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => ['required', 'email', 'string', Rule::unique('users')->ignore($id)],
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg'
        ]);

        // Get the authenticated admin user
        $id = Auth::guard('web')->user()->id;
        $user = User::find($id);

        // Update user profile fields
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            // Check if an old photo exists and delete it
            if ($user->photo && file_exists(public_path('upload/user_images/' . $user->photo))) {
                unlink(public_path('upload/user_images/' . $user->photo)); // delete the old photo
            }

            // Store new photo and update user record
            $photo = $request->file('photo');
            $photo_name = time() . '-' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('upload/user_images'), $photo_name);

            // Only store the file name in the database
            $user->photo = $photo_name;
        }

        // Save updated user details
        $user->save();

        // Redirect back with success message
        return redirect()->back()->with([
            'message' => 'Profile updated successfully.',
            'alert-type' => 'success',
        ]);
    }
}

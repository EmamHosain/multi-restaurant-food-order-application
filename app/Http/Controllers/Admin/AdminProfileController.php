<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminProfileController extends Controller
{
    public function getProfile()
    {
        $id = Auth::guard('admin')->id();
        $admin = Admin::find($id);
        return view('admin.admin_profile', compact('admin'));
    }

    public function profileUpdate(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|string|exists:admins,email',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg'
        ]);

        // Get the authenticated admin user
        $id = Auth::guard('admin')->id();
        $admin = Admin::find($id);

        // Update user profile fields
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->address = $request->address;
        $admin->phone = $request->phone;

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            // Check if an old photo exists and delete it
            if ($admin->photo && file_exists(public_path('upload/admin_images/' . $admin->photo))) {
                unlink(public_path('upload/admin_images/' . $admin->photo)); // delete the old photo
            }

            // Store new photo and update user record
            $photo = $request->file('photo');
            $photo_name = time() . '-' . uniqid() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('upload/admin_images'), $photo_name);

            // Only store the file name in the database
            $admin->photo = $photo_name;
        }

        // Save updated user details
        $admin->save();

        // Redirect back with success message
        return redirect()->back()->with([
            'message' => 'Profile updated successfully.',
            'alert-type' => 'success',
        ]);
    }





    public function getUpdatePasswordPage()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.admin_change_password', compact('admin'));
    }

    public function getUpdatePasswordSubmit(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        $admin = Auth::guard('admin')->user();

        $notification = [
            'message' => 'Password updated successfully.',
            'alert-type' => 'success',
        ];
        if (!Hash::check($request->old_password, $admin->password)) {
            $notification = [
                'message' => 'Invalid old password.',
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($notification);
        }


        if ($request->new_password === $request->confirm_password) {
            Admin::whereId($admin->id)->update([
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

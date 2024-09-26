<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminRoleManageController extends Controller
{
    public function getAllAdmin()
    {
        $admins = Admin::with('roles')->latest()->get();
        // return response()->json($admins);
        return view('admin.backend.pages.admin.all_admin', [
            'alladmin' => $admins
        ]);

    }

    public function addAdmin()
    {
        $roles = Role::latest()->get();
        return view('admin.backend.pages.admin.add_admin', [
            'roles' => $roles
        ]);
    }
    public function storeAdmin(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,id', // Matching form field name 'roles'
        ]);

        // Create new admin record
        $admin = new Admin();
        $admin->name = $validatedData['name'];
        $admin->email = $validatedData['email'];
        $admin->phone = $validatedData['phone'];
        $admin->address = $validatedData['address'];
        $admin->password = Hash::make($validatedData['password']);
        $admin->role = 'admin';  // Assuming all admins will have a 'role' value of 'admin'
        $admin->status = '1';    // Set default status as active (1)
        $admin->save();

        // Assign role if it exists
        if ($validatedData['role']) {
            $role = Role::where('id', $validatedData['role'])
                ->where('guard_name', 'admin')
                ->first();

            if ($role) {
                $admin->assignRole($role->name);  // Assign the selected role
            }
        }
        $notification = array(
            'message' => 'New Admin Inserted Successfully',
            'alert-type' => 'success'
        );
        // Redirect back with success message
        return redirect()->route('admin.get_all_admin')->with($notification);
    }

    public function editAdmin(Admin $admin)
    {
        $roles = Role::latest()->get();
        return view('admin.backend.pages.admin.edit_admin', [
            'admin' => $admin,
            'roles' => $roles
        ]);
    }

    public function updateAdmin(Request $request, Admin $admin)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'nullable|exists:roles,id',
        ]);

        $admin->name = $validatedData['name'];
        $admin->email = $validatedData['email'];
        $admin->phone = $validatedData['phone'];
        $admin->address = $validatedData['address'];
        $admin->role = 'admin';  // Assuming all admins will have a 'role' value of 'admin'
        $admin->status = '1';    // Set default status as active (1)
        $admin->save();



        // remove exiting role 
        $admin->roles()->detach();

        if ($validatedData['role']) {
            $role = Role::where('id', $request->role)->where('guard_name', 'admin')->first();
            if ($role) {
                $admin->assignRole($role->name);
            }
        }
        $notification = array(
            'message' => 'New Admin updated Successfully',
            'alert-type' => 'success'
        );
        // Redirect back with success message
        return redirect()->route('admin.get_all_admin')->with($notification);
    }

    public function deleteAdmin(Admin $admin)
    {
        if ($admin->photo && file_exists(public_path('upload/admin_images/' . $admin->photo))) {
            unlink(public_path('upload/admin_images/' . $admin->photo)); // delete the old photo
        }
        $admin->delete();
        $notification = array(
            'message' => 'New Admin deleted Successfully',
            'alert-type' => 'success'
        );
        // Redirect back with success message
        return redirect()->route('admin.get_all_admin')->with($notification);
    }

}

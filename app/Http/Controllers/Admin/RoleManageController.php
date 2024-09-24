<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RoleManageController extends Controller
{
    public function getAllRoles()
    {
        $roles = Role::get();
        return view('admin.backend.pages.role.all_roles', [
            'roles' => $roles
        ]);
    }
    public function addRole()
    {
        return view('admin.backend.pages.role.add_roles');
    }

    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Role::create([
            'name' => $request->input('name'),
            'guard_name' => 'admin',
            'created_at' => Carbon::now(),
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Role created successfully.',
        ];
        return to_route('admin.get_all_roles')->with($notification);
    }

    public function editRole(Role $role)
    {

        return view('admin.backend.pages.role.edit_roles', [
            'roles' => $role
        ]);
    }
    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $role->update([
            'name' => $request->input('name'),
        ]);
        $notification = [
            'alert-type' => 'success',
            'message' => 'Role updated successfully.',
        ];
        return to_route('admin.get_all_roles')->with($notification);
    }

    public function deleteRole(Role $role)
    {
        $role->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Role deleted successfully.',
        ];
        return redirect()->back()->with($notification);
    }
}

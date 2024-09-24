<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionManageController extends Controller
{
    public function getAllPermissions()
    {
        $permissions = Permission::orderByDesc('id')->get();
        return view('admin.backend.pages.permission.all_permission', [
            'permissions' => $permissions
        ]);
    }
    public function addPermission()
    {
        return view('admin.backend.pages.permission.add_permission');
    }

    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'group_name' => 'required|string',
        ]);

        Permission::create([
            'name' => $request->input('name'),
            'guard_name' => 'admin',
            'group_name' => $request->input('group_name'),
        ]);


        $notification = [
            'alert-type' => 'success',
            'message' => 'Permission created successfully.',
        ];
        return to_route('admin.get_all_permissions')->with($notification);
    }
    public function editPermission(Permission $permission)
    {
        return view('admin.backend.pages.permission.edit_permission', [
            'permission' => $permission
        ]);
    }

    public function updatePermission(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'group_name' => 'required|string',
        ]);

        $permission->update($request->all());
        $notification = [
            'alert-type' => 'success',
            'message' => 'Permission updated successfully.',
        ];
        return to_route('admin.get_all_permissions')->with($notification);
    }


    
    public function deletePermission(Permission $permission)
    {
        $permission->delete();
        $notification = [
            'alert-type' => 'success',
            'message' => 'Permission deleted successfully.',
        ];
        return redirect()->back()->with($notification);
    }


}

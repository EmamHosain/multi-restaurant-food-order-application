<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RolePermissionManageController extends Controller
{
    public function addRoleAndPermission()
    {
        $roles = Role::get();
        $permissions = Permission::get();
        $permissions_group = Admin::getPermissionGroups();


        // return response()->json($permissions_group);

        return view('admin.backend.pages.rolesetup.add_roles_permission', [
            'roles' => $roles,
            'permissions' => $permissions,
            'permission_groups' => $permissions_group
        ]);

    }


    public function assignRolePermission(Request $request)
    {

        $request->validate([
            'role' => 'required',
            // 'permission' => 'required|array'
        ]);


        $permissions = $request->input('permission');

        if (empty($permissions)) {
            $notification = [
                'alert-type' => 'error',
                'message' => 'Please select permission'
            ];
            return redirect()->back()->with($notification);
        }


        $data = array();
        foreach ($permissions as $key => $item) {
            $data['role_id'] = $request->input('role');
            $data['permission_id'] = $item;
            DB::table('role_has_permissions')->insert($data);
        }

        $notification = [
            'alert-type' => 'success',
            'message' => 'Role and permission assing successful.'
        ];
        return to_route('admin.get_all_role_and_permission')->with($notification);

    }

    public function getAllRoleAndPermission()
    {
        $roles = Role::orderByDesc('id')->get();
        return view('admin.backend.pages.rolesetup.all_roles_permission', [
            'roles' => $roles
        ]);
    }

    public function editRoleAndPermission(Role $role)
    {
        $permissions = Permission::get();
        $permissions_group = Admin::getPermissionGroups();

        return view('admin.backend.pages.rolesetup.edit_roles_permission', [
            'permissions' => $permissions,
            'permission_groups' => $permissions_group,
            'role' => $role
        ]);
    }

    public function updateRoleAndPermission(Request $request, Role $role)
    {

        $permissions = $request->permission;
        if (!empty($permissions)) {
            $permissionNames = Permission::whereIn('id', $permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
        } else {
            $role->syncPermissions([]);
        }
        $notification = array(
            'message' => 'Role Permission Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.get_all_role_and_permission')->with($notification);
    }


    public function deleteRoleAndPermission(Role $role)
    {
        $role->delete();
        $notification = array(
            'message' => 'Role deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.get_all_role_and_permission')->with($notification);
    }

}

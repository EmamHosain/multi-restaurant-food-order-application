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
        // Validate request
        $request->validate([
            'role' => 'required|exists:roles,id',
            // 'permission' => 'required|array'
        ]);

        // Get the role by its ID
        $role = Role::findOrFail($request->role);

        // Fetch permission names by their IDs
        $permissions = Permission::whereIn('id', $request->input('permission'))
            ->pluck('name')
            ->toArray();

        // Check if there are valid permissions
        if (empty($permissions)) {
            $notification = [
                'alert-type' => 'error',
                'message' => 'Please select valid permissions.'
            ];
            return redirect()->back()->with($notification);
        }

        // Sync the role with the permissions (this will remove old permissions and assign new ones)
        // data insert or update into role_has_parmission pivot table
        $role->syncPermissions($permissions);

        // Success notification
        $notification = [
            'alert-type' => 'success',
            'message' => 'Role and permissions assigned successfully.'
        ];

        // Redirect to the roles and permissions list
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
        // Ensure that 'permission' is always an array, even if none are selected
        $permissions = $request->input('permission', []);

        // Check if permissions are provided
        if (empty($permissions)) {
            $notification = [
                'alert-type' => 'error',
                'message' => 'Please select valid permissions.'
            ];
            return redirect()->back()->with($notification);
        }

        // Fetch the permission names from the selected IDs
        $permissionNames = Permission::whereIn('id', $permissions)->pluck('name')->toArray();

        // Sync the role with the permissions
        $role->syncPermissions($permissionNames);

        // Success notification
        $notification = [
            'message' => 'Role Permission Updated Successfully',
            'alert-type' => 'success'
        ];

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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function __construct()
    {
        //for ajax middleware
    }

    //fetch roles
    public function fetchRoles()
    {
        return Role::paginate(10);
    }
    //fetch all permissions
    public function fetchPermissions()
    {
        return Permission::all();
    }


    //save roles
    public function saveRole(SaveRoleRequest $request)
    {

        $permission_ids = \array_filter($request->ids);
        $role = Role::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name]
        );;

        $role->syncPermissions($permission_ids);

        return \response('success', 200);
    }
    public function editRole($role)
    {
        $role = Role::where('id', $role)->with('permissions')->first();
        return $role;
    }
    //delete role
    public function deleteRole(Role $role)
    {
        $role->permissions()->detach();
        $role->delete();

        return \response('success', 200);
    }

    //permission
    public function savePermission(Request $request)
    {
        $permission = Permission::updateOrCreate(
            ['id' => $request->id],
            ['name' => $request->name]
        );

        return \response('success', 200);
    }

    public function editPermission(Permission $permission)
    {
        return $permission;
    }
    public function deletePermission(Permission $permission)
    {
        $permission->roles()->detach();
        $permission->delete();

        return \response('success', 200);
    }
}

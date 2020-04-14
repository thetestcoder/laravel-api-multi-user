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
        return Role::paginate(5);
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
        $role = Role::create(['name' => $request->name]);

        $role->syncPermissions($permission_ids);

        return \response('success', 200);
    }
}

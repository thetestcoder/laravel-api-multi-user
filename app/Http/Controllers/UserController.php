<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function fetchUsers()
    {
        return User::with('roles')->paginate(10);
    }
    public function fetchAllRoles()
    {
        return Role::all();
    }
    public function onEdit($id)
    {
        return User::where('id', $id)->with('roles')->first();
    }

    public function saveUser(UserRequest $request)
    {
        $user = User::create(
            [
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password)
            ]
        );

        $user->assignRole($request->role_id);

        return \response('success', 200);
    }
    public function updateUser(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $roles = Role::find($request->role_id);

        $user->syncRoles($roles);

        return \response('success', 200);
    }
    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->syncRoles('');
        $user->delete();
        return \response('success', 200);
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'id'            => 'required',
            'password'      => 'required|min:8'
        ]);
        $user = User::find($request->id);
        $user->password = Hash::make($request->password);
        $user->save();

        return \response('success', 200);
    }
}

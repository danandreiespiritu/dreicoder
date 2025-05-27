<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function assignRoleToUser(Request $request)
    {
        $roleName = 'admin';
        $role = Role::firstOrCreate(['name' => $roleName]);

        $user = User::find($request->user_id);
        if ($user) {
            $user->assignRole($role);
            return response()->json(['message' => 'Role assigned successfully.']);
        } else {
            return response()->json(['error' => 'User not found.'], 404);
        }
    }
}

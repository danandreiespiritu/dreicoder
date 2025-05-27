<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        $roleName = 'admin';
        $role = Role::firstOrCreate(['name' => $roleName]);

        $user = User::find(2);
        if ($user) {
            $user->assignRole($role);
        } else {
            echo "User with ID 1 not found.";
        }
    }
}

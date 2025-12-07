<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a global superadmin permission and role. organization_id = null => global
        $perm = Permission::firstOrCreate(
            ['name' => 'superadmin'],
            ['display_name' => 'Super Administrator', 'description' => 'Global super admin permission']
        );

        $role = Role::firstOrCreate(
            ['name' => 'superadmin', 'organization_id' => null],
            ['display_name' => 'Super Administrator', 'description' => 'Global tenant superadmin role']
        );

        // Attach permission to role if not already attached
        if (! $role->permissions()->where('permissions.id', $perm->id)->exists()) {
            $role->permissions()->attach($perm->id);
        }

        // Create a superadmin user
        $email = config('app.superadmin_email', 'admin@example.com');
        $password = config('app.superadmin_password', 'password');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Super Admin',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );

        // Attach role to user via pivot. role_user has organization_id nullable for global role.
        if (! $user->roles()->where('roles.id', $role->id)->exists()) {
            $user->roles()->attach($role->id, [
                'organization_id' => null,
                'user_type' => get_class($user),
            ]);
        }
    }
}

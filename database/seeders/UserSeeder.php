<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizations = Organization::all();
        if ($organizations->isEmpty()) {
            $this->call(OrganizationSeeder::class);
            $organizations = Organization::all();
        }

        $roles = Role::all();
        if ($roles->isEmpty()) {
            $this->call(RolePermissionSeeder::class);
            $roles = Role::all();
        }

        foreach ($organizations as $org) {
            $orgRoles = Role::where('organization_id', $org->id)->get();
            $adminRole = $orgRoles->where('name', 'administrator')->first();
            $managerRole = $orgRoles->where('name', 'manager')->first();
            $staffRole = $orgRoles->where('name', 'staff')->first();

            // Admin user
            $admin = User::firstOrCreate(
                ['email' => "admin@{$org->slug}.com"],
                [
                    'name' => "مدير {$org->name}",
                    'password' => Hash::make('password'),
                    'organization_id' => $org->id,
                    'email_verified_at' => now(),
                ]
            );
            if ($adminRole && !$admin->roles()->where('roles.id', $adminRole->id)->exists()) {
                $admin->roles()->attach($adminRole->id, [
                    'organization_id' => $org->id,
                    'user_type' => User::class,
                ]);
            }

            // Manager user
            $manager = User::firstOrCreate(
                ['email' => "manager@{$org->slug}.com"],
                [
                    'name' => "مدير العمليات - {$org->name}",
                    'password' => Hash::make('password'),
                    'organization_id' => $org->id,
                    'email_verified_at' => now(),
                ]
            );
            if ($managerRole && !$manager->roles()->where('roles.id', $managerRole->id)->exists()) {
                $manager->roles()->attach($managerRole->id, [
                    'organization_id' => $org->id,
                    'user_type' => User::class,
                ]);
            }

            // Staff users
            for ($i = 1; $i <= 3; $i++) {
                $staff = User::firstOrCreate(
                    ['email' => "staff{$i}@{$org->slug}.com"],
                    [
                        'name' => "موظف {$i} - {$org->name}",
                        'password' => Hash::make('password'),
                        'organization_id' => $org->id,
                        'email_verified_at' => now(),
                    ]
                );
                if ($staffRole && !$staff->roles()->where('roles.id', $staffRole->id)->exists()) {
                    $staff->roles()->attach($staffRole->id, [
                        'organization_id' => $org->id,
                        'user_type' => User::class,
                    ]);
                }
            }
        }
    }
}


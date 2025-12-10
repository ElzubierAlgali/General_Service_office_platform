<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all organizations or create default
        $organizations = Organization::all();
        if ($organizations->isEmpty()) {
            $this->call(OrganizationSeeder::class);
            $organizations = Organization::all();
        }

        // Define permissions
        $permissions = [
            // User Management
            ['name' => 'view-users', 'display_name' => 'عرض المستخدمين', 'description' => 'القدرة على عرض قائمة المستخدمين'],
            ['name' => 'create-users', 'display_name' => 'إنشاء المستخدمين', 'description' => 'القدرة على إنشاء مستخدمين جدد'],
            ['name' => 'edit-users', 'display_name' => 'تعديل المستخدمين', 'description' => 'القدرة على تعديل بيانات المستخدمين'],
            ['name' => 'delete-users', 'display_name' => 'حذف المستخدمين', 'description' => 'القدرة على حذف المستخدمين'],
            
            // Role Management
            ['name' => 'view-roles', 'display_name' => 'عرض الصلاحيات', 'description' => 'القدرة على عرض قائمة الصلاحيات'],
            ['name' => 'create-roles', 'display_name' => 'إنشاء الصلاحيات', 'description' => 'القدرة على إنشاء صلاحيات جديدة'],
            ['name' => 'edit-roles', 'display_name' => 'تعديل الصلاحيات', 'description' => 'القدرة على تعديل الصلاحيات'],
            ['name' => 'delete-roles', 'display_name' => 'حذف الصلاحيات', 'description' => 'القدرة على حذف الصلاحيات'],
            
            // Permission Management
            ['name' => 'view-permissions', 'display_name' => 'عرض الأذونات', 'description' => 'القدرة على عرض قائمة الأذونات'],
            ['name' => 'create-permissions', 'display_name' => 'إنشاء الأذونات', 'description' => 'القدرة على إنشاء أذونات جديدة'],
            ['name' => 'edit-permissions', 'display_name' => 'تعديل الأذونات', 'description' => 'القدرة على تعديل الأذونات'],
            ['name' => 'delete-permissions', 'display_name' => 'حذف الأذونات', 'description' => 'القدرة على حذف الأذونات'],
            
            // Customer Management
            ['name' => 'view-customers', 'display_name' => 'عرض العملاء', 'description' => 'القدرة على عرض قائمة العملاء'],
            ['name' => 'create-customers', 'display_name' => 'إنشاء العملاء', 'description' => 'القدرة على إنشاء عملاء جدد'],
            ['name' => 'edit-customers', 'display_name' => 'تعديل العملاء', 'description' => 'القدرة على تعديل بيانات العملاء'],
            ['name' => 'delete-customers', 'display_name' => 'حذف العملاء', 'description' => 'القدرة على حذف العملاء'],
            
            // Service Management
            ['name' => 'view-services', 'display_name' => 'عرض الخدمات', 'description' => 'القدرة على عرض قائمة الخدمات'],
            ['name' => 'create-services', 'display_name' => 'إنشاء الخدمات', 'description' => 'القدرة على إنشاء خدمات جديدة'],
            ['name' => 'edit-services', 'display_name' => 'تعديل الخدمات', 'description' => 'القدرة على تعديل الخدمات'],
            ['name' => 'delete-services', 'display_name' => 'حذف الخدمات', 'description' => 'القدرة على حذف الخدمات'],
            
            // Transaction Management
            ['name' => 'view-transactions', 'display_name' => 'عرض المعاملات', 'description' => 'القدرة على عرض قائمة المعاملات'],
            ['name' => 'create-transactions', 'display_name' => 'إنشاء المعاملات', 'description' => 'القدرة على إنشاء معاملات جديدة'],
            ['name' => 'edit-transactions', 'display_name' => 'تعديل المعاملات', 'description' => 'القدرة على تعديل المعاملات'],
            ['name' => 'delete-transactions', 'display_name' => 'حذف المعاملات', 'description' => 'القدرة على حذف المعاملات'],
            
            // Settings
            ['name' => 'manage-settings', 'display_name' => 'إدارة الإعدادات', 'description' => 'القدرة على إدارة إعدادات النظام'],
            ['name' => 'manage-users', 'display_name' => 'إدارة المستخدمين', 'description' => 'إدارة كاملة للمستخدمين والصلاحيات'],
        ];

        // Define roles
        $roles = [
            [
                'name' => 'administrator',
                'display_name' => 'مدير النظام',
                'description' => 'صلاحية مدير النظام الكاملة',
                'permissions' => [
                    'view-users', 'create-users', 'edit-users', 'delete-users',
                    'view-roles', 'create-roles', 'edit-roles', 'delete-roles',
                    'view-permissions', 'create-permissions', 'edit-permissions', 'delete-permissions',
                    'view-customers', 'create-customers', 'edit-customers', 'delete-customers',
                    'view-services', 'create-services', 'edit-services', 'delete-services',
                    'view-transactions', 'create-transactions', 'edit-transactions', 'delete-transactions',
                    'manage-settings', 'manage-users',
                ],
            ],
            [
                'name' => 'manager',
                'display_name' => 'مدير',
                'description' => 'صلاحية المدير لإدارة العمليات اليومية',
                'permissions' => [
                    'view-users', 'view-roles',
                    'view-customers', 'create-customers', 'edit-customers',
                    'view-services', 'create-services', 'edit-services',
                    'view-transactions', 'create-transactions', 'edit-transactions',
                ],
            ],
            [
                'name' => 'staff',
                'display_name' => 'موظف',
                'description' => 'صلاحية الموظف العادي',
                'permissions' => [
                    'view-customers', 'create-customers', 'edit-customers',
                    'view-services',
                    'view-transactions', 'create-transactions',
                ],
            ],
            [
                'name' => 'viewer',
                'display_name' => 'مشاهد',
                'description' => 'صلاحية العرض فقط بدون تعديل',
                'permissions' => [
                    'view-users', 'view-roles', 'view-permissions',
                    'view-customers', 'view-services', 'view-transactions',
                ],
            ],
        ];

        // Create permissions and roles for each organization
        foreach ($organizations as $org) {
            // Create permissions for this organization
            $orgPermissions = [];
            foreach ($permissions as $permData) {
                $permission = Permission::firstOrCreate(
                    [
                        'name' => $permData['name'],
                        'organization_id' => $org->id,
                    ],
                    [
                        'display_name' => $permData['display_name'],
                        'description' => $permData['description'],
                    ]
                );
                $orgPermissions[$permData['name']] = $permission;
            }

            // Create roles for this organization
            foreach ($roles as $roleData) {
                $role = Role::firstOrCreate(
                    [
                        'name' => $roleData['name'],
                        'organization_id' => $org->id,
                    ],
                    [
                        'display_name' => $roleData['display_name'],
                        'description' => $roleData['description'],
                    ]
                );

                // Attach permissions to role
                $permissionIds = [];
                foreach ($roleData['permissions'] as $permName) {
                    if (isset($orgPermissions[$permName])) {
                        $permissionIds[] = $orgPermissions[$permName]->id;
                    }
                }
                $role->permissions()->sync($permissionIds);
            }
        }
    }
}


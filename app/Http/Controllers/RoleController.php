<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use App\Services\TenantManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index(Request $request): View
    {
        $organizationId = TenantManager::getOrganizationId();
        
        $query = Role::withCount('users')->with('permissions');
        
        if ($organizationId) {
            $query->where('organization_id', $organizationId);
        }
        
        $roles = $query->latest()->get();
        
        $stats = [
            'total_roles' => $roles->count(),
            'total_permissions' => Permission::when($organizationId, function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            })->count(),
            'total_users' => User::when($organizationId, function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            })->count(),
            'users_without_role' => User::when($organizationId, function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            })->doesntHave('roles')->count(),
        ];
        
        return view('dashboard.roles.index', compact('roles', 'stats'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        $organizationId = TenantManager::getOrganizationId();
        
        $permissions = Permission::when($organizationId, function ($q) use ($organizationId) {
            $q->where('organization_id', $organizationId);
        })->orderBy('name')->get();
        
        return view('dashboard.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $organizationId = TenantManager::getOrganizationId();
        
        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'organization_id' => $organizationId,
        ]);

        // Attach permissions
        if ($request->has('permissions') && !empty($request->permissions)) {
            $role->permissions()->attach($request->permissions);
        }

        return redirect()->route('roles.index')
            ->with('success', 'تم إضافة الصلاحية بنجاح.');
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role): View
    {
        $role->load('permissions', 'users');
        return view('dashboard.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role): View
    {
        $organizationId = TenantManager::getOrganizationId();
        
        $permissions = Permission::when($organizationId, function ($q) use ($organizationId) {
            $q->where('organization_id', $organizationId);
        })->orderBy('name')->get();
        
        $role->load('permissions');
        
        return view('dashboard.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified role.
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        // Sync permissions
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        } else {
            $role->permissions()->detach();
        }

        return redirect()->route('roles.index')
            ->with('success', 'تم تحديث بيانات الصلاحية بنجاح.');
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role): RedirectResponse
    {
        // Prevent deleting role if it has users
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')
                ->with('error', 'لا يمكن حذف الصلاحية لأنها مرتبطة بمستخدمين.');
        }

        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'تم حذف الصلاحية بنجاح.');
    }

    /**
     * Clone a role.
     */
    public function clone(Role $role): RedirectResponse
    {
        $organizationId = TenantManager::getOrganizationId();
        
        $newRole = $role->replicate();
        $newRole->name = $role->name . '_copy_' . time();
        $newRole->display_name = $role->display_name . ' (نسخة)';
        $newRole->organization_id = $organizationId;
        $newRole->save();

        // Copy permissions
        $newRole->permissions()->attach($role->permissions->pluck('id'));

        return redirect()->route('roles.edit', $newRole->id)
            ->with('success', 'تم نسخ الصلاحية بنجاح.');
    }
}


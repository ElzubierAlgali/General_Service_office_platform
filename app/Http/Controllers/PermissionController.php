<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Services\TenantManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PermissionController extends Controller
{
    /**
     * Display a listing of permissions.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-permissions');
        
        $organizationId = TenantManager::getOrganizationId();
        
        $query = Permission::withCount('roles');
        
        if ($organizationId) {
            $query->where('organization_id', $organizationId);
        }
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('display_name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        
        $permissions = $query->orderBy('name')->get();
        
        $stats = [
            'total_permissions' => $permissions->count(),
            'total_roles' => Role::when($organizationId, function ($q) use ($organizationId) {
                $q->where('organization_id', $organizationId);
            })->count(),
        ];
        
        return view('dashboard.permissions.index', compact('permissions', 'stats'));
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create(): View
    {
        $this->authorize('create-permissions');
        
        return view('dashboard.permissions.create');
    }

    /**
     * Store a newly created permission.
     */
    public function store(StorePermissionRequest $request): RedirectResponse
    {
        $this->authorize('create-permissions');
        
        $organizationId = TenantManager::getOrganizationId();
        
        Permission::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'organization_id' => $organizationId,
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'تم إضافة الصلاحية بنجاح.');
    }

    /**
     * Display the specified permission.
     */
    public function show(Permission $permission): View
    {
        $this->authorize('view-permissions');
        
        $permission->load('roles');
        return view('dashboard.permissions.show', compact('permission'));
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit(Permission $permission): View
    {
        $this->authorize('edit-permissions');
        
        $permission->load('roles');
        return view('dashboard.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified permission.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission): RedirectResponse
    {
        $this->authorize('edit-permissions');
        
        $permission->name = $request->name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;
        $permission->save();

        return redirect()->route('permissions.index')
            ->with('success', 'تم تحديث بيانات الصلاحية بنجاح.');
    }

    /**
     * Remove the specified permission.
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        $this->authorize('delete-permissions');
        
        // Prevent deleting permission if it's attached to roles
        if ($permission->roles()->count() > 0) {
            return redirect()->route('permissions.index')
                ->with('error', 'لا يمكن حذف الصلاحية لأنها مرتبطة بصلاحيات أخرى.');
        }

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', 'تم حذف الصلاحية بنجاح.');
    }
}


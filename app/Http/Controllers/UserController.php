<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Role;
use App\Models\Organization;
use App\Services\TenantManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-users');
        
        $organizationId = TenantManager::getOrganizationId();
        
        $query = User::with('roles', 'organization');
        
        // Filter by organization if tenant scope is active
        if ($organizationId) {
            $query->where('organization_id', $organizationId);
        }
        
        $users = $query->latest()->get();
        $roles = Role::when($organizationId, function ($q) use ($organizationId) {
            $q->where('organization_id', $organizationId);
        })->get();
        
        return view('dashboard.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        $this->authorize('create-users');
        
        $organizationId = TenantManager::getOrganizationId();
        
        $roles = Role::when($organizationId, function ($q) use ($organizationId) {
            $q->where('organization_id', $organizationId);
        })->get();
        
        $organizations = Organization::when($organizationId, function ($q) use ($organizationId) {
            $q->where('id', $organizationId);
        })->get();
        
        return view('dashboard.users.create', compact('roles', 'organizations'));
    }

    /**
     * Store a newly created user.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->authorize('create-users');
        
        $organizationId = TenantManager::getOrganizationId();
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'organization_id' => $request->organization_id ?? $organizationId,
        ]);

        // Attach roles with organization_id in pivot
        if ($request->has('roles') && !empty($request->roles)) {
            $rolesData = [];
            foreach ($request->roles as $roleId) {
                $rolesData[$roleId] = ['organization_id' => $user->organization_id];
            }
            $user->roles()->attach($rolesData);
        }

        return redirect()->route('users.index')
            ->with('success', 'تم إضافة المستخدم بنجاح.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        $this->authorize('view-users');
        
        $user->load('roles', 'organization');
        return view('dashboard.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        $this->authorize('edit-users');
        
        $organizationId = TenantManager::getOrganizationId();
        
        $roles = Role::when($organizationId, function ($q) use ($organizationId) {
            $q->where('organization_id', $organizationId);
        })->get();
        
        $organizations = Organization::when($organizationId, function ($q) use ($organizationId) {
            $q->where('id', $organizationId);
        })->get();
        
        $user->load('roles');
        
        return view('dashboard.users.edit', compact('user', 'roles', 'organizations'));
    }

    /**
     * Update the specified user.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('edit-users');
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        if ($request->has('organization_id')) {
            $user->organization_id = $request->organization_id;
        }
        
        $user->save();

        // Sync roles with organization_id in pivot
        if ($request->has('roles')) {
            $rolesData = [];
            foreach ($request->roles as $roleId) {
                $rolesData[$roleId] = ['organization_id' => $user->organization_id];
            }
            $user->roles()->sync($rolesData);
        } else {
            $user->roles()->detach();
        }

        return redirect()->route('users.index')
            ->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete-users');
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'لا يمكنك حذف حسابك الخاص.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'تم حذف المستخدم بنجاح.');
    }
}

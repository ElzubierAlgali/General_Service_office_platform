<?php

namespace App\Http\Controllers;

<<<<<<< Updated upstream
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Role;
use App\Models\Organization;
use App\Services\TenantManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
=======
use App\Models\User;
use App\Models\Organization;
use Illuminate\Http\Request;
>>>>>>> Stashed changes
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
<<<<<<< Updated upstream
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
=======
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of users for the current organization.
     */
    public function index()
    {
        $users = User::where('organization_id', auth()->user()->organization_id)->paginate(15);
        return view('users.index', compact('users'));
>>>>>>> Stashed changes
    }

    /**
     * Show the form for creating a new user.
     */
<<<<<<< Updated upstream
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
=======
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'organization_id' => auth()->user()->organization_id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('users.show', $user)->with('success', 'User created successfully.');
>>>>>>> Stashed changes
    }

    /**
     * Display the specified user.
     */
<<<<<<< Updated upstream
    public function show(User $user): View
    {
        $this->authorize('view-users');
        
        $user->load('roles', 'organization');
        return view('dashboard.users.show', compact('user'));
=======
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return view('users.show', compact('user'));
>>>>>>> Stashed changes
    }

    /**
     * Show the form for editing the specified user.
     */
<<<<<<< Updated upstream
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

=======
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        return redirect()->route('users.show', $user)->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
>>>>>>> Stashed changes

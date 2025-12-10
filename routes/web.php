<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

// Email verification routes (Blade-based)
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->name('verification.notice');

    Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.resend');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\DashController::class, 'index'])->name('dashboard');

    // User CRUD Routes
    Route::middleware('permission:view-users')->group(function () {
        Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('users.show');
        Route::middleware('permission:create-users')->group(function () {
            Route::get('users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
            Route::post('users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        });
        Route::middleware('permission:edit-users')->group(function () {
            Route::get('users/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
            Route::put('users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
            Route::patch('users/{user}', [\App\Http\Controllers\UserController::class, 'update']);
        });
        Route::delete('users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])
            ->middleware('permission:delete-users')
            ->name('users.destroy');
    });

    // RBAC Routes
    Route::middleware('permission:view-roles')->group(function () {
        Route::get('roles', [\App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
        Route::get('roles/{role}', [\App\Http\Controllers\RoleController::class, 'show'])->name('roles.show');
        Route::middleware('permission:create-roles')->group(function () {
            Route::get('roles/create', [\App\Http\Controllers\RoleController::class, 'create'])->name('roles.create');
            Route::post('roles', [\App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
            Route::post('roles/{role}/clone', [\App\Http\Controllers\RoleController::class, 'clone'])->name('roles.clone');
        });
        Route::middleware('permission:edit-roles')->group(function () {
            Route::get('roles/{role}/edit', [\App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
            Route::put('roles/{role}', [\App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
            Route::patch('roles/{role}', [\App\Http\Controllers\RoleController::class, 'update']);
        });
        Route::delete('roles/{role}', [\App\Http\Controllers\RoleController::class, 'destroy'])
            ->middleware('permission:delete-roles')
            ->name('roles.destroy');
    });
    
    // Permission Routes
    Route::middleware('permission:view-permissions')->group(function () {
        Route::get('permissions', [\App\Http\Controllers\PermissionController::class, 'index'])->name('permissions.index');
        Route::get('permissions/{permission}', [\App\Http\Controllers\PermissionController::class, 'show'])->name('permissions.show');
        Route::middleware('permission:create-permissions')->group(function () {
            Route::get('permissions/create', [\App\Http\Controllers\PermissionController::class, 'create'])->name('permissions.create');
            Route::post('permissions', [\App\Http\Controllers\PermissionController::class, 'store'])->name('permissions.store');
        });
        Route::middleware('permission:edit-permissions')->group(function () {
            Route::get('permissions/{permission}/edit', [\App\Http\Controllers\PermissionController::class, 'edit'])->name('permissions.edit');
            Route::put('permissions/{permission}', [\App\Http\Controllers\PermissionController::class, 'update'])->name('permissions.update');
            Route::patch('permissions/{permission}', [\App\Http\Controllers\PermissionController::class, 'update']);
        });
        Route::delete('permissions/{permission}', [\App\Http\Controllers\PermissionController::class, 'destroy'])
            ->middleware('permission:delete-permissions')
            ->name('permissions.destroy');
    });

    // Business Entity Routes
    Route::middleware('permission:view-customers')->group(function () {
        Route::get('customers', [\App\Http\Controllers\CustomerController::class, 'index'])->name('customers.index');
        Route::get('customers/{customer}', [\App\Http\Controllers\CustomerController::class, 'show'])->name('customers.show');
        Route::middleware('permission:create-customers')->group(function () {
            Route::get('customers/create', [\App\Http\Controllers\CustomerController::class, 'create'])->name('customers.create');
            Route::post('customers', [\App\Http\Controllers\CustomerController::class, 'store'])->name('customers.store');
        });
        Route::middleware('permission:edit-customers')->group(function () {
            Route::get('customers/{customer}/edit', [\App\Http\Controllers\CustomerController::class, 'edit'])->name('customers.edit');
            Route::put('customers/{customer}', [\App\Http\Controllers\CustomerController::class, 'update'])->name('customers.update');
            Route::patch('customers/{customer}', [\App\Http\Controllers\CustomerController::class, 'update']);
        });
        Route::delete('customers/{customer}', [\App\Http\Controllers\CustomerController::class, 'destroy'])
            ->middleware('permission:delete-customers')
            ->name('customers.destroy');
    });

    Route::middleware('permission:view-services')->group(function () {
        Route::get('services', [\App\Http\Controllers\ServiceController::class, 'index'])->name('services.index');
        Route::get('services/{service}', [\App\Http\Controllers\ServiceController::class, 'show'])->name('services.show');
        Route::middleware('permission:create-services')->group(function () {
            Route::get('services/create', [\App\Http\Controllers\ServiceController::class, 'create'])->name('services.create');
            Route::post('services', [\App\Http\Controllers\ServiceController::class, 'store'])->name('services.store');
        });
        Route::middleware('permission:edit-services')->group(function () {
            Route::get('services/{service}/edit', [\App\Http\Controllers\ServiceController::class, 'edit'])->name('services.edit');
            Route::put('services/{service}', [\App\Http\Controllers\ServiceController::class, 'update'])->name('services.update');
            Route::patch('services/{service}', [\App\Http\Controllers\ServiceController::class, 'update']);
        });
        Route::delete('services/{service}', [\App\Http\Controllers\ServiceController::class, 'destroy'])
            ->middleware('permission:delete-services')
            ->name('services.destroy');
    });
});

require __DIR__.'/settings.php';

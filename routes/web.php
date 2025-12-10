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
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // User CRUD Routes
    Route::resource('users', \App\Http\Controllers\UserController::class);

    // RBAC Routes
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::post('roles/{role}/clone', [\App\Http\Controllers\RoleController::class, 'clone'])->name('roles.clone');
    
    Route::resource('permissions', \App\Http\Controllers\PermissionController::class);
});

require __DIR__.'/settings.php';

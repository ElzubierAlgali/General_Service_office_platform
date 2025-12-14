@extends('layouts.master')

@section('page-header')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Management
                    </div>
                    <h2 class="page-title">
                        User Profile
                    </h2>
                    <div class="text-muted mt-1">{{ $user->name }}</div>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                            Edit User
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-link">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                            Back to Users
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="row row-deck row-cards">
                        <!-- Profile Card -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="mb-3">
                                        <span class="avatar avatar-xl" style="background-image: url(https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7C3AED&background=EEF2FF&size=128)"></span>
                                    </div>
                                    <h3 class="card-title mb-1">{{ $user->name }}</h3>
                                    <p class="text-muted">{{ $user->email }}</p>
                                    <div class="mt-3">
                                        @if($user->email_verified_at)
                                            <span class="badge bg-green">Email Verified</span>
                                        @else
                                            <span class="badge bg-yellow">Email Unverified</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="font-weight-bold">{{ $user->created_at->diffForHumans() }}</div>
                                            <div class="text-muted">Member since</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="font-weight-bold">{{ $user->id }}</div>
                                            <div class="text-muted">User ID</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Details -->
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Account Information</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Full Name</h6>
                                        </div>
                                        <div class="col-sm-9 text-muted">
                                            {{ $user->name }}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email Address</h6>
                                        </div>
                                        <div class="col-sm-9 text-muted">
                                            <div class="d-flex align-items-center">
                                                {{ $user->email }}
                                                @if($user->email_verified_at)
                                                    <span class="badge bg-green-lt ms-2">Verified</span>
                                                @else
                                                    <span class="badge bg-yellow-lt ms-2">Unverified</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Account Created</h6>
                                        </div>
                                        <div class="col-sm-9 text-muted">
                                            {{ $user->created_at->format('F d, Y \a\t H:i') }}
                                            <small class="text-muted d-block">{{ $user->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Last Updated</h6>
                                        </div>
                                        <div class="col-sm-9 text-muted">
                                            {{ $user->updated_at->format('F d, Y \a\t H:i') }}
                                            <small class="text-muted d-block">{{ $user->updated_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">User ID</h6>
                                        </div>
                                        <div class="col-sm-9 text-muted">
                                            <code>{{ $user->id }}</code>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Status -->
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h3 class="card-title">Account Status</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" {{ $user->email_verified_at ? 'checked' : '' }} disabled>
                                                    <span class="form-check-label">Email Verified</span>
                                                </label>
                                                <small class="form-hint">
                                                    {{ $user->email_verified_at ? 'Email was verified on ' . $user->email_verified_at->format('M d, Y') : 'Email verification pending' }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" checked disabled>
                                                    <span class="form-check-label">Account Active</span>
                                                </label>
                                                <small class="form-hint">User account is active and can access the system</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body text-end">
                                    <div class="btn-list">
                                        <a href="{{ route('users.index') }}" class="btn btn-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                                            Back to Users
                                        </a>
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                            Edit User
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

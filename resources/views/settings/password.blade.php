@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">Password</h1>

    <form method="POST" action="{{ route('user-password.update') }}" class="mt-6 max-w-md">
        @csrf
        @method('PUT')

        <div>
            <label>Current password</label>
            <input type="password" name="current_password" class="w-full border p-2" />
        </div>

        <div class="mt-3">
            <label>New password</label>
            <input type="password" name="password" class="w-full border p-2" />
        </div>

        <div class="mt-3">
            <label>Confirm password</label>
            <input type="password" name="password_confirmation" class="w-full border p-2" />
        </div>

        <div class="mt-4">
            <button class="px-4 py-2 bg-blue-600 text-white">Update Password</button>
        </div>
    </form>
@endsection

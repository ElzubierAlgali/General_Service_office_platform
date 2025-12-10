@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">Profile Settings</h1>

    @if($mustVerifyEmail)
        <p class="mt-2 text-sm text-yellow-700">Your email must be verified.</p>
    @endif

    @if($status)
        <div class="mt-4 text-green-600">{{ $status }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 max-w-lg">
        @csrf
        @method('PATCH')

        <div>
            <label>Name</label>
            <input name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full border p-2" />
        </div>

        <div class="mt-3">
            <label>Email</label>
            <input name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full border p-2" />
        </div>

        <div class="mt-4">
            <button class="px-4 py-2 bg-blue-600 text-white">Save</button>
        </div>
    </form>
@endsection

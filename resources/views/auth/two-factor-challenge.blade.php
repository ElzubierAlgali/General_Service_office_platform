@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">Two-Factor Challenge</h1>

    <form method="POST" action="{{ route('two-factor.login') }}" class="mt-6">
        @csrf
        <div>
            <label>One-time code</label>
            <input name="code" class="w-full border p-2" />
        </div>
        <div class="mt-3">
            <button class="px-4 py-2 bg-blue-600 text-white">Verify</button>
        </div>
    </form>
@endsection

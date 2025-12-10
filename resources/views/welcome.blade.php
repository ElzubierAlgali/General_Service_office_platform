@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">Welcome</h1>

    @if($canRegister)
        <p class="mt-4">Registration is open. <a href="{{ route('register') }}" class="text-blue-600">Register</a></p>
    @endif
@endsection

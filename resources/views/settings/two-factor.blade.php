@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">Two-Factor Authentication</h1>

    <p class="mt-3">2FA enabled: {{ $twoFactorEnabled ? 'Yes' : 'No' }}</p>

    @if($requiresConfirmation)
        <p class="mt-2 text-sm text-yellow-700">Some actions require confirmation.</p>
    @endif
@endsection

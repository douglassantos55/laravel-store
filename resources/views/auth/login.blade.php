@extends('template/base')

@section('title', __('auth.login'))

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">{{ __('auth.login') }}</h1>

    <form method="POST" action="{{ route('auth.login') }}">
        @csrf

        <div class="mb-3">
            <label for="auth-email">{{ __('auth.email') }}</label>
            <input id="auth-email" type="email" name="email" value="{{ old('email') }}" class="p-2 border w-full">

            @error('email')
                <div class="mt-1 text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="auth-password">{{ __('auth.password') }}</label>
            <input id="auth-password" type="password" name="password" value="{{ old('password') }}" class="p-2 border w-full">

            @error('password')
                <div class="mt-1 text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="auth-remember">{{ __('auth.remember') }}</label>
            <input id="auth-remember" type="checkbox" name="remember" value="{{ old('remember') }}">

            @error('remember')
                <div class="mt-1 text-red-600">{{ $message }}</div>
            @enderror
        </div>

        <x-button primary type="submit">{{ __('auth.login') }}</x-button>
    </form>
</div>
@endsection

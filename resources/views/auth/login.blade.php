@extends('template/base')

@section('title', __('auth.login'))

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">{{ __('auth.login') }}</h1>

    <form method="POST" action="{{ route('auth.login') }}">
        @csrf

        <x-form-group>
            <label for="auth-email">{{ __('auth.email') }}</label>
            <x-input id="auth-email" type="email" name="email" value="{{ old('email') }}" />

            @error('email')
                <div class="mt-1 text-red-600">{{ $message }}</div>
            @enderror
        </x-form-group>

        <x-form-group>
            <label for="auth-password">{{ __('auth.password') }}</label>
            <x-input id="auth-password" type="password" name="password" value="{{ old('password') }}" />

            @error('password')
                <div class="mt-1 text-red-600">{{ $message }}</div>
            @enderror
        </x-form-group>

        <x-form-group>
            <label for="auth-remember">{{ __('auth.remember') }}</label>
            <input id="auth-remember" type="checkbox" name="remember" value="{{ old('remember') }}" />

            @error('remember')
                <div class="mt-1 text-red-600">{{ $message }}</div>
            @enderror
        </x-form-group>

        <x-button primary type="submit">{{ __('auth.login') }}</x-button>
    </form>
</div>
@endsection

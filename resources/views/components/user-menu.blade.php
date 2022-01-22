<div {{ $attributes->class('group relative')->merge() }}>
    @auth
        {{ auth()->user()->name }}

        <div class="hidden group-hover:block w-60 bg-white shadow-lg p-4 absolute right-0 top-110 border">
            <a class="block py-2" href="{{ route('user.dashboard') }}">{{ __('user.dashboard') }}</a>
            <a class="block py-2" href="{{ route('wishlist.index') }}">{{ __('user.wishlist') }}</a>
            <a class="block py-2" href="{{ route('auth.logout') }}">{{ __('auth.logout') }}</a>
        </div>
    @endauth

    @guest
        <a href="{{ route('auth.index') }}">{{ __('auth.login') }}</a>
    @endguest
</div>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
</head>

<body class="antialiased">
    <header class="p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('welcome') }}" class="text-xl font-semibold">Book store</a>

            <div class="flex items-center">
                <x-user-menu class="mr-5" />
                <x-mini-cart />
            </div>
        </div>
    </header>

    <main class="py-10">
        @yield('content')
    </main>

    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendors.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>

    @stack('scripts')
</body>

</html>

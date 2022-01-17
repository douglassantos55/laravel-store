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
    <header class="flex p-4 shadow-md justify-between items-center">
        <a href="{{ route('welcome') }}" class="text-xl font-semibold">Book store</a>

        <x-mini-cart />
    </header>

    <main class="py-10">
        @yield('content')
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>

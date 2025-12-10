<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="antialiased">
    <div id="app">
        <header class="p-4 bg-gray-100">
            <div class="container mx-auto">
                <a href="{{ route('home') }}" class="font-bold">{{ config('app.name', 'App') }}</a>
            </div>
        </header>

        <main class="container mx-auto p-6">
            @yield('content')
        </main>

        <footer class="p-4 text-center text-sm text-gray-600">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </footer>
    </div>
</body>
</html>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
    <div id="app">
        {{-- Minimal app shell for Inertia compatibility --}}
        @yield('content')
    </div>
</body>
</html>

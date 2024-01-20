<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.ts'])
</head>
<body>
<div id="app" class="d-flex flex-column min-vh-100">
    @yield('content')
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>
        {{-- todo refactor this --}}
        @if(Request::path() === 'month-review')
            Month Review - myspace
        @endif
        @if(Request::path() === '/')
            Goals - myspace
        @endif
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/favicon.svg">

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @inertiaHead
</head>

<body class="bg-gray-800 text-gray-200">
    @inertia
</body>
</html>

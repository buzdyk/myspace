<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>myspace</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" type="image/png" href="/favicon.svg">
    </head>
    <body class="bg-gray-800 text-gray-200">
        {{ $slot }}
    </body>
</html>

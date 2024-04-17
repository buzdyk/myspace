<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>myspace</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="icon" type="image/png" href="/favicon.png">
        {{-- ty https://icons8.com/icon/36026/favorite --}}
    </head>
    <body>
        {{ $slot }}
    </body>
</html>

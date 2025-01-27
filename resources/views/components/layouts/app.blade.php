<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'BonScan - Centralizator Motorină' }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
      @livewireStyles
</head>
<body>
    <div class="container px-4 py-8 mx-auto">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>
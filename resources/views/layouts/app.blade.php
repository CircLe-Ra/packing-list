<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }} - {{ config('app.name', 'Laravel') }}</title>

        <style>
            [x-cloak] { display: none !important; }
        </style>

        <script>
            (function () {
            const currentTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches

            if (currentTheme) {
                document.documentElement.setAttribute('data-theme', currentTheme);
            }else if (prefersDark) {
                document.documentElement.setAttribute('data-theme', 'dark');
            }else {
                document.documentElement.setAttribute('data-theme', 'light');
            }
            })();
        </script>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="">
            <livewire:layout.navigation />

            <!-- Page Content -->
            <main class="container px-4 mx-auto sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>

        <livewire:toast />
        @stack('scripts')
    </body>
</html>

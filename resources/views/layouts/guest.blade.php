<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
    <body class="font-sans text-base-content antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-base-100">

            <div class="min-h-screen py-6 flex flex-col justify-center sm:py-12">
                <div class="relative py-3 sm:max-w-xl sm:mx-auto">
                  <div
                    class="absolute inset-0 bg-gradient-to-r from-base-content to-base-content shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl">
                  </div>
                  <div class="relative px-4 py-10 bg-base-300 shadow-lg sm:rounded-3xl sm:p-20 w-full">
                    <div class="max-w-md mx-auto">
                    {{ $slot }}
                    </div>

                  </div>
                </div>
              </div>

        </div>
    </body>
</html>

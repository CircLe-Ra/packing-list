<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }} - {{ config('app.name', 'Laravel') }}</title>

        <link href="{{ asset('assets/3party/filepond/filepond.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/3party/filepond/filepond-plugin-image-preview.css') }}" rel="stylesheet">
        <style>
            /* Default light theme styles */
            .filepond--panel-root {
                background-color: #eee;
                /* ... other styles ... */
            }

            /* ... other default light theme styles ... */

            /* Dark theme styles */
            .dark .filepond--panel-root {
                background-color: #333;
                /* Dark background for the panel */
                /* ... other dark styles ... */
            }

            .dark .filepond--drop-label {
                color: #ddd;
                /* Lighter text color for dark mode */
            }

            .dark .filepond--label-action {
                text-decoration-color: #ccc;
                /* Lighter underline color for "Browse" button */
            }

            .dark .filepond--item-panel {
                background-color: #444;
                /* Dark background for file items */
            }

            .dark .filepond--drip-blob {
                background-color: #555;
                /* Dark background for the drop circle */
            }

            .dark .filepond--file-action-button {
                background-color: rgba(255, 255, 255, 0.5);
                /* Lighter background for action buttons */
                color: black;
                /* Dark text/icon color for action buttons */
            }

            /* ... other dark theme styles ... */

            /* You can also customize the colors for error and success states in dark mode */
            .dark [data-filepond-item-state*='error'] .filepond--item-panel {
                background-color: #ff5555;
                /* Darker red for errors */
            }

            .dark [data-filepond-item-state='processing-complete'] .filepond--item-panel {
                background-color: #55ff55;
                /* Darker green for success */
            }
        </style>

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

{{--        <livewire:toast />--}}
        @stack('scripts')
        <x-toaster-hub />

        <script src="{{ asset('assets/3party/filepond/filepond-plugin-file-validate-type.js') }}"></script>
        <script src="{{ asset('assets/3party/filepond/filepond-plugin-file-validate-size.js') }}"></script>
        <script src="{{ asset('assets/3party/filepond/filepond-plugin-image-preview.js') }}"></script>
        <script src="{{ asset('assets/3party/filepond/filepond.js') }}"></script>
        <script>
            FilePond.registerPlugin(FilePondPluginFileValidateType);
            FilePond.registerPlugin(FilePondPluginFileValidateSize);
            FilePond.registerPlugin(FilePondPluginImagePreview);

        </script>
    </body>
</html>

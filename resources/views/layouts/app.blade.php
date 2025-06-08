<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Nugasyuk') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-blue-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            @if(session('success'))
                <div id="alert-success" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md flex justify-between items-center" role="alert">
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button onclick="document.getElementById('alert-success').style.display='none'" class="text-green-700 hover:text-green-900">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
                <script>
                    setTimeout(() => {
                        const alert = document.getElementById('alert-success');
                        if (alert) {
                            alert.style.transition = 'opacity 500ms';
                            alert.style.opacity = '0';
                            setTimeout(() => alert.style.display = 'none', 500);
                        }
                    }, 4000);
                </script>
            @endif
            {{ $slot }}
        </main>
    </div>
    @stack('scripts')
</body>

</html>

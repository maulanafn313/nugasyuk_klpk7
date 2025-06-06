<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? config('app.name', 'Nugas Yuk!') }}</title>
    @vite('resources/css/app.css')
</head>

<body class="font-sans bg-gray-50 min-h-screen flex flex-col">

    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-4 px-6 flex justify-between items-center">
            <a href="/" class="flex items-center space-x-2">
                <img src="https://i.ibb.co/9s3hQ7Q/logo-nugas-yuk.png" alt="Logo" class="h-10 w-10" />
                <span class="font-bold text-blue-600 text-xl">Nugas Yuk!</span>
            </a>
            <nav class="space-x-4">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Login</a>
                <a href="{{ route('register') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Register</a>
            </nav>
        </div>
    </header>

    <main class="flex-grow">
        {{ $slot }}
    </main>

    <footer class="bg-gray-200 py-6 text-center text-gray-700">
        &copy; {{ date('Y') }} Nugas Yuk!. All rights reserved.
    </footer>

</body>

</html>

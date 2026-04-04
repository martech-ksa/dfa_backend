<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700&display=swap" rel="stylesheet" />

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

    <div id="app">
        <nav class="bg-white border-b border-gray-100 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    
                    <!-- Logo -->
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-800">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center">
                        @guest
                            @if (Route::has('login'))
                                <a class="text-sm text-gray-700 underline me-4" href="{{ route('login') }}">
                                    {{ __('Login') }}
                                </a>
                            @endif

                            @if (Route::has('register'))
                                <a class="text-sm text-gray-700 underline" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        @else
                            <div class="relative">
                                <span class="text-gray-800 me-4">
                                    {{ Auth::user()->name }}
                                </span>

                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-sm text-red-600 underline">
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        @endguest
                    </div>

                </div>
            </div>
        </nav>

        <main class="py-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'DFA System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700&display=swap" rel="stylesheet" />

    <!-- Alpine -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body 
x-data="{
    sidebarOpen: localStorage.getItem('sidebar') === null 
        ? true 
        : localStorage.getItem('sidebar') === 'true'
}"
x-init="$watch('sidebarOpen', val => localStorage.setItem('sidebar', val))"
class="font-sans antialiased bg-gray-50 text-gray-900">

<div id="app">

    <!-- ================= SIDEBAR ================= -->
    <aside 
        :class="sidebarOpen ? 'w-64' : 'w-20'"
        class="fixed top-0 left-0 h-screen bg-gradient-to-b from-gray-900 to-gray-800 text-white p-4 shadow-lg transition-all duration-300 z-50 overflow-hidden">

        <!-- Logo -->
        <div class="text-xl font-bold mb-6 border-b border-gray-700 pb-3 text-center">
            <span x-show="sidebarOpen">DFA Admin</span>
            <span x-show="!sidebarOpen">D</span>
        </div>

        <!-- Menu -->
        <nav class="space-y-2 text-sm">

            @php
            $menus = [
                ['📊','Dashboard','admin.dashboard'],
                ['🎓','Students','admin.students.index'],
                ['📚','Programs','admin.programs.index'],
                ['🏫','Levels','admin.levels.index'],
                ['🧑‍🏫','Classes','admin.classarms.index'],
                ['👥','Users','admin.users.index'],
                ['📍','Attendance','staff.attendance.dashboard'],
                ['⚙️','Settings','admin.settings'],
            ];
            @endphp

            @foreach($menus as $menu)
            <a href="{{ route($menu[2]) }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg transition
               {{ request()->routeIs($menu[2]) 
                    ? 'bg-blue-500 text-white shadow-md' 
                    : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">

                <div class="flex items-center gap-3 w-full"
                     :class="!sidebarOpen ? 'justify-center' : ''">

                    <span class="text-lg">{{ $menu[0] }}</span>
                    <span x-show="sidebarOpen">{{ $menu[1] }}</span>

                </div>
            </a>
            @endforeach

        </nav>

    </aside>

    <!-- ================= MAIN ================= -->
    <div 
        :class="sidebarOpen ? 'ml-64' : 'ml-20'"
        class="transition-all duration-300 min-h-screen">

        <!-- TOP NAV -->
        <nav class="bg-white border-b shadow-sm sticky top-0 z-40 px-6 h-16 flex justify-between items-center">

            <!-- LEFT -->
            <div class="flex items-center gap-4">

                <button 
                    @click="sidebarOpen = !sidebarOpen"
                    class="text-xl text-gray-600 hover:text-gray-900 transition">
                    ☰
                </button>

                <span class="text-lg font-semibold">
                    {{ config('app.name', 'DFA System') }}
                </span>

            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-6">

                @auth
                    <!-- Notification -->
                    <button class="relative text-gray-600 hover:text-gray-900">
                        🔔
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1 rounded-full">
                            0
                        </span>
                    </button>

                    <!-- User -->
                    <div x-data="{ open:false }" class="relative">

                        <button @click="open = !open"
                                class="flex items-center gap-2 text-gray-800 hover:text-gray-900">
                            {{ Auth::user()->name }} ▾
                        </button>

                        <div x-show="open"
                             @click.outside="open=false"
                             x-transition
                             class="absolute right-0 mt-2 w-44 bg-white border rounded-xl shadow-lg z-50">

                            <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">
                                Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>

                        </div>

                    </div>
                @endauth

            </div>

        </nav>

        <!-- CONTENT -->
        <main class="p-6">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>
@extends('layouts.app')

@section('content')

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex gap-6">

            <!-- Sidebar -->
            <aside class="w-64 bg-gray-800 text-white rounded-lg p-4">

                <div class="text-xl font-bold mb-6">
                    DFA Admin
                </div>

                <nav class="space-y-3 text-sm">

                    <a href="{{ route('admin.dashboard') }}" class="block hover:bg-gray-700 p-2 rounded">
                        Dashboard
                    </a>

                    <a href="{{ route('admin.students.index') }}" class="block hover:bg-gray-700 p-2 rounded">
                        Students
                    </a>

                    <a href="{{ route('admin.programs.index') }}" class="block hover:bg-gray-700 p-2 rounded">
                        Programs
                    </a>

                    <a href="{{ route('admin.levels.index') }}" class="block hover:bg-gray-700 p-2 rounded">
                        Levels
                    </a>

                    <a href="{{ route('admin.classarms.index') }}" class="block hover:bg-gray-700 p-2 rounded">
                        Classes
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="block hover:bg-gray-700 p-2 rounded">
                        Users
                    </a>

                </nav>

            </aside>


            <!-- Main Content -->
            <main class="flex-1">

                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">
                        Admin Dashboard
                    </h1>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-4 gap-6">

                    <div class="bg-blue-600 text-white p-6 rounded-lg shadow">
                        <p class="text-sm">Students</p>
                        <p class="text-3xl font-bold">{{ $students ?? 0 }}</p>
                    </div>

                    <div class="bg-green-600 text-white p-6 rounded-lg shadow">
                        <p class="text-sm">Programs</p>
                        <p class="text-3xl font-bold">{{ $programs ?? 0 }}</p>
                    </div>

                    <div class="bg-purple-600 text-white p-6 rounded-lg shadow">
                        <p class="text-sm">Levels</p>
                        <p class="text-3xl font-bold">{{ $levels ?? 0 }}</p>
                    </div>

                    <div class="bg-orange-500 text-white p-6 rounded-lg shadow">
                        <p class="text-sm">Classes</p>
                        <p class="text-3xl font-bold">{{ $classes ?? 0 }}</p>
                    </div>

                </div>

            </main>

        </div>

    </div>
</div>

@endsection
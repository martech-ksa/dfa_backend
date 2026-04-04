@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Students</h2>

        <a href="{{ route('admin.students.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            + Add Student
        </a>
    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif


    {{-- Filters --}}
    <form method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Search name or admission no..."
               class="w-full border-gray-300 rounded shadow-sm">

        <select name="program" class="w-full border-gray-300 rounded shadow-sm">
            <option value="">All Programs</option>

            @foreach($programs as $program)
                <option value="{{ $program->id }}"
                    {{ request('program') == $program->id ? 'selected' : '' }}>
                    {{ $program->name }}
                </option>
            @endforeach
        </select>

        <select name="session" class="w-full border-gray-300 rounded shadow-sm">
            <option value="">All Sessions</option>

            @foreach($sessions as $session)
                <option value="{{ $session->id }}"
                    {{ request('session') == $session->id ? 'selected' : '' }}>
                    {{ $session->name }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="bg-gray-800 hover:bg-black text-white px-4 py-2 rounded shadow">
            Filter
        </button>

    </form>


    {{-- Table --}}
    <div class="overflow-x-auto bg-white shadow rounded-lg">

        <table class="min-w-full text-sm text-left border border-gray-200">

            <thead class="bg-gray-100 uppercase text-gray-600 text-xs">
                <tr>
                    <th class="px-4 py-3 border">Admission No</th>
                    <th class="px-4 py-3 border">Full Name</th>
                    <th class="px-4 py-3 border">Programs / Classes</th>
                    <th class="px-4 py-3 border">Session</th>
                    <th class="px-4 py-3 border">Status</th>
                    <th class="px-4 py-3 border text-center">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse($students as $student)

                    <tr class="hover:bg-gray-50">

                        {{-- Admission --}}
                        <td class="px-4 py-3 border font-medium">
                            {{ $student->admission_number }}
                        </td>

                        {{-- Name --}}
                        <td class="px-4 py-3 border">
                            {{ $student->full_name }}
                        </td>

                        {{-- 🔥 MULTI-PROGRAM DISPLAY --}}
                        <td class="px-4 py-3 border">

                            @forelse($student->enrollments as $enrollment)

                                <div class="mb-1">

                                    {{-- Program Badge --}}
                                    <span class="inline-block bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded font-semibold">
                                        {{ $enrollment->program->name ?? '' }}
                                    </span>

                                    {{-- Class --}}
                                    <span class="ml-2">
                                        {{ $enrollment->classArm->level->name ?? '' }}
                                        {{ $enrollment->classArm->arm ?? '' }}
                                    </span>

                                </div>

                            @empty
                                <span class="text-gray-400">No class assigned</span>
                            @endforelse

                        </td>

                        {{-- Session (latest or current) --}}
                        <td class="px-4 py-3 border">
                            {{ optional($student->enrollments->first()?->academicSession)->name ?? '-' }}
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-3 border">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                {{ $student->status === 'active'
                                    ? 'bg-green-100 text-green-700'
                                    : 'bg-gray-200 text-gray-700' }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="px-4 py-3 border text-center space-x-2">

                            <a href="{{ route('admin.students.show', $student) }}"
                               class="text-blue-600 hover:underline">
                                View
                            </a>

                            <a href="{{ route('admin.students.edit', $student) }}"
                               class="text-yellow-600 hover:underline">
                                Edit
                            </a>

                            <form action="{{ route('admin.students.destroy', $student) }}"
                                  method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Delete this student?')">

                                @csrf
                                @method('DELETE')

                                <button class="text-red-600 hover:underline">
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            No students found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- Pagination --}}
    <div class="mt-6">
        {{ $students->withQueryString()->links() }}
    </div>

</div>

@endsection
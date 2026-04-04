@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold">Subjects</h2>

        <a href="{{ route('admin.subjects.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            + Add Subject
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded">

        <table class="min-w-full text-sm">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($subjects as $subject)
                    <tr class="border-t">

                        <td class="p-3">
                            {{ $subject->name }}
                        </td>

                        <td class="p-3 space-x-2">

                            <a href="{{ route('admin.subjects.edit', $subject->id) }}"
                               class="text-yellow-600">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.subjects.destroy', $subject->id) }}"
                                  class="inline">
                                @csrf
                                @method('DELETE')

                                <button class="text-red-600"
                                    onclick="return confirm('Delete subject?')">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="p-4 text-center text-gray-500">
                            No subjects found
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection
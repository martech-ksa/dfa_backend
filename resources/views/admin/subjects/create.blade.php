@extends('layouts.app')

@section('content')

<div class="p-6 max-w-lg mx-auto">

    <h2 class="text-xl font-bold mb-4">Add Subject</h2>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="bg-red-100 p-3 mb-4 rounded">
            @foreach ($errors->all() as $error)
                <div class="text-red-600">{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.subjects.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Subject Name</label>
            <input type="text" name="name"
                   class="w-full border p-2 rounded"
                   required>
        </div>

        <div class="flex gap-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Save
            </button>

            <a href="{{ route('admin.subjects.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded">
                Cancel
            </a>
        </div>

    </form>

</div>

@endsection
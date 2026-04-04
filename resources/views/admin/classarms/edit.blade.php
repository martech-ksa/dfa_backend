<x-app-layout>
    <div class="p-6 max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-semibold">Edit Student</h2>
                <p class="text-sm text-gray-500">
                    Admission No: {{ $student->admission_number }}
                </p>
            </div>

            <a href="{{ route('admin.students.index') }}"
               class="text-blue-600 hover:underline text-sm">
                ← Back to Students
            </a>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow rounded p-6">

            <form method="POST"
                  action="{{ route('admin.students.update', $student) }}">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-6">

                    {{-- First Name --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">First Name</label>
                        <input type="text"
                               name="first_name"
                               value="{{ old('first_name', $student->first_name) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- Other Names --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Other Names</label>
                        <input type="text"
                               name="other_names"
                               value="{{ old('other_names', $student->other_names) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- Last Name --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Last Name</label>
                        <input type="text"
                               name="last_name"
                               value="{{ old('last_name', $student->last_name) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- Gender --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Gender</label>
                        <select name="gender"
                                class="w-full border rounded px-3 py-2">
                            <option value="male"
                                {{ old('gender', $student->gender) === 'male' ? 'selected' : '' }}>
                                Male
                            </option>
                            <option value="female"
                                {{ old('gender', $student->gender) === 'female' ? 'selected' : '' }}>
                                Female
                            </option>
                        </select>
                    </div>

                    {{-- Date of Birth (RAW DB VALUE - GUARANTEED ISO FORMAT) --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Date of Birth</label>
                        <input type="date"
                               name="date_of_birth"
                               value="{{ old('date_of_birth', $student->getRawOriginal('date_of_birth')) }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <select name="status"
                                class="w-full border rounded px-3 py-2">
                            <option value="active"
                                {{ old('status', $student->status) === 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="graduated"
                                {{ old('status', $student->status) === 'graduated' ? 'selected' : '' }}>
                                Graduated
                            </option>
                            <option value="withdrawn"
                                {{ old('status', $student->status) === 'withdrawn' ? 'selected' : '' }}>
                                Withdrawn
                            </option>
                        </select>
                    </div>

                </div>

                {{-- Buttons --}}
                <div class="mt-8 flex gap-4">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                        Update Student
                    </button>

                    <a href="{{ route('admin.students.show', $student) }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded">
                        Cancel
                    </a>
                </div>

            </form>

        </div>

    </div>
</x-app-layout>
@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-4">Edit Student</h3>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.students.update', $student->id) }}">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" name="first_name"
                       value="{{ old('first_name', $student->first_name) }}"
                       class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name"
                       value="{{ old('last_name', $student->last_name) }}"
                       class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="">Select</option>
                    <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="">Select</option>
                    <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="graduated" {{ old('status', $student->status) == 'graduated' ? 'selected' : '' }}>Graduated</option>
                    <option value="withdrawn" {{ old('status', $student->status) == 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                </select>
            </div>

        </div>

        <hr>

        {{-- MULTI CLASS SELECTION --}}
        <h5 class="mb-3">Assign Classes (Multi-Program)</h5>

        @php
            $selected = $student->enrollments->pluck('class_arm_id')->toArray();
        @endphp

        @foreach($classArms as $programName => $arms)

            <div class="mb-3 p-3 border rounded">

                <strong class="text-primary">{{ $programName }}</strong>

                @foreach($arms as $arm)

                    <div class="form-check">
                        <input type="checkbox"
                               name="class_selection[]"
                               value="{{ $arm->id }}"
                               class="form-check-input"
                               {{ in_array($arm->id, $selected) ? 'checked' : '' }}>

                        <label class="form-check-label">
                            {{ $arm->level->name }} - {{ $arm->arm }}
                        </label>
                    </div>

                @endforeach

            </div>

        @endforeach

        <div class="mt-4">

            <button class="btn btn-primary">
                Update Student
            </button>

            <a href="{{ route('admin.students.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection
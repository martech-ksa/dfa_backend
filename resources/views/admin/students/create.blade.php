@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-4">Add Student</h3>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.students.store') }}">
        @csrf

        <div class="row">

            {{-- First Name --}}
            <div class="col-md-6 mb-3">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>

            {{-- Last Name --}}
            <div class="col-md-6 mb-3">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>

            {{-- Gender --}}
            <div class="col-md-6 mb-3">
                <label>Gender</label>
                <select name="gender" class="form-control" required>
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            {{-- Status --}}
            <div class="col-md-6 mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="">Select</option>
                    <option value="Active">Active</option>
                    <option value="Graduated">Graduated</option>
                </select>
            </div>

            {{-- Class --}}
            <div class="col-md-12 mb-3">
                <label>Class Arm</label>
                <select name="class_arm_id" class="form-control" required>

                    <option value="">Select Class</option>

                    @foreach($classArms as $arm)
                        <option value="{{ $arm->id }}">
                            {{ $arm->level->program->name ?? '' }} -
                            {{ $arm->level->name ?? '' }} -
                            {{ $arm->arm }}
                        </option>
                    @endforeach

                </select>
            </div>

        </div>

        <button class="btn btn-primary">Save Student</button>

        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
            Cancel
        </a>

    </form>

</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="container">

<h3>Enter Student Results</h3>

@if(session('success'))

<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('teacher.results.store') }}">
@csrf

<div class="row mb-3">

<div class="col-md-3">
<select name="level_id" class="form-control">
<option value="">Select Level</option>
@foreach(\App\Models\Level::all() as $level)
<option value="{{ $level->id }}">{{ $level->name }}</option>
@endforeach
</select>
</div>

<div class="col-md-3">
<select name="class_arm_id" class="form-control">
<option value="">Select Class Arm</option>
@foreach(\App\Models\ClassArm::all() as $arm)
<option value="{{ $arm->id }}">{{ $arm->name }}</option>
@endforeach
</select>
</div>

<div class="col-md-3">
<select name="subject_id" class="form-control">
<option value="">Select Subject</option>
@foreach(\App\Models\Subject::all() as $subject)
<option value="{{ $subject->id }}">{{ $subject->name }}</option>
@endforeach
</select>
</div>

</div>

<table class="table table-bordered">

<thead>
<tr>
<th>Student</th>
<th>CA</th>
<th>Exam</th>
</tr>
</thead>

<tbody>

@foreach(\App\Models\Student::orderBy('name')->get() as $student)

<tr>

<td>
{{ $student->name }}
<input type="hidden" name="student_id[]" value="{{ $student->id }}">
</td>

<td>
<input type="number" name="ca[]" class="form-control" min="0" max="40">
</td>

<td>
<input type="number" name="exam[]" class="form-control" min="0" max="60">
</td>

</tr>

@endforeach

</tbody>

</table>

<button class="btn btn-primary">
Save Results
</button>

</form>

</div>

@endsection

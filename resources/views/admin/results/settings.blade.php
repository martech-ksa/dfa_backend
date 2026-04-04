@extends('layouts.app')

@section('content')

<div class="container mx-auto px-6 py-6">

<div class="bg-white shadow rounded-lg p-6">

<h2 class="text-lg font-semibold mb-6">
Result Scoring Settings
</h2>

<form method="POST" action="{{ route('admin.results.settings.update') }}">

@csrf

<div class="grid grid-cols-4 gap-4">

<div>
<label class="text-sm">1st CA</label>

<input
type="number"
name="ca1"
value="{{ $setting->ca1 }}"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="text-sm">2nd CA</label>

<input
type="number"
name="ca2"
value="{{ $setting->ca2 }}"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="text-sm">Attendance</label>

<input
type="number"
name="attendance"
value="{{ $setting->attendance }}"
class="w-full border rounded px-3 py-2">
</div>

<div>
<label class="text-sm">Exam</label>

<input
type="number"
name="exam"
value="{{ $setting->exam }}"
class="w-full border rounded px-3 py-2">
</div>

</div>

<button
class="mt-6 bg-blue-600 text-white px-4 py-2 rounded">

Update Scoring

</button>

</form>

</div>

</div>

@endsection
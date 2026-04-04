@extends('layouts.app')

@section('content')

<div class="p-6 max-w-xl mx-auto">

<h2 class="text-xl font-bold mb-6">Add Class Arm</h2>

<form method="POST"
action="{{ route('admin.classarms.store') }}">

@csrf

<label class="block mb-2">Level</label>

<select name="level_id"
class="w-full border rounded p-2 mb-4">

@foreach($levels as $level)

<option value="{{ $level->id }}">

{{ $level->program->name }} — {{ $level->name }}

</option>

@endforeach

</select>


<label class="block mb-2">Arm</label>

<input type="text"
name="arm"
class="w-full border rounded p-2 mb-6"
placeholder="Example: A, B, C">


<button class="bg-blue-600 text-white px-6 py-2 rounded">
Save
</button>

</form>

</div>

@endsection
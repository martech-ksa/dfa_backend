@extends('layouts.app')

@section('content')

<div class="p-6 max-w-xl mx-auto">

<h2 class="text-xl font-bold mb-6">Add Level</h2>

<form method="POST" action="{{ route('admin.levels.store') }}">

@csrf

<label class="block mb-2">Program</label>

<select name="program_id"
class="w-full border rounded p-2 mb-4">

@foreach($programs as $program)

<option value="{{ $program->id }}">
{{ $program->name }}
</option>

@endforeach

</select>


<label class="block mb-2">Level Name</label>

<input type="text"
name="name"
class="w-full border rounded p-2 mb-6"
placeholder="Example: KG1, Nursery1, Class1">


<button class="bg-blue-600 text-white px-6 py-2 rounded">
Save Level
</button>

</form>

</div>

@endsection
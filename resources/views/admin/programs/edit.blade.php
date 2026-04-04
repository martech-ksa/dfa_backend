@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto p-6">

<h2 class="text-2xl font-semibold mb-6">Edit Program</h2>

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
<ul class="list-disc pl-5">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('admin.programs.update', $program) }}">

@csrf
@method('PUT')

<div class="mb-4">

<label class="block mb-2 font-medium">
Program Name
</label>

<input
type="text"
name="name"
value="{{ old('name', $program->name) }}"
class="w-full border rounded p-2"
required
>

</div>

<div class="flex gap-3">

<button
type="submit"
class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"
>
Update Program
</button>

<a
href="{{ route('admin.programs.index') }}"
class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded"
>
Cancel
</a>

</div>

</form>

</div>

@endsection
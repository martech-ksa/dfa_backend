@extends('layouts.app')

@section('content')

<div class="p-6">

<h2 class="text-2xl font-bold mb-6">Levels</h2>

<a href="{{ route('admin.levels.create') }}"
class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
+ Add Level
</a>

<table class="w-full border">

<thead>
<tr class="bg-gray-100">
<th class="p-3 border">Program</th>
<th class="p-3 border">Level</th>
<th class="p-3 border">Actions</th>
</tr>
</thead>

<tbody>

@foreach($levels as $level)

<tr>

<td class="p-3 border">
{{ $level->program->name }}
</td>

<td class="p-3 border">
{{ $level->name }}
</td>

<td class="p-3 border">

<a href="{{ route('admin.levels.edit',$level) }}"
class="text-blue-600">Edit</a>

<form method="POST"
action="{{ route('admin.levels.destroy',$level) }}"
style="display:inline">

@csrf
@method('DELETE')

<button class="text-red-600">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection
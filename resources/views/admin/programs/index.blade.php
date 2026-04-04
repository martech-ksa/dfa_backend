@extends('layouts.app')

@section('content')

<div class="p-6">

<h2 class="text-2xl font-semibold mb-6">Programs</h2>

<a href="{{ route('admin.programs.create') }}"
class="bg-blue-600 text-white px-4 py-2 rounded">
+ Add Program
</a>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 mt-4">
{{ session('success') }}
</div>
@endif

<div class="mt-6 bg-white shadow rounded">

<table class="min-w-full border">

<thead class="bg-gray-100">
<tr>
<th class="p-3 border">Program Name</th>
<th class="p-3 border">Actions</th>
</tr>
</thead>

<tbody>

@forelse($programs as $program)

<tr>

<td class="p-3 border">
{{ $program->name }}
</td>

<td class="p-3 border">

<a href="{{ route('admin.programs.edit',$program) }}"
class="text-blue-600">Edit</a>

<form method="POST"
action="{{ route('admin.programs.destroy',$program) }}"
class="inline">

@csrf
@method('DELETE')

<button class="text-red-600"
onclick="return confirm('Delete program?')">
Delete
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="2" class="p-4 text-center text-gray-500">
No programs found
</td>
</tr>

@endforelse

</tbody>

</table>

</div>

<div class="mt-6">
{{ $programs->links() }}
</div>

</div>

@endsection
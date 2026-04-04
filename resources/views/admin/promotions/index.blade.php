@extends('layouts.app')

@section('content')

<div class="container mx-auto px-6 py-6">

<div class="bg-white shadow rounded-lg p-6">

<h2 class="text-lg font-semibold mb-6">
Promote Students
</h2>

<form method="POST" action="{{ route('admin.promotions.promote') }}">

@csrf

<div class="grid grid-cols-3 gap-4">

<div>
<label class="block text-sm mb-1">From Class</label>

<select name="from_class" class="w-full border rounded px-3 py-2">

@foreach($classArms as $class)

<option value="{{ $class->id }}">

{{ $class->level->program->name }}
-
{{ $class->level->name }}
-
{{ $class->name }}

</option>

@endforeach

</select>
</div>


<div>
<label class="block text-sm mb-1">To Class</label>

<select name="to_class" class="w-full border rounded px-3 py-2">

@foreach($classArms as $class)

<option value="{{ $class->id }}">

{{ $class->level->program->name }}
-
{{ $class->level->name }}
-
{{ $class->name }}

</option>

@endforeach

</select>

</div>


<div>
<label class="block text-sm mb-1">Session</label>

<select name="session" class="w-full border rounded px-3 py-2">

@foreach($sessions as $session)

<option value="{{ $session->id }}">
{{ $session->name }}
</option>

@endforeach

</select>

</div>

</div>

<button
type="submit"
class="mt-6 bg-green-600 text-white px-4 py-2 rounded">

Promote Students

</button>

</form>

</div>

</div>

@endsection
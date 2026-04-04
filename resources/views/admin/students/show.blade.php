@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

@if(session('success'))
<div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded">
    {{ session('success') }}
</div>
@endif


<div class="bg-white shadow rounded p-6">

{{-- Header Section --}}
<div class="flex justify-between items-center mb-6">

<div>
<h2 class="text-xl font-semibold text-gray-800">
Student Profile
</h2>

<p class="text-sm text-gray-500">
Admission No: {{ $student->admission_number }}
</p>
</div>


{{-- Action Buttons --}}
<div class="flex gap-3">

<a href="{{ route('admin.students.edit',$student) }}"
class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm shadow">

Edit

</a>

<a href="{{ route('admin.students.index') }}"
class="text-blue-600 hover:underline text-sm flex items-center">

← Back

</a>

</div>

</div>



{{-- Student Information --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

<div>
<p class="text-gray-500 text-sm">Full Name</p>
<p class="font-semibold text-lg">
{{ $student->full_name }}
</p>
</div>


<div>
<p class="text-gray-500 text-sm">Gender</p>
<p class="font-semibold">
{{ ucfirst($student->gender) }}
</p>
</div>


<div>
<p class="text-gray-500 text-sm">Date of Birth</p>

<p class="font-semibold">

{{ $student->formatted_dob ?? '-' }}

@if($student->age)
<span class="text-gray-400 text-sm ml-1">
({{ $student->age }} yrs)
</span>
@endif

</p>

</div>


<div>
<p class="text-gray-500 text-sm">Status</p>

<span class="px-3 py-1 rounded text-xs font-medium
{{ $student->status === 'active'
? 'bg-green-100 text-green-700'
: 'bg-gray-200 text-gray-700' }}">

{{ ucfirst($student->status) }}

</span>

</div>

</div>



<hr class="my-6">


{{-- Enrollments --}}
<h3 class="text-lg font-semibold mb-4">
Enrollments
</h3>


@forelse($student->enrollments as $enrollment)

<div class="flex justify-between items-center border-b py-3">

<div>

<span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">

{{ $enrollment->classArm?->level?->program?->name ?? '-' }}

</span>

<span class="ml-2 font-medium">

{{ $enrollment->classArm?->level?->name ?? '-' }}
{{ $enrollment->classArm?->arm ?? '' }}

</span>

</div>


<span class="text-sm text-gray-500">

{{ $enrollment->academicSession?->name ?? '-' }}

</span>

</div>

@empty

<p class="text-gray-500 text-sm">
No enrollments found.
</p>

@endforelse


</div>

</div>

@endsection
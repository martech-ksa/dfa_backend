@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card p-4">

        <h3 class="text-center mb-4">Student Result Sheet</h3>

        {{-- Student Info --}}
        <div class="mb-3">
            <strong>Name:</strong>
            {{ $student->first_name }} {{ $student->last_name }} <br>

            <strong>Admission No:</strong>
            {{ $student->admission_number ?? '-' }}
        </div>

        {{-- Result Table --}}
        <table class="table table-bordered">

            <thead class="table-dark">
                <tr>
                    <th>Subject</th>
                    <th>1st CA</th>
                    <th>2nd CA</th>
                    <th>Exam</th>
                    <th>Attendance</th>
                    <th>Total</th>
                    <th>Grade</th>
                </tr>
            </thead>

            <tbody>

                @forelse($results as $result)
                    <tr>
                        <td>{{ $result->subject->name ?? '-' }}</td>
                        <td>{{ $result->first_ca }}</td>
                        <td>{{ $result->second_ca }}</td>
                        <td>{{ $result->exam }}</td>
                        <td>{{ $attendance }}</td>
                        <td>{{ $result->total }}</td>
                        <td>{{ $result->grade }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            No results found
                        </td>
                    </tr>
                @endforelse

            </tbody>

        </table>

        {{-- Summary --}}
        <div class="mt-3">
            <strong>Total Score:</strong> {{ $totalScore }} <br>
            <strong>Average:</strong> {{ $average }}
        </div>

        {{-- Print --}}
        <div class="mt-4 text-center">
            <button onclick="window.print()" class="btn btn-primary">
                Print Result
            </button>
        </div>

    </div>

</div>

@endsection
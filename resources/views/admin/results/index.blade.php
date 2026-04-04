@extends('layouts.app')

@section('content')

<div class="container">

    <h3 class="mb-4">Result Entry</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- FILTERS --}}
    <div class="row mb-3">

        {{-- PROGRAM --}}
        <div class="col-md-4">
            <label>Program</label>
            <select id="program_id" class="form-control">
                <option value="">Select Program</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- LEVEL --}}
        <div class="col-md-4">
            <label>Level</label>
            <select id="level_id" class="form-control">
                <option value="">Select Level</option>
            </select>
        </div>

        {{-- CLASS ARM --}}
        <div class="col-md-4">
            <label>Class Arm</label>
            <select id="class_arm_id" class="form-control" onchange="loadData()">
                <option value="">Select Class</option>
            </select>
        </div>

    </div>

    <hr>

    <form method="POST" action="{{ route('admin.results.store') }}">
        @csrf

        <input type="hidden" name="class_arm_id" id="form_class_arm_id">

        <div id="result-area">
            <div class="text-center text-muted">
                Select class to load students and subjects
            </div>
        </div>

        <button type="submit" class="btn btn-success mt-3">
            Save Results
        </button>

    </form>

</div>


<script>

// ==========================
// LOAD LEVELS
// ==========================
document.getElementById('program_id').addEventListener('change', function() {

    let programId = this.value;

    if(!programId) return;

    fetch('/admin/results/get-levels/' + programId)
        .then(res => res.json())
        .then(data => {

            let levelDropdown = document.getElementById('level_id');
            levelDropdown.innerHTML = '<option value="">Select Level</option>';

            data.forEach(level => {
                levelDropdown.innerHTML += `<option value="${level.id}">${level.name}</option>`;
            });

            document.getElementById('class_arm_id').innerHTML = '<option value="">Select Class</option>';
        });
});


// ==========================
// LOAD CLASS ARMS
// ==========================
document.getElementById('level_id').addEventListener('change', function() {

    let levelId = this.value;

    if(!levelId) return;

    fetch('/admin/results/get-class-arms/' + levelId)
        .then(res => res.json())
        .then(data => {

            let classDropdown = document.getElementById('class_arm_id');
            classDropdown.innerHTML = '<option value="">Select Class</option>';

            data.forEach(cls => {
                classDropdown.innerHTML += `<option value="${cls.id}">${cls.arm}</option>`;
            });
        });
});


// ==========================
// LOAD STUDENTS + SUBJECTS
// ==========================
function loadData(){

    let classArmId = document.getElementById('class_arm_id').value;

    if(!classArmId) return;

    document.getElementById('form_class_arm_id').value = classArmId;

    fetch("{{ route('admin.results.loadStudents') }}", {

        method: "POST",

        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },

        body: JSON.stringify({
            class_arm_id: classArmId
        })

    })

    .then(res => res.json())

    .then(data => {

        let html = '';

        if(data.students.length === 0){
            html = `<div class="alert alert-warning">No students found</div>`;
            document.getElementById('result-area').innerHTML = html;
            return;
        }

        data.students.forEach(student => {

            html += `
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <strong>${student.first_name ?? ''} ${student.last_name ?? ''}</strong>
                    </div>

                    <div class="card-body p-0">

                        <table class="table table-bordered table-sm">

                            <thead class="table-dark">
                                <tr>
                                    <th>Subject</th>
                                    <th>CA1</th>
                                    <th>CA2</th>
                                    <th>Exam</th>
                                    <th>Total</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>

                            <tbody>
            `;

            data.subjects.forEach(sub => {

                html += `
                    <tr>
                        <td>${sub.subject.name}</td>

                        <td><input type="number" class="form-control score-input"
                            data-student="${student.id}" data-subject="${sub.subject_id}" data-type="first"
                            name="results[${student.id}][${sub.subject_id}][first_ca]" min="0" max="20"></td>

                        <td><input type="number" class="form-control score-input"
                            data-student="${student.id}" data-subject="${sub.subject_id}" data-type="second"
                            name="results[${student.id}][${sub.subject_id}][second_ca]" min="0" max="20"></td>

                        <td><input type="number" class="form-control score-input"
                            data-student="${student.id}" data-subject="${sub.subject_id}" data-type="exam"
                            name="results[${student.id}][${sub.subject_id}][exam]" min="0" max="60"></td>

                        <td id="total_${student.id}_${sub.subject_id}" class="fw-bold">0</td>
                        <td id="grade_${student.id}_${sub.subject_id}" class="fw-bold text-primary">-</td>
                    </tr>
                `;
            });

            html += `</tbody></table></div></div>`;
        });

        document.getElementById('result-area').innerHTML = html;

    });

}


// ==========================
// LIVE TOTAL + GRADE
// ==========================
document.addEventListener('input', function(e){

    if(!e.target.classList.contains('score-input')) return;

    let student = e.target.dataset.student;
    let subject = e.target.dataset.subject;

    let inputs = document.querySelectorAll(
        `.score-input[data-student="${student}"][data-subject="${subject}"]`
    );

    let first = 0, second = 0, exam = 0;

    inputs.forEach(input => {
        if(input.dataset.type === 'first') first = parseInt(input.value) || 0;
        if(input.dataset.type === 'second') second = parseInt(input.value) || 0;
        if(input.dataset.type === 'exam') exam = parseInt(input.value) || 0;
    });

    let total = first + second + exam;

    let grade = 'F';
    if(total >= 70) grade = 'A';
    else if(total >= 60) grade = 'B';
    else if(total >= 50) grade = 'C';
    else if(total >= 45) grade = 'D';
    else if(total >= 40) grade = 'E';

    document.getElementById(`total_${student}_${subject}`).innerText = total;
    document.getElementById(`grade_${student}_${subject}`).innerText = grade;

});

</script>

@endsection
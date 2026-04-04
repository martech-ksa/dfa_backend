<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Domains\Student\Services\StudentService;
use App\Domains\Student\DTO\StudentData;

use App\Models\Student;
use App\Models\ClassArm;
use App\Models\Program;
use App\Models\AcademicSession;

class StudentController extends Controller
{
    protected StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $students = Student::with([
            'classArm.level.program',
            'enrollments.classArm.level.program',
            'enrollments.academicSession'
        ])
        ->when($request->search, function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%")
                  ->orWhere('admission_number', 'like', "%{$request->search}%");
            });
        })
        ->when($request->program, function ($query) use ($request) {
            $query->whereHas('enrollments.classArm.level.program', function ($q) use ($request) {
                $q->where('id', $request->program);
            });
        })
        ->when($request->session, function ($query) use ($request) {
            $query->whereHas('enrollments.academicSession', function ($q) use ($request) {
                $q->where('id', $request->session);
            });
        })
        ->latest()
        ->paginate(10);

        $programs = Program::all();
        $sessions = AcademicSession::all();

        return view('admin.students.index', compact('students','programs','sessions'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $classArms = ClassArm::with('level.program')
            ->get()
            ->groupBy(fn($arm) => $arm->level->program->name);

        return view('admin.students.create', compact('classArms'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'first_name'      => 'required|string',
            'last_name'       => 'required|string',
            'gender'          => 'required',
            'status'          => 'required',
            'class_selection' => 'required|array|min:1'
        ]);

        $studentData = StudentData::fromArray($request->all());

        $this->studentService->createStudent($studentData);

        return redirect()
            ->route('admin.students.index')
            ->with('success','Student created successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Student $student)
    {
        $student = Student::with([
            'classArm.level.program',
            'enrollments.classArm.level.program',
            'enrollments.academicSession'
        ])->findOrFail($student->id);

        $timeline = $student->timeline();

        return view('admin.students.show', compact('student','timeline'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Student $student)
    {
        $classArms = ClassArm::with('level.program')
            ->get()
            ->groupBy(fn($arm) => $arm->level->program->name);

        $student->load([
            'classArm',
            'enrollments.classArm.level.program',
            'enrollments.academicSession'
        ]);

        return view('admin.students.edit', compact('student','classArms'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'first_name'      => 'required|string',
            'last_name'       => 'required|string',
            'gender'          => 'required',
            'status'          => 'required',
            'class_selection' => 'required|array|min:1'
        ]);

        $studentData = StudentData::fromArray($request->all());

        $this->studentService->updateStudent($student->id, $studentData);

        return redirect()
            ->route('admin.students.show', $student->id)
            ->with('success','Student updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(Student $student)
    {
        $this->studentService->deleteStudent($student->id);

        return redirect()
            ->route('admin.students.index')
            ->with('success','Student deleted successfully');
    }
}
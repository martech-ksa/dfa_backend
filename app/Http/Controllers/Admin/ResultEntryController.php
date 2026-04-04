<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Program;
use App\Models\Level;
use App\Models\ClassArm;
use App\Models\Student;
use App\Models\StudentResult;
use App\Models\ClassSubject;
use App\Models\StudentAttendance;

class ResultEntryController extends Controller
{

    public function index()
    {
        $programs = Program::orderBy('name')->get();

        return view('admin.results.index', compact('programs'));
    }


    public function getLevels($programId)
    {
        return Level::where('program_id', $programId)
            ->orderBy('name')
            ->get();
    }


    public function getClassArms($levelId)
    {
        return ClassArm::where('level_id', $levelId)
            ->orderBy('arm')
            ->get();
    }


    public function loadStudents(Request $request)
    {
        $request->validate([
            'class_arm_id' => 'required|exists:class_arms,id',
        ]);

        $students = Student::where('class_arm_id', $request->class_arm_id)
            ->orderBy('first_name')
            ->get();

        $subjects = ClassSubject::where('class_arm_id', $request->class_arm_id)
            ->with('subject:id,name')
            ->get();

        return response()->json([
            'students' => $students,
            'subjects' => $subjects
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'class_arm_id' => 'required|exists:class_arms,id',
            'results' => 'required|array',
        ]);

        foreach ($request->results as $studentId => $subjects) {

            $attendance = StudentAttendance::where([
                'student_id' => $studentId,
                'class_arm_id' => $request->class_arm_id
            ])->value('score') ?? 0;

            foreach ($subjects as $subjectId => $score) {

                $first  = min(max((int)($score['first_ca'] ?? 0), 0), 20);
                $second = min(max((int)($score['second_ca'] ?? 0), 0), 20);
                $exam   = min(max((int)($score['exam'] ?? 0), 0), 60);
                $attendance = min(max($attendance, 0), 10);

                $total = $first + $second + $exam + $attendance;

                $grade = $this->calculateGrade($total);

                StudentResult::updateOrCreate(
                    [
                        'student_id'   => $studentId,
                        'subject_id'   => $subjectId,
                        'class_arm_id' => $request->class_arm_id,
                    ],
                    [
                        'first_ca'  => $first,
                        'second_ca' => $second,
                        'exam'      => $exam,
                        'total'     => $total,
                        'grade'     => $grade,
                    ]
                );
            }
        }

        // 🔥 Assign Positions
        $this->assignPositions($request->class_arm_id);

        return back()->with('success', 'Results saved successfully');
    }


    private function assignPositions($classArmId)
    {
        $students = StudentResult::where('class_arm_id', $classArmId)
            ->selectRaw('student_id, SUM(total) as total_score')
            ->groupBy('student_id')
            ->orderByDesc('total_score')
            ->get();

        $position = 1;

        foreach ($students as $student) {

            StudentResult::where('class_arm_id', $classArmId)
                ->where('student_id', $student->student_id)
                ->update(['position' => $position]);

            $position++;
        }
    }


    public function show($studentId, $classArmId)
    {
        $student = Student::findOrFail($studentId);

        $results = StudentResult::where('student_id', $studentId)
            ->where('class_arm_id', $classArmId)
            ->with('subject:id,name')
            ->get();

        $attendance = StudentAttendance::where([
            'student_id' => $studentId,
            'class_arm_id' => $classArmId
        ])->value('score') ?? 0;

        $totalScore = $results->sum('total');

        $average = $results->count() > 0
            ? round($totalScore / $results->count(), 2)
            : 0;

        return view('admin.results.show', compact(
            'student',
            'results',
            'attendance',
            'totalScore',
            'average'
        ));
    }


    private function calculateGrade($score)
    {
        if ($score >= 70) return 'A';
        if ($score >= 60) return 'B';
        if ($score >= 50) return 'C';
        if ($score >= 45) return 'D';
        if ($score >= 40) return 'E';

        return 'F';
    }
}
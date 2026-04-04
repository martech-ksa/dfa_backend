<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassArm;
use App\Models\Subject;
use App\Models\ClassSubject;

class ClassSubjectController extends Controller
{
    public function index()
    {
        $classArms = ClassArm::all();
        $subjects = Subject::all();

        return view('admin.class_subjects.index', compact('classArms', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_arm_id' => 'required',
            'subjects' => 'required|array'
        ]);

        // Remove old assignments
        ClassSubject::where('class_arm_id', $request->class_arm_id)->delete();

        // Save new ones
        foreach ($request->subjects as $subjectId) {
            ClassSubject::create([
                'class_arm_id' => $request->class_arm_id,
                'subject_id' => $subjectId
            ]);
        }

        return back()->with('success', 'Subjects assigned successfully');
    }
}
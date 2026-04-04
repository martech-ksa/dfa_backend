<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Program;
use App\Models\Level;
use App\Models\ClassArm;

class DashboardController extends Controller
{
    public function index()
    {
        $students = Student::count();
        $programs = Program::count();
        $levels = Level::count();
        $classes = ClassArm::count();

        return view('admin.dashboard', compact(
            'students',
            'programs',
            'levels',
            'classes'
        ));
    }
}
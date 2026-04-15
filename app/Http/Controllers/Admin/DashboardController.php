<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Program;
use App\Models\Level;
use App\Models\ClassArm;
use App\Models\Attendance;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // Academic Stats
        // =========================
        $students = Student::count();
        $programs = Program::count();
        $levels   = Level::count();
        $classes  = ClassArm::count();

        // =========================
        // Today's Attendance (Optimized)
        // =========================
        $today = Carbon::today();

        $todayQuery = Attendance::whereDate('date', $today);

        $attendance = [
            'total'   => (clone $todayQuery)->count(),
            'present' => (clone $todayQuery)->where('status', 'present')->count(),
            'late'    => (clone $todayQuery)->where('status', 'late')->count(),
            'absent'  => (clone $todayQuery)->whereNull('check_in')->count(),
        ];

        // =========================
        // 7 DAYS ATTENDANCE TREND (Optimized)
        // =========================
        $chartLabels = [];
        $presentData = [];
        $lateData    = [];
        $absentData  = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = Carbon::today()->subDays($i);

            $query = Attendance::whereDate('date', $date);

            $chartLabels[] = $date->format('D');

            $presentData[] = (clone $query)->where('status', 'present')->count();
            $lateData[]    = (clone $query)->where('status', 'late')->count();
            $absentData[]  = (clone $query)->whereNull('check_in')->count();
        }

        return view('admin.dashboard', compact(
            'students',
            'programs',
            'levels',
            'classes',
            'attendance',
            'chartLabels',
            'presentData',
            'lateData',
            'absentData'
        ));
    }
}
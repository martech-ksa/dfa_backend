<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Setting;
use Illuminate\Http\Request;

class StaffAttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $today = Carbon::today();

        $attendances = Attendance::with('staff')
            ->whereDate('date', $today)
            ->get();

        $summary = [
            'total' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'absent' => $attendances->whereNull('check_in')->count(),
        ];

        $myAttendance = Attendance::where('staff_id', auth()->id())
            ->whereDate('date', $today)
            ->first();

        return view('staff.attendance.dashboard', compact('attendances', 'summary', 'myAttendance'));
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK IN
    |--------------------------------------------------------------------------
    */

    public function checkIn(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $today = Carbon::today();
        $now = Carbon::now();
        $user = auth()->user();

        // Prevent duplicate check-in
        $existing = Attendance::where('staff_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($existing) {
            return back()->with('error', '⚠️ You have already checked in today');
        }

        // Get settings from DB
        $setting = Setting::first();

        if (!$setting) {
            return back()->with('error', '⚠️ System settings not configured');
        }

        // Calculate distance
        $distance = $this->calculateDistance(
            $request->lat,
            $request->lng,
            $setting->office_lat,
            $setting->office_lng
        );

        // Block outside radius
        if ($distance > $setting->radius) {
            return back()->with('error', '❌ You are outside the allowed office radius');
        }

        // Late detection
        $resumption = Carbon::createFromTimeString($setting->resumption_time);
        $status = $now->gt($resumption) ? 'late' : 'present';

        // Save attendance
        Attendance::create([
            'staff_id' => $user->id,
            'date' => $today,
            'check_in' => $now,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'status' => $status,
        ]);

        return back()->with('success', "✅ Checked in successfully ($status)");
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK OUT
    |--------------------------------------------------------------------------
    */

    public function checkOut(Request $request)
    {
        $today = Carbon::today();
        $user = auth()->user();

        $attendance = Attendance::where('staff_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            return back()->with('error', '⚠️ You must check in first');
        }

        if ($attendance->check_out) {
            return back()->with('error', '⚠️ You have already checked out');
        }

        $attendance->update([
            'check_out' => Carbon::now()
        ]);

        return back()->with('success', '✅ Checked out successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | DISTANCE CALCULATION (HAVERSINE)
    |--------------------------------------------------------------------------
    */

    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000;

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLng/2) * sin($dLng/2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
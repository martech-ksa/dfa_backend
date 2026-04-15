<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffAttendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    // School GPS (SET YOUR REAL LOCATION)
    private $schoolLat = 24.7136; // example (update!)
    private $schoolLng = 46.6753; // example (update!)
    private $radius = 100; // meters

    public function index()
    {
        return view('staff.attendance.index');
    }

    public function mark(Request $request)
    {
        $staff = Auth::user();

        $lat = $request->latitude;
        $lng = $request->longitude;

        $isInside = $this->isWithinGeofence($lat, $lng);

        $attendance = StaffAttendance::firstOrCreate(
            [
                'staff_id' => $staff->id,
                'date' => now()->toDateString(),
            ]
        );

        if (!$attendance->check_in) {
            $attendance->update([
                'check_in' => now()->toTimeString(),
                'latitude' => $lat,
                'longitude' => $lng,
                'is_within_geofence' => $isInside,
            ]);
        } else {
            $attendance->update([
                'check_out' => now()->toTimeString(),
            ]);
        }

        return back()->with('success', 'Attendance recorded');
    }

    private function isWithinGeofence($lat, $lng)
    {
        $earthRadius = 6371000;

        $dLat = deg2rad($lat - $this->schoolLat);
        $dLng = deg2rad($lng - $this->schoolLng);

        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($this->schoolLat)) *
             cos(deg2rad($lat)) *
             sin($dLng/2) * sin($dLng/2);

        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        $distance = $earthRadius * $c;

        return $distance <= $this->radius;
    }
}
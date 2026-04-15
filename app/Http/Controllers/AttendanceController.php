<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Setting;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
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

        $user = auth()->user();
        $today = Carbon::today();

        // Prevent double check-in
        $existing = Attendance::where('staff_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if ($existing) {
            return back()->with('error', '⚠️ You have already checked in today');
        }

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
        $now = Carbon::now();
        $isLate = $now->format('H:i:s') > $setting->resumption_time;

        Attendance::create([
            'staff_id' => $user->id,
            'date' => $today,
            'check_in' => $now,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'status' => $isLate ? 'late' : 'present',
        ]);

        return back()->with('success', '✅ Check-in successful');
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK OUT
    |--------------------------------------------------------------------------
    */

    public function checkOut(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today();

        $attendance = Attendance::where('staff_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance) {
            return back()->with('error', '⚠️ You have not checked in today');
        }

        if ($attendance->check_out) {
            return back()->with('error', '⚠️ You have already checked out');
        }

        $attendance->update([
            'check_out' => Carbon::now()
        ]);

        return back()->with('success', '✅ Check-out successful');
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
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        return view('admin.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'office_lat' => 'required|numeric',
            'office_lng' => 'required|numeric',
            'radius' => 'required|integer|min:10|max:1000',
            'resumption_time' => 'required'
        ]);

        Setting::updateOrCreate(
            ['id' => 1],
            [
                'office_lat' => $request->office_lat,
                'office_lng' => $request->office_lng,
                'radius' => $request->radius,
                'resumption_time' => $request->resumption_time,
            ]
        );

        return back()->with('success', 'Settings updated successfully');
    }
}
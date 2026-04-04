<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResultSetting;

class ResultSettingController extends Controller
{
    public function index()
    {
        $setting = ResultSetting::first();

        if (!$setting) {
            $setting = ResultSetting::create([
                'ca1' => 20,
                'ca2' => 20,
                'attendance' => 10,
                'exam' => 50
            ]);
        }

        return view('admin.results.settings', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'ca1' => 'required|numeric',
            'ca2' => 'required|numeric',
            'attendance' => 'required|numeric',
            'exam' => 'required|numeric',
        ]);

        $setting = ResultSetting::first();

        $setting->update($request->all());

        return back()->with('success','Scoring system updated successfully');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ClassArm;
use App\Models\Level;

class ClassArmController extends Controller
{

    public function index()
    {
        $arms = ClassArm::with('level.program')
                ->latest()
                ->paginate(20);

        return view('admin.classarms.index', compact('arms'));
    }


    public function create()
    {
        $levels = Level::with('program')->get();

        return view('admin.classarms.create', compact('levels'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'level_id' => 'required',
            'arm' => 'required|max:5'
        ]);

        ClassArm::create([
            'level_id' => $request->level_id,
            'arm' => $request->arm
        ]);

        return redirect()
            ->route('admin.classarms.index')
            ->with('success','Class Arm created successfully');
    }


    public function edit(ClassArm $classarm)
    {
        $levels = Level::with('program')->get();

        return view('admin.classarms.edit', compact('classarm','levels'));
    }


    public function update(Request $request, ClassArm $classarm)
    {
        $request->validate([
            'level_id' => 'required',
            'arm' => 'required|max:5'
        ]);

        $classarm->update([
            'level_id' => $request->level_id,
            'arm' => $request->arm
        ]);

        return redirect()
            ->route('admin.classarms.index')
            ->with('success','Class Arm updated successfully');
    }


    public function destroy(ClassArm $classarm)
    {
        $classarm->delete();

        return redirect()
            ->route('admin.classarms.index')
            ->with('success','Class Arm deleted successfully');
    }

}
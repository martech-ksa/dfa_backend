<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\Program;

class LevelController extends Controller
{

    public function index()
    {
        $levels = Level::with('program')->latest()->paginate(20);

        return view('admin.levels.index', compact('levels'));
    }



    public function create()
    {
        $programs = Program::all();

        return view('admin.levels.create', compact('programs'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required',
            'name' => 'required|string|max:255'
        ]);

        Level::create([
            'program_id' => $request->program_id,
            'name' => $request->name
        ]);

        return redirect()
            ->route('admin.levels.index')
            ->with('success','Level created successfully');
    }



    public function edit(Level $level)
    {
        $programs = Program::all();

        return view('admin.levels.edit', compact('level','programs'));
    }



    public function update(Request $request, Level $level)
    {
        $request->validate([
            'program_id' => 'required',
            'name' => 'required|string|max:255'
        ]);

        $level->update([
            'program_id' => $request->program_id,
            'name' => $request->name
        ]);

        return redirect()
            ->route('admin.levels.index')
            ->with('success','Level updated successfully');
    }



    public function destroy(Level $level)
    {
        $level->delete();

        return redirect()
            ->route('admin.levels.index')
            ->with('success','Level deleted successfully');
    }
}
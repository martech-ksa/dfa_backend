<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;

class ProgramController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Display Programs
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $programs = Program::latest()->paginate(10);

        return view('admin.programs.index', compact('programs'));
    }


    /*
    |--------------------------------------------------------------------------
    | Show Create Form
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('admin.programs.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Store Program
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:programs,name',
            'category' => 'required|string|max:255'
        ]);

        Program::create([
            'name' => $request->name,
            'category' => $request->category
        ]);

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program created successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Show Program
    |--------------------------------------------------------------------------
    */

    public function show(Program $program)
    {
        return view('admin.programs.show', compact('program'));
    }


    /*
    |--------------------------------------------------------------------------
    | Show Edit Form
    |--------------------------------------------------------------------------
    */

    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }


    /*
    |--------------------------------------------------------------------------
    | Update Program
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Program $program)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255'
        ]);

        $program->update([
            'name' => $request->name,
            'category' => $request->category
        ]);

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program updated successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Program
    |--------------------------------------------------------------------------
    */

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program deleted successfully.');
    }
}
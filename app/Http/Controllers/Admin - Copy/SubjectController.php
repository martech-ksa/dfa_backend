<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();
        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('admin.subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:subjects,name'
        ]);

        Subject::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.subjects.index')->with('success', 'Subject added');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $request->validate([
            'name' => 'required'
        ]);

        $subject->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.subjects.index')->with('success', 'Updated');
    }

    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();
        return back()->with('success', 'Deleted');
    }
}
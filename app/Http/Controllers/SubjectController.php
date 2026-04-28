<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::with(['schoolClass', 'teacher']);

        if ($request->filled('class_id')) {
            $query->byClass($request->class_id);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%");
            });
        }

        $subjects = $query->orderBy('class_id')->paginate(15)->withQueryString();
        $classes = SchoolClass::active()->get();

        return view('subjects.index', compact('subjects', 'classes'));
    }

    public function create()
    {
        $classes = SchoolClass::active()->get();
        $teachers = Teacher::active()->get();
        return view('subjects.create', compact('classes', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:20|unique:subjects,code',
            'class_id' => 'required|exists:classes,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'type' => 'required|in:theory,practical,both',
            'full_marks' => 'required|integer|min:1',
            'pass_marks' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Subject::create($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    public function edit(Subject $subject)
    {
        $classes = SchoolClass::active()->get();
        $teachers = Teacher::active()->get();
        return view('subjects.edit', compact('subject', 'classes', 'teachers'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:20|unique:subjects,code,' . $subject->id,
            'class_id' => 'required|exists:classes,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'type' => 'required|in:theory,practical,both',
            'full_marks' => 'required|integer|min:1',
            'pass_marks' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $subject->update($validated);

        return redirect()->route('subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Routine;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
    public function classRoutine(Request $request)
    {
        $classes = SchoolClass::active()->with('sections')->get();
        $routines = collect();
        if ($request->filled('class_id')) {
            $query = Routine::forClass($request->class_id)->classRoutines()->with(['subject', 'teacher', 'section']);
            if ($request->filled('section_id')) $query->where('section_id', $request->section_id);
            $routines = $query->orderByRaw("FIELD(day,'sunday','monday','tuesday','wednesday','thursday','friday','saturday')")->orderBy('start_time')->get()->groupBy('day');
        }
        return view('routines.class', compact('classes', 'routines'));
    }

    public function teacherRoutine(Request $request)
    {
        $teachers = Teacher::active()->get();
        $routines = collect();
        if ($request->filled('teacher_id')) {
            $routines = Routine::forTeacher($request->teacher_id)->with(['schoolClass', 'section', 'subject'])->orderByRaw("FIELD(day,'sunday','monday','tuesday','wednesday','thursday','friday','saturday')")->orderBy('start_time')->get()->groupBy('day');
        }
        return view('routines.teacher', compact('teachers', 'routines'));
    }

    public function create()
    {
        $classes = SchoolClass::active()->with('sections')->get();
        $subjects = Subject::active()->get();
        $teachers = Teacher::active()->get();
        return view('routines.create', compact('classes', 'subjects', 'teachers'));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'nullable|exists:teachers,id',
            'day' => 'required|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'room' => 'nullable|string|max:100',
            'type' => 'required|in:class,exam',
        ]);
        Routine::create($v);
        return redirect()->route('routines.class')->with('success', 'Routine created.');
    }

    public function destroy(Routine $routine)
    {
        $routine->delete();
        return redirect()->back()->with('success', 'Routine deleted.');
    }
}

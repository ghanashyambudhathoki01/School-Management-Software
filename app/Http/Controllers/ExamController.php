<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::withCount('schedules')->orderByDesc('start_date')->paginate(15);
        return view('exams.index', compact('exams'));
    }

    public function create()
    {
        return view('exams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        Exam::create($validated);
        return redirect()->route('exams.index')->with('success', 'Exam created successfully.');
    }

    public function show(Exam $exam)
    {
        $exam->load(['schedules.subject', 'schedules.schoolClass', 'schedules.section']);
        return view('exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        return view('exams.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);
        $exam->update($validated);
        return redirect()->route('exams.index')->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Exam deleted successfully.');
    }

    public function schedule(Exam $exam)
    {
        $classes = SchoolClass::active()->with('sections')->get();
        $subjects = Subject::active()->get();
        $schedules = $exam->schedules()->with(['subject', 'schoolClass', 'section'])->get();
        return view('exams.schedule', compact('exam', 'classes', 'subjects', 'schedules'));
    }

    public function storeSchedule(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'exam_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'room' => 'nullable|string|max:100',
        ]);
        $exam->schedules()->create($validated);
        return redirect()->back()->with('success', 'Schedule added successfully.');
    }

    public function marks(Request $request, Exam $exam)
    {
        $classes = SchoolClass::active()->with('sections')->get();
        $students = collect();
        $subjects = collect();
        $existingMarks = collect();
        if ($request->filled('class_id')) {
            $students = Student::active()->byClass($request->class_id);
            if ($request->filled('section_id')) $students->bySection($request->section_id);
            $students = $students->orderBy('roll_number')->get();
            $subjects = Subject::active()->byClass($request->class_id)->get();
            $existingMarks = Mark::where('exam_id', $exam->id)->where('class_id', $request->class_id)->get()->groupBy('student_id');
        }
        return view('exams.marks', compact('exam', 'classes', 'students', 'subjects', 'existingMarks'));
    }

    public function storeMarks(Request $request, Exam $exam)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'marks' => 'required|array',
        ]);
        foreach ($request->marks as $studentId => $subjects) {
            foreach ($subjects as $subjectId => $marksObtained) {
                if ($marksObtained === null || $marksObtained === '') continue;
                $subject = Subject::find($subjectId);
                $mark = Mark::updateOrCreate(
                    ['exam_id' => $exam->id, 'student_id' => $studentId, 'subject_id' => $subjectId],
                    [
                        'class_id' => $request->class_id,
                        'section_id' => $request->section_id,
                        'marks_obtained' => $marksObtained,
                        'total_marks' => $subject->full_marks ?? 100,
                        'recorded_by' => Auth::id(),
                    ]
                );
                $mark->update(['grade' => $mark->calculated_grade]);
            }
        }
        return redirect()->back()->with('success', 'Marks saved successfully.');
    }

    public function results(Request $request, Exam $exam)
    {
        $classes = SchoolClass::active()->get();
        $results = collect();
        if ($request->filled('class_id')) {
            $students = Student::active()->byClass($request->class_id);
            if ($request->filled('section_id')) $students->bySection($request->section_id);
            foreach ($students->get() as $student) {
                $marks = Mark::where('exam_id', $exam->id)->where('student_id', $student->id)->with('subject')->get();
                if ($marks->isEmpty()) continue;
                $totalObtained = $marks->sum('marks_obtained');
                $totalFull = $marks->sum('total_marks');
                $percentage = $totalFull > 0 ? round(($totalObtained / $totalFull) * 100, 2) : 0;
                $results->push(['student' => $student, 'marks' => $marks, 'total_obtained' => $totalObtained, 'total_full' => $totalFull, 'percentage' => $percentage, 'gpa' => $marks->avg('gpa')]);
            }
            $results = $results->sortByDesc('percentage')->values();
        }
        return view('exams.results', compact('exam', 'classes', 'results'));
    }
}

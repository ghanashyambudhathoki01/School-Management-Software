<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::active()->get();
        $records = collect();
        if ($request->filled('class_id') && $request->filled('date')) {
            $query = AttendanceRecord::forStudents()->forClass($request->class_id)->forDate($request->date);
            if ($request->filled('section_id')) {
                $query->where('section_id', $request->section_id);
            }
            $records = $query->get();
        }
        return view('attendance.index', compact('classes', 'records'));
    }

    public function studentAttendance(Request $request)
    {
        $classes = SchoolClass::active()->with('sections')->get();
        $students = collect();
        $existingRecords = collect();
        if ($request->filled('class_id') && $request->filled('date')) {
            $query = Student::active()->byClass($request->class_id);
            if ($request->filled('section_id')) $query->bySection($request->section_id);
            $students = $query->orderBy('roll_number')->get();
            $existingRecords = AttendanceRecord::forStudents()->forDate($request->date)->forClass($request->class_id)->pluck('status', 'attendee_id');
        }
        return view('attendance.student', compact('classes', 'students', 'existingRecords'));
    }

    public function storeStudentAttendance(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*' => 'in:present,absent,late,half_day',
        ]);
        foreach ($request->attendance as $studentId => $status) {
            AttendanceRecord::updateOrCreate(
                ['attendee_type' => 'student', 'attendee_id' => $studentId, 'date' => $request->date],
                ['class_id' => $request->class_id, 'section_id' => $request->section_id, 'status' => $status, 'recorded_by' => Auth::id()]
            );
        }
        return redirect()->back()->with('success', 'Student attendance saved successfully.');
    }

    public function teacherAttendance(Request $request)
    {
        $teachers = Teacher::active()->get();
        $existingRecords = collect();
        if ($request->filled('date')) {
            $existingRecords = AttendanceRecord::forTeachers()->forDate($request->date)->pluck('status', 'attendee_id');
        }
        return view('attendance.teacher', compact('teachers', 'existingRecords'));
    }

    public function storeTeacherAttendance(Request $request)
    {
        $request->validate(['date' => 'required|date', 'attendance' => 'required|array']);
        foreach ($request->attendance as $teacherId => $status) {
            AttendanceRecord::updateOrCreate(
                ['attendee_type' => 'teacher', 'attendee_id' => $teacherId, 'date' => $request->date],
                ['status' => $status, 'recorded_by' => Auth::id()]
            );
        }
        return redirect()->back()->with('success', 'Teacher attendance saved successfully.');
    }

    public function report(Request $request)
    {
        $classes = SchoolClass::active()->get();
        $report = collect();
        if ($request->filled(['class_id', 'month', 'year'])) {
            $students = Student::active()->byClass($request->class_id);
            if ($request->filled('section_id')) $students->bySection($request->section_id);
            foreach ($students->get() as $student) {
                $records = AttendanceRecord::forStudents()->where('attendee_id', $student->id)->forMonth($request->month, $request->year)->get();
                $report->push(['student' => $student, 'present' => $records->where('status', 'present')->count(), 'absent' => $records->where('status', 'absent')->count(), 'late' => $records->where('status', 'late')->count(), 'total_days' => $records->count()]);
            }
        }
        return view('attendance.report', compact('classes', 'report'));
    }
}

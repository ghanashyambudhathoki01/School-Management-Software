<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\FeeInvoice;
use App\Models\Payment;
use App\Models\SalaryRecord;
use App\Models\Exam;
use App\Models\Notice;
use App\Models\AttendanceRecord;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalStudents' => Student::active()->count(),
            'totalTeachers' => Teacher::active()->count(),
            'totalClasses' => SchoolClass::active()->count(),

            // Financial
            'pendingFees' => FeeInvoice::where('status', '!=', 'paid')->sum('due_amount'),
            'monthlyRevenue' => Payment::whereMonth('payment_date', now()->month)
                                       ->whereYear('payment_date', now()->year)
                                       ->sum('amount'),
            'salaryOverview' => SalaryRecord::forMonth(now()->format('F'), now()->year)
                                            ->sum('net_salary'),

            // Attendance today
            'todayAttendance' => [
                'present' => AttendanceRecord::forStudents()->forDate(now())->present()->count(),
                'absent' => AttendanceRecord::forStudents()->forDate(now())->absent()->count(),
                'total' => Student::active()->count(),
            ],

            // Upcoming exams
            'upcomingExams' => Exam::upcoming()->orderBy('start_date')->limit(5)->get(),

            // Recent notices
            'recentNotices' => Notice::active()->orderByDesc('publish_date')->limit(5)->get(),

            'pendingSalaries' => SalaryRecord::with('teacher')->pending()->limit(5)->get(),
        ];

        return view('school_admin.dashboard', $data);
    }
}

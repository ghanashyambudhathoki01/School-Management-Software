<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Notice;
use App\Models\AttendanceRecord;
use App\Models\Routine;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teacher = $user->teacher;

        $data = [
            'teacher' => $teacher,
            'assignedClasses' => $teacher ? $teacher->getAssignedClasses()->get() : collect(),
            'assignedSubjects' => $teacher ? $teacher->subjects()->with('schoolClass')->get() : collect(),
            'todayRoutine' => $teacher ? Routine::forTeacher($teacher->id)
                                                 ->forDay(strtolower(now()->format('l')))
                                                 ->with(['schoolClass', 'section', 'subject'])
                                                 ->orderBy('start_time')
                                                 ->get() : collect(),
            'recentNotices' => Notice::active()->forTeachers()
                                     ->orderByDesc('publish_date')
                                     ->limit(5)
                                     ->get(),
            'latestSalary' => $teacher ? $teacher->salaryRecords()->orderByDesc('year')->orderByDesc('month')->first() : null,
        ];

        return view('teacher.dashboard', $data);
    }
}

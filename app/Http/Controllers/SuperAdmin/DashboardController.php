<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\FeeInvoice;
use App\Models\Payment;
use App\Models\SalaryRecord;
use App\Models\Exam;
use App\Models\Notice;
use App\Models\AttendanceRecord;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalUsers' => User::count(),
            'totalSchoolAdmins' => User::where('role', 'school_admin')->count(),
            'totalTeachers' => User::where('role', 'teacher')->count(),

            // Account status alerts
            'expiringAccounts' => User::expiringSoon(30)
                                      ->where('role', '!=', 'super_admin')
                                      ->get(),
            'expiredAccounts' => User::expired()
                                     ->where('role', '!=', 'super_admin')
                                     ->count(),
            'suspendedAccounts' => User::suspended()
                                       ->where('role', '!=', 'super_admin')
                                       ->count(),
            'disabledAccounts' => User::disabled()
                                      ->where('role', '!=', 'super_admin')
                                      ->count(),
            
            'recentUsers' => User::orderByDesc('created_at')->limit(5)->get(),
        ];

        return view('super_admin.dashboard', $data);
    }
}

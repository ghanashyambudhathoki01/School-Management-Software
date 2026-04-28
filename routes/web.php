<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboard;
use App\Http\Controllers\SuperAdmin\UserManagementController;
use App\Http\Controllers\SchoolAdmin\DashboardController as SchoolAdminDashboard;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboard;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\RoutineController;

// ─── Guest Routes ────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// ─── Authenticated Routes ────────────────────────
Route::middleware(['auth', 'access.check'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ─── Super Admin Routes ──────────────────────
    Route::prefix('super-admin')->name('super_admin.')->middleware('role:super_admin')->group(function () {
        Route::get('/dashboard', [SuperAdminDashboard::class, 'index'])->name('dashboard');

        // User Management
        Route::resource('users', UserManagementController::class)->except(['show']);
        Route::get('users/{user}/show', [UserManagementController::class, 'show'])->name('users.show');
        Route::patch('users/{user}/activate', [UserManagementController::class, 'activate'])->name('users.activate');
        Route::patch('users/{user}/suspend', [UserManagementController::class, 'suspend'])->name('users.suspend');
        Route::patch('users/{user}/disable', [UserManagementController::class, 'disable'])->name('users.disable');
        Route::patch('users/{user}/renew', [UserManagementController::class, 'renew'])->name('users.renew');
        Route::patch('users/{user}/extend', [UserManagementController::class, 'extend'])->name('users.extend');
    });

    // Global Settings (Shared by Super Admin and School Admin)
    Route::middleware('role:super_admin,school_admin')->group(function () {
        Route::get('super-admin/settings', [App\Http\Controllers\SuperAdmin\SettingsController::class, 'index'])->name('super_admin.settings.index');
        Route::post('super-admin/settings', [App\Http\Controllers\SuperAdmin\SettingsController::class, 'update'])->name('super_admin.settings.update');
    });

    // ─── School Admin Routes ─────────────────────
    Route::prefix('school-admin')->name('school_admin.')->middleware('role:super_admin,school_admin')->group(function () {
        Route::get('/dashboard', [SchoolAdminDashboard::class, 'index'])->name('dashboard');
    });

    // ─── Teacher Routes ──────────────────────────
    Route::prefix('teacher')->name('teacher.')->middleware('role:super_admin,school_admin,teacher')->group(function () {
        Route::get('/dashboard', [TeacherDashboard::class, 'index'])->name('dashboard');
    });

    // ─── Shared Module Routes (Admin + Super Admin) ──
    Route::middleware('role:super_admin,school_admin')->group(function () {
        // Students
        Route::resource('students', StudentController::class);

        // Teachers
        Route::resource('teachers', TeacherController::class);

        // Classes
        Route::resource('classes', ClassController::class)->parameters(['classes' => 'class']);
        Route::get('classes/{class}/sections', [ClassController::class, 'getSections'])->name('classes.sections');

        // Sections
        Route::resource('sections', SectionController::class);

        // Subjects
        Route::resource('subjects', SubjectController::class);

        // Attendance
        Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('attendance/teacher', [AttendanceController::class, 'teacherAttendance'])->name('attendance.teacher');
        Route::post('attendance/teacher', [AttendanceController::class, 'storeTeacherAttendance'])->name('attendance.teacher.store');
        Route::get('attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');

        // Fees
        Route::get('fees/categories', [FeeController::class, 'categories'])->name('fees.categories');
        Route::post('fees/categories', [FeeController::class, 'storeCategory'])->name('fees.categories.store');
        Route::put('fees/categories/{category}', [FeeController::class, 'updateCategory'])->name('fees.categories.update');
        Route::delete('fees/categories/{category}', [FeeController::class, 'deleteCategory'])->name('fees.categories.delete');
        Route::get('fees/invoices', [FeeController::class, 'invoices'])->name('fees.invoices');
        Route::get('fees/invoices/create', [FeeController::class, 'createInvoice'])->name('fees.invoices.create');
        Route::post('fees/invoices', [FeeController::class, 'storeInvoice'])->name('fees.invoices.store');
        Route::get('fees/invoices/{invoice}', [FeeController::class, 'showInvoice'])->name('fees.invoices.show');
        Route::post('fees/invoices/{invoice}/pay', [FeeController::class, 'recordPayment'])->name('fees.invoices.pay');
        Route::get('fees/due-report', [FeeController::class, 'dueReport'])->name('fees.due_report');

        // Exams
        Route::resource('exams', ExamController::class);
        Route::get('exams/{exam}/schedule', [ExamController::class, 'schedule'])->name('exams.schedule');
        Route::post('exams/{exam}/schedule', [ExamController::class, 'storeSchedule'])->name('exams.schedule.store');
        Route::get('exams/{exam}/marks', [ExamController::class, 'marks'])->name('exams.marks');
        Route::post('exams/{exam}/marks', [ExamController::class, 'storeMarks'])->name('exams.marks.store');
        Route::get('exams/{exam}/results', [ExamController::class, 'results'])->name('exams.results');

        // Salary
        Route::get('salary', [SalaryController::class, 'index'])->name('salary.index');
        Route::get('salary/create', [SalaryController::class, 'create'])->name('salary.create');
        Route::post('salary', [SalaryController::class, 'store'])->name('salary.store');
        Route::post('salary/generate-bulk', [SalaryController::class, 'generateBulk'])->name('salary.generate_bulk');
        Route::get('salary/{salary}', [SalaryController::class, 'show'])->name('salary.show');
        Route::patch('salary/{salary}/pay', [SalaryController::class, 'pay'])->name('salary.pay');
        Route::delete('salary/{salary}', [SalaryController::class, 'destroy'])->name('salary.destroy');

        // Notices Management (Create/Edit/Delete)
        Route::resource('notices', NoticeController::class)->except(['index', 'show']);

        // Accounts
        Route::get('accounts', [AccountController::class, 'index'])->name('accounts.index');
        Route::get('accounts/incomes', [AccountController::class, 'incomes'])->name('accounts.incomes');
        Route::post('accounts/incomes', [AccountController::class, 'storeIncome'])->name('accounts.incomes.store');
        Route::delete('accounts/incomes/{income}', [AccountController::class, 'deleteIncome'])->name('accounts.incomes.delete');
        Route::get('accounts/expenses', [AccountController::class, 'expenses'])->name('accounts.expenses');
        Route::post('accounts/expenses', [AccountController::class, 'storeExpense'])->name('accounts.expenses.store');
        Route::delete('accounts/expenses/{expense}', [AccountController::class, 'deleteExpense'])->name('accounts.expenses.delete');

        // Certificates
        Route::resource('certificates', CertificateController::class)->only(['index', 'create', 'store', 'show', 'destroy']);

        // Routines
        Route::get('routines/class', [RoutineController::class, 'classRoutine'])->name('routines.class');
        Route::get('routines/teacher', [RoutineController::class, 'teacherRoutine'])->name('routines.teacher');
        Route::get('routines/create', [RoutineController::class, 'create'])->name('routines.create');
        Route::post('routines', [RoutineController::class, 'store'])->name('routines.store');
        Route::delete('routines/{routine}', [RoutineController::class, 'destroy'])->name('routines.destroy');
    });

    // ─── Teacher-Accessible Routes ───────────────
    Route::middleware('role:super_admin,school_admin,teacher')->group(function () {
        Route::get('notices', [NoticeController::class, 'index'])->name('notices.index');
        Route::get('notices/{notice}', [NoticeController::class, 'show'])->name('notices.show');

        // Student Attendance (for teachers to mark)
        Route::get('attendance/student', [AttendanceController::class, 'studentAttendance'])->name('attendance.student');
        Route::post('attendance/student', [AttendanceController::class, 'storeStudentAttendance'])->name('attendance.student.store');
    });
});

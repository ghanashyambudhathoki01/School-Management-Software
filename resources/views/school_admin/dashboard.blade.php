@extends('layouts.app')
@section('title', 'School Admin Dashboard')
@section('page-title', 'My Dashboard')
@section('page-description', 'Welcome back, ' . Auth::user()->name)

@section('content')
    {{-- Welcome Banner --}}
    <div
        class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-600 to-teal-700 p-8 mb-8 text-white shadow-lg">
        <div class="relative z-10">
            <h2 class="text-3xl font-bold mb-2">Hello, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-emerald-100 max-w-xl text-lg">Oversee your school's daily operations, students, and academic
                excellence in one place.</p>
        </div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 mr-32 -mb-12 w-48 h-48 bg-emerald-500/20 rounded-full blur-2xl"></div>
        <i class="fas fa-school absolute right-12 top-1/2 -translate-y-1/2 text-white/10 text-9xl -rotate-12"></i>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-indigo-100 flex items-center justify-center"><i
                        class="fas fa-user-graduate text-indigo-600"></i></div>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalStudents) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Students</p>
        </div>
        <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-purple-100 flex items-center justify-center"><i
                        class="fas fa-chalkboard-teacher text-purple-600"></i></div>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalTeachers) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Teachers</p>
        </div>
        <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-sky-100 flex items-center justify-center"><i
                        class="fas fa-school text-sky-600"></i></div>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalClasses) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total Classes</p>
        </div>
        <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center"><i
                        class="fas fa-file-invoice-dollar text-amber-600"></i></div>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($pendingFees, 2) }}</p>
            <p class="text-sm text-gray-500 mt-1">Pending Fees</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-6 text-white shadow-lg">
            <p class="text-sm text-indigo-200 mb-1">Monthly Revenue</p>
            <p class="text-3xl font-bold">{{ number_format($monthlyRevenue, 2) }}</p>
            <p class="text-xs text-indigo-300 mt-2">{{ now()->format('F Y') }}</p>
        </div>
        <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl p-6 text-white shadow-lg">
            <p class="text-sm text-emerald-200 mb-1">Salary Expenses</p>
            <p class="text-3xl font-bold">{{ number_format($salaryOverview, 2) }}</p>
            <p class="text-xs text-emerald-300 mt-2">{{ now()->format('F Y') }}</p>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
            <p class="text-sm text-gray-500 mb-3 font-medium">Today's Attendance</p>
            <div class="flex items-center gap-4">
                <div class="text-center">
                    <p class="text-2xl font-bold text-emerald-600">{{ $todayAttendance['present'] }}</p>
                    <p class="text-xs text-gray-500">Present</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-red-500">{{ $todayAttendance['absent'] }}</p>
                    <p class="text-xs text-gray-500">Absent</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-400">{{ $todayAttendance['total'] }}</p>
                    <p class="text-xs text-gray-500">Total</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Salary Management Quick Action --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Monthly Payroll Management</h3>
                <p class="text-sm text-gray-500">Generate and process teacher salaries for {{ now()->format('F Y') }}</p>
            </div>
            <form method="POST" action="{{ route('salary.generate_bulk') }}">
                @csrf
                <button type="submit"
                    class="px-4 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition flex items-center gap-2">
                    <i class="fas fa-magic"></i> Generate All Salaries
                </button>
            </form>
        </div>

        @if($pendingSalaries->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="pb-2">Teacher</th>
                            <th class="pb-2">Month</th>
                            <th class="pb-2 text-right">Net Salary</th>
                            <th class="pb-2 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingSalaries as $sal)
                            <tr class="border-b border-gray-50 last:border-0">
                                <td class="py-3">
                                    <p class="font-medium text-gray-800">{{ $sal->teacher->full_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $sal->teacher->employee_id }}</p>
                                </td>
                                <td class="py-3 text-gray-600">{{ $sal->month }} {{ $sal->year }}</td>
                                <td class="py-3 text-right font-semibold text-indigo-600">{{ number_format($sal->net_salary, 2) }}
                                </td>
                                <td class="py-3 text-right">
                                    <form method="POST" action="{{ route('salary.pay', $sal) }}" class="inline">
                                        @csrf @method('PATCH')
                                        <button type="submit"
                                            class="text-xs font-medium px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full hover:bg-emerald-100 transition">Mark
                                            Paid</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('salary.index') }}" class="text-sm text-indigo-600 font-medium hover:underline">View All
                    Salary Records</a>
            </div>
        @else
            <div class="text-center py-8 bg-gray-50 rounded-xl">
                <p class="text-gray-500">No pending payments for this month. Click "Generate" above to start.</p>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4"><i class="fas fa-file-alt text-indigo-500 mr-2"></i>
                Upcoming Exams</h3>
            @forelse($upcomingExams as $exam)
                <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
                    <div>
                        <p class="font-medium text-gray-800">{{ $exam->name }}</p>
                        <p class="text-xs text-gray-500">{{ $exam->start_date->format('M d') }} -
                            {{ $exam->end_date->format('M d, Y') }}</p>
                    </div>
                    <span
                        class="text-xs font-medium px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-600">{{ ucfirst($exam->status) }}</span>
                </div>
            @empty
                <p class="text-gray-400 text-sm py-4 text-center">No upcoming exams</p>
            @endforelse
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4"><i class="fas fa-bullhorn text-purple-500 mr-2"></i> Recent
                Notices</h3>
            @forelse($recentNotices as $notice)
                <div class="py-3 border-b border-gray-50 last:border-0">
                    <p class="font-medium text-gray-800 text-sm">{{ $notice->title }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $notice->publish_date->format('M d, Y') }}</p>
                </div>
            @empty
                <p class="text-gray-400 text-sm py-4 text-center">No recent notices</p>
            @endforelse
        </div>
    </div>
@endsection
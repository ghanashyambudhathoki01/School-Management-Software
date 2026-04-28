@extends('layouts.app')
@section('title', 'Attendance Overview')
@section('page-title', 'Attendance Management')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    <a href="{{ route('attendance.student') }}" class="bg-white rounded-2xl border p-6 hover:shadow-md transition group"><div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center mb-3"><i class="fas fa-user-graduate text-indigo-600 text-xl"></i></div><h3 class="font-semibold text-gray-800 group-hover:text-indigo-600">Student Attendance</h3><p class="text-sm text-gray-500 mt-1">Mark daily student attendance</p></a>
    <a href="{{ route('attendance.teacher') }}" class="bg-white rounded-2xl border p-6 hover:shadow-md transition group"><div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center mb-3"><i class="fas fa-chalkboard-teacher text-purple-600 text-xl"></i></div><h3 class="font-semibold text-gray-800 group-hover:text-purple-600">Teacher Attendance</h3><p class="text-sm text-gray-500 mt-1">Mark daily teacher attendance</p></a>
    <a href="{{ route('attendance.report') }}" class="bg-white rounded-2xl border p-6 hover:shadow-md transition group"><div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center mb-3"><i class="fas fa-chart-bar text-emerald-600 text-xl"></i></div><h3 class="font-semibold text-gray-800 group-hover:text-emerald-600">Attendance Report</h3><p class="text-sm text-gray-500 mt-1">View monthly attendance reports</p></a>
</div>
@endsection

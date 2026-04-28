@extends('layouts.app')
@section('title', 'Teacher Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Class & Routine Overview')

@section('content')
{{-- Welcome Banner --}}
<div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-purple-600 to-indigo-700 p-8 mb-8 text-white shadow-lg">
    <div class="relative z-10">
        <h2 class="text-3xl font-bold mb-2">Hello, {{ Auth::user()->name }}! 👋</h2>
        <p class="text-purple-100 max-w-xl text-lg">Your students are waiting! Check your schedule and manage your classes efficiently today.</p>
    </div>
    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 mr-32 -mb-12 w-48 h-48 bg-purple-500/20 rounded-full blur-2xl"></div>
    <i class="fas fa-book-open absolute right-12 top-1/2 -translate-y-1/2 text-white/10 text-9xl -rotate-12"></i>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="w-11 h-11 rounded-xl bg-indigo-100 flex items-center justify-center mb-3"><i class="fas fa-school text-indigo-600"></i></div>
        <p class="text-2xl font-bold text-gray-800">{{ $assignedClasses->count() }}</p>
        <p class="text-sm text-gray-500 mt-1">Assigned Classes</p>
    </div>
    <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="w-11 h-11 rounded-xl bg-purple-100 flex items-center justify-center mb-3"><i class="fas fa-book text-purple-600"></i></div>
        <p class="text-2xl font-bold text-gray-800">{{ $assignedSubjects->count() }}</p>
        <p class="text-sm text-gray-500 mt-1">Assigned Subjects</p>
    </div>
    <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="w-11 h-11 rounded-xl bg-sky-100 flex items-center justify-center mb-3"><i class="fas fa-calendar-day text-sky-600"></i></div>
        <p class="text-2xl font-bold text-gray-800">{{ $todayRoutine->count() }}</p>
        <p class="text-sm text-gray-500 mt-1">Today's Classes</p>
    </div>
    <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
        <div class="w-11 h-11 rounded-xl bg-emerald-100 flex items-center justify-center mb-3"><i class="fas fa-money-check-alt text-emerald-600"></i></div>
        @if($latestSalary)
            <p class="text-lg font-bold {{ $latestSalary->payment_status == 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">
                {{ $latestSalary->payment_status == 'pending_payment' ? 'Pending Payment' : ucfirst($latestSalary->payment_status) }}
            </p>
            <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold tracking-wider">
                @if($latestSalary->payment_status == 'paid')
                    Paid on: {{ $latestSalary->payment_date->format('M d, Y') }}
                @else
                    Due: {{ $latestSalary->due_date ? $latestSalary->due_date->format('M d, Y') : 'Pending' }}
                @endif
            </p>
            @if($latestSalary->next_payment_date)
                <div class="mt-2 pt-2 border-t border-gray-50">
                    <p class="text-xs text-indigo-600 font-semibold">Next: {{ $latestSalary->next_payment_date->format('M d, Y') }}</p>
                </div>
            @endif
        @else
            <p class="text-lg font-bold text-gray-400">No Record</p>
            <p class="text-xs text-gray-400 mt-1">N/A</p>
        @endif
        <p class="text-sm text-gray-500 mt-1">Salary Status</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    {{-- Today's Schedule --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4"><i class="fas fa-clock text-indigo-500 mr-2"></i> Today's Schedule ({{ now()->format('l') }})</h3>
        @forelse($todayRoutine as $routine)
            <div class="flex items-center gap-4 py-3 border-b border-gray-50 last:border-0">
                <div class="text-center bg-indigo-50 rounded-xl px-3 py-2 min-w-[80px]">
                    <p class="text-xs font-semibold text-indigo-600">{{ \Carbon\Carbon::parse($routine->start_time)->format('h:i A') }}</p>
                    <p class="text-xs text-indigo-400">{{ \Carbon\Carbon::parse($routine->end_time)->format('h:i A') }}</p>
                </div>
                <div>
                    <p class="font-medium text-gray-800">{{ $routine->subject->name ?? 'N/A' }}</p>
                    <p class="text-xs text-gray-500">{{ $routine->schoolClass->name ?? '' }} {{ $routine->section ? '- '.$routine->section->name : '' }} {{ $routine->room ? '| Room: '.$routine->room : '' }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-400 text-sm py-4 text-center">No classes scheduled for today</p>
        @endforelse
    </div>

    {{-- Notices --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4"><i class="fas fa-bullhorn text-purple-500 mr-2"></i> Notices</h3>
        @forelse($recentNotices as $notice)
            <div class="py-3 border-b border-gray-50 last:border-0">
                <div class="flex items-center gap-2 mb-1">
                    @if($notice->type === 'urgent')
                        <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-red-100 text-red-600">Urgent</span>
                    @endif
                    <p class="font-medium text-gray-800 text-sm">{{ $notice->title }}</p>
                </div>
                <p class="text-xs text-gray-500">{{ $notice->publish_date->format('M d, Y') }}</p>
            </div>
        @empty
            <p class="text-gray-400 text-sm py-4 text-center">No notices</p>
        @endforelse
    </div>
</div>

{{-- My Subjects --}}
@if($assignedSubjects->count() > 0)
<div class="mt-5 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4"><i class="fas fa-book text-emerald-500 mr-2"></i> My Subjects</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($assignedSubjects as $subject)
            <div class="border border-gray-100 rounded-xl p-4 hover:shadow-md transition">
                <p class="font-semibold text-gray-800">{{ $subject->name }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $subject->schoolClass->name ?? '' }}</p>
                <span class="inline-block mt-2 text-xs font-medium px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600">{{ ucfirst($subject->type) }}</span>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection

@extends('layouts.app')
@section('title', 'Teacher Profile')
@section('page-title', $teacher->full_name)
@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border p-6 mb-5">
        <div class="flex items-start gap-5">
            <div class="w-20 h-20 rounded-2xl bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-2xl">{{ strtoupper(substr($teacher->first_name,0,1)) }}</div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-gray-800">{{ $teacher->full_name }}</h3>
                <p class="text-gray-500 text-sm">{{ $teacher->employee_id }} | {{ $teacher->designation ?? 'Teacher' }}</p>
                <span class="inline-block mt-2 text-xs font-medium px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700">{{ ucfirst($teacher->status) }}</span>
            </div>
            <a href="{{ route('teachers.edit', $teacher) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl">Edit</a>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl border p-6 text-sm space-y-2">
            <h4 class="font-semibold mb-3">Personal</h4>
            <p><span class="text-gray-500">Email:</span> {{ $teacher->email }}</p>
            <p><span class="text-gray-500">Phone:</span> {{ $teacher->phone ?? 'N/A' }}</p>
            <p><span class="text-gray-500">Gender:</span> {{ ucfirst($teacher->gender ?? 'N/A') }}</p>
            <p><span class="text-gray-500">DOB:</span> {{ optional($teacher->date_of_birth)->format('M d, Y') ?? 'N/A' }}</p>
        </div>
        <div class="bg-white rounded-2xl border p-6 text-sm space-y-2">
            <h4 class="font-semibold mb-3">Professional</h4>
            <p><span class="text-gray-500">Department:</span> {{ $teacher->department ?? 'N/A' }}</p>
            <p><span class="text-gray-500">Qualification:</span> {{ $teacher->qualification ?? 'N/A' }}</p>
            <p><span class="text-gray-500">Experience:</span> {{ $teacher->experience ?? 'N/A' }}</p>
            <p><span class="text-gray-500">Salary:</span> {{ number_format($teacher->salary_amount, 2) }}</p>
            <p><span class="text-gray-500">Joined:</span> {{ optional($teacher->joining_date)->format('M d, Y') ?? 'N/A' }}</p>
        </div>
    </div>
    @if($teacher->subjects->count())
    <div class="mt-5 bg-white rounded-2xl border p-6">
        <h4 class="font-semibold mb-3">Assigned Subjects</h4>
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($teacher->subjects as $subject)
            <div class="border rounded-xl p-3"><p class="font-medium text-sm">{{ $subject->name }}</p><p class="text-xs text-gray-500">{{ $subject->schoolClass->name ?? '' }} | {{ $subject->code }}</p></div>
            @endforeach
        </div>
    </div>
    @endif
    <div class="mt-4"><a href="{{ route('teachers.index') }}" class="text-sm text-indigo-600 hover:underline"><i class="fas fa-arrow-left mr-1"></i> Back</a></div>
</div>
@endsection

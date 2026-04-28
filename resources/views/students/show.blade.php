@extends('layouts.app')
@section('title', 'Student Profile')
@section('page-title', $student->full_name)
@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-5">
        <div class="flex items-start gap-5">
            <div class="w-20 h-20 rounded-2xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-2xl flex-shrink-0">{{ strtoupper(substr($student->first_name,0,1)) }}</div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-gray-800">{{ $student->full_name }}</h3>
                <p class="text-gray-500 text-sm">{{ $student->admission_no }}</p>
                <span class="inline-block mt-2 text-xs font-medium px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700">{{ ucfirst($student->status) }}</span>
            </div>
            <a href="{{ route('students.edit', $student) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition">Edit</a>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl border p-6 text-sm space-y-2">
            <h4 class="font-semibold mb-3">Personal Details</h4>
            <p><span class="text-gray-500">DOB:</span> {{ optional($student->date_of_birth)->format('M d, Y') ?? 'N/A' }}</p>
            <p><span class="text-gray-500">Gender:</span> {{ ucfirst($student->gender ?? 'N/A') }}</p>
            <p><span class="text-gray-500">Blood:</span> {{ $student->blood_group ?? 'N/A' }}</p>
            <p><span class="text-gray-500">Phone:</span> {{ $student->phone ?? 'N/A' }}</p>
            <p><span class="text-gray-500">Email:</span> {{ $student->email ?? 'N/A' }}</p>
        </div>
        <div class="bg-white rounded-2xl border p-6 text-sm space-y-2">
            <h4 class="font-semibold mb-3">Guardian Details</h4>
            <p><span class="text-gray-500">Name:</span> {{ $student->guardian_name ?? 'N/A' }}</p>
            <p><span class="text-gray-500">Relation:</span> {{ $student->guardian_relation ?? 'N/A' }}</p>
            <p><span class="text-gray-500">Phone:</span> {{ $student->guardian_phone ?? 'N/A' }}</p>
            <p><span class="text-gray-500">Email:</span> {{ $student->guardian_email ?? 'N/A' }}</p>
        </div>
    </div>
    <div class="mt-4"><a href="{{ route('students.index') }}" class="text-sm text-indigo-600 hover:underline"><i class="fas fa-arrow-left mr-1"></i> Back</a></div>
</div>
@endsection

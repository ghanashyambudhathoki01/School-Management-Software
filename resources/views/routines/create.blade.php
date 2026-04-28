@extends('layouts.app')
@section('title', 'Add Routine Entry')
@section('page-title', 'Create Routine Entry')
@section('content')
<div class="max-w-2xl bg-white rounded-2xl border shadow-sm p-6">
    <form method="POST" action="{{ route('routines.store') }}" class="space-y-5">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Class *</label>
                <select name="class_id" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Class</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Subject *</label>
                <select name="subject_id" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Subject</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->schoolClass->name ?? '' }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Teacher</label>
                <select name="teacher_id" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Teacher</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Day *</label>
                <select name="day" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                        <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Start Time *</label>
                <input type="time" name="start_time" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">End Time *</label>
                <input type="time" name="end_time" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Room Number</label>
                <input type="text" name="room" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500" placeholder="e.g. 101">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Type *</label>
                <select name="type" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="class">Regular Class</option>
                    <option value="exam">Exam Session</option>
                </select>
            </div>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition">Save Entry</button>
            <a href="{{ route('routines.class') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl hover:bg-gray-300 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Exam Schedule')
@section('page-title', 'Exam Schedule - '.$exam->name)
@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border p-6 mb-5">
        <h3 class="font-semibold mb-4">Add Schedule Entry</h3>
        <form method="POST" action="{{ route('exams.schedule.store', $exam) }}" class="grid grid-cols-2 md:grid-cols-3 gap-4">@csrf
            <div><label class="block text-sm font-medium mb-1">Class *</label><select name="class_id" required class="w-full px-4 py-2.5 border rounded-xl text-sm"><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium mb-1">Subject *</label><select name="subject_id" required class="w-full px-4 py-2.5 border rounded-xl text-sm"><option value="">Select</option>@foreach($subjects as $s)<option value="{{ $s->id }}">{{ $s->name }} ({{ $s->code }})</option>@endforeach</select></div>
            <div><label class="block text-sm font-medium mb-1">Date *</label><input type="date" name="exam_date" required class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Start Time *</label><input type="time" name="start_time" required class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">End Time *</label><input type="time" name="end_time" required class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Room</label><input type="text" name="room" class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
            <div class="md:col-span-3"><button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl"><i class="fas fa-plus mr-1"></i>Add</button></div>
        </form>
    </div>
    @if($schedules->count())
    <div class="bg-white rounded-2xl border p-6">
        <h3 class="font-semibold mb-4">Current Schedule</h3>
        <table class="w-full text-sm"><thead><tr class="text-left text-gray-500 bg-gray-50 border-b"><th class="px-4 py-3">Subject</th><th class="px-4 py-3">Class</th><th class="px-4 py-3">Date</th><th class="px-4 py-3">Time</th><th class="px-4 py-3">Room</th></tr></thead>
        <tbody>@foreach($schedules as $s)<tr class="border-b border-gray-50"><td class="px-4 py-3 font-medium">{{ $s->subject->name ?? '' }}</td><td class="px-4 py-3">{{ $s->schoolClass->name ?? '' }}</td><td class="px-4 py-3">{{ $s->exam_date->format('M d') }}</td><td class="px-4 py-3">{{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }}</td><td class="px-4 py-3">{{ $s->room ?? '-' }}</td></tr>@endforeach</tbody></table>
    </div>
    @endif
</div>
@endsection

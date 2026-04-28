@extends('layouts.app')
@section('title', $exam->name)
@section('page-title', $exam->name)
@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border p-6 mb-5">
        <div class="flex justify-between"><div><p class="text-sm text-gray-500">{{ $exam->start_date->format('M d') }} - {{ $exam->end_date->format('M d, Y') }}</p><p class="text-sm text-gray-600 mt-1">{{ $exam->description }}</p></div><span class="text-xs font-medium px-3 py-1.5 rounded-full bg-indigo-100 text-indigo-700">{{ ucfirst($exam->status) }}</span></div>
        <div class="flex gap-3 mt-4"><a href="{{ route('exams.schedule', $exam) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl">Schedule</a><a href="{{ route('exams.marks', $exam) }}" class="px-4 py-2 bg-purple-600 text-white text-sm rounded-xl">Marks</a><a href="{{ route('exams.results', $exam) }}" class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-xl">Results</a></div>
    </div>
    @if($exam->schedules->count())
    <div class="bg-white rounded-2xl border p-6">
        <h3 class="font-semibold mb-4">Exam Schedule</h3>
        <table class="w-full text-sm"><thead><tr class="text-left text-gray-500 bg-gray-50 border-b"><th class="px-4 py-3">Subject</th><th class="px-4 py-3">Class</th><th class="px-4 py-3">Date</th><th class="px-4 py-3">Time</th><th class="px-4 py-3">Room</th></tr></thead>
        <tbody>@foreach($exam->schedules as $s)<tr class="border-b border-gray-50"><td class="px-4 py-3 font-medium">{{ $s->subject->name ?? '' }}</td><td class="px-4 py-3">{{ $s->schoolClass->name ?? '' }}</td><td class="px-4 py-3">{{ $s->exam_date->format('M d, Y') }}</td><td class="px-4 py-3">{{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }}</td><td class="px-4 py-3">{{ $s->room ?? '-' }}</td></tr>@endforeach</tbody></table>
    </div>
    @endif
</div>
@endsection

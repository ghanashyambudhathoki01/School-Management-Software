@extends('layouts.app')
@section('title', 'Teacher Routine')
@section('page-title', 'Teacher Schedule')
@section('content')
<div class="bg-white rounded-2xl border shadow-sm p-6 mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Teacher *</label>
            <select name="teacher_id" required class="px-4 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">Select Teacher</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->full_name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl">View Schedule</button>
        @if($routines->count())
            <button type="button" onclick="window.print()" class="px-4 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl no-print"><i class="fas fa-print mr-1"></i> Print</button>
        @endif
    </form>
</div>

@if($routines->count())
<div class="bg-white rounded-2xl border shadow-sm overflow-hidden print-full">
    <div class="grid grid-cols-1 md:grid-cols-7 divide-x divide-y md:divide-y-0">
        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
            <div class="flex flex-col">
                <div class="bg-gray-50 px-4 py-3 border-b text-center">
                    <h4 class="text-xs font-bold uppercase tracking-widest text-purple-600">{{ $day }}</h4>
                </div>
                <div class="p-3 space-y-3 flex-grow">
                    @forelse($routines[$day] ?? [] as $r)
                        <div class="bg-purple-50 border border-purple-100 rounded-xl p-3">
                            <p class="text-[10px] font-bold text-purple-400 mb-1">
                                {{ \Carbon\Carbon::parse($r->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($r->end_time)->format('h:i A') }}
                            </p>
                            <p class="text-sm font-bold text-gray-800">{{ $r->subject->name ?? 'N/A' }}</p>
                            <p class="text-[10px] text-gray-500">{{ $r->schoolClass->name ?? 'Class' }}</p>
                            @if($r->room)
                                <p class="text-[10px] text-purple-600 mt-1"><i class="fas fa-door-open mr-1"></i>Room {{ $r->room }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-[10px] text-gray-300 text-center py-4 italic">No Class</p>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>
@else
    @if(request('teacher_id'))
        <div class="py-12 text-center text-gray-400 bg-white rounded-2xl border border-dashed">No routine found for this teacher</div>
    @else
        <div class="py-12 text-center text-gray-400 bg-white rounded-2xl border border-dashed">Please select a teacher to view schedule</div>
    @endif
@endif
@endsection

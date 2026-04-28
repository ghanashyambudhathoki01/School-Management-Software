@extends('layouts.app')
@section('title', 'Class Routine')
@section('page-title', 'Class Schedule')
@section('content')
<div class="bg-white rounded-2xl border shadow-sm p-6 mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Class *</label>
            <select name="class_id" required class="px-4 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">Select Class</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl">View Routine</button>
        <a href="{{ route('routines.create') }}" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition"><i class="fas fa-plus mr-1"></i> Add Entry</a>
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
                    <h4 class="text-xs font-bold uppercase tracking-widest text-indigo-600">{{ $day }}</h4>
                </div>
                <div class="p-3 space-y-3 flex-grow">
                    @forelse($routines[$day] ?? [] as $r)
                        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-3 relative group">
                            <p class="text-[10px] font-bold text-indigo-400 mb-1">
                                {{ \Carbon\Carbon::parse($r->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($r->end_time)->format('h:i A') }}
                            </p>
                            <p class="text-sm font-bold text-gray-800">{{ $r->subject->name ?? 'N/A' }}</p>
                            <p class="text-[10px] text-gray-500">{{ $r->teacher->full_name ?? 'Staff' }}</p>
                            @if($r->room)
                                <p class="text-[10px] text-indigo-600 mt-1"><i class="fas fa-door-open mr-1"></i>Room {{ $r->room }}</p>
                            @endif
                            <form method="POST" action="{{ route('routines.destroy', $r) }}" class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition no-print">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-600"><i class="fas fa-times-circle"></i></button>
                            </form>
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
    @if(request('class_id'))
        <div class="py-12 text-center text-gray-400 bg-white rounded-2xl border border-dashed">No routine found for this class</div>
    @else
        <div class="py-12 text-center text-gray-400 bg-white rounded-2xl border border-dashed">Please select a class to view routine</div>
    @endif
@endif
@endsection

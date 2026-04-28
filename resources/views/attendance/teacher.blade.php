@extends('layouts.app')
@section('title', 'Teacher Attendance')
@section('page-title', 'Mark Teacher Attendance')
@section('content')
<div class="bg-white rounded-2xl border p-6 mb-5">
    <form method="GET" class="flex gap-3 items-end">
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Date *</label><input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" required class="px-4 py-2.5 border rounded-xl text-sm"></div>
        <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl">Load</button>
    </form>
</div>
@if(request('date') && $teachers->count())
<div class="bg-white rounded-2xl border p-6">
    <form method="POST" action="{{ route('attendance.teacher.store') }}">@csrf
        <input type="hidden" name="date" value="{{ request('date') }}">
        <table class="w-full text-sm"><thead><tr class="text-left text-gray-500 bg-gray-50 border-b"><th class="px-4 py-3">Teacher</th><th class="px-4 py-3">Department</th><th class="px-4 py-3">Present</th><th class="px-4 py-3">Absent</th><th class="px-4 py-3">Late</th></tr></thead>
        <tbody>@foreach($teachers as $t)
            @php $cur = $existingRecords[$t->id] ?? 'present'; @endphp
            <tr class="border-b border-gray-50"><td class="px-4 py-3 font-medium">{{ $t->full_name }}</td><td class="px-4 py-3 text-gray-500">{{ $t->department ?? '-' }}</td>
            <td class="px-4 py-3"><input type="radio" name="attendance[{{ $t->id }}]" value="present" {{ $cur=='present'?'checked':'' }}></td>
            <td class="px-4 py-3"><input type="radio" name="attendance[{{ $t->id }}]" value="absent" {{ $cur=='absent'?'checked':'' }}></td>
            <td class="px-4 py-3"><input type="radio" name="attendance[{{ $t->id }}]" value="late" {{ $cur=='late'?'checked':'' }}></td></tr>
        @endforeach</tbody></table>
        <div class="mt-4"><button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm rounded-xl"><i class="fas fa-save mr-2"></i>Save</button></div>
    </form>
</div>
@endif
@endsection

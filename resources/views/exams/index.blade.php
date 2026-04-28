@extends('layouts.app')
@section('title', 'Examinations')
@section('page-title', 'Examination Management')
@section('content')
<div class="bg-white rounded-2xl border shadow-sm">
    <div class="flex items-center justify-between p-6 border-b"><h3 class="text-lg font-semibold">All Exams</h3><a href="{{ route('exams.create') }}" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl"><i class="fas fa-plus mr-1"></i> Create Exam</a></div>
    <div class="overflow-x-auto"><table class="w-full text-sm"><thead><tr class="text-left text-gray-500 bg-gray-50 border-b"><th class="px-6 py-3">Exam</th><th class="px-6 py-3">Start</th><th class="px-6 py-3">End</th><th class="px-6 py-3">Schedules</th><th class="px-6 py-3">Status</th><th class="px-6 py-3">Actions</th></tr></thead>
    <tbody>@forelse($exams as $exam)
        <tr class="border-b border-gray-50"><td class="px-6 py-4 font-medium">{{ $exam->name }}</td><td class="px-6 py-4 text-gray-600">{{ $exam->start_date->format('M d, Y') }}</td><td class="px-6 py-4 text-gray-600">{{ $exam->end_date->format('M d, Y') }}</td><td class="px-6 py-4"><span class="bg-indigo-50 text-indigo-600 px-2 py-1 rounded-full text-xs">{{ $exam->schedules_count }}</span></td>
        <td class="px-6 py-4"><span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $exam->status=='upcoming'?'bg-blue-100 text-blue-700':($exam->status=='ongoing'?'bg-amber-100 text-amber-700':($exam->status=='completed'?'bg-emerald-100 text-emerald-700':'bg-gray-100 text-gray-700')) }}">{{ ucfirst($exam->status) }}</span></td>
        <td class="px-6 py-4"><div class="flex gap-1"><a href="{{ route('exams.schedule', $exam) }}" class="p-2 text-gray-400 hover:text-indigo-600" title="Schedule"><i class="fas fa-calendar"></i></a><a href="{{ route('exams.marks', $exam) }}" class="p-2 text-gray-400 hover:text-purple-600" title="Marks"><i class="fas fa-pen"></i></a><a href="{{ route('exams.results', $exam) }}" class="p-2 text-gray-400 hover:text-emerald-600" title="Results"><i class="fas fa-chart-bar"></i></a><a href="{{ route('exams.edit', $exam) }}" class="p-2 text-gray-400 hover:text-indigo-600"><i class="fas fa-edit"></i></a><form method="POST" action="{{ route('exams.destroy', $exam) }}" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="p-2 text-gray-400 hover:text-red-600"><i class="fas fa-trash"></i></button></form></div></td></tr>
    @empty<tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">No exams</td></tr>@endforelse</tbody></table></div>
    <div class="p-6">{{ $exams->links() }}</div>
</div>
@endsection

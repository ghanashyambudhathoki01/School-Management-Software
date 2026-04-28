@extends('layouts.app')
@section('title', 'Exam Results')
@section('page-title', 'Results - '.$exam->name)
@section('content')
<div class="bg-white rounded-2xl border p-6 mb-5">
    <form method="GET" class="flex gap-3 items-end">
        <div><label class="block text-sm font-medium mb-1">Class</label><select name="class_id" required class="px-4 py-2.5 border rounded-xl text-sm"><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select></div>
        <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl">View Results</button>
        @if($results->count())<button type="button" onclick="window.print()" class="px-4 py-2.5 bg-gray-200 text-sm rounded-xl no-print"><i class="fas fa-print mr-1"></i>Print</button>@endif
    </form>
</div>
@if($results->count())
<div class="bg-white rounded-2xl border p-6 print-full">
    <h3 class="font-semibold mb-4">Result Sheet - {{ $exam->name }}</h3>
    <table class="w-full text-sm"><thead><tr class="text-left text-gray-500 bg-gray-50 border-b"><th class="px-4 py-3">Rank</th><th class="px-4 py-3">Student</th><th class="px-4 py-3">Obtained</th><th class="px-4 py-3">Total</th><th class="px-4 py-3">Percentage</th><th class="px-4 py-3">GPA</th></tr></thead>
    <tbody>@foreach($results as $i => $r)
        <tr class="border-b border-gray-50"><td class="px-4 py-3 font-bold text-indigo-600">{{ $i+1 }}</td><td class="px-4 py-3 font-medium">{{ $r['student']->full_name }}</td><td class="px-4 py-3">{{ $r['total_obtained'] }}</td><td class="px-4 py-3">{{ $r['total_full'] }}</td>
        <td class="px-4 py-3"><span class="font-bold {{ $r['percentage']>=60?'text-emerald-600':($r['percentage']>=40?'text-amber-600':'text-red-600') }}">{{ $r['percentage'] }}%</span></td>
        <td class="px-4 py-3 font-medium">{{ number_format($r['gpa'], 2) }}</td></tr>
    @endforeach</tbody></table>
</div>
@endif
@endsection

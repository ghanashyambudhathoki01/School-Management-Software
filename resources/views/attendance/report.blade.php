@extends('layouts.app')
@section('title', 'Attendance Report')
@section('page-title', 'Monthly Attendance Report')
@section('content')
<div class="bg-white rounded-2xl border p-6 mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Class</label><select name="class_id" required class="px-4 py-2.5 border rounded-xl text-sm"><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Month</label><select name="month" required class="px-4 py-2.5 border rounded-xl text-sm">@for($i=1;$i<=12;$i++)<option value="{{ $i }}" {{ request('month')==$i?'selected':'' }}>{{ date('F', mktime(0,0,0,$i)) }}</option>@endfor</select></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Year</label><input type="number" name="year" value="{{ request('year', date('Y')) }}" required class="px-4 py-2.5 border rounded-xl text-sm w-24"></div>
        <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl">Generate</button>
    </form>
</div>
@if($report->count())
<div class="bg-white rounded-2xl border p-6">
    <div class="flex justify-between mb-4"><h3 class="font-semibold">Attendance Report</h3><button onclick="window.print()" class="px-3 py-1.5 bg-gray-100 text-gray-700 text-sm rounded-lg no-print"><i class="fas fa-print mr-1"></i>Print</button></div>
    <table class="w-full text-sm"><thead><tr class="text-left text-gray-500 bg-gray-50 border-b"><th class="px-4 py-3">#</th><th class="px-4 py-3">Student</th><th class="px-4 py-3">Present</th><th class="px-4 py-3">Absent</th><th class="px-4 py-3">Late</th><th class="px-4 py-3">Total</th><th class="px-4 py-3">%</th></tr></thead>
    <tbody>@foreach($report as $i => $r)
        <tr class="border-b border-gray-50"><td class="px-4 py-3">{{ $i+1 }}</td><td class="px-4 py-3 font-medium">{{ $r['student']->full_name }}</td>
        <td class="px-4 py-3 text-emerald-600 font-medium">{{ $r['present'] }}</td><td class="px-4 py-3 text-red-600 font-medium">{{ $r['absent'] }}</td><td class="px-4 py-3 text-amber-600 font-medium">{{ $r['late'] }}</td><td class="px-4 py-3">{{ $r['total_days'] }}</td>
        <td class="px-4 py-3 font-medium">{{ $r['total_days']>0 ? round(($r['present']/$r['total_days'])*100, 1).'%' : '-' }}</td></tr>
    @endforeach</tbody></table>
</div>
@endif
@endsection

@extends('layouts.app')
@section('title', 'Due Report')
@section('page-title', 'Fee Due Report')
@section('content')
<div class="bg-white rounded-2xl border shadow-sm">
    <div class="p-6 border-b"><h3 class="text-lg font-semibold">Outstanding Dues</h3></div>
    <div class="overflow-x-auto"><table class="w-full text-sm"><thead><tr class="text-left text-gray-500 bg-gray-50 border-b"><th class="px-6 py-3">Student</th><th class="px-6 py-3">Class</th><th class="px-6 py-3">Invoice</th><th class="px-6 py-3">Total</th><th class="px-6 py-3">Due</th><th class="px-6 py-3">Due Date</th></tr></thead>
    <tbody>@forelse($invoices as $inv)
        <tr class="border-b border-gray-50"><td class="px-6 py-4 font-medium">{{ $inv->student->full_name ?? 'N/A' }}</td><td class="px-6 py-4 text-gray-600">{{ $inv->schoolClass->name ?? '' }}</td><td class="px-6 py-4 font-mono text-xs">{{ $inv->invoice_no }}</td><td class="px-6 py-4">{{ number_format($inv->total,2) }}</td><td class="px-6 py-4 text-red-600 font-bold">{{ number_format($inv->due_amount,2) }}</td><td class="px-6 py-4 {{ $inv->due_date->isPast()?'text-red-600':'text-gray-600' }}">{{ $inv->due_date->format('M d, Y') }}</td></tr>
    @empty<tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">No outstanding dues</td></tr>@endforelse</tbody></table></div>
    <div class="p-6">{{ $invoices->links() }}</div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Fee Invoices')
@section('page-title', 'Fee & Billing Management')
@section('content')
<div class="flex gap-3 mb-5">
    <a href="{{ route('fees.invoices') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl font-medium">Invoices</a>
    <a href="{{ route('fees.categories') }}" class="px-4 py-2 bg-white text-gray-700 text-sm rounded-xl border hover:bg-gray-50">Categories</a>
    <a href="{{ route('fees.due_report') }}" class="px-4 py-2 bg-white text-gray-700 text-sm rounded-xl border hover:bg-gray-50">Due Report</a>
</div>
<div class="bg-white rounded-2xl border shadow-sm">
    <div class="flex items-center justify-between p-6 border-b"><h3 class="text-lg font-semibold">All Invoices</h3><a href="{{ route('fees.invoices.create') }}" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl"><i class="fas fa-plus mr-1"></i> Create Invoice</a></div>
    <div class="p-6 border-b bg-gray-50/50"><form method="GET" class="flex flex-wrap gap-3"><input type="text" name="search" value="{{ request('search') }}" placeholder="Search student..." class="px-4 py-2 border rounded-xl text-sm w-48"><select name="status" class="px-4 py-2 border rounded-xl text-sm"><option value="">All Status</option><option value="paid" {{ request('status')=='paid'?'selected':'' }}>Paid</option><option value="unpaid" {{ request('status')=='unpaid'?'selected':'' }}>Unpaid</option><option value="partial" {{ request('status')=='partial'?'selected':'' }}>Partial</option><option value="overdue" {{ request('status')=='overdue'?'selected':'' }}>Overdue</option></select><button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-xl">Filter</button></form></div>
    <div class="overflow-x-auto"><table class="w-full text-sm"><thead><tr class="text-left text-gray-500 bg-gray-50 border-b"><th class="px-6 py-3">Invoice</th><th class="px-6 py-3">Student</th><th class="px-6 py-3">Category</th><th class="px-6 py-3">Total</th><th class="px-6 py-3">Paid</th><th class="px-6 py-3">Due</th><th class="px-6 py-3">Status</th><th class="px-6 py-3">Actions</th></tr></thead>
    <tbody>@forelse($invoices as $inv)
        <tr class="border-b border-gray-50"><td class="px-6 py-4 font-mono text-xs">{{ $inv->invoice_no }}</td><td class="px-6 py-4 font-medium">{{ $inv->student->full_name ?? 'N/A' }}</td><td class="px-6 py-4 text-gray-600">{{ $inv->feeCategory->name ?? 'N/A' }}</td><td class="px-6 py-4 font-medium">{{ number_format($inv->total, 2) }}</td><td class="px-6 py-4 text-emerald-600">{{ number_format($inv->paid_amount, 2) }}</td><td class="px-6 py-4 text-red-600 font-medium">{{ number_format($inv->due_amount, 2) }}</td>
        <td class="px-6 py-4"><span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $inv->status=='paid'?'bg-emerald-100 text-emerald-700':($inv->status=='overdue'?'bg-red-100 text-red-700':($inv->status=='partial'?'bg-amber-100 text-amber-700':'bg-gray-100 text-gray-700')) }}">{{ ucfirst($inv->status) }}</span></td>
        <td class="px-6 py-4"><a href="{{ route('fees.invoices.show', $inv) }}" class="p-2 text-gray-400 hover:text-indigo-600"><i class="fas fa-eye"></i></a></td></tr>
    @empty<tr><td colspan="8" class="px-6 py-12 text-center text-gray-400">No invoices</td></tr>@endforelse</tbody></table></div>
    <div class="p-6">{{ $invoices->links() }}</div>
</div>
@endsection

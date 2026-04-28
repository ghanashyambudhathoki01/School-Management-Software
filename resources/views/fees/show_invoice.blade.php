@extends('layouts.app')
@section('title', 'Invoice Details')
@section('page-title', 'Invoice #'.$invoice->invoice_no)
@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border p-6 mb-5 print-full">
        <div class="flex justify-between items-start mb-6"><div><h2 class="text-xl font-bold text-gray-800">Invoice</h2><p class="text-sm text-gray-500">{{ $invoice->invoice_no }}</p></div><span class="text-xs font-medium px-3 py-1.5 rounded-full {{ $invoice->status=='paid'?'bg-emerald-100 text-emerald-700':'bg-red-100 text-red-700' }}">{{ ucfirst($invoice->status) }}</span></div>
        <div class="grid grid-cols-2 gap-4 text-sm mb-6">
            <div><p class="text-gray-500">Student</p><p class="font-medium">{{ $invoice->student->full_name ?? 'N/A' }}</p></div>
            <div><p class="text-gray-500">Class</p><p class="font-medium">{{ $invoice->schoolClass->name ?? 'N/A' }}</p></div>
            <div><p class="text-gray-500">Category</p><p class="font-medium">{{ $invoice->feeCategory->name ?? 'N/A' }}</p></div>
            <div><p class="text-gray-500">Issue Date</p><p class="font-medium">{{ $invoice->issue_date->format('M d, Y') }}</p></div>
        </div>
        <table class="w-full text-sm mb-6"><tbody>
            <tr class="border-b"><td class="py-2 text-gray-500">Amount</td><td class="py-2 text-right">{{ number_format($invoice->amount,2) }}</td></tr>
            <tr class="border-b"><td class="py-2 text-gray-500">Discount</td><td class="py-2 text-right text-emerald-600">-{{ number_format($invoice->discount,2) }}</td></tr>
            <tr class="border-b"><td class="py-2 text-gray-500">Fine</td><td class="py-2 text-right text-red-600">+{{ number_format($invoice->fine,2) }}</td></tr>
            <tr class="border-b font-bold"><td class="py-2">Total</td><td class="py-2 text-right">{{ number_format($invoice->total,2) }}</td></tr>
            <tr class="border-b"><td class="py-2 text-emerald-600">Paid</td><td class="py-2 text-right text-emerald-600">{{ number_format($invoice->paid_amount,2) }}</td></tr>
            <tr class="font-bold text-lg"><td class="py-2 text-red-600">Due</td><td class="py-2 text-right text-red-600">{{ number_format($invoice->due_amount,2) }}</td></tr>
        </tbody></table>
        <button onclick="window.print()" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-xl no-print"><i class="fas fa-print mr-1"></i>Print Receipt</button>
    </div>
    @if($invoice->due_amount > 0)
    <div class="bg-white rounded-2xl border p-6 no-print">
        <h3 class="font-semibold mb-4">Record Payment</h3>
        <form method="POST" action="{{ route('fees.invoices.pay', $invoice) }}" class="space-y-3">@csrf
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium mb-1">Amount *</label><input type="number" name="amount" step="0.01" max="{{ $invoice->due_amount }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
                <div><label class="block text-sm font-medium mb-1">Method</label><select name="payment_method" class="w-full px-4 py-2.5 border rounded-xl text-sm"><option value="cash">Cash</option><option value="bank_transfer">Bank Transfer</option><option value="cheque">Cheque</option><option value="online">Online</option></select></div>
            </div>
            <div><label class="block text-sm font-medium mb-1">Date *</label><input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">Remarks</label><input type="text" name="remarks" class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-xl">Record Payment</button>
        </form>
    </div>
    @endif
    @if($invoice->payments->count())
    <div class="mt-5 bg-white rounded-2xl border p-6">
        <h3 class="font-semibold mb-4">Payment History</h3>
        @foreach($invoice->payments as $p)
        <div class="flex justify-between py-3 border-b border-gray-50 text-sm"><div><p class="font-medium">{{ number_format($p->amount,2) }}</p><p class="text-xs text-gray-500">{{ ucfirst($p->payment_method) }} | {{ $p->payment_date->format('M d, Y') }}</p></div><span class="text-emerald-600 font-medium text-xs">Paid</span></div>
        @endforeach
    </div>
    @endif
</div>
@endsection

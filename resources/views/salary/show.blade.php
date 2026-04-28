@extends('layouts.app')
@section('title', 'Salary Details')
@section('page-title', 'Salary Payslip')
@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl border shadow-sm p-8 print-full" id="payslip">
            <div class="flex justify-between items-start border-b pb-6 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">PAYSLIP</h2>
                    <p class="text-gray-500">{{ $salary->month }} {{ $salary->year }}</p>
                </div>
                <div class="text-right">
                    <h3 class="text-lg font-bold text-indigo-600">
                        {{ \App\Models\Setting::get('school_name', 'Gorkhabyte Academy') }}</h3>
                    <p class="text-xs text-gray-400">School Management System</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 mb-8">
                <div>
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Employee Details</h4>
                    <div class="space-y-1">
                        <p class="text-sm font-semibold text-gray-800">{{ $salary->teacher->full_name }}</p>
                        <p class="text-xs text-gray-500">ID: {{ $salary->teacher->employee_id }}</p>
                        <p class="text-xs text-gray-500">Dept: {{ $salary->teacher->department ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">Designation: {{ $salary->teacher->designation ?? 'N/A' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Payment Details</h4>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-800">Status: <span
                                class="font-bold {{ $salary->payment_status == 'paid' ? 'text-emerald-600' : 'text-amber-600' }}">{{ $salary->payment_status == 'pending_payment' ? 'Pending Payment' : ucfirst($salary->payment_status) }}</span>
                        </p>
                        <p class="text-xs text-gray-500">Method: {{ ucfirst($salary->payment_method ?? 'N/A') }}</p>
                        <p class="text-xs text-gray-500">Paid Date:
                            {{ $salary->payment_date ? $salary->payment_date->format('M d, Y') : '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="border rounded-xl overflow-hidden mb-6">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold text-gray-600">Description</th>
                            <th class="px-4 py-2 text-right font-semibold text-gray-600">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <tr>
                            <td class="px-4 py-3 text-gray-700">Basic Salary</td>
                            <td class="px-4 py-3 text-right">{{ number_format($salary->basic_salary, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-gray-700">Bonus (+)</td>
                            <td class="px-4 py-3 text-right text-emerald-600">{{ number_format($salary->bonus, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 text-gray-700">Deductions (-)</td>
                            <td class="px-4 py-3 text-right text-red-600">{{ number_format($salary->deductions, 2) }}</td>
                        </tr>
                        <tr class="bg-indigo-50 font-bold">
                            <td class="px-4 py-3 text-indigo-900">Net Salary</td>
                            <td class="px-4 py-3 text-right text-indigo-900">{{ number_format($salary->net_salary, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if($salary->remarks)
                <div class="mb-6">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Remarks</p>
                    <p class="text-xs text-gray-600 italic">{{ $salary->remarks }}</p>
                </div>
            @endif

            <div class="flex justify-between items-end mt-12 pt-6 border-t border-dashed no-print">
                <a href="{{ route('salary.index') }}" class="text-sm text-gray-500 hover:text-gray-700"><i
                        class="fas fa-arrow-left mr-1"></i> Back to Salary List</a>
                <div class="flex gap-2">
                    <button onclick="window.print()"
                        class="px-4 py-2 bg-gray-800 text-white text-sm rounded-xl hover:bg-gray-700 transition"><i
                            class="fas fa-print mr-1"></i> Print Payslip</button>
                    @if($salary->payment_status != 'paid')
                        <form method="POST" action="{{ route('salary.pay', $salary) }}">
                            @csrf @method('PATCH')
                            <button type="submit"
                                class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-xl hover:bg-emerald-700 transition"><i
                                    class="fas fa-check mr-1"></i> Mark as Paid</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
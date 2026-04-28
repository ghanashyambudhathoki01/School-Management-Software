@extends('layouts.app')
@section('title', 'Financial Accounts')
@section('page-title', 'Financial Overview')
@section('content')
<div class="bg-white rounded-2xl border shadow-sm p-6 mb-5">
    <form method="GET" class="flex gap-3 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
            <select name="month" class="px-4 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $i => $m)
                    <option value="{{ $i+1 }}" {{ $month == $i+1 ? 'selected' : '' }}>{{ $m }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
            <input type="number" name="year" value="{{ $year }}" class="px-4 py-2 border rounded-xl text-sm w-24 focus:ring-2 focus:ring-indigo-500">
        </div>
        <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl">Generate Report</button>
        <button type="button" onclick="window.print()" class="px-4 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl no-print"><i class="fas fa-print mr-1"></i> Print</button>
    </form>
</div>

{{-- Summary Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <div class="flex items-center gap-4 mb-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600"><i class="fas fa-money-bill-wave"></i></div>
            <p class="text-sm font-medium text-gray-500">Fee Income</p>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($totalFeeIncome, 2) }}</p>
    </div>
    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <div class="flex items-center gap-4 mb-3">
            <div class="w-10 h-10 rounded-xl bg-teal-100 flex items-center justify-center text-teal-600"><i class="fas fa-plus-circle"></i></div>
            <p class="text-sm font-medium text-gray-500">Other Income</p>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($totalIncome, 2) }}</p>
    </div>
    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <div class="flex items-center gap-4 mb-3">
            <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center text-red-600"><i class="fas fa-minus-circle"></i></div>
            <p class="text-sm font-medium text-gray-500">Expenses</p>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($totalExpense, 2) }}</p>
    </div>
    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <div class="flex items-center gap-4 mb-3">
            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600"><i class="fas fa-user-tie"></i></div>
            <p class="text-sm font-medium text-gray-500">Salaries Paid</p>
        </div>
        <p class="text-2xl font-bold text-gray-800">{{ number_format($totalSalary, 2) }}</p>
    </div>
</div>

{{-- Net Balance --}}
<div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl p-8 text-white shadow-lg mb-8">
    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <p class="text-indigo-100 font-medium mb-1">Net Balance for {{ date('F Y', mktime(0,0,0,$month,1,$year)) }}</p>
            <h2 class="text-4xl font-bold">
                @php $balance = ($totalFeeIncome + $totalIncome) - ($totalExpense + $totalSalary); @endphp
                {{ number_format($balance, 2) }}
            </h2>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('accounts.incomes') }}" class="px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-xl font-bold transition">Manage Incomes</a>
            <a href="{{ route('accounts.expenses') }}" class="px-6 py-3 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-xl font-bold transition">Manage Expenses</a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- Recent Incomes --}}
    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Recent Incomes</h3>
            <i class="fas fa-arrow-up text-emerald-500"></i>
        </div>
        <table class="w-full text-sm">
            <tbody class="divide-y">
                @forelse($recentIncomes as $inc)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800">{{ $inc->title }}</p>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wider">{{ $inc->category }}</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <p class="font-bold text-emerald-600">+{{ number_format($inc->amount, 2) }}</p>
                            <p class="text-[10px] text-gray-400">{{ $inc->date->format('M d, Y') }}</p>
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-6 py-8 text-center text-gray-400">No recent income found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Recent Expenses --}}
    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
            <h3 class="font-bold text-gray-800">Recent Expenses</h3>
            <i class="fas fa-arrow-down text-red-500"></i>
        </div>
        <table class="w-full text-sm">
            <tbody class="divide-y">
                @forelse($recentExpenses as $exp)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <p class="font-medium text-gray-800">{{ $exp->title }}</p>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wider">{{ $exp->category }}</p>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <p class="font-bold text-red-600">-{{ number_format($exp->amount, 2) }}</p>
                            <p class="text-[10px] text-gray-400">{{ $exp->date->format('M d, Y') }}</p>
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-6 py-8 text-center text-gray-400">No recent expenses found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

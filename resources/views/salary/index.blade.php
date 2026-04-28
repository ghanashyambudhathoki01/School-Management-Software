@extends('layouts.app')
@section('title', 'Salary Management')
@section('page-title', 'Teacher Salary Management')
@section('content')
<div class="bg-white rounded-2xl border shadow-sm p-6 mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
            <select name="month" class="px-4 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">All Months</option>
                @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
            <input type="number" name="year" value="{{ request('year', date('Y')) }}" class="px-4 py-2 border rounded-xl text-sm w-24 focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="px-4 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">All Status</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="pending_payment" {{ request('status') == 'pending_payment' ? 'selected' : '' }}>Pending Payment</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition">Filter</button>
        <a href="{{ route('salary.create') }}" class="px-4 py-2.5 bg-emerald-600 text-white text-sm rounded-xl hover:bg-emerald-700 transition"><i class="fas fa-plus mr-1"></i> Add Record</a>
    </form>
</div>

<div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-gray-500 bg-gray-50 border-b">
                <th class="px-6 py-4 font-medium">Teacher</th>
                <th class="px-6 py-4 font-medium">Month/Year</th>
                <th class="px-6 py-4 font-medium">Basic Salary</th>
                <th class="px-6 py-4 font-medium">Net Salary</th>
                <th class="px-6 py-4 font-medium">Status</th>
                <th class="px-6 py-4 font-medium">Payment Date</th>
                <th class="px-6 py-4 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-800">{{ $record->teacher->full_name ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500">{{ $record->teacher->employee_id ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $record->month }} {{ $record->year }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ number_format($record->basic_salary, 2) }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800">{{ number_format($record->net_salary, 2) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $record->payment_status == 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $record->payment_status == 'pending_payment' ? 'Pending Payment' : ucfirst($record->payment_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $record->payment_date ? $record->payment_date->format('M d, Y') : '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('salary.show', $record) }}" class="p-2 text-gray-400 hover:text-indigo-600 transition" title="View"><i class="fas fa-eye"></i></a>
                            @if($record->payment_status != 'paid')
                                <form method="POST" action="{{ route('salary.pay', $record) }}" onsubmit="return confirm('Mark as paid?')">
                                    @csrf @method('PATCH')
                                    <button class="p-2 text-gray-400 hover:text-emerald-600 transition" title="Mark as Paid"><i class="fas fa-check-circle"></i></button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('salary.destroy', $record) }}" onsubmit="return confirm('Delete this record?')">
                                @csrf @method('DELETE')
                                <button class="p-2 text-gray-400 hover:text-red-600 transition" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">No salary records found</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-6 border-t">{{ $records->links() }}</div>
</div>
@endsection

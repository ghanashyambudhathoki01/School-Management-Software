@extends('layouts.app')
@section('title', 'Manage Incomes')
@section('page-title', 'Income Records')
@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border shadow-sm p-6 sticky top-24">
            <h3 class="font-bold text-gray-800 mb-4">Add Other Income</h3>
            <form method="POST" action="{{ route('accounts.incomes.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Income Title *</label>
                    <input type="text" name="title" required class="w-full px-4 py-2 border rounded-xl text-sm" placeholder="e.g. Canteen Rent">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Category *</label>
                    <select name="category" required class="w-full px-4 py-2 border rounded-xl text-sm">
                        <option value="rent">Rent</option>
                        <option value="donation">Donation</option>
                        <option value="sale">Asset Sale</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Amount *</label>
                    <input type="number" name="amount" step="0.01" required class="w-full px-4 py-2 border rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Date *</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2 border rounded-xl text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Description</label>
                    <textarea name="description" rows="2" class="w-full px-4 py-2 border rounded-xl text-sm"></textarea>
                </div>
                <button type="submit" class="w-full py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition">Save Income</button>
            </form>
        </div>
    </div>
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-800">Income Log</h3>
                <form method="GET" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="px-3 py-1.5 border rounded-lg text-xs">
                    <button class="px-3 py-1.5 bg-gray-800 text-white text-xs rounded-lg">Go</button>
                </form>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left bg-gray-50 text-gray-500 border-b">
                        <th class="px-6 py-4 font-medium">Title/Date</th>
                        <th class="px-6 py-4 font-medium">Category</th>
                        <th class="px-6 py-4 font-medium">Amount</th>
                        <th class="px-6 py-4 font-medium">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($incomes as $inc)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800">{{ $inc->title }}</p>
                                <p class="text-[10px] text-gray-400">{{ $inc->date->format('M d, Y') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-[10px] font-bold uppercase">{{ $inc->category }}</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-emerald-600">{{ number_format($inc->amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('accounts.incomes.delete', $inc) }}" onsubmit="return confirm('Delete record?')">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-400 hover:text-red-600 transition"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-12 text-center text-gray-400">No records found</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-6 border-t">{{ $incomes->links() }}</div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Fee Categories')
@section('page-title', 'Fee Categories')
@section('content')
<div class="flex gap-3 mb-5">
    <a href="{{ route('fees.invoices') }}" class="px-4 py-2 bg-white text-gray-700 text-sm rounded-xl border">Invoices</a>
    <a href="{{ route('fees.categories') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl font-medium">Categories</a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
    <div class="bg-white rounded-2xl border p-6">
        <h3 class="font-semibold mb-4">Add Category</h3>
        <form method="POST" action="{{ route('fees.categories.store') }}" class="space-y-3">@csrf
            <input type="text" name="name" placeholder="Category Name" required class="w-full px-4 py-2.5 border rounded-xl text-sm">
            <input type="number" name="amount" placeholder="Amount" step="0.01" required class="w-full px-4 py-2.5 border rounded-xl text-sm">
            <select name="frequency" class="w-full px-4 py-2.5 border rounded-xl text-sm"><option value="monthly">Monthly</option><option value="quarterly">Quarterly</option><option value="yearly">Yearly</option><option value="one_time">One Time</option></select>
            <textarea name="description" placeholder="Description" rows="2" class="w-full px-4 py-2.5 border rounded-xl text-sm"></textarea>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl">Add Category</button>
        </form>
    </div>
    <div class="bg-white rounded-2xl border p-6">
        <h3 class="font-semibold mb-4">All Categories</h3>
        @forelse($categories as $cat)
        <div class="flex items-center justify-between py-3 border-b border-gray-50 last:border-0">
            <div><p class="font-medium text-gray-800">{{ $cat->name }}</p><p class="text-xs text-gray-500">{{ ucfirst($cat->frequency) }} | {{ number_format($cat->amount, 2) }}</p></div>
            <form method="POST" action="{{ route('fees.categories.delete', $cat) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="p-2 text-gray-400 hover:text-red-600"><i class="fas fa-trash"></i></button></form>
        </div>
        @empty<p class="text-gray-400 text-sm text-center py-4">No categories</p>@endforelse
        <div class="mt-4">{{ $categories->links() }}</div>
    </div>
</div>
@endsection

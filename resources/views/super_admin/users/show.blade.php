@extends('layouts.app')
@section('title', 'User Details')
@section('page-title', 'User Details')

@section('content')
<div class="max-w-2xl bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <div class="flex items-center gap-4 mb-6">
        <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
        <div>
            <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
            <p class="text-gray-500">{{ $user->email }}</p>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-4 text-sm">
        <div class="bg-gray-50 rounded-xl p-3"><span class="text-gray-500 block">Role</span><span class="font-medium capitalize">{{ str_replace('_',' ',$user->role) }}</span></div>
        <div class="bg-gray-50 rounded-xl p-3"><span class="text-gray-500 block">Status</span><span class="font-medium capitalize">{{ $user->access_status }}</span></div>
        <div class="bg-gray-50 rounded-xl p-3"><span class="text-gray-500 block">Phone</span><span class="font-medium">{{ $user->phone ?: 'N/A' }}</span></div>
        <div class="bg-gray-50 rounded-xl p-3"><span class="text-gray-500 block">Account Start</span><span class="font-medium">{{ $user->account_start_date ? $user->account_start_date->format('M d, Y') : 'N/A' }}</span></div>
        <div class="bg-gray-50 rounded-xl p-3"><span class="text-gray-500 block">Expiry Date</span><span class="font-medium">{{ $user->account_expiry_date ? $user->account_expiry_date->format('M d, Y') : 'N/A' }}</span></div>
        <div class="bg-gray-50 rounded-xl p-3"><span class="text-gray-500 block">Days Remaining</span><span class="font-medium">{{ $user->daysUntilExpiry() ?? 'N/A' }} days</span></div>
    </div>
    <div class="mt-6 flex gap-3">
        <a href="{{ route('super_admin.users.edit', $user) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition"><i class="fas fa-edit mr-1"></i> Edit</a>
        <a href="{{ route('super_admin.users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-xl hover:bg-gray-300 transition">Back</a>
    </div>
</div>
@endsection

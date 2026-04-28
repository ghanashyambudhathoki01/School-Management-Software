@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form method="POST" action="{{ route('super_admin.users.update', $user) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">New Password (leave blank to keep)</label>
                    <input type="password" name="password" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                    <input type="file" name="photo" accept="image/*" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea name="address" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('address', $user->address) }}</textarea>
            </div>

            {{-- Account Status Info --}}
            <div class="bg-gray-50 rounded-xl p-4">
                <h4 class="font-medium text-gray-800 mb-3">Account Status</h4>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div><span class="text-gray-500">Role:</span> <span class="capitalize font-medium">{{ str_replace('_',' ',$user->role) }}</span></div>
                    <div><span class="text-gray-500">Status:</span> <span class="capitalize font-medium">{{ $user->access_status }}</span></div>
                    <div><span class="text-gray-500">Start:</span> {{ $user->account_start_date ? $user->account_start_date->format('M d, Y') : 'N/A' }}</div>
                    <div><span class="text-gray-500">Expiry:</span> {{ $user->account_expiry_date ? $user->account_expiry_date->format('M d, Y') : 'N/A' }}</div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition"><i class="fas fa-save mr-2"></i>Update User</button>
                <a href="{{ route('super_admin.users.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl hover:bg-gray-300 transition">Cancel</a>
            </div>
        </form>
    </div>

    {{-- Quick Actions --}}
    <div class="mt-5 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h4 class="font-semibold text-gray-800 mb-4">Quick Actions</h4>
        <div class="flex flex-wrap gap-3">
            <form method="POST" action="{{ route('super_admin.users.renew', $user) }}">@csrf @method('PATCH')
                <button class="px-4 py-2 bg-blue-600 text-white text-sm rounded-xl hover:bg-blue-700 transition"><i class="fas fa-sync mr-1"></i> Renew 1 Year</button></form>
            <form method="POST" action="{{ route('super_admin.users.activate', $user) }}">@csrf @method('PATCH')
                <button class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-xl hover:bg-emerald-700 transition"><i class="fas fa-check mr-1"></i> Activate</button></form>
            <form method="POST" action="{{ route('super_admin.users.suspend', $user) }}">@csrf @method('PATCH')
                <button class="px-4 py-2 bg-orange-600 text-white text-sm rounded-xl hover:bg-orange-700 transition"><i class="fas fa-pause mr-1"></i> Suspend</button></form>
            <form method="POST" action="{{ route('super_admin.users.disable', $user) }}">@csrf @method('PATCH')
                <button class="px-4 py-2 bg-gray-600 text-white text-sm rounded-xl hover:bg-gray-700 transition"><i class="fas fa-ban mr-1"></i> Disable</button></form>
        </div>
        {{-- Custom Extension --}}
        <form method="POST" action="{{ route('super_admin.users.extend', $user) }}" class="mt-4 flex gap-3 items-end">
            @csrf @method('PATCH')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Custom Extend (days)</label>
                <input type="number" name="days" min="1" max="3650" value="90" class="px-4 py-2 border border-gray-200 rounded-xl text-sm w-32">
            </div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition">Extend</button>
        </form>
    </div>
</div>
@endsection

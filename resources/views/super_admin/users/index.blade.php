@extends('layouts.app')
@section('title', 'User Management')
@section('page-title', 'User Management')
@section('page-description', 'Manage School Admin & Teacher Accounts')

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-6 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800">All Users</h3>
        <a href="{{ route('super_admin.users.create') }}" class="mt-3 sm:mt-0 inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition">
            <i class="fas fa-plus"></i> Add User
        </a>
    </div>

    {{-- Filters --}}
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email..." class="px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent w-64">
            <select name="role" class="px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">All Roles</option>
                <option value="school_admin" {{ request('role')=='school_admin'?'selected':'' }}>School Admin</option>
                <option value="teacher" {{ request('role')=='teacher'?'selected':'' }}>Teacher</option>
            </select>
            <select name="status" class="px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">All Status</option>
                <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                <option value="suspended" {{ request('status')=='suspended'?'selected':'' }}>Suspended</option>
                <option value="disabled" {{ request('status')=='disabled'?'selected':'' }}>Disabled</option>
                <option value="expired" {{ request('status')=='expired'?'selected':'' }}>Expired</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-xl hover:bg-gray-700 transition">Filter</button>
            <a href="{{ route('super_admin.users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-xl hover:bg-gray-300 transition">Reset</a>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-gray-500 bg-gray-50 border-b">
                <th class="px-6 py-3 font-medium">User</th>
                <th class="px-6 py-3 font-medium">Role</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 font-medium">Expiry Date</th>
                <th class="px-6 py-3 font-medium">Days Left</th>
                <th class="px-6 py-3 font-medium">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                            <div><p class="font-medium text-gray-800">{{ $user->name }}</p><p class="text-xs text-gray-500">{{ $user->email }}</p></div>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="capitalize text-xs font-medium px-2.5 py-1 rounded-full {{ $user->role=='school_admin' ? 'bg-purple-100 text-purple-700' : 'bg-sky-100 text-sky-700' }}">{{ str_replace('_',' ',$user->role) }}</span></td>
                    <td class="px-6 py-4"><span class="text-xs font-medium px-2.5 py-1 rounded-full
                        {{ $user->access_status=='active' ? 'bg-emerald-100 text-emerald-700' : '' }}
                        {{ $user->access_status=='suspended' ? 'bg-orange-100 text-orange-700' : '' }}
                        {{ $user->access_status=='disabled' ? 'bg-gray-100 text-gray-700' : '' }}
                        {{ $user->access_status=='expired' ? 'bg-red-100 text-red-700' : '' }}
                        ">{{ ucfirst($user->access_status) }}</span></td>
                    <td class="px-6 py-4 text-gray-600">{{ $user->account_expiry_date ? $user->account_expiry_date->format('M d, Y') : 'N/A' }}</td>
                    <td class="px-6 py-4">
                        @if($user->daysUntilExpiry() !== null)
                            <span class="font-semibold {{ $user->daysUntilExpiry() <= 0 ? 'text-red-600' : ($user->daysUntilExpiry() <= 30 ? 'text-amber-600' : 'text-emerald-600') }}">{{ $user->daysUntilExpiry() }} days</span>
                        @else N/A @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1">
                            <a href="{{ route('super_admin.users.edit', $user) }}" class="p-2 text-gray-400 hover:text-indigo-600 transition" title="Edit"><i class="fas fa-edit"></i></a>
                            @if($user->access_status !== 'active')
                                <form method="POST" action="{{ route('super_admin.users.activate', $user) }}" class="inline">@csrf @method('PATCH')<button class="p-2 text-gray-400 hover:text-emerald-600 transition" title="Activate"><i class="fas fa-check-circle"></i></button></form>
                            @endif
                            @if($user->access_status === 'active')
                                <form method="POST" action="{{ route('super_admin.users.suspend', $user) }}" class="inline">@csrf @method('PATCH')<button class="p-2 text-gray-400 hover:text-orange-600 transition" title="Suspend"><i class="fas fa-pause-circle"></i></button></form>
                            @endif
                            <form method="POST" action="{{ route('super_admin.users.renew', $user) }}" class="inline">@csrf @method('PATCH')<button class="p-2 text-gray-400 hover:text-blue-600 transition" title="Renew 1 Year"><i class="fas fa-sync"></i></button></form>
                            <form method="POST" action="{{ route('super_admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Delete this user?')">@csrf @method('DELETE')<button class="p-2 text-gray-400 hover:text-red-600 transition" title="Delete"><i class="fas fa-trash"></i></button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">No users found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6">{{ $users->links() }}</div>
</div>
@endsection

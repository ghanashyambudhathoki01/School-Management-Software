@extends('layouts.app')
@section('title', 'Super Admin Dashboard')
@section('page-title', 'My Dashboard')
@section('page-description', 'Welcome back, ' . Auth::user()->name)

@section('content')
    {{-- Welcome Banner --}}
    <div
        class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 to-violet-700 p-8 mb-8 text-white shadow-lg">
        <div class="relative z-10">
            <h2 class="text-3xl font-bold mb-2">Hello, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-indigo-100 max-w-xl text-lg">Manage your educational ecosystem with ease. Here is what's
                happening across the system today.</p>
        </div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 mr-32 -mb-12 w-48 h-48 bg-indigo-500/20 rounded-full blur-2xl"></div>
        <i class="fas fa-rocket absolute right-12 top-1/2 -translate-y-1/2 text-white/10 text-9xl -rotate-12"></i>
    </div>
    {{-- User Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-indigo-100 flex items-center justify-center"><i
                        class="fas fa-users text-indigo-600"></i></div>
                <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full">System Wide</span>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalUsers) }}</p>
            <p class="text-sm text-gray-500 mt-1">Total System Users</p>
        </div>
        <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-purple-100 flex items-center justify-center"><i
                        class="fas fa-user-shield text-purple-600"></i></div>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalSchoolAdmins) }}</p>
            <p class="text-sm text-gray-500 mt-1">School Administrators</p>
        </div>
        <div class="stat-card bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-sky-100 flex items-center justify-center"><i
                        class="fas fa-chalkboard-teacher text-sky-600"></i></div>
            </div>
            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalTeachers) }}</p>
            <p class="text-sm text-gray-500 mt-1">Teachers</p>
        </div>
    </div>

    {{-- Account Alerts --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4"><i class="fas fa-exclamation-triangle text-amber-500 mr-2"></i>
            Account Status Alerts</h3>
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                <p class="text-2xl font-bold text-amber-600">{{ $expiringAccounts->count() }}</p>
                <p class="text-sm text-amber-700">Expiring Soon</p>
            </div>
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <p class="text-2xl font-bold text-red-600">{{ $expiredAccounts }}</p>
                <p class="text-sm text-red-700">Expired Accounts</p>
            </div>
            <div class="bg-orange-50 border border-orange-200 rounded-xl p-4">
                <p class="text-2xl font-bold text-orange-600">{{ $suspendedAccounts }}</p>
                <p class="text-sm text-orange-700">Suspended</p>
            </div>
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                <p class="text-2xl font-bold text-gray-600">{{ $disabledAccounts }}</p>
                <p class="text-sm text-gray-700">Disabled</p>
            </div>
        </div>

        @if($expiringAccounts->count() > 0)
            <div class="mt-6">
                <p class="text-sm font-semibold text-gray-700 mb-3">Recently Expiring Accounts</p>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="pb-2 pr-4">User</th>
                                <th class="pb-2 pr-4">Role</th>
                                <th class="pb-2 pr-4">Expiry Date</th>
                                <th class="pb-2">Days Left</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expiringAccounts->take(5) as $account)
                                <tr class="border-b border-gray-50">
                                    <td class="py-2 pr-4 font-medium">{{ $account->name }}</td>
                                    <td class="py-2 pr-4 capitalize">{{ str_replace('_', ' ', $account->role) }}</td>
                                    <td class="py-2 pr-4">{{ $account->account_expiry_date->format('M d, Y') }}</td>
                                    <td class="py-2"><span class="text-amber-600 font-semibold">{{ $account->daysUntilExpiry() }}
                                            days</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    {{-- Recent User Registrations --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4"><i class="fas fa-user-plus text-indigo-500 mr-2"></i> Recent
            User Registrations</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 border-b">
                        <th class="pb-2 pr-4">User Name</th>
                        <th class="pb-2 pr-4">Role</th>
                        <th class="pb-2 pr-4">Joined At</th>
                        <th class="pb-2 text-right">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $user)
                        <tr class="border-b border-gray-50">
                            <td class="py-3 pr-4 font-medium">{{ $user->name }}</td>
                            <td class="py-3 pr-4"><span
                                    class="capitalize text-xs px-2 py-1 bg-gray-100 rounded-lg">{{ str_replace('_', ' ', $user->role) }}</span>
                            </td>
                            <td class="py-3 pr-4 text-gray-500">{{ $user->created_at->diffForHumans() }}</td>
                            <td class="py-3 text-right">
                                <span class="text-xs font-medium px-2 py-1 rounded-full 
                                    @if($user->access_status == 'active') bg-emerald-50 text-emerald-600 
                                    @elseif($user->access_status == 'suspended') bg-orange-50 text-orange-600 
                                    @else bg-gray-50 text-gray-600 @endif">
                                    {{ ucfirst($user->access_status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
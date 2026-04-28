@extends('layouts.app')
@section('title', 'General Settings')
@section('page-title', 'General Settings')
@section('content')
<div class="max-w-2xl bg-white rounded-2xl border shadow-sm p-6">
    <form method="POST" action="{{ route('super_admin.settings.update') }}" class="space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">School Name *</label>
            <input type="text" name="school_name" value="{{ old('school_name', $schoolName) }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500" placeholder="e.g. Springfield High School">
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Official Email</label>
                <input type="email" name="school_email" value="{{ old('school_email', $schoolEmail) }}" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500" placeholder="info@school.com">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Official Phone</label>
                <input type="text" name="school_phone" value="{{ old('school_phone', $schoolPhone) }}" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500" placeholder="+1 234 567 890">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
            <textarea name="school_address" rows="3" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500" placeholder="Full school address...">{{ old('school_address', $schoolAddress) }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition">Save Settings</button>
        </div>
    </form>
</div>
@endsection

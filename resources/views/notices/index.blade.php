@extends('layouts.app')
@section('title', 'Notice Board')
@section('page-title', 'Notice Board')
@section('content')
<div class="bg-white rounded-2xl border shadow-sm p-6 mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Notice title..." class="w-full px-4 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
            <select name="type" class="px-4 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">All Types</option>
                <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>General</option>
                <option value="teacher" {{ request('type') == 'teacher' ? 'selected' : '' }}>For Teachers</option>
                <option value="student" {{ request('type') == 'student' ? 'selected' : '' }}>For Students</option>
                <option value="urgent" {{ request('type') == 'urgent' ? 'selected' : '' }}>Urgent</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl">Filter</button>
        @if(Auth::user()->isSuperAdmin() || Auth::user()->isSchoolAdmin())
            <a href="{{ route('notices.create') }}" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition"><i class="fas fa-plus mr-1"></i> New Notice</a>
        @endif
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse($notices as $notice)
        <div class="bg-white rounded-2xl border shadow-sm p-6 flex flex-col hover:shadow-md transition">
            <div class="flex justify-between items-start mb-4">
                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                    {{ $notice->type == 'urgent' ? 'bg-red-100 text-red-600' : 
                       ($notice->type == 'general' ? 'bg-indigo-100 text-indigo-600' : 
                       ($notice->type == 'teacher' ? 'bg-purple-100 text-purple-600' : 'bg-sky-100 text-sky-600')) }}">
                    {{ $notice->type }}
                </span>
                <span class="text-xs text-gray-400">{{ $notice->publish_date->format('M d, Y') }}</span>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-1">{{ $notice->title }}</h3>
            <p class="text-sm text-gray-500 mb-6 line-clamp-3 flex-grow">{{ strip_tags($notice->message) }}</p>
            <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-50">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-[10px] font-bold">{{ strtoupper(substr($notice->publisher->name ?? 'A', 0, 1)) }}</div>
                    <span class="text-xs text-gray-500">{{ $notice->publisher->name ?? 'Admin' }}</span>
                </div>
                <div class="flex gap-1">
                    <a href="{{ route('notices.show', $notice) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="View"><i class="fas fa-eye text-sm"></i></a>
                    @if(Auth::user()->isSuperAdmin() || Auth::user()->isSchoolAdmin())
                        <a href="{{ route('notices.edit', $notice) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Edit"><i class="fas fa-edit text-sm"></i></a>
                        <form method="POST" action="{{ route('notices.destroy', $notice) }}" onsubmit="return confirm('Delete this notice?')">
                            @csrf @method('DELETE')
                            <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete"><i class="fas fa-trash text-sm"></i></button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full py-12 text-center text-gray-400">No notices found</div>
    @endforelse
</div>
<div class="mt-8">{{ $notices->links() }}</div>
@endsection

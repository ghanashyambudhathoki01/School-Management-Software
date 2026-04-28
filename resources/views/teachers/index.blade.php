@extends('layouts.app')
@section('title', 'Teachers')
@section('page-title', 'Teacher Management')
@section('content')
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-6 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800">All Teachers</h3>
        <a href="{{ route('teachers.create') }}" class="mt-3 sm:mt-0 inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition"><i class="fas fa-plus"></i> Add Teacher</a>
    </div>
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="px-4 py-2 border border-gray-200 rounded-xl text-sm w-64 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            <select name="status" class="px-4 py-2 border border-gray-200 rounded-xl text-sm"><option value="">All Status</option><option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option><option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option><option value="on_leave" {{ request('status')=='on_leave'?'selected':'' }}>On Leave</option></select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-xl">Filter</button>
            <a href="{{ route('teachers.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-xl">Reset</a>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-gray-500 bg-gray-50 border-b"><th class="px-6 py-3">Teacher</th><th class="px-6 py-3">Employee ID</th><th class="px-6 py-3">Department</th><th class="px-6 py-3">Phone</th><th class="px-6 py-3">Status</th><th class="px-6 py-3">Actions</th></tr></thead>
            <tbody>
                @forelse($teachers as $teacher)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50">
                    <td class="px-6 py-4"><div class="flex items-center gap-3"><div class="w-9 h-9 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-xs">{{ strtoupper(substr($teacher->first_name,0,1).substr($teacher->last_name,0,1)) }}</div><div><p class="font-medium text-gray-800">{{ $teacher->full_name }}</p><p class="text-xs text-gray-500">{{ $teacher->email }}</p></div></div></td>
                    <td class="px-6 py-4 text-gray-600 font-mono text-xs">{{ $teacher->employee_id }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $teacher->department ?: 'N/A' }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $teacher->phone ?: 'N/A' }}</td>
                    <td class="px-6 py-4"><span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $teacher->status=='active'?'bg-emerald-100 text-emerald-700':'bg-gray-100 text-gray-600' }}">{{ ucfirst($teacher->status) }}</span></td>
                    <td class="px-6 py-4"><div class="flex gap-1"><a href="{{ route('teachers.show', $teacher) }}" class="p-2 text-gray-400 hover:text-indigo-600"><i class="fas fa-eye"></i></a><a href="{{ route('teachers.edit', $teacher) }}" class="p-2 text-gray-400 hover:text-indigo-600"><i class="fas fa-edit"></i></a><form method="POST" action="{{ route('teachers.destroy', $teacher) }}" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="p-2 text-gray-400 hover:text-red-600"><i class="fas fa-trash"></i></button></form></div></td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">No teachers found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6">{{ $teachers->links() }}</div>
</div>
@endsection

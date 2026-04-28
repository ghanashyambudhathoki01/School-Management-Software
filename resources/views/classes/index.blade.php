@extends('layouts.app')
@section('title', 'Classes')
@section('page-title', 'Class Management')
@section('content')
<div class="bg-white rounded-2xl border shadow-sm">
    <div class="flex items-center justify-between p-6 border-b"><h3 class="text-lg font-semibold">All Classes</h3><a href="{{ route('classes.create') }}" class="px-4 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700"><i class="fas fa-plus mr-1"></i> Add Class</a></div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-gray-500 bg-gray-50 border-b"><th class="px-6 py-3">Class Name</th><th class="px-6 py-3">Numeric</th><th class="px-6 py-3">Sections</th><th class="px-6 py-3">Students</th><th class="px-6 py-3">Status</th><th class="px-6 py-3">Actions</th></tr></thead>
            <tbody>
                @forelse($classes as $class)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50">
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $class->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $class->numeric_name ?? '-' }}</td>
                    <td class="px-6 py-4"><span class="bg-indigo-50 text-indigo-600 px-2 py-1 rounded-full text-xs font-medium">{{ $class->sections_count }}</span></td>
                    <td class="px-6 py-4"><span class="bg-sky-50 text-sky-600 px-2 py-1 rounded-full text-xs font-medium">{{ $class->students_count }}</span></td>
                    <td class="px-6 py-4"><span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $class->status?'bg-emerald-100 text-emerald-700':'bg-gray-100 text-gray-600' }}">{{ $class->status?'Active':'Inactive' }}</span></td>
                    <td class="px-6 py-4"><div class="flex gap-1"><a href="{{ route('classes.edit', $class) }}" class="p-2 text-gray-400 hover:text-indigo-600"><i class="fas fa-edit"></i></a><form method="POST" action="{{ route('classes.destroy', $class) }}" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="p-2 text-gray-400 hover:text-red-600"><i class="fas fa-trash"></i></button></form></div></td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">No classes found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6">{{ $classes->links() }}</div>
</div>
@endsection

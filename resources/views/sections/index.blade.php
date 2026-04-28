@extends('layouts.app')
@section('title', 'Sections')
@section('page-title', 'Section Management')
@section('content')
<div class="bg-white rounded-2xl border shadow-sm">
    <div class="flex items-center justify-between p-6 border-b"><h3 class="text-lg font-semibold">All Sections</h3><a href="{{ route('sections.create') }}" class="px-4 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl"><i class="fas fa-plus mr-1"></i> Add Section</a></div>
    <div class="p-6 border-b bg-gray-50/50"><form method="GET" class="flex gap-3"><select name="class_id" class="px-4 py-2 border border-gray-200 rounded-xl text-sm" onchange="this.form.submit()"><option value="">All Classes</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select></form></div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-gray-500 bg-gray-50 border-b"><th class="px-6 py-3">Section</th><th class="px-6 py-3">Class</th><th class="px-6 py-3">Capacity</th><th class="px-6 py-3">Students</th><th class="px-6 py-3">Actions</th></tr></thead>
            <tbody>
                @forelse($sections as $section)
                <tr class="border-b border-gray-50"><td class="px-6 py-4 font-medium">{{ $section->name }}</td><td class="px-6 py-4 text-gray-600">{{ $section->schoolClass->name ?? 'N/A' }}</td><td class="px-6 py-4 text-gray-600">{{ $section->capacity }}</td><td class="px-6 py-4"><span class="bg-sky-50 text-sky-600 px-2 py-1 rounded-full text-xs font-medium">{{ $section->students_count }}</span></td><td class="px-6 py-4"><div class="flex gap-1"><a href="{{ route('sections.edit', $section) }}" class="p-2 text-gray-400 hover:text-indigo-600"><i class="fas fa-edit"></i></a><form method="POST" action="{{ route('sections.destroy', $section) }}" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="p-2 text-gray-400 hover:text-red-600"><i class="fas fa-trash"></i></button></form></div></td></tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400">No sections</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6">{{ $sections->links() }}</div>
</div>
@endsection

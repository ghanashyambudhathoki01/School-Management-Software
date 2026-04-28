@extends('layouts.app')
@section('title', 'Subjects')
@section('page-title', 'Subject Management')
@section('content')
<div class="bg-white rounded-2xl border shadow-sm">
    <div class="flex items-center justify-between p-6 border-b"><h3 class="text-lg font-semibold">All Subjects</h3><a href="{{ route('subjects.create') }}" class="px-4 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl"><i class="fas fa-plus mr-1"></i> Add Subject</a></div>
    <div class="p-6 border-b bg-gray-50/50"><form method="GET" class="flex gap-3"><input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="px-4 py-2 border rounded-xl text-sm w-48"><select name="class_id" class="px-4 py-2 border rounded-xl text-sm" onchange="this.form.submit()"><option value="">All Classes</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select><button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-xl">Filter</button></form></div>
    <div class="overflow-x-auto"><table class="w-full text-sm"><thead><tr class="text-left text-gray-500 bg-gray-50 border-b"><th class="px-6 py-3">Subject</th><th class="px-6 py-3">Class</th><th class="px-6 py-3">Teacher</th><th class="px-6 py-3">Type</th><th class="px-6 py-3">Marks</th><th class="px-6 py-3">Actions</th></tr></thead>
    <tbody>@forelse($subjects as $sub)
        <tr class="border-b border-gray-50"><td class="px-6 py-4 font-medium">{{ $sub->name }}</td><td class="px-6 py-4 text-gray-600">{{ $sub->schoolClass->name ?? 'N/A' }}</td><td class="px-6 py-4 text-gray-600">{{ $sub->teacher->full_name ?? 'N/A' }}</td><td class="px-6 py-4"><span class="text-xs font-medium px-2 py-1 rounded-full bg-indigo-50 text-indigo-600">{{ ucfirst($sub->type) }}</span></td><td class="px-6 py-4 text-gray-600">{{ $sub->full_marks }}/{{ $sub->pass_marks }}</td>
        <td class="px-6 py-4"><div class="flex gap-1"><a href="{{ route('subjects.edit', $sub) }}" class="p-2 text-gray-400 hover:text-indigo-600"><i class="fas fa-edit"></i></a><form method="POST" action="{{ route('subjects.destroy', $sub) }}" class="inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="p-2 text-gray-400 hover:text-red-600"><i class="fas fa-trash"></i></button></form></div></td></tr>
    @empty<tr><td colspan="7" class="px-6 py-12 text-center text-gray-400">No subjects</td></tr>@endforelse</tbody></table></div>
    <div class="p-6">{{ $subjects->links() }}</div>
</div>
@endsection

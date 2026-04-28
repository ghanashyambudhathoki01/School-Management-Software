@extends('layouts.app')
@section('title', 'Students')
@section('page-title', 'Student Management')
@section('page-description', 'Manage all students')

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-6 border-b border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800">All Students</h3>
        <a href="{{ route('students.create') }}" class="mt-3 sm:mt-0 inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition"><i class="fas fa-plus"></i> Add Student</a>
    </div>
    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
        <form method="GET" class="flex flex-wrap gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, ID, email..." class="px-4 py-2 border border-gray-200 rounded-xl text-sm w-64 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            <select name="class_id" class="px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500" onchange="this.form.submit()">
                <option value="">All Classes</option>
                @foreach($classes as $class)<option value="{{ $class->id }}" {{ request('class_id')==$class->id?'selected':'' }}>{{ $class->name }}</option>@endforeach
            </select>
            <select name="status" class="px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">All Status</option>
                <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                <option value="inactive" {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
                <option value="graduated" {{ request('status')=='graduated'?'selected':'' }}>Graduated</option>
                <option value="transferred" {{ request('status')=='transferred'?'selected':'' }}>Transferred</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-xl hover:bg-gray-700 transition">Filter</button>
            <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-xl hover:bg-gray-300 transition">Reset</a>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-left text-gray-500 bg-gray-50 border-b">
                <th class="px-6 py-3 font-medium">Student</th>
                <th class="px-6 py-3 font-medium">Admission No</th>
                <th class="px-6 py-3 font-medium">Class</th>
                <th class="px-6 py-3 font-medium">Guardian</th>
                <th class="px-6 py-3 font-medium">Status</th>
                <th class="px-6 py-3 font-medium">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($students as $student)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">{{ strtoupper(substr($student->first_name, 0, 1).substr($student->last_name, 0, 1)) }}</div>
                            <div><p class="font-medium text-gray-800">{{ $student->full_name }}</p><p class="text-xs text-gray-500">{{ $student->email ?: 'No email' }}</p></div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 font-mono text-xs">{{ $student->admission_no }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $student->schoolClass->name ?? 'N/A' }} {{ $student->section ? '- '.$student->section->name : '' }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $student->guardian_name ?: 'N/A' }}</td>
                    <td class="px-6 py-4"><span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $student->status=='active' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($student->status) }}</span></td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1">
                            <a href="{{ route('students.show', $student) }}" class="p-2 text-gray-400 hover:text-indigo-600" title="View"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('students.edit', $student) }}" class="p-2 text-gray-400 hover:text-indigo-600" title="Edit"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('students.destroy', $student) }}" class="inline" onsubmit="return confirm('Delete this student?')">@csrf @method('DELETE')<button class="p-2 text-gray-400 hover:text-red-600"><i class="fas fa-trash"></i></button></form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">No students found. <a href="{{ route('students.create') }}" class="text-indigo-600 hover:underline">Add your first student</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6">{{ $students->links() }}</div>
</div>
@endsection

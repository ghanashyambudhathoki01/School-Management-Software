@extends('layouts.app')
@section('title', 'Create Exam')
@section('page-title', 'Create Exam')
@section('content')
<div class="max-w-lg"><div class="bg-white rounded-2xl border p-6">
    <form method="POST" action="{{ route('exams.store') }}" class="space-y-4">@csrf
        <div><label class="block text-sm font-medium mb-1">Exam Name *</label><input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Mid Term Exam 2026" class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
        <div><label class="block text-sm font-medium mb-1">Description</label><textarea name="description" rows="2" class="w-full px-4 py-2.5 border rounded-xl text-sm">{{ old('description') }}</textarea></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium mb-1">Start Date *</label><input type="date" name="start_date" value="{{ old('start_date') }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
            <div><label class="block text-sm font-medium mb-1">End Date *</label><input type="date" name="end_date" value="{{ old('end_date') }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
        </div>
        <div class="flex gap-3"><button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm rounded-xl"><i class="fas fa-save mr-2"></i>Create</button><a href="{{ route('exams.index') }}" class="px-6 py-2.5 bg-gray-200 text-sm rounded-xl">Cancel</a></div>
    </form>
</div></div>
@endsection

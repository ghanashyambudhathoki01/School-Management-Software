@extends('layouts.app')
@section('title', 'Add Subject')
@section('page-title', 'Add Subject')
@section('content')
<div class="max-w-lg"><div class="bg-white rounded-2xl border p-6">
    <form method="POST" action="{{ route('subjects.store') }}" class="space-y-4">@csrf
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Subject Name *</label><input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Class *</label><select name="class_id" required class="w-full px-4 py-2.5 border rounded-xl text-sm"><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Teacher</label><select name="teacher_id" class="w-full px-4 py-2.5 border rounded-xl text-sm"><option value="">Select</option>@foreach($teachers as $t)<option value="{{ $t->id }}">{{ $t->full_name }}</option>@endforeach</select></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Type *</label><select name="type" required class="w-full px-4 py-2.5 border rounded-xl text-sm"><option value="theory">Theory</option><option value="practical">Practical</option><option value="both">Both</option></select></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Full Marks</label><input type="number" name="full_marks" value="{{ old('full_marks', 100) }}" class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Pass Marks</label><input type="number" name="pass_marks" value="{{ old('pass_marks', 40) }}" class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
        </div>
        <div class="flex gap-3"><button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl"><i class="fas fa-save mr-2"></i>Save</button><a href="{{ route('subjects.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl">Cancel</a></div>
    </form>
</div></div>
@endsection

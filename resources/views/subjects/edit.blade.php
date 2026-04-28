@extends('layouts.app')
@section('title', 'Edit Subject')
@section('page-title', 'Edit Subject')
@section('content')
<div class="max-w-lg"><div class="bg-white rounded-2xl border p-6">
    <form method="POST" action="{{ route('subjects.update', $subject) }}" class="space-y-4">@csrf @method('PUT')
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Subject Name *</label><input type="text" name="name" value="{{ old('name', $subject->name) }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Class *</label><select name="class_id" required class="w-full px-4 py-2.5 border rounded-xl text-sm">@foreach($classes as $c)<option value="{{ $c->id }}" {{ $subject->class_id==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Teacher</label><select name="teacher_id" class="w-full px-4 py-2.5 border rounded-xl text-sm"><option value="">None</option>@foreach($teachers as $t)<option value="{{ $t->id }}" {{ $subject->teacher_id==$t->id?'selected':'' }}>{{ $t->full_name }}</option>@endforeach</select></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Type</label><select name="type" class="w-full px-4 py-2.5 border rounded-xl text-sm"><option value="theory" {{ $subject->type=='theory'?'selected':'' }}>Theory</option><option value="practical" {{ $subject->type=='practical'?'selected':'' }}>Practical</option><option value="both" {{ $subject->type=='both'?'selected':'' }}>Both</option></select></div>
        <div class="grid grid-cols-2 gap-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Full Marks</label><input type="number" name="full_marks" value="{{ $subject->full_marks }}" class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Pass Marks</label><input type="number" name="pass_marks" value="{{ $subject->pass_marks }}" class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
        </div>
        <div class="flex gap-3"><button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl"><i class="fas fa-save mr-2"></i>Update</button><a href="{{ route('subjects.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl">Cancel</a></div>
    </form>
</div></div>
@endsection

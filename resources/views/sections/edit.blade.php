@extends('layouts.app')
@section('title', 'Edit Section')
@section('page-title', 'Edit Section')
@section('content')
<div class="max-w-lg"><div class="bg-white rounded-2xl border p-6">
    <form method="POST" action="{{ route('sections.update', $section) }}" class="space-y-4">@csrf @method('PUT')
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Class *</label><select name="class_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm">@foreach($classes as $c)<option value="{{ $c->id }}" {{ $section->class_id==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Section Name *</label><input type="text" name="name" value="{{ old('name', $section->name) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Capacity</label><input type="number" name="capacity" value="{{ old('capacity', $section->capacity) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
        <div class="flex gap-3"><button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl"><i class="fas fa-save mr-2"></i>Update</button><a href="{{ route('sections.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl">Cancel</a></div>
    </form>
</div></div>
@endsection

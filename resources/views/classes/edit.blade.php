@extends('layouts.app')
@section('title', 'Edit Class')
@section('page-title', 'Edit Class')
@section('content')
    <div class="max-w-lg">
        <div class="bg-white rounded-2xl border p-6">
            <form method="POST" action="{{ route('classes.update', $class) }}" class="space-y-4">@csrf @method('PUT')
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Class Name *</label><input type="text"
                        name="name" value="{{ old('name', $class->name) }}" required
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Section</label><input type="number"
                        name="numeric_name" value="{{ old('numeric_name', $class->numeric_name) }}"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Description</label><textarea
                        name="description" rows="2"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm">{{ old('description', $class->description) }}</textarea>
                </div>
                <div class="flex gap-3"><button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl"><i
                            class="fas fa-save mr-2"></i>Update</button><a href="{{ route('classes.index') }}"
                        class="px-6 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl">Cancel</a></div>
            </form>
        </div>
    </div>
@endsection
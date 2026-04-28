@extends('layouts.app')
@section('title', 'Create Notice')
@section('page-title', 'Create New Notice')
@section('content')
<div class="max-w-3xl bg-white rounded-2xl border shadow-sm p-6">
    <form method="POST" action="{{ route('notices.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500" placeholder="Notice heading">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                <select name="type" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="general">General</option>
                    <option value="teacher">For Teachers</option>
                    <option value="student">For Students</option>
                    <option value="urgent">Urgent</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Publish Date *</label>
                <input type="date" name="publish_date" value="{{ old('publish_date', date('Y-m-d')) }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Target Audience</label>
                <input type="text" name="target_audience" value="{{ old('target_audience') }}" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500" placeholder="e.g. All Students, Grade 10">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
            <textarea name="message" rows="8" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500" placeholder="Notice content..."></textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Attachment</label>
            <input type="file" name="attachment" class="w-full px-4 py-2 border rounded-xl text-sm">
            <p class="text-[10px] text-gray-400 mt-1">PDF, Images or Docs (Max 5MB)</p>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition">Publish Notice</button>
            <a href="{{ route('notices.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl hover:bg-gray-300 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection

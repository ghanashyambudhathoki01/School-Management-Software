@extends('layouts.app')
@section('title', 'Edit Notice')
@section('page-title', 'Edit Notice')
@section('content')
<div class="max-w-3xl bg-white rounded-2xl border shadow-sm p-6">
    <form method="POST" action="{{ route('notices.update', $notice) }}" enctype="multipart/form-data" class="space-y-5">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
            <input type="text" name="title" value="{{ old('title', $notice->title) }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                <select name="type" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="general" {{ $notice->type == 'general' ? 'selected' : '' }}>General</option>
                    <option value="teacher" {{ $notice->type == 'teacher' ? 'selected' : '' }}>For Teachers</option>
                    <option value="student" {{ $notice->type == 'student' ? 'selected' : '' }}>For Students</option>
                    <option value="urgent" {{ $notice->type == 'urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Publish Date *</label>
                <input type="date" name="publish_date" value="{{ old('publish_date', $notice->publish_date->format('Y-m-d')) }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                <input type="date" name="expiry_date" value="{{ old('expiry_date', $notice->expiry_date ? $notice->expiry_date->format('Y-m-d') : '') }}" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="1" {{ $notice->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$notice->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
            <textarea name="message" rows="8" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">{{ old('message', $notice->message) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Attachment</label>
            @if($notice->attachment)
                <div class="mb-2 p-2 bg-gray-50 border rounded-lg flex items-center gap-2">
                    <i class="fas fa-paperclip text-gray-400"></i>
                    <span class="text-xs text-gray-600 truncate flex-grow">{{ basename($notice->attachment) }}</span>
                </div>
            @endif
            <input type="file" name="attachment" class="w-full px-4 py-2 border rounded-xl text-sm">
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition">Update Notice</button>
            <a href="{{ route('notices.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl hover:bg-gray-300 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Issue Certificate')
@section('page-title', 'Issue New Certificate')
@section('content')
<div class="max-w-2xl bg-white rounded-2xl border shadow-sm p-6">
    <form method="POST" action="{{ route('certificates.store') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Student *</label>
            <select name="student_id" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">Select Student</option>
                @foreach($students as $s)
                    <option value="{{ $s->id }}">{{ $s->full_name }} ({{ $s->admission_no }})</option>
                @endforeach
            </select>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium mb-1">Certificate Type *</label>
                <select name="type" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="transfer">Transfer Certificate</option>
                    <option value="character">Character Certificate</option>
                    <option value="completion">Completion Certificate</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Issue Date *</label>
                <input type="date" name="issue_date" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Content/Remarks</label>
            <textarea name="content" rows="4" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500" placeholder="Optional specific content to include..."></textarea>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition">Generate Certificate</button>
            <a href="{{ route('certificates.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl hover:bg-gray-300 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection

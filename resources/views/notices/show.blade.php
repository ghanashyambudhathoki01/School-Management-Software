@extends('layouts.app')
@section('title', $notice->title)
@section('page-title', 'Notice Details')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
        <div class="px-8 py-4 bg-gray-50 border-b flex justify-between items-center">
            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                {{ $notice->type == 'urgent' ? 'bg-red-100 text-red-600' : 
                   ($notice->type == 'general' ? 'bg-indigo-100 text-indigo-600' : 
                   ($notice->type == 'teacher' ? 'bg-purple-100 text-purple-600' : 'bg-sky-100 text-sky-600')) }}">
                {{ $notice->type }}
            </span>
            <div class="text-right">
                <p class="text-xs text-gray-400">Published: {{ $notice->publish_date->format('M d, Y') }}</p>
                @if($notice->expiry_date)
                    <p class="text-[10px] text-red-400">Expires: {{ $notice->expiry_date->format('M d, Y') }}</p>
                @endif
            </div>
        </div>
        <div class="p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $notice->title }}</h1>
            <div class="prose prose-indigo max-w-none text-gray-600 leading-relaxed mb-8">
                {!! nl2br(e($notice->message)) !!}
            </div>

            @if($notice->attachment)
                <div class="mt-8 pt-6 border-t">
                    <h4 class="text-sm font-bold text-gray-800 mb-3">Attachment</h4>
                    <a href="{{ asset('storage/' . $notice->attachment) }}" target="_blank" class="inline-flex items-center gap-3 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl hover:bg-gray-100 transition group">
                        <i class="fas fa-file-pdf text-red-500 text-lg group-hover:scale-110 transition"></i>
                        <div class="text-left">
                            <p class="text-sm font-medium text-gray-800">Download Attachment</p>
                            <p class="text-[10px] text-gray-400 uppercase">Click to view/download</p>
                        </div>
                    </a>
                </div>
            @endif
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t flex justify-between items-center no-print">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-600">{{ strtoupper(substr($notice->publisher->name ?? 'A', 0, 1)) }}</div>
                <div>
                    <p class="text-xs font-bold text-gray-800">{{ $notice->publisher->name ?? 'Admin' }}</p>
                    <p class="text-[10px] text-gray-400">Publisher</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('notices.index') }}" class="px-4 py-2 bg-white border text-gray-700 text-sm rounded-xl hover:bg-gray-50 transition">Back</a>
                @if(Auth::user()->isSuperAdmin() || Auth::user()->isSchoolAdmin())
                    <a href="{{ route('notices.edit', $notice) }}" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition">Edit</a>
                @endif
                <button onclick="window.print()" class="px-4 py-2 bg-gray-800 text-white text-sm rounded-xl hover:bg-gray-700 transition"><i class="fas fa-print mr-1"></i> Print</button>
            </div>
        </div>
    </div>
</div>
@endsection

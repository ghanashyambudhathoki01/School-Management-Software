@extends('layouts.app')
@section('title', 'Certificates')
@section('page-title', 'Issued Certificates')
@section('content')
<div class="bg-white rounded-2xl border shadow-sm p-6 mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Search Student</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or ID..." class="w-full px-4 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
            <select name="type" class="px-4 py-2 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                <option value="">All Types</option>
                <option value="transfer" {{ request('type') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                <option value="character" {{ request('type') == 'character' ? 'selected' : '' }}>Character</option>
                <option value="completion" {{ request('type') == 'completion' ? 'selected' : '' }}>Completion</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl">Filter</button>
        <a href="{{ route('certificates.create') }}" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl hover:bg-indigo-700 transition"><i class="fas fa-plus mr-1"></i> Issue New</a>
    </form>
</div>

<div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left bg-gray-50 text-gray-500 border-b">
                <th class="px-6 py-4 font-medium">Certificate #</th>
                <th class="px-6 py-4 font-medium">Student</th>
                <th class="px-6 py-4 font-medium">Type</th>
                <th class="px-6 py-4 font-medium">Issue Date</th>
                <th class="px-6 py-4 font-medium">Issued By</th>
                <th class="px-6 py-4 font-medium">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($certificates as $cert)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-mono text-xs text-indigo-600 font-bold">{{ $cert->certificate_no }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $cert->student->full_name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded text-[10px] font-bold uppercase">{{ $cert->type }}</span>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $cert->issue_date->format('M d, Y') }}</td>
                    <td class="px-6 py-4 text-gray-600 text-xs">{{ $cert->issuer->name ?? 'Admin' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('certificates.show', $cert) }}" class="p-2 text-gray-400 hover:text-indigo-600 transition" title="View/Print"><i class="fas fa-print"></i></a>
                            <form method="POST" action="{{ route('certificates.destroy', $cert) }}" onsubmit="return confirm('Delete this record?')">
                                @csrf @method('DELETE')
                                <button class="p-2 text-gray-400 hover:text-red-600 transition" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400">No certificates found</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-6 border-t">{{ $certificates->links() }}</div>
</div>
@endsection

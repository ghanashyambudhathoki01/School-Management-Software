@extends('layouts.app')
@section('title', 'Enter Marks')
@section('page-title', 'Enter Marks - '.$exam->name)
@section('content')
<div class="bg-white rounded-2xl border p-6 mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div><label class="block text-sm font-medium mb-1">Class *</label><select name="class_id" required class="px-4 py-2.5 border rounded-xl text-sm"><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach</select></div>
        <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl">Load</button>
    </form>
</div>
@if($students->count() && $subjects->count())
<div class="bg-white rounded-2xl border p-6">
    <form method="POST" action="{{ route('exams.marks.store', $exam) }}">@csrf
        <input type="hidden" name="class_id" value="{{ request('class_id') }}">
        <div class="overflow-x-auto">
        <table class="w-full text-sm"><thead><tr class="text-left text-gray-500 bg-gray-50 border-b"><th class="px-4 py-3">Student</th>@foreach($subjects as $sub)<th class="px-4 py-3">{{ $sub->name }}<br><span class="text-xs text-gray-400">({{ $sub->full_marks }})</span></th>@endforeach</tr></thead>
        <tbody>@foreach($students as $student)
            <tr class="border-b border-gray-50"><td class="px-4 py-3 font-medium">{{ $student->full_name }}</td>
            @foreach($subjects as $sub)
                @php $existing = isset($existingMarks[$student->id]) ? $existingMarks[$student->id]->where('subject_id', $sub->id)->first() : null; @endphp
                <td class="px-4 py-3"><input type="number" name="marks[{{ $student->id }}][{{ $sub->id }}]" value="{{ $existing ? $existing->marks_obtained : '' }}" min="0" max="{{ $sub->full_marks }}" step="0.5" class="w-20 px-2 py-1.5 border rounded-lg text-sm text-center"></td>
            @endforeach</tr>
        @endforeach</tbody></table>
        </div>
        <div class="mt-4"><button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm rounded-xl"><i class="fas fa-save mr-2"></i>Save Marks</button></div>
    </form>
</div>
@endif
@endsection

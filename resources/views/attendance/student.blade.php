@extends('layouts.app')
@section('title', 'Student Attendance')
@section('page-title', 'Mark Student Attendance')
@section('content')
<div class="bg-white rounded-2xl border shadow-sm p-6 mb-5">
    <form method="GET" class="flex flex-wrap gap-3 items-end">
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Class *</label><select name="class_id" id="class_id" required class="px-4 py-2.5 border rounded-xl text-sm"><option value="">Select</option>@foreach($classes as $c)<option value="{{ $c->id }}" {{ request('class_id')==$c->id?'selected':'' }} data-sections='@json($c->sections)'>{{ $c->name }}</option>@endforeach</select></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Section</label><select name="section_id" id="section_id" class="px-4 py-2.5 border rounded-xl text-sm"><option value="">All</option></select></div>
        <div><label class="block text-sm font-medium text-gray-700 mb-1">Date *</label><input type="date" name="date" value="{{ request('date', date('Y-m-d')) }}" required class="px-4 py-2.5 border rounded-xl text-sm"></div>
        <button type="submit" class="px-4 py-2.5 bg-indigo-600 text-white text-sm rounded-xl">Load Students</button>
    </form>
</div>

@if($students->count())
<div class="bg-white rounded-2xl border shadow-sm p-6">
    <form method="POST" action="{{ route('attendance.student.store') }}">@csrf
        <input type="hidden" name="class_id" value="{{ request('class_id') }}">
        <input type="hidden" name="section_id" value="{{ request('section_id') }}">
        <input type="hidden" name="date" value="{{ request('date') }}">
        <div class="mb-4 flex gap-3">
            <button type="button" onclick="setAll('present')" class="px-3 py-1.5 bg-emerald-100 text-emerald-700 text-xs rounded-lg font-medium">All Present</button>
            <button type="button" onclick="setAll('absent')" class="px-3 py-1.5 bg-red-100 text-red-700 text-xs rounded-lg font-medium">All Absent</button>
        </div>
        <table class="w-full text-sm">
            <thead><tr class="text-left text-gray-500 bg-gray-50 border-b"><th class="px-4 py-3">Roll</th><th class="px-4 py-3">Student</th><th class="px-4 py-3">Present</th><th class="px-4 py-3">Absent</th><th class="px-4 py-3">Late</th><th class="px-4 py-3">Half Day</th></tr></thead>
            <tbody>
                @foreach($students as $student)
                @php $current = $existingRecords[$student->id] ?? 'present'; @endphp
                <tr class="border-b border-gray-50">
                    <td class="px-4 py-3 text-gray-600">{{ $student->roll_number ?? '-' }}</td>
                    <td class="px-4 py-3 font-medium">{{ $student->full_name }}</td>
                    <td class="px-4 py-3"><input type="radio" name="attendance[{{ $student->id }}]" value="present" {{ $current=='present'?'checked':'' }} class="att-radio text-emerald-600 focus:ring-emerald-500"></td>
                    <td class="px-4 py-3"><input type="radio" name="attendance[{{ $student->id }}]" value="absent" {{ $current=='absent'?'checked':'' }} class="att-radio text-red-600 focus:ring-red-500"></td>
                    <td class="px-4 py-3"><input type="radio" name="attendance[{{ $student->id }}]" value="late" {{ $current=='late'?'checked':'' }} class="att-radio text-amber-600 focus:ring-amber-500"></td>
                    <td class="px-4 py-3"><input type="radio" name="attendance[{{ $student->id }}]" value="half_day" {{ $current=='half_day'?'checked':'' }} class="att-radio text-sky-600 focus:ring-sky-500"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4"><button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl"><i class="fas fa-save mr-2"></i>Save Attendance</button></div>
    </form>
</div>
@endif
@endsection
@push('scripts')
<script>
function setAll(v) { document.querySelectorAll(`input[value="${v}"].att-radio`).forEach(r => r.checked = true); }
const cs = document.getElementById('class_id'), ss = document.getElementById('section_id');
cs.addEventListener('change', function() { ss.innerHTML='<option value="">All</option>'; const o=this.options[this.selectedIndex]; if(o.dataset.sections){JSON.parse(o.dataset.sections).forEach(s=>{ss.innerHTML+=`<option value="${s.id}">${s.name}</option>`;});} });
@if(request('class_id'))
cs.dispatchEvent(new Event('change'));
@if(request('section_id')) setTimeout(()=>{ ss.value="{{ request('section_id') }}"; }, 100); @endif
@endif
</script>
@endpush

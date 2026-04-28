@extends('layouts.app')
@section('title', 'Edit Student')
@section('page-title', 'Edit Student')
@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form method="POST" action="{{ route('students.update', $student) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b"><i class="fas fa-user text-indigo-500 mr-2"></i>Personal</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label><input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label><input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label><input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($student->date_of_birth)->format('Y-m-d')) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Gender</label><select name="gender" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"><option value="">Select</option><option value="male" {{ $student->gender=='male'?'selected':'' }}>Male</option><option value="female" {{ $student->gender=='female'?'selected':'' }}>Female</option><option value="other" {{ $student->gender=='other'?'selected':'' }}>Other</option></select></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Blood Group</label><input type="text" name="blood_group" value="{{ old('blood_group', $student->blood_group) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Photo</label><input type="file" name="photo" accept="image/*" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm"></div>
                </div>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b"><i class="fas fa-school text-indigo-500 mr-2"></i>Academic</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Class *</label><select name="class_id" id="class_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm">@foreach($classes as $c)<option value="{{ $c->id }}" {{ $student->class_id==$c->id?'selected':'' }} data-sections='@json($c->sections)'>{{ $c->name }}</option>@endforeach</select></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Section</label><select name="section_id" id="section_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"><option value="">Select</option></select></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Roll Number</label><input type="text" name="roll_number" value="{{ old('roll_number', $student->roll_number) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Status</label><select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"><option value="active" {{ $student->status=='active'?'selected':'' }}>Active</option><option value="inactive" {{ $student->status=='inactive'?'selected':'' }}>Inactive</option><option value="graduated" {{ $student->status=='graduated'?'selected':'' }}>Graduated</option><option value="transferred" {{ $student->status=='transferred'?'selected':'' }}>Transferred</option></select></div>
                </div>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b"><i class="fas fa-user-friends text-indigo-500 mr-2"></i>Guardian</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Guardian Name</label><input type="text" name="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Relation</label><input type="text" name="guardian_relation" value="{{ old('guardian_relation', $student->guardian_relation) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Guardian Phone</label><input type="text" name="guardian_phone" value="{{ old('guardian_phone', $student->guardian_phone) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                </div>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b"><i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>Contact</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Phone</label><input type="text" name="phone" value="{{ old('phone', $student->phone) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Email</label><input type="email" name="email" value="{{ old('email', $student->email) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">City</label><input type="text" name="city" value="{{ old('city', $student->city) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                </div>
            </div>
            <div class="flex gap-3"><button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition"><i class="fas fa-save mr-2"></i>Update</button><a href="{{ route('students.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl">Cancel</a></div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
const cs = document.getElementById('class_id'), ss = document.getElementById('section_id');
function loadSections() { ss.innerHTML='<option value="">Select</option>'; const o=cs.options[cs.selectedIndex]; if(o.dataset.sections){JSON.parse(o.dataset.sections).forEach(s=>{ss.innerHTML+=`<option value="${s.id}" ${s.id=={{ $student->section_id ?? 'null' }}?'selected':''}>${s.name}</option>`;});} }
cs.addEventListener('change', loadSections); loadSections();
</script>
@endpush

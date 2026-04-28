@extends('layouts.app')
@section('title', 'Add Student')
@section('page-title', 'Add Student')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <form method="POST" action="{{ route('students.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            {{-- Personal Info --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b"><i class="fas fa-user text-indigo-500 mr-2"></i>Personal Information</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label><input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label><input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label><input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Gender</label><select name="gender" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"><option value="">Select</option><option value="male">Male</option><option value="female">Female</option><option value="other">Other</option></select></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Blood Group</label><input type="text" name="blood_group" value="{{ old('blood_group') }}" placeholder="e.g. A+" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Religion</label><input type="text" name="religion" value="{{ old('religion') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Photo</label><input type="file" name="photo" accept="image/*" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm"></div>
                </div>
            </div>
            {{-- Academic Info --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b"><i class="fas fa-school text-indigo-500 mr-2"></i>Academic Information</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Class *</label><select name="class_id" id="class_id" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"><option value="">Select Class</option>@foreach($classes as $class)<option value="{{ $class->id }}" data-sections='@json($class->sections)'>{{ $class->name }}</option>@endforeach</select></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Section</label><select name="section_id" id="section_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"><option value="">Select Section</option></select></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Roll Number</label><input type="text" name="roll_number" value="{{ old('roll_number') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Admission Date</label><input type="date" name="admission_date" value="{{ old('admission_date', date('Y-m-d')) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Previous School</label><input type="text" name="previous_school" value="{{ old('previous_school') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                </div>
            </div>
            {{-- Guardian Info --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b"><i class="fas fa-user-friends text-indigo-500 mr-2"></i>Guardian Information</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Guardian Name</label><input type="text" name="guardian_name" value="{{ old('guardian_name') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Relation</label><input type="text" name="guardian_relation" value="{{ old('guardian_relation') }}" placeholder="Father/Mother" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Guardian Phone</label><input type="text" name="guardian_phone" value="{{ old('guardian_phone') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Guardian Email</label><input type="email" name="guardian_email" value="{{ old('guardian_email') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Occupation</label><input type="text" name="guardian_occupation" value="{{ old('guardian_occupation') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                </div>
            </div>
            {{-- Contact --}}
            <div>
                <h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b"><i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>Contact Information</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Phone</label><input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">Email</label><input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">City</label><input type="text" name="city" value="{{ old('city') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Address</label><input type="text" name="address" value="{{ old('address') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                    <div><label class="block text-sm font-medium text-gray-700 mb-1">State</label><input type="text" name="state" value="{{ old('state') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition"><i class="fas fa-save mr-2"></i>Save Student</button>
                <a href="{{ route('students.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl hover:bg-gray-300 transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('class_id').addEventListener('change', function() {
    const sectionSelect = document.getElementById('section_id');
    sectionSelect.innerHTML = '<option value="">Select Section</option>';
    const option = this.options[this.selectedIndex];
    if (option.dataset.sections) {
        JSON.parse(option.dataset.sections).forEach(s => {
            sectionSelect.innerHTML += `<option value="${s.id}">${s.name}</option>`;
        });
    }
});
</script>
@endpush

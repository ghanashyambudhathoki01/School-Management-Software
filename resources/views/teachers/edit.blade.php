@extends('layouts.app')
@section('title', 'Edit Teacher')
@section('page-title', 'Edit Teacher')
@section('content')
<div class="max-w-4xl"><div class="bg-white rounded-2xl border p-6">
    <form method="POST" action="{{ route('teachers.update', $teacher) }}" enctype="multipart/form-data" class="space-y-6">@csrf @method('PUT')
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label><input type="text" name="first_name" value="{{ old('first_name', $teacher->first_name) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label><input type="text" name="last_name" value="{{ old('last_name', $teacher->last_name) }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Gender</label><select name="gender" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"><option value="">Select</option><option value="male" {{ $teacher->gender=='male'?'selected':'' }}>Male</option><option value="female" {{ $teacher->gender=='female'?'selected':'' }}>Female</option></select></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Phone</label><input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Qualification</label><input type="text" name="qualification" value="{{ old('qualification', $teacher->qualification) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Department</label><input type="text" name="department" value="{{ old('department', $teacher->department) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Designation</label><input type="text" name="designation" value="{{ old('designation', $teacher->designation) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Salary</label><input type="number" name="salary_amount" value="{{ old('salary_amount', $teacher->salary_amount) }}" step="0.01" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1">Status</label><select name="status" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"><option value="active" {{ $teacher->status=='active'?'selected':'' }}>Active</option><option value="inactive" {{ $teacher->status=='inactive'?'selected':'' }}>Inactive</option><option value="on_leave" {{ $teacher->status=='on_leave'?'selected':'' }}>On Leave</option><option value="terminated" {{ $teacher->status=='terminated'?'selected':'' }}>Terminated</option></select></div>
        </div>
        <div class="flex gap-3"><button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700"><i class="fas fa-save mr-2"></i>Update</button><a href="{{ route('teachers.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl">Cancel</a></div>
    </form>
</div></div>
@endsection

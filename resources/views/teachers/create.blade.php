@extends('layouts.app')
@section('title', 'Add Teacher')
@section('page-title', 'Add Teacher')
@section('content')
<div class="max-w-4xl"><div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
    <form method="POST" action="{{ route('teachers.store') }}" enctype="multipart/form-data" class="space-y-6">@csrf
        <div><h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b"><i class="fas fa-user text-indigo-500 mr-2"></i>Personal</h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">First Name *</label><input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label><input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Email *</label><input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Password *</label><input type="password" name="password" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label><input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Gender</label><select name="gender" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"><option value="">Select</option><option value="male">Male</option><option value="female">Female</option><option value="other">Other</option></select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label><input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Phone</label><input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Photo</label><input type="file" name="photo" accept="image/*" class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm"></div>
            </div>
        </div>
        <div><h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b"><i class="fas fa-briefcase text-indigo-500 mr-2"></i>Professional</h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Qualification</label><input type="text" name="qualification" value="{{ old('qualification') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Designation</label><input type="text" name="designation" value="{{ old('designation') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Department</label><input type="text" name="department" value="{{ old('department') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Experience</label><input type="text" name="experience" value="{{ old('experience') }}" placeholder="e.g. 5 years" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Joining Date</label><input type="date" name="joining_date" value="{{ old('joining_date', date('Y-m-d')) }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Salary Amount</label><input type="number" name="salary_amount" value="{{ old('salary_amount', 0) }}" step="0.01" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
            </div>
        </div>
        <div><h4 class="text-sm font-semibold text-gray-800 mb-3 pb-2 border-b"><i class="fas fa-map-marker-alt text-indigo-500 mr-2"></i>Address</h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Address</label><input type="text" name="address" value="{{ old('address') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">City</label><input type="text" name="city" value="{{ old('city') }}" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm"></div>
            </div>
        </div>
        <div class="flex gap-3"><button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition"><i class="fas fa-save mr-2"></i>Save</button><a href="{{ route('teachers.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl">Cancel</a></div>
    </form>
</div></div>
@endsection

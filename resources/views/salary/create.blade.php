@extends('layouts.app')
@section('title', 'Add Salary Record')
@section('page-title', 'Create Salary Record')
@section('content')
<div class="max-w-2xl bg-white rounded-2xl border shadow-sm p-6">
    <form method="POST" action="{{ route('salary.store') }}" class="space-y-5">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Teacher *</label>
                <select name="teacher_id" id="teacher_id" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Select Teacher</option>
                    @foreach($teachers as $t)
                        <option value="{{ $t->id }}" data-salary="{{ $t->salary_amount }}">{{ $t->full_name }} ({{ $t->employee_id }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Basic Salary *</label>
                <input type="number" name="basic_salary" id="basic_salary" step="0.01" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Month *</label>
                <select name="month" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $m)
                        <option value="{{ $m }}" {{ date('F') == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Year *</label>
                <input type="number" name="year" value="{{ date('Y') }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bonus</label>
                <input type="number" name="bonus" value="0" step="0.01" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deductions</label>
                <input type="number" name="deductions" value="0" step="0.01" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                <select name="payment_method" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="cash">Cash</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="cheque">Cheque</option>
                    <option value="online">Online</option>
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
            <textarea name="remarks" rows="2" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-indigo-500" placeholder="Optional notes..."></textarea>
        </div>
        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-xl hover:bg-indigo-700 transition">Create Record</button>
            <a href="{{ route('salary.index') }}" class="px-6 py-2.5 bg-gray-200 text-gray-700 text-sm rounded-xl hover:bg-gray-300 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
    document.getElementById('teacher_id').addEventListener('change', function() {
        const salary = this.options[this.selectedIndex].dataset.salary;
        if(salary) document.getElementById('basic_salary').value = salary;
    });
</script>
@endpush

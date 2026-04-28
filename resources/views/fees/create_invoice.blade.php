@extends('layouts.app')
@section('title', 'Create Invoice')
@section('page-title', 'Create Fee Invoice')
@section('content')
<div class="max-w-lg"><div class="bg-white rounded-2xl border p-6">
    <form method="POST" action="{{ route('fees.invoices.store') }}" class="space-y-4">@csrf
        <div><label class="block text-sm font-medium mb-1">Student *</label><select name="student_id" required class="w-full px-4 py-2.5 border rounded-xl text-sm"><option value="">Select</option>@foreach($students as $s)<option value="{{ $s->id }}">{{ $s->full_name }} ({{ $s->admission_no }})</option>@endforeach</select></div>
        <div><label class="block text-sm font-medium mb-1">Fee Category *</label><select name="fee_category_id" id="fc" required class="w-full px-4 py-2.5 border rounded-xl text-sm"><option value="">Select</option>@foreach($categories as $c)<option value="{{ $c->id }}" data-amt="{{ $c->amount }}">{{ $c->name }}</option>@endforeach</select></div>
        <div><label class="block text-sm font-medium mb-1">Amount *</label><input type="number" name="amount" id="amt" step="0.01" required class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
        <div class="grid grid-cols-2 gap-4"><div><label class="block text-sm font-medium mb-1">Discount</label><input type="number" name="discount" value="0" step="0.01" class="w-full px-4 py-2.5 border rounded-xl text-sm"></div><div><label class="block text-sm font-medium mb-1">Fine</label><input type="number" name="fine" value="0" step="0.01" class="w-full px-4 py-2.5 border rounded-xl text-sm"></div></div>
        <div><label class="block text-sm font-medium mb-1">Due Date *</label><input type="date" name="due_date" required class="w-full px-4 py-2.5 border rounded-xl text-sm"></div>
        <div class="flex gap-3"><button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm rounded-xl">Create</button><a href="{{ route('fees.invoices') }}" class="px-6 py-2.5 bg-gray-200 text-sm rounded-xl">Cancel</a></div>
    </form>
</div></div>
@endsection
@push('scripts')<script>document.getElementById('fc').addEventListener('change',function(){const a=this.options[this.selectedIndex].dataset.amt;if(a)document.getElementById('amt').value=a;});</script>@endpush

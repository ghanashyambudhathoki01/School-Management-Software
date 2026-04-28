<?php

namespace App\Http\Controllers;

use App\Models\FeeCategory;
use App\Models\FeeInvoice;
use App\Models\Payment;
use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeeController extends Controller
{
    public function categories()
    {
        $categories = FeeCategory::withCount('invoices')->paginate(15);
        return view('fees.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|in:monthly,quarterly,yearly,one_time',
        ]);
        FeeCategory::create($validated);
        return redirect()->route('fees.categories')->with('success', 'Fee category created successfully.');
    }

    public function updateCategory(Request $request, FeeCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'frequency' => 'required|in:monthly,quarterly,yearly,one_time',
        ]);
        $category->update($validated);
        return redirect()->route('fees.categories')->with('success', 'Fee category updated.');
    }

    public function deleteCategory(FeeCategory $category)
    {
        $category->delete();
        return redirect()->route('fees.categories')->with('success', 'Fee category deleted.');
    }

    public function invoices(Request $request)
    {
        $query = FeeInvoice::with(['student', 'schoolClass', 'feeCategory']);
        if ($request->filled('search')) {
            $query->whereHas('student', fn($q) => $q->where('first_name', 'like', "%{$request->search}%")->orWhere('last_name', 'like', "%{$request->search}%")->orWhere('admission_no', 'like', "%{$request->search}%"));
        }
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('class_id')) $query->where('class_id', $request->class_id);

        $invoices = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $classes = SchoolClass::active()->get();
        return view('fees.invoices', compact('invoices', 'classes'));
    }

    public function createInvoice()
    {
        $students = Student::active()->with('schoolClass')->get();
        $categories = FeeCategory::active()->get();
        $classes = SchoolClass::active()->get();
        return view('fees.create_invoice', compact('students', 'categories', 'classes'));
    }

    public function storeInvoice(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'fee_category_id' => 'required|exists:fee_categories,id',
            'amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'fine' => 'nullable|numeric|min:0',
            'due_date' => 'required|date',
            'month' => 'nullable|string',
            'year' => 'nullable|string',
        ]);
        $student = Student::findOrFail($validated['student_id']);
        $validated['class_id'] = $student->class_id;
        $validated['issue_date'] = now();
        $validated['discount'] = $validated['discount'] ?? 0;
        $validated['fine'] = $validated['fine'] ?? 0;
        $validated['total'] = ($validated['amount'] - $validated['discount']) + $validated['fine'];
        $validated['due_amount'] = $validated['total'];
        $validated['paid_amount'] = 0;
        $validated['invoice_no'] = 'INV-' . date('Ymd') . '-' . str_pad(FeeInvoice::count() + 1, 5, '0', STR_PAD_LEFT);

        FeeInvoice::create($validated);
        return redirect()->route('fees.invoices')->with('success', 'Invoice created successfully.');
    }

    public function showInvoice(FeeInvoice $invoice)
    {
        $invoice->load(['student', 'schoolClass', 'feeCategory', 'payments']);
        return view('fees.show_invoice', compact('invoice'));
    }

    public function recordPayment(Request $request, FeeInvoice $invoice)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $invoice->due_amount,
            'payment_method' => 'required|in:cash,bank_transfer,cheque,online,other',
            'payment_date' => 'required|date',
            'transaction_id' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);
        Payment::create([
            'fee_invoice_id' => $invoice->id,
            'student_id' => $invoice->student_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'transaction_id' => $request->transaction_id,
            'remarks' => $request->remarks,
            'received_by' => Auth::id(),
        ]);
        $invoice->updatePaymentStatus();
        return redirect()->back()->with('success', 'Payment recorded successfully.');
    }

    public function dueReport(Request $request)
    {
        $query = FeeInvoice::with(['student', 'schoolClass', 'feeCategory'])->where('status', '!=', 'paid');
        if ($request->filled('class_id')) $query->where('class_id', $request->class_id);
        $invoices = $query->orderByDesc('due_amount')->paginate(15)->withQueryString();
        $classes = SchoolClass::active()->get();
        return view('fees.due_report', compact('invoices', 'classes'));
    }
}

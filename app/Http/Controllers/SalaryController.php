<?php

namespace App\Http\Controllers;

use App\Models\SalaryRecord;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $query = SalaryRecord::with('teacher');
        if ($request->filled('month')) $query->where('month', $request->month);
        if ($request->filled('year')) $query->where('year', $request->year);
        if ($request->filled('status')) $query->where('payment_status', $request->status);
        $records = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $teachers = Teacher::active()->get();
        return view('salary.index', compact('records', 'teachers'));
    }

    public function create()
    {
        $teachers = Teacher::active()->get();
        return view('salary.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'month' => 'required|string',
            'year' => 'required|string',
            'basic_salary' => 'required|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'deductions' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|in:cash,bank_transfer,cheque,online',
            'remarks' => 'nullable|string',
        ]);
        $validated['bonus'] = $validated['bonus'] ?? 0;
        $validated['deductions'] = $validated['deductions'] ?? 0;
        $validated['net_salary'] = ($validated['basic_salary'] + $validated['bonus']) - $validated['deductions'];
        SalaryRecord::create($validated);
        return redirect()->route('salary.index')->with('success', 'Salary record created.');
    }

    public function show(SalaryRecord $salary)
    {
        $salary->load('teacher');
        return view('salary.show', compact('salary'));
    }

    public function pay(SalaryRecord $salary)
    {
        $salary->update(['payment_status' => 'paid', 'payment_date' => now()]);
        return redirect()->back()->with('success', 'Salary marked as paid.');
    }

    public function generateBulk()
    {
        $teachers = Teacher::active()->get();
        $month = now()->format('F');
        $year = now()->year;
        $count = 0;

        foreach ($teachers as $teacher) {
            $exists = SalaryRecord::where('teacher_id', $teacher->id)
                                 ->where('month', $month)
                                 ->where('year', $year)
                                 ->exists();

            if (!$exists && $teacher->salary_amount > 0) {
                SalaryRecord::create([
                    'teacher_id' => $teacher->id,
                    'month' => $month,
                    'year' => $year,
                    'basic_salary' => $teacher->salary_amount,
                    'bonus' => 0,
                    'deductions' => 0,
                    'payment_status' => 'pending_payment',
                    'due_date' => now(), // Set due date to generation date
                    'next_payment_date' => now()->addMonth(), // Suggested next payment
                ]);
                $count++;
            }
        }

        return redirect()->back()->with('success', "$count salary records generated for $month $year.");
    }

    public function destroy(SalaryRecord $salary)
    {
        $salary->delete();
        return redirect()->route('salary.index')->with('success', 'Salary record deleted.');
    }
}

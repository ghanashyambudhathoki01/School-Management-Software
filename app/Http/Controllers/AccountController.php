<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Payment;
use App\Models\SalaryRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $month = (int) $request->get('month', now()->month);
        $year = (int) $request->get('year', now()->year);

        $totalIncome = Income::forMonth($month, $year)->sum('amount');
        $totalFeeIncome = Payment::whereMonth('payment_date', $month)->whereYear('payment_date', $year)->sum('amount');
        $totalExpense = Expense::forMonth($month, $year)->sum('amount');
        $totalSalary = SalaryRecord::forMonth(now()->setMonth($month)->format('F'), $year)->paid()->sum('net_salary');

        $recentIncomes = Income::forMonth($month, $year)->orderByDesc('date')->limit(10)->get();
        $recentExpenses = Expense::forMonth($month, $year)->orderByDesc('date')->limit(10)->get();

        return view('accounts.index', compact('totalIncome', 'totalFeeIncome', 'totalExpense', 'totalSalary', 'recentIncomes', 'recentExpenses', 'month', 'year'));
    }

    public function incomes(Request $request)
    {
        $query = Income::query();
        if ($request->filled('category')) $query->byCategory($request->category);
        if ($request->filled('search')) $query->where('title', 'like', "%{$request->search}%");
        $incomes = $query->orderByDesc('date')->paginate(15)->withQueryString();
        return view('accounts.incomes', compact('incomes'));
    }

    public function storeIncome(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);
        $validated['recorded_by'] = Auth::id();
        Income::create($validated);
        return redirect()->route('accounts.incomes')->with('success', 'Income recorded.');
    }

    public function expenses(Request $request)
    {
        $query = Expense::query();
        if ($request->filled('category')) $query->byCategory($request->category);
        if ($request->filled('search')) $query->where('title', 'like', "%{$request->search}%");
        $expenses = $query->orderByDesc('date')->paginate(15)->withQueryString();
        return view('accounts.expenses', compact('expenses'));
    }

    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'receipt' => 'nullable|file|max:5120',
        ]);
        $validated['recorded_by'] = Auth::id();
        if ($request->hasFile('receipt')) {
            $validated['receipt'] = $request->file('receipt')->store('receipts', 'public');
        }
        Expense::create($validated);
        return redirect()->route('accounts.expenses')->with('success', 'Expense recorded.');
    }

    public function deleteIncome(Income $income)
    {
        $income->delete();
        return redirect()->back()->with('success', 'Income deleted.');
    }

    public function deleteExpense(Expense $expense)
    {
        $expense->delete();
        return redirect()->back()->with('success', 'Expense deleted.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $query = Certificate::with('student');
        if ($request->filled('type')) $query->byType($request->type);
        $certificates = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        return view('certificates.index', compact('certificates'));
    }

    public function create()
    {
        $students = Student::active()->get();
        return view('certificates.create', compact('students'));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|in:transfer,character,completion',
            'issue_date' => 'required|date',
            'content' => 'nullable|string',
        ]);
        $v['issued_by'] = Auth::id();
        $v['status'] = 'issued';
        Certificate::create($v);
        return redirect()->route('certificates.index')->with('success', 'Certificate created.');
    }

    public function show(Certificate $certificate)
    {
        $certificate->load(['student.schoolClass', 'issuer']);
        return view('certificates.show', compact('certificate'));
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return redirect()->route('certificates.index')->with('success', 'Certificate deleted.');
    }
}

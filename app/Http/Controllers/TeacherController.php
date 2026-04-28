<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::with(['user', 'subjects']);

        if ($request->filled('search')) {
            $query->search($request->search);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $teachers = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'religion' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:100',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:10',
            'salary_amount' => 'nullable|numeric|min:0',
            'salary_type' => 'nullable|in:monthly,hourly',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Create user account for teacher
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teacher',
            'access_status' => 'active',
            'account_start_date' => now(),
            'account_expiry_date' => now()->addYear(),
            'access_duration' => 365,
            'phone' => $validated['phone'] ?? null,
        ]);

        $teacherData = collect($validated)->except(['email', 'password', 'password_confirmation'])->toArray();
        $teacherData['user_id'] = $user->id;
        $teacherData['employee_id'] = 'EMP-' . str_pad($user->id, 5, '0', STR_PAD_LEFT);

        if ($request->hasFile('photo')) {
            $teacherData['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        Teacher::create($teacherData);

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher added successfully.');
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(['user', 'subjects.schoolClass', 'salaryRecords']);
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|string|max:5',
            'religion' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:100',
            'designation' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:10',
            'salary_amount' => 'nullable|numeric|min:0',
            'salary_type' => 'nullable|in:monthly,hourly',
            'status' => 'nullable|in:active,inactive,on_leave,terminated',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        $teacher->update($validated);

        // Update associated user
        if ($teacher->user) {
            $userData = [
                'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                'phone' => $validated['phone'] ?? null,
            ];

            // Map teacher status to user access status
            if ($validated['status'] === 'terminated') {
                $userData['access_status'] = 'disabled';
            } elseif ($validated['status'] === 'inactive') {
                $userData['access_status'] = 'suspended';
            } elseif ($validated['status'] === 'active') {
                $userData['access_status'] = 'active';
            }

            $teacher->user->update($userData);
        }

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(Teacher $teacher)
    {
        if ($teacher->user) {
            $teacher->user->delete();
        }
        $teacher->delete();
        return redirect()->route('teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}

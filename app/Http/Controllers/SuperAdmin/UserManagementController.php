<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * List all users (school admins and teachers).
     */
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'super_admin');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('access_status', $request->status);
        }

        $users = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('super_admin.users.index', compact('users'));
    }

    /**
     * Show create user form.
     */
    public function create()
    {
        return view('super_admin.users.create');
    }

    /**
     * Store new user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => ['required', Rule::in(['school_admin', 'teacher'])],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'access_duration' => 'nullable|integer|min:1',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['access_status'] = 'active';
        $validated['account_start_date'] = now();
        $validated['access_duration'] = (int) ($validated['access_duration'] ?? 365);
        $validated['account_expiry_date'] = now()->addDays((int) $validated['access_duration']);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('users', 'public');
        }

        $user = User::create($validated);

        // If creating a teacher, also create teacher profile
        if ($validated['role'] === 'teacher') {
            $nameParts = explode(' ', $validated['name'], 2);
            Teacher::create([
                'user_id' => $user->id,
                'employee_id' => 'EMP-' . str_pad($user->id, 5, '0', STR_PAD_LEFT),
                'first_name' => $nameParts[0],
                'last_name' => $nameParts[1] ?? '',
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'joining_date' => now(),
                'status' => 'active',
            ]);
        }

        return redirect()->route('super_admin.users.index')
            ->with('success', 'User account created successfully.');
    }

    /**
     * Show user details.
     */
    public function show(User $user)
    {
        return view('super_admin.users.show', compact('user'));
    }

    /**
     * Show edit form.
     */
    public function edit(User $user)
    {
        return view('super_admin.users.edit', compact('user'));
    }

    /**
     * Update user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('users', 'public');
        }

        $user->update($validated);

        return redirect()->route('super_admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Activate user account.
     */
    public function activate(User $user)
    {
        $user->update(['access_status' => 'active']);
        return back()->with('success', 'Account activated successfully.');
    }

    /**
     * Suspend user account.
     */
    public function suspend(User $user)
    {
        $user->update(['access_status' => 'suspended']);
        return back()->with('success', 'Account suspended successfully.');
    }

    /**
     * Disable user account.
     */
    public function disable(User $user)
    {
        $user->update(['access_status' => 'disabled']);
        return back()->with('success', 'Account disabled successfully.');
    }

    /**
     * Renew user account for 1 year.
     */
    public function renew(User $user)
    {
        $user->update([
            'access_status' => 'active',
            'account_expiry_date' => now()->addYear(),
            'renewal_date' => now(),
            'access_duration' => 365,
        ]);
        return back()->with('success', 'Account renewed for 1 year successfully.');
    }

    /**
     * Custom extend user account.
     */
    public function extend(Request $request, User $user)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:3650',
        ]);

        $currentExpiry = $user->account_expiry_date ?? now();
        if ($currentExpiry->isPast()) {
            $currentExpiry = now();
        }

        $user->update([
            'access_status' => 'active',
            'account_expiry_date' => $currentExpiry->addDays((int) $request->days),
            'renewal_date' => now(),
            'access_duration' => (int) $request->days,
        ]);

        return back()->with('success', "Account extended by {$request->days} days successfully.");
    }

    /**
     * Delete user account (soft delete).
     */
    public function destroy(User $user)
    {
        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Cannot delete Super Admin account.');
        }

        $user->delete();
        return redirect()->route('super_admin.users.index')
            ->with('success', 'User account deleted successfully.');
    }
}

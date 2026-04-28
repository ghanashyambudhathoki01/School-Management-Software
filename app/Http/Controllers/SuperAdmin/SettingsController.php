<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show general settings form.
     */
    public function index()
    {
        $schoolName = Setting::get('school_name', 'Gorkhabyte Academy Academy');
        $schoolAddress = Setting::get('school_address', '');
        $schoolEmail = Setting::get('school_email', '');
        $schoolPhone = Setting::get('school_phone', '');

        return view('super_admin.settings.index', compact('schoolName', 'schoolAddress', 'schoolEmail', 'schoolPhone'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_address' => 'nullable|string',
            'school_email' => 'nullable|email',
            'school_phone' => 'nullable|string',
        ]);

        Setting::set('school_name', $request->school_name);
        Setting::set('school_address', $request->school_address);
        Setting::set('school_email', $request->school_email);
        Setting::set('school_phone', $request->school_phone);

        return back()->with('success', 'General settings updated successfully.');
    }
}

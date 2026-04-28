<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::withCount(['sections', 'students'])->orderBy('numeric_name')->paginate(15);
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'numeric_name' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        SchoolClass::create($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Class created successfully.');
    }

    public function edit(SchoolClass $class)
    {
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'numeric_name' => 'nullable|integer',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')
            ->with('success', 'Class updated successfully.');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return redirect()->route('classes.index')
            ->with('success', 'Class deleted successfully.');
    }

    /**
     * Get sections for a class (AJAX).
     */
    public function getSections(SchoolClass $class)
    {
        return response()->json($class->sections()->active()->get());
    }
}

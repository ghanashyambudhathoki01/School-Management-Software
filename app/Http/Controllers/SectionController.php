<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index(Request $request)
    {
        $query = Section::with('schoolClass')->withCount('students');

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $sections = $query->orderBy('class_id')->orderBy('name')->paginate(15)->withQueryString();
        $classes = SchoolClass::active()->get();

        return view('sections.index', compact('sections', 'classes'));
    }

    public function create()
    {
        $classes = SchoolClass::active()->get();
        return view('sections.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:50',
            'capacity' => 'nullable|integer|min:1',
        ]);

        Section::create($validated);

        return redirect()->route('sections.index')
            ->with('success', 'Section created successfully.');
    }

    public function edit(Section $section)
    {
        $classes = SchoolClass::active()->get();
        return view('sections.edit', compact('section', 'classes'));
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'name' => 'required|string|max:50',
            'capacity' => 'nullable|integer|min:1',
            'status' => 'nullable|boolean',
        ]);

        $section->update($validated);

        return redirect()->route('sections.index')
            ->with('success', 'Section updated successfully.');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('sections.index')
            ->with('success', 'Section deleted successfully.');
    }
}

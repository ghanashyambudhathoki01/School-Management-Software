<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        $query = Notice::with('publisher');
        if ($request->filled('type')) $query->where('type', $request->type);
        if ($request->filled('search')) $query->where('title', 'like', "%{$request->search}%");
        $notices = $query->orderByDesc('publish_date')->paginate(15)->withQueryString();
        return view('notices.index', compact('notices'));
    }

    public function create()
    {
        return view('notices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:general,teacher,student,urgent',
            'target_audience' => 'nullable|string',
            'publish_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:publish_date',
            'attachment' => 'nullable|file|max:5120',
        ]);
        $validated['published_by'] = Auth::id();
        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('notices', 'public');
        }
        Notice::create($validated);
        return redirect()->route('notices.index')->with('success', 'Notice published successfully.');
    }

    public function show(Notice $notice)
    {
        return view('notices.show', compact('notice'));
    }

    public function edit(Notice $notice)
    {
        return view('notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:general,teacher,student,urgent',
            'target_audience' => 'nullable|string',
            'publish_date' => 'required|date',
            'expiry_date' => 'nullable|date',
            'status' => 'nullable|boolean',
            'attachment' => 'nullable|file|max:5120',
        ]);
        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('notices', 'public');
        }
        $notice->update($validated);
        return redirect()->route('notices.index')->with('success', 'Notice updated.');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return redirect()->route('notices.index')->with('success', 'Notice deleted.');
    }
}

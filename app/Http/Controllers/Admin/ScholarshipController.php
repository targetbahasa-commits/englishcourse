<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of the scholarships.
     */
    public function index()
    {
        $scholarships = Scholarship::latest()->paginate(10);
        return view('admin.scholarships.index', compact('scholarships'));
    }

    /**
     * Show the form for creating a new scholarship.
     */
    public function create()
    {
        return view('admin.scholarships.create');
    }

    /**
     * Store a newly created scholarship in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'level_of_study' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'benefits' => 'required|string',
            'deadline' => 'required|date',
            'apply_link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $scholarship = new Scholarship($validated);
        $scholarship->is_active = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('scholarships', 'public');
            $scholarship->image_path = $imagePath;
        }

        $scholarship->save();

        return redirect()->route('admin.scholarships.index')
                         ->with('success', 'Scholarship created successfully.');
    }

    /**
     * Show the form for editing the specified scholarship.
     */
    public function edit(Scholarship $scholarship)
    {
        return view('admin.scholarships.edit', compact('scholarship'));
    }

    /**
     * Update the specified scholarship in storage.
     */
    public function update(Request $request, Scholarship $scholarship)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'level_of_study' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'benefits' => 'required|string',
            'deadline' => 'required|date',
            'apply_link' => 'required|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
        ]);

        $scholarship->fill($validated);
        $scholarship->is_active = $request->boolean('is_active', false);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($scholarship->image_path) {
                Storage::disk('public')->delete($scholarship->image_path);
            }
            $imagePath = $request->file('image')->store('scholarships', 'public');
            $scholarship->image_path = $imagePath;
        }

        $scholarship->save();

        return redirect()->route('admin.scholarships.index')
                         ->with('success', 'Scholarship updated successfully.');
    }

    /**
     * Remove the specified scholarship from storage.
     */
    public function destroy(Scholarship $scholarship)
    {
        if ($scholarship->image_path) {
            Storage::disk('public')->delete($scholarship->image_path);
        }
        
        $scholarship->delete();

        return redirect()->route('admin.scholarships.index')
                         ->with('success', 'Scholarship deleted successfully.');
    }
}

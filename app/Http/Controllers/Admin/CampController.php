<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\User;
use Illuminate\Http\Request;

class CampController extends Controller
{
    public function index(Request $request)
    {
        $query = Camp::with('teacher')->withCount('rooms');
        
        if ($request->filled('search')) {
            $query->where('nama_camp', 'like', '%' . $request->search . '%');
        }
        
        $camps = $query->paginate(15)->withQueryString();
        
        return view('admin.camp-management.camps.index', compact('camps'));
    }

    public function create()
    {
        $teachers = User::byRole('teacher')->get();
        return view('admin.camp-management.camps.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_camp' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'gender_khusus' => 'required|in:Putra,Putri',
            'teacher_id' => 'required|exists:users,id',
            'jumlah_toilet' => 'required|integer|min:0',
        ]);

        Camp::create($validated);

        return redirect()->route('admin.camps.index')->with('success', 'Master Camp berhasil ditambahkan.');
    }

    public function show(Camp $camp)
    {
        $camp->load(['teacher', 'rooms' => function ($q) {
            $q->withCount('users');
        }]);
        return view('admin.camp-management.camps.show', compact('camp'));
    }

    public function edit(Camp $camp)
    {
        $teachers = User::byRole('teacher')->get();
        return view('admin.camp-management.camps.edit', compact('camp', 'teachers'));
    }

    public function update(Request $request, Camp $camp)
    {
        $validated = $request->validate([
            'nama_camp' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'gender_khusus' => 'required|in:Putra,Putri',
            'teacher_id' => 'required|exists:users,id',
            'jumlah_toilet' => 'required|integer|min:0',
        ]);

        $camp->update($validated);

        return redirect()->route('admin.camps.index')->with('success', 'Master Camp berhasil diperbarui.');
    }

    public function destroy(Camp $camp)
    {
        $camp->delete();
        return redirect()->route('admin.camps.index')->with('success', 'Master Camp berhasil dihapus.');
    }
}

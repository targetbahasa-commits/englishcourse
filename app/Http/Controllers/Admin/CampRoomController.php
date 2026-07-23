<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampRoom;
use App\Models\Camp;
use Illuminate\Http\Request;

class CampRoomController extends Controller
{
    public function create(Camp $camp)
    {
        return view('admin.camp-management.rooms.create', compact('camp'));
    }

    public function store(Request $request, Camp $camp)
    {
        $validated = $request->validate([
            'nama_kamar' => 'required|string|max:255',
            'kapasitas_per_kamar' => 'required|integer|min:1',
            'harga_per_orang' => 'required|numeric|min:0',
            'status' => 'required|in:Tersedia,Penuh',
        ]);

        $camp->rooms()->create($validated);

        return redirect()->route('admin.camps.show', $camp)->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit(CampRoom $campRoom)
    {
        $camp = $campRoom->camp;
        return view('admin.camp-management.rooms.edit', compact('campRoom', 'camp'));
    }

    public function update(Request $request, CampRoom $campRoom)
    {
        $validated = $request->validate([
            'nama_kamar' => 'required|string|max:255',
            'kapasitas_per_kamar' => 'required|integer|min:1',
            'harga_per_orang' => 'required|numeric|min:0',
            'status' => 'required|in:Tersedia,Penuh',
        ]);

        $campRoom->update($validated);

        return redirect()->route('admin.camps.show', $campRoom->camp_id)->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy(CampRoom $campRoom)
    {
        $campId = $campRoom->camp_id;
        $campRoom->delete();
        return redirect()->route('admin.camps.show', $campId)->with('success', 'Kamar berhasil dihapus.');
    }
}

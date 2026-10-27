<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrammarPlacementPackage;
use Illuminate\Http\Request;

class GrammarPlacementPackageController extends Controller
{
    public function index()
    {
        $packages = GrammarPlacementPackage::withCount(['questions', 'results'])
            ->orderByDesc('id')
            ->get();

        return view('admin.grammar-placement.packages.index', compact('packages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $data['is_active'] = true;

        $package = GrammarPlacementPackage::create($data);

        return redirect()->route('admin.grammar-placement.questions.index', $package)
            ->with('success', 'Paket tes grammar dibuat. Tambahkan soal untuk paket ini.');
    }

    public function update(Request $request, GrammarPlacementPackage $package)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $package->update($data);

        return back()->with('success', 'Paket tes grammar berhasil diperbarui.');
    }

    public function destroy(GrammarPlacementPackage $package)
    {
        $package->delete();

        return back()->with('success', 'Paket tes grammar berhasil dihapus.');
    }

    public function activate(GrammarPlacementPackage $package)
    {
        $package->update(['is_active' => true]);

        return back()->with('success', "Paket \"{$package->title}\" diaktifkan. Link tes bisa dibagikan ke calon siswa.");
    }

    public function deactivate(GrammarPlacementPackage $package)
    {
        $package->update(['is_active' => false]);

        return back()->with('success', "Paket \"{$package->title}\" dinonaktifkan. Link tes tidak bisa diakses sampai diaktifkan kembali.");
    }
}

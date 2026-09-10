<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlacementTestPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPlacementTestPackageController extends Controller
{
    public function index(Request $request)
    {
        $packages = PlacementTestPackage::withCount(['readingPassages', 'listeningBanks', 'writingPrompts', 'speakingPrompts'])
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        return view('admin.placement-test.packages.index', compact('packages'));
    }

    public function store(Request $request)
    {
        $data = $this->validatePackage($request);
        $package = PlacementTestPackage::create($data);

        return redirect()->route('admin.placement-test.reading.index', ['package_id' => $package->id])
            ->with('success', 'Paket tes kompetensi dibuat.');
    }

    public function update(Request $request, PlacementTestPackage $package)
    {
        $data = $this->validatePackage($request);
        $package->update($data);

        return back()->with('success', 'Paket tes kompetensi diperbarui.');
    }

    public function destroy(PlacementTestPackage $package)
    {
        $package->delete();

        return back()->with('success', 'Paket tes kompetensi dihapus.');
    }

    public function activate(PlacementTestPackage $package)
    {
        DB::transaction(function () use ($package) {
            PlacementTestPackage::where('id', '!=', $package->id)->where('status', 'active')->update(['status' => 'draft']);
            $package->update(['status' => 'active']);
        });

        $message = $package->fresh()->scheduleState() === 'scheduled'
            ? "Paket \"{$package->title}\" diaktifkan, tapi baru akan mulai melayani siswa sesuai jadwal \"Aktif Mulai\" yang diatur."
            : "Paket \"{$package->title}\" sekarang aktif dan dipakai siswa.";

        return back()->with('success', $message);
    }

    public function deactivate(PlacementTestPackage $package)
    {
        $package->update(['status' => 'draft']);

        return back()->with('success', "Paket \"{$package->title}\" dinonaktifkan. Saat ini tidak ada paket yang aktif melayani siswa kecuali paket lain diaktifkan.");
    }

    private function validatePackage(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'active_from' => 'nullable|date',
            'active_until' => 'nullable|date|after:active_from',
            'order' => 'nullable|integer|min:0',
        ]);
    }
}

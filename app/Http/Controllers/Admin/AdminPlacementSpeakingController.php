<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ResolvesPlacementTestPackage;
use App\Http\Controllers\Controller;
use App\Models\PlacementSpeakingPrompt;
use App\Models\PlacementTestPackage;
use Illuminate\Http\Request;

class AdminPlacementSpeakingController extends Controller
{
    use ResolvesPlacementTestPackage;

    public function index(Request $request)
    {
        $package = $this->resolvePackage($request);
        if (!$package) {
            return redirect()->route('admin.placement-test.packages.index')
                ->with('error', 'Buat paket tes kompetensi terlebih dahulu.');
        }

        $prompts = PlacementSpeakingPrompt::where('placement_test_package_id', $package->id)
            ->orderBy('order')
            ->orderBy('id')
            ->get();
        $packages = PlacementTestPackage::orderBy('order')->orderBy('id')->get();

        return view('admin.placement-test.speaking.index', compact('prompts', 'package', 'packages'));
    }

    public function store(Request $request)
    {
        $packageId = $request->validate(['placement_test_package_id' => 'required|exists:placement_test_packages,id'])['placement_test_package_id'];
        $data = $this->validatePrompt($request);
        $data['placement_test_package_id'] = $packageId;

        PlacementSpeakingPrompt::create($data);

        return redirect()->route('admin.placement-test.speaking.index', ['package_id' => $packageId])
            ->with('success', 'Speaking prompt created.');
    }

    public function update(Request $request, PlacementSpeakingPrompt $speaking)
    {
        $data = $this->validatePrompt($request);
        $speaking->update($data);

        return back()->with('success', 'Speaking prompt updated.');
    }

    public function destroy(PlacementSpeakingPrompt $speaking)
    {
        $speaking->delete();

        return back()->with('success', 'Speaking prompt deleted.');
    }

    private function validatePrompt(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'prompt_text' => 'required|string',
            'prep_seconds' => 'required|integer|min:0|max:600',
            'response_seconds' => 'required|integer|min:1|max:600',
            'status' => 'required|in:draft,ready',
            'order' => 'nullable|integer|min:0',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ResolvesPlacementTestPackage;
use App\Http\Controllers\Controller;
use App\Models\PlacementTestPackage;
use App\Models\PlacementWritingPrompt;
use Illuminate\Http\Request;

class AdminPlacementWritingController extends Controller
{
    use ResolvesPlacementTestPackage;

    public function index(Request $request)
    {
        $package = $this->resolvePackage($request);
        if (!$package) {
            return redirect()->route('admin.placement-test.packages.index')
                ->with('error', 'Buat paket tes kompetensi terlebih dahulu.');
        }

        $prompts = PlacementWritingPrompt::where('placement_test_package_id', $package->id)
            ->orderBy('order')
            ->orderBy('id')
            ->get();
        $packages = PlacementTestPackage::orderBy('order')->orderBy('id')->get();

        return view('admin.placement-test.writing.index', compact('prompts', 'package', 'packages'));
    }

    public function store(Request $request)
    {
        $packageId = $request->validate(['placement_test_package_id' => 'required|exists:placement_test_packages,id'])['placement_test_package_id'];
        $data = $this->validatePrompt($request);
        $data['placement_test_package_id'] = $packageId;

        PlacementWritingPrompt::create($data);

        return redirect()->route('admin.placement-test.writing.index', ['package_id' => $packageId])
            ->with('success', 'Writing prompt created.');
    }

    public function update(Request $request, PlacementWritingPrompt $writing)
    {
        $data = $this->validatePrompt($request);
        $writing->update($data);

        return back()->with('success', 'Writing prompt updated.');
    }

    public function destroy(PlacementWritingPrompt $writing)
    {
        $writing->delete();

        return back()->with('success', 'Writing prompt deleted.');
    }

    private function validatePrompt(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'prompt_text' => 'required|string',
            'min_words' => 'required|integer|min:0',
            'status' => 'required|in:draft,ready',
            'order' => 'nullable|integer|min:0',
        ]);
    }
}

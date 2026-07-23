<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Setting;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    /**
     * Display the pricing management dashboard.
     */
    public function index()
    {
        // --- Mock Tests (Cambridge IELTS) ---
        // Grouped by edition: each edition has a "Full Edition" (package) price
        // and 4 individual test prices.
        $cambridgeEditions = [];
        $editionSlugs = ['cambridge-16', 'cambridge-17', 'cambridge-18', 'cambridge-19', 'cambridge-20'];

        foreach ($editionSlugs as $editionSlug) {
            $editionNum = str_replace('cambridge-', '', $editionSlug);
            $pkg = Program::where('slug', $editionSlug)->first();
            if (!$pkg) continue;

            $tests = [];
            for ($i = 1; $i <= 4; $i++) {
                $testSlug = $editionSlug . '-test-' . $i;
                $tests[] = Program::where('slug', $testSlug)->first();
            }

            $cambridgeEditions[] = [
                'edition'   => $editionNum,
                'package'   => $pkg,
                'tests'     => $tests,
            ];
        }

        // --- TOEFL ITP Mock Packages ---
        $toeflMockPrograms = Program::where('slug', 'like', 'toefl-itp-mock-%')
            ->orderBy('slug')
            ->get();

        // --- Online Tests: price stored in `settings` table with key pattern
        //   "online_test_{slug}_price"  (we'll read/write them here)
        $onlineTestSlugs = ['ielts_academic', 'ielts_general', 'toefl_itp', 'pte_academic'];
        $onlineTestLabels = [
            'ielts_academic' => 'IELTS Academic',
            'ielts_general'  => 'IELTS General',
            'toefl_itp'      => 'TOEFL ITP',
            'pte_academic'   => 'PTE Academic',
        ];

        $onlineTests = [];
        foreach ($onlineTestSlugs as $slug) {
            $priceSetting = Setting::where('key', "online_test_{$slug}_price")->first();
            $enabledSetting = Setting::where('key', "online_test_{$slug}_enabled")->first();
            $onlineTests[] = [
                'slug'    => $slug,
                'label'   => $onlineTestLabels[$slug],
                'price'   => $priceSetting ? (int) $priceSetting->value : 0,
                'enabled' => ($enabledSetting->value ?? '1') === '1',
            ];
        }

        return view('admin.pricing.index', compact(
            'cambridgeEditions',
            'toeflMockPrograms',
            'onlineTests',
        ));
    }

    /**
     * Bulk-update prices for Cambridge mock test programs.
     */
    public function updateMockTest(Request $request)
    {
        $request->validate([
            'prices'   => 'required|array',
            'prices.*' => 'nullable|integer|min:0',
        ]);

        foreach ($request->input('prices', []) as $programId => $price) {
            $program = Program::find((int) $programId);
            if (!$program) continue;

            // Only allow updating cambridge/toefl-mock programs via this endpoint
            if (!str_starts_with($program->slug, 'cambridge-') && !str_starts_with($program->slug, 'toefl-itp-mock')) {
                continue;
            }

            $program->price = (int) $price;
            $program->save();
        }

        return back()->with('success', 'Harga Mock Test berhasil diperbarui!');
    }

    /**
     * Update a single program price via AJAX.
     */
    public function updateSingleProgram(Request $request, Program $program)
    {
        $request->validate([
            'price' => 'required|integer|min:0',
        ]);

        // Security check: only allow cambridge / toefl-mock programs
        if (!str_starts_with($program->slug, 'cambridge-') && !str_starts_with($program->slug, 'toefl-itp-mock')) {
            return response()->json(['error' => 'Not allowed'], 403);
        }

        $program->price = (int) $request->input('price');
        $program->save();

        return response()->json(['success' => true, 'price' => $program->price]);
    }

    /**
     * Update online test prices (stored in settings table).
     */
    public function updateOnlineTest(Request $request)
    {
        $request->validate([
            'online_prices'         => 'required|array',
            'online_prices.*'       => 'nullable|integer|min:0',
            'online_enabled'        => 'nullable|array',
            'online_enabled.*'      => 'nullable|in:1,0',
        ]);

        $allowedSlugs = ['ielts_academic', 'ielts_general', 'toefl_itp', 'pte_academic'];

        foreach ($request->input('online_prices', []) as $slug => $price) {
            if (!in_array($slug, $allowedSlugs, true)) continue;

            Setting::updateOrCreate(
                ['key' => "online_test_{$slug}_price"],
                ['value' => (string) (int) $price, 'type' => 'integer']
            );

            $enabled = isset($request->input('online_enabled', [])[$slug]) ? '1' : '0';
            Setting::updateOrCreate(
                ['key' => "online_test_{$slug}_enabled"],
                ['value' => $enabled, 'type' => 'boolean']
            );
        }

        return back()->with('success', 'Harga Online Test berhasil diperbarui!');
    }
}

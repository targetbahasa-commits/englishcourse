<?php

namespace App\Http\Controllers\Admin;

use App\Application\GrammarPlacement\ResolveSelfStudyGrammarMode;
use App\Http\Controllers\Controller;
use App\Models\GrammarPlacementResult;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class SelfStudyPlacementController extends Controller
{
    public function index(ResolveSelfStudyGrammarMode $modeResolver)
    {
        $packageId = Setting::where('key', 'self_study_grammar_placement_package_id')->value('value');

        $results = $packageId
            ? GrammarPlacementResult::where('grammar_placement_package_id', $packageId)
                ->whereNotNull('user_id')
                ->with('student')
                ->orderByDesc('id')
                ->get()
                ->map(function (GrammarPlacementResult $result) use ($modeResolver) {
                    $result->resolved_mode = $modeResolver->resolve((float) $result->percentage);
                    return $result;
                })
            : collect();

        $students = User::where('role', '!=', 'admin')->orderBy('name')->get(['id', 'name', 'email', 'self_study_grammar_mode_override']);

        return view('admin.self-study-placement.index', compact('results', 'students', 'packageId'));
    }

    public function override(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'mode' => 'nullable|in:A,B',
        ]);

        User::where('id', $data['user_id'])->update([
            'self_study_grammar_mode_override' => $data['mode'] ?? null,
        ]);

        return back()->with('success', $data['mode']
            ? "Mode berhasil diatur ke Mode {$data['mode']}."
            : 'Mode override dihapus, siswa kembali mengikuti hasil tes penempatan.');
    }

    public function setGatePackage(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'package_id' => 'required|exists:grammar_placement_packages,id',
        ]);

        Setting::updateOrCreate(
            ['key' => 'self_study_grammar_placement_package_id'],
            ['value' => (string) $data['package_id'], 'type' => 'string']
        );

        $pkg = \App\Models\GrammarPlacementPackage::find($data['package_id']);
        $title = $pkg ? $pkg->title : "ID {$data['package_id']}";

        return back()->with('success', "Paket tes \"{$title}\" berhasil dijadikan tes penempatan aktif untuk siswa.");
    }
}

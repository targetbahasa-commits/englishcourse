<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FreeTestCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FreeTestCertificateController extends Controller
{
    public function index()
    {
        $certificates = collect();
        $testTypes = ['ielts_academic', 'ielts_general', 'toefl_itp', 'pte_academic'];
        
        foreach ($testTypes as $type) {
            $cert = FreeTestCertificate::firstOrCreate(
                ['test_type' => $type],
                [
                    'background_image' => null,
                    'description' => 'Certificate for ' . ucwords(str_replace('_', ' ', $type)),
                    'text_color' => '#000000',
                    'is_active' => true,
                ]
            );
            $certificates->push($cert);
        }

        return view('admin.free-tests.certificates.index', compact('certificates'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'description' => 'nullable|string',
            'text_color' => 'required|string',
            'is_active' => 'boolean',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
        ]);

        $certificate = FreeTestCertificate::findOrFail($id);
        
        $data = [
            'description' => $request->description,
            'text_color' => $request->text_color,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('background_image')) {
            if ($certificate->background_image) {
                Storage::disk('public')->delete($certificate->background_image);
            }
            $data['background_image'] = $request->file('background_image')->store('certificates', 'public');
        }

        $certificate->update($data);

        return back()->with('success', 'Certificate configuration updated successfully.');
    }
}

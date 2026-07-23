<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfflineTestCertificate;
use App\Models\OfflineTestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfflineTestCertificateController extends Controller
{
    public function index()
    {
        // Define default test types
        $testTypes = [
            'toefl_itp' => 'TOEFL ITP',
            'ielts_academic' => 'IELTS Academic',
            'ielts_general' => 'IELTS General Training'
        ];

        // Ensure default certificates exist
        foreach ($testTypes as $slug => $label) {
            OfflineTestCertificate::firstOrCreate(['test_type' => $slug], [
                'is_active' => true,
                'text_color' => '#0f172a',
                'template_config' => [
                    'eyebrow' => 'CERTIFICATE OF ACHIEVEMENT',
                    'title' => 'This is to certify that',
                    'subtitle' => 'has achieved the following score on the',
                    'score_label' => 'Total Score',
                    'body' => 'This certificate is proudly presented for outstanding performance in the offline test.',
                    'footer_left_label' => 'Date',
                    'footer_right_label' => 'Signature',
                    'signature_name' => 'Director',
                ]
            ]);
        }

        $certificates = OfflineTestCertificate::orderBy('test_type')->get();
        return view('admin.offline-tests.certificates.index', compact('certificates'));
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $validated = $request->validate([
            'text_color'       => 'required|string',
            'is_active'        => 'boolean',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
            'eyebrow'          => 'nullable|string|max:120',
            'title'            => 'nullable|string|max:120',
            'subtitle'         => 'nullable|string|max:200',
            'score_label'      => 'nullable|string|max:120',
            'body'             => 'nullable|string|max:500',
            'footer_left_label'=> 'nullable|string|max:120',
            'footer_right_label'=> 'nullable|string|max:120',
            'signature_name'   => 'nullable|string|max:120',
        ]);

        $certificate = OfflineTestCertificate::findOrFail($id);
        $certificate->is_active = $request->has('is_active');
        $certificate->text_color = $validated['text_color'];
        
        $templateConfig = $certificate->template_config ?? [];
        $templateConfig['eyebrow'] = $validated['eyebrow'] ?? null;
        $templateConfig['title'] = $validated['title'] ?? null;
        $templateConfig['subtitle'] = $validated['subtitle'] ?? null;
        $templateConfig['score_label'] = $validated['score_label'] ?? null;
        $templateConfig['body'] = $validated['body'] ?? null;
        $templateConfig['footer_left_label'] = $validated['footer_left_label'] ?? null;
        $templateConfig['footer_right_label'] = $validated['footer_right_label'] ?? null;
        $templateConfig['signature_name'] = $validated['signature_name'] ?? null;
        
        $certificate->template_config = $templateConfig;

        if ($request->hasFile('background_image')) {
            if ($certificate->background_image) {
                Storage::disk('public')->delete($certificate->background_image);
            }
            $path = $request->file('background_image')->store('certificates', 'public');
            $certificate->background_image = $path;
        }

        $certificate->save();

        return back()->with('success', 'Certificate configuration updated successfully.');
    }

    public function preview(Request $request)
    {
        $id = $request->query('id');
        $certificate = OfflineTestCertificate::findOrFail($id);

        $result = OfflineTestResult::where('test_type', $certificate->test_type)
            ->latest('created_at')
            ->first();

        return view('admin.offline-tests.certificates.preview', [
            'certificate' => $certificate,
            'result' => $result,
        ]);
    }
}

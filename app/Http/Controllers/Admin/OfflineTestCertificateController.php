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
            'text_color'              => 'required|string',
            'is_active'               => 'boolean',
            'background_image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'signature_image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'stamp_image'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'remove_background_image' => 'nullable|boolean',
            'remove_signature_image'  => 'nullable|boolean',
            'remove_stamp_image'      => 'nullable|boolean',
            'eyebrow'                 => 'nullable|string|max:120',
            'title'                   => 'nullable|string|max:120',
            'subtitle'                => 'nullable|string|max:200',
            'score_label'             => 'nullable|string|max:120',
            'body'                    => 'nullable|string|max:500',
            'footer_left_label'       => 'nullable|string|max:120',
            'footer_right_label'      => 'nullable|string|max:120',
            'signature_name'          => 'nullable|string|max:120',
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

        // Handle signature image
        if ($request->boolean('remove_signature_image')) {
            if (!empty($templateConfig['signature_image'])) {
                Storage::disk('public')->delete($templateConfig['signature_image']);
                $templateConfig['signature_image'] = null;
            }
        }
        if ($request->hasFile('signature_image')) {
            if (!empty($templateConfig['signature_image'])) {
                Storage::disk('public')->delete($templateConfig['signature_image']);
            }
            $templateConfig['signature_image'] = $request->file('signature_image')->store('certificates/signatures', 'public');
        }

        // Handle stamp image
        if ($request->boolean('remove_stamp_image')) {
            if (!empty($templateConfig['stamp_image'])) {
                Storage::disk('public')->delete($templateConfig['stamp_image']);
                $templateConfig['stamp_image'] = null;
            }
        }
        if ($request->hasFile('stamp_image')) {
            if (!empty($templateConfig['stamp_image'])) {
                Storage::disk('public')->delete($templateConfig['stamp_image']);
            }
            $templateConfig['stamp_image'] = $request->file('stamp_image')->store('certificates/stamps', 'public');
        }
        
        $certificate->template_config = $templateConfig;

        // Handle background image
        if ($request->boolean('remove_background_image') && $certificate->background_image) {
            Storage::disk('public')->delete($certificate->background_image);
            $certificate->background_image = null;
        }
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

    public function backgroundImage($id)
    {
        $certificate = OfflineTestCertificate::findOrFail($id);

        if (! $certificate->background_image || ! Storage::disk('public')->exists($certificate->background_image)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($certificate->background_image));
    }

    public function signatureImage($id)
    {
        $certificate = OfflineTestCertificate::findOrFail($id);
        $path = $certificate->template_config['signature_image'] ?? null;

        if (! $path || ! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($path));
    }

    public function stampImage($id)
    {
        $certificate = OfflineTestCertificate::findOrFail($id);
        $path = $certificate->template_config['stamp_image'] ?? null;

        if (! $path || ! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($path));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Application\FreeTest\ManageFreeTestCertificates;
use App\Http\Controllers\Controller;
use App\Models\FreeTestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FreeTestCertificateController extends Controller
{
    public function __construct(
        private readonly ManageFreeTestCertificates $useCase
    ) {}

    public function index()
    {
        $certificates = $this->useCase->listAll();
        return view('admin.free-tests.certificates.index', compact('certificates'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'description'             => 'nullable|string',
            'text_color'              => 'required|string',
            'is_active'               => 'boolean',
            'background_image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'background_opacity'      => 'nullable|numeric|min:0|max:100',
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
            'signature_title'         => 'nullable|string|max:120',
        ]);

        $certificate = $this->useCase->findOrFail($id);

        $templateConfig = $certificate->template_config ?? [];
        $templateConfig['background_opacity'] = $request->filled('background_opacity')
            ? (int) $request->input('background_opacity')
            : (isset($templateConfig['background_opacity']) ? (int) $templateConfig['background_opacity'] : 18);
        $templateConfig['eyebrow'] = $request->input('eyebrow') ?? '';
        $templateConfig['title'] = $request->input('title') ?? '';
        $templateConfig['subtitle'] = $request->input('subtitle') ?? '';
        $templateConfig['score_label'] = $request->input('score_label') ?? '';
        $templateConfig['body'] = $request->input('body') ?? '';
        $templateConfig['footer_left_label'] = $request->input('footer_left_label') ?? '';
        $templateConfig['footer_right_label'] = $request->input('footer_right_label') ?? '';
        $templateConfig['signature_name'] = $request->input('signature_name') ?? '';
        $templateConfig['signature_title'] = $request->input('signature_title') ?? '';

        $data = [
            'description'     => $request->input('description') ?? '',
            'text_color'      => $validated['text_color'],
            'is_active'       => $request->has('is_active'),
            'template_config' => $templateConfig,
        ];

        $this->useCase->update(
            $certificate,
            $data,
            $request->hasFile('background_image') ? $request->file('background_image') : null,
            $request->boolean('remove_background_image'),
            $request->hasFile('signature_image') ? $request->file('signature_image') : null,
            $request->boolean('remove_signature_image'),
            $request->hasFile('stamp_image') ? $request->file('stamp_image') : null,
            $request->boolean('remove_stamp_image')
        );

        return back()->with('success', 'Certificate configuration updated successfully.');
    }

    public function preview($id, $resultId = null)
    {
        $certificate = $this->useCase->findOrFail($id);

        if ($resultId) {
            $result = FreeTestResult::with('user')
                ->where('test_type', $certificate->test_type)
                ->where('id', $resultId)
                ->firstOrFail();
        } else {
            $result = FreeTestResult::with('user')
                ->where('test_type', $certificate->test_type)
                ->latest('created_at')
                ->first();
        }

        return view('admin.free-tests.certificates.preview', [
            'certificate' => $certificate,
            'result' => $result,
        ]);
    }

    public function backgroundImage($id)
    {
        $certificate = $this->useCase->findOrFail($id);

        if (! $certificate->background_image || ! Storage::disk('public')->exists($certificate->background_image)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($certificate->background_image));
    }

    public function signatureImage($id)
    {
        $certificate = $this->useCase->findOrFail($id);
        $path = $certificate->template_config['signature_image'] ?? null;

        if (! $path || ! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($path));
    }

    public function stampImage($id)
    {
        $certificate = $this->useCase->findOrFail($id);
        $path = $certificate->template_config['stamp_image'] ?? null;

        if (! $path || ! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('public')->path($path));
    }
}

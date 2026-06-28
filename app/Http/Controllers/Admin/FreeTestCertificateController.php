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
            'description'      => 'nullable|string',
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

        $certificate = $this->useCase->findOrFail($id);

        $data = [
            'description' => $validated['description'] ?? null,
            'text_color'  => $validated['text_color'],
            'is_active'   => $request->has('is_active'),
            'template_config' => [
                'eyebrow' => $validated['eyebrow'] ?? null,
                'title' => $validated['title'] ?? null,
                'subtitle' => $validated['subtitle'] ?? null,
                'score_label' => $validated['score_label'] ?? null,
                'body' => $validated['body'] ?? null,
                'footer_left_label' => $validated['footer_left_label'] ?? null,
                'footer_right_label' => $validated['footer_right_label'] ?? null,
                'signature_name' => $validated['signature_name'] ?? null,
            ],
        ];

        $this->useCase->update(
            $certificate,
            $data,
            $request->hasFile('background_image') ? $request->file('background_image') : null
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
}

<?php

namespace App\Http\Controllers\Admin;

use App\Application\FreeTest\ManageFreeTestCertificates;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $request->validate([
            'description'      => 'nullable|string',
            'text_color'       => 'required|string',
            'is_active'        => 'boolean',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg|max:3072',
        ]);

        $certificate = $this->useCase->findOrFail($id);

        $data = [
            'description' => $request->description,
            'text_color'  => $request->text_color,
            'is_active'   => $request->has('is_active'),
        ];

        $this->useCase->update(
            $certificate,
            $data,
            $request->hasFile('background_image') ? $request->file('background_image') : null
        );

        return back()->with('success', 'Certificate configuration updated successfully.');
    }
}

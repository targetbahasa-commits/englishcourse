<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class GuestCambridgeTestController extends Controller
{
    public function showRegisterForm()
    {
        // Ambil semua program mock test yang aktif dari database
        $programs = Program::where('is_active', true)
            ->where(function ($q) {
                $q->where('slug', 'like', 'cambridge-%')
                  ->orWhere('slug', 'like', 'toefl-itp-mock-package-%');
            })
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'price']);

        // Kelompokkan: Cambridge (full book) → Cambridge (individual test) → TOEFL ITP
        $grouped = [
            'Cambridge Mock Test (Full Book)' => $programs->filter(fn($p) =>
                str_starts_with($p->slug, 'cambridge-') &&
                preg_match('/^cambridge-\d+$/', $p->slug)
            )->sortBy('name')->values(),

            'Cambridge Mock Test (Individual Test)' => $programs->filter(fn($p) =>
                str_starts_with($p->slug, 'cambridge-') &&
                preg_match('/^cambridge-\d+-test-\d+$/', $p->slug)
            )->sortBy('name')->values(),

            'TOEFL ITP Mock Test' => $programs->filter(fn($p) =>
                str_starts_with($p->slug, 'toefl-itp-mock-package-')
            )->sortBy('name')->values(),
        ];

        return view('guest.cambridge-test-register', compact('grouped'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name'     => 'required|string|max:255',
            'whatsapp'      => 'required|string|max:30',
            'email'         => 'nullable|email|max:255',
            'cambridge_test'=> 'required|string|max:255',
        ]);

        // TODO: Simpan data ke database atau kirim notifikasi sesuai kebutuhan
        // Contoh: CambridgeTestRegistration::create($validated);

        return redirect()->back()->with('success', 'Pendaftaran berhasil! Tim kami akan segera menghubungi Anda melalui WhatsApp.');
    }
}

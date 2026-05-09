<?php

namespace App\Http\Controllers;

use App\Application\StudentRegistration\RegisterStudent;
use App\Domain\StudentRegistration\Repositories\StudentRegistrationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentNoPaymentController extends Controller
{
    public function __construct(
        private readonly StudentRegistrationRepository $repository,
        private readonly RegisterStudent $registerStudent,
    ) {
    }

    public function show(Request $request)
    {
        $programs = $this->repository->getActivePrograms();
        $preselectedProgram = $request->query('program');

        return view('student.register-no-payment', compact('programs', 'preselectedProgram'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:150',
            'email'        => 'required|email|max:150|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'password'     => 'required|string|min:6|confirmed',
            'program_id'   => 'nullable|exists:programs,id',
        ], [
            'name.required'         => 'Nama lengkap wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.unique'          => 'Email sudah terdaftar. Silakan login atau gunakan email lain.',
            'phone_number.required' => 'Nomor WhatsApp wajib diisi.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $user = $this->registerStudent->execute($data);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Selamat datang, '.$user->name.'! Akun studentmu berhasil dibuat.');
    }
}

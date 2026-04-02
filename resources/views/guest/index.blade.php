@extends('layouts.dashboard')

@section('pageTitle', 'Guest Free Tests & Lessons')
@section('content')

    <div class="px-4 py-8 w-full max-w-7xl mx-auto">

        @include('guest.components.free-tests-content')

        {{-- Footer CTA --}}
        @guest
        <div class="mt-16 bg-gradient-to-br from-blue-900 to-indigo-900 rounded-3xl py-14 text-center text-white px-6">
            <h2 class="text-3xl font-bold mb-4">Siap untuk belajar lebih dalam?</h2>
            <p class="text-blue-100 mb-8 max-w-xl mx-auto">Buat akun gratis sekarang untuk menyimpan progres belajarmu, mendapatkan hasil tes lengkap, dan mengakses materi berbayar.</p>
            <a href="{{ route('student.register') }}" class="bg-white text-blue-900 font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl hover:bg-gray-50 hover:-translate-y-1 transition-all duration-300 inline-block">
                Mendaftar Secara Gratis
            </a>
        </div>
        @endguest
    </div>
@endsection

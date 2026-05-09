<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Guest Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <div class="p-4 rounded-xl bg-blue-50 mb-4">
                    <strong>Selamat datang, {{ $user->name }}!</strong>
                    @if($user->role === 'guest_quick')
                        <div class="mt-2 text-blue-700">
                            Anda menggunakan akses cepat guest. Hanya 1 tes gratis yang dapat diakses: <b>{{ strtoupper(str_replace('_',' ', $allowedTest)) }}</b>.<br>
                            Untuk mengakses semua tes gratis, silakan <a href="{{ route('guest.register') }}" class="underline font-semibold">daftar akun guest lengkap</a>.
                        </div>
                    @else
                        <div class="mt-2 text-green-700">
                            Anda sudah terdaftar sebagai guest. Semua tes gratis dapat diakses!
                        </div>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                @php
                    $tests = [
                        'ielts_academic' => 'IELTS Academic',
                        'ielts_general' => 'IELTS General',
                        'toefl_itp' => 'TOEFL ITP',
                        'pte_academic' => 'PTE Academic',
                    ];
                @endphp
                @foreach($tests as $type => $label)
                    <div class="p-6 rounded-xl shadow bg-white flex flex-col items-center justify-between">
                        <div class="text-xl font-bold mb-2">{{ $label }}</div>
                        @if($user->role === 'guest_quick' && $allowedTest !== $type)
                            <button class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed mt-4" disabled>
                                Terkunci
                            </button>
                        @else
                            @if($type === 'ielts_academic')
                                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.edition', ['edition' => 16]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg mt-4 font-semibold text-center mt-auto">Kerjakan Tes</a>
                            @else
                                <a href="{{ route('free-test.show', $type) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg mt-4 font-semibold text-center mt-auto">Kerjakan Tes</a>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

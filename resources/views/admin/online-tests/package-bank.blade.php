<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bank Paket {{ $test['label'] }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased" style="background: #f1f5f9;">
    @include('components.impersonation-banner')
    @php
        $isGeneral = ($test['slug'] ?? '') === 'ielts_general';
        $isToefl = ($test['slug'] ?? '') === 'toefl_itp';
        $accentText = $isToefl ? 'blue-700' : ($isGeneral ? 'orange-700' : 'red-700');
        $accentSoft = $isToefl ? 'blue-500' : ($isGeneral ? 'orange-500' : 'red-500');
        $accentBorder = $isToefl ? 'blue-100' : ($isGeneral ? 'orange-100' : 'red-100');
        $accentBg = $isToefl ? 'blue-50' : ($isGeneral ? 'orange-50' : 'red-50');
        $accentFocus = $isToefl ? 'blue' : ($isGeneral ? 'orange' : 'red');
    @endphp
    <div class="flex min-h-screen">
        @include('components.sidebar-admin')

        <main class="flex-1 md:ml-64">
            <div class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-gray-200 px-6 lg:px-10 py-4 flex items-center gap-4">
                <a href="{{ route('admin.online-tests.index') }}" class="flex items-center justify-center w-9 h-9 bg-gray-100 hover:bg-gray-200 rounded-xl text-gray-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div class="flex-1">
                    <h1 class="text-lg font-bold text-gray-900">Bank Paket {{ $test['label'] }}</h1>
                    <p class="text-xs text-gray-400 hidden sm:block">Siapkan format paket 1-16. Konten soal diisi manual satu per satu.</p>
                </div>
                <a href="{{ route('online-test.show', ['slug' => $test['slug']]) }}" target="_blank" class="hidden sm:flex items-center gap-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    Lihat Portal
                </a>
            </div>

            <div class="px-6 lg:px-10 py-8 max-w-7xl" x-data="{ currentPackage: {{ (int) $test['package_number'] }}, activeTab: {{ (int) $test['package_number'] }} }">
                @if(session('success'))
                    <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl shadow-sm">
                        <span class="flex-shrink-0 w-8 h-8 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        </span>
                        <p class="text-sm font-medium flex-1">{{ session('success') }}</p>
                    </div>
                @endif

                <section class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                    <div class="px-6 py-5 border-b border-gray-100">
                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-widest text-{{ $accentSoft }}">{{ $test['label'] }}</p>
                                <h2 class="text-2xl font-bold text-gray-900 mt-1">Kelola bank paket 1 sampai 16</h2>
                                <p class="text-sm text-gray-500 mt-2 max-w-3xl">Isi judul, format, dan catatan untuk setiap paket. Halaman ini tidak mengambil isi dari Cambridge; Cambridge hanya dipakai sebagai referensi style dan format.</p>
                            </div>
                            <div class="rounded-2xl border border-{{ $accentBorder }} bg-{{ $accentBg }} px-4 py-3">
                                <p class="text-[11px] uppercase tracking-wide text-{{ $accentSoft }} font-semibold">Paket aktif di portal</p>
                                <p class="text-xl font-bold text-{{ $accentText }} mt-1">Paket {{ $test['package_number'] }}</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.online-tests.package-bank.update', ['slug' => $test['slug']]) }}">
                        @csrf
                        <div class="p-6 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach(range(1, 16) as $number)
                                    @php
                                        $package = $packageBank[$number] ?? [
                                            'package_number' => $number,
                                            'title' => 'Paket ' . $number,
                                            'subtitle' => '',
                                            'description' => '',
                                            'notes' => '',
                                            'sections' => collect($sectionKeys)->mapWithKeys(fn (string $key): array => [$key => ''])->all(),
                                        ];
                                        $packageSections = is_array($package['sections'] ?? null) ? $package['sections'] : [];
                                    @endphp
                                    <article class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                                        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between gap-3 bg-gray-50/60">
                                            <div>
                                                <p class="text-xs uppercase tracking-wide text-gray-400 font-semibold">Paket {{ $number }}</p>
                                                <h3 class="text-base font-bold text-gray-900 mt-1">{{ $package['title'] ?? ('Paket ' . $number) }}</h3>
                                            </div>
                                            <button type="button" class="text-xs font-semibold px-3 py-2 rounded-xl border border-gray-200 bg-white hover:bg-gray-50" @click="activeTab = activeTab === {{ $number }} ? 0 : {{ $number }}">
                                                {{ $number === 1 ? 'Buka' : 'Edit' }}
                                            </button>
                                        </div>

                                        <div class="p-5 space-y-4" x-show="activeTab === {{ $number }}" x-transition>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Judul Paket</label>
                                                <input type="text" name="packages[{{ $number }}][title]" value="{{ $package['title'] ?? '' }}" class="w-full rounded-xl border-gray-200 text-sm focus:ring-{{ $accentFocus }}-500 focus:border-{{ $accentFocus }}-500" placeholder="Contoh: {{ $test['label'] }} Paket {{ $number }}">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Subjudul / Format</label>
                                                <input type="text" name="packages[{{ $number }}][subtitle]" value="{{ $package['subtitle'] ?? '' }}" class="w-full rounded-xl border-gray-200 text-sm focus:ring-{{ $accentFocus }}-500 focus:border-{{ $accentFocus }}-500" placeholder="Contoh: General practice set">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Deskripsi singkat</label>
                                                <textarea name="packages[{{ $number }}][description]" rows="3" class="w-full rounded-xl border-gray-200 text-sm focus:ring-{{ $accentFocus }}-500 focus:border-{{ $accentFocus }}-500" placeholder="Ringkasan format paket dan catatan umum.">{{ $package['description'] ?? '' }}</textarea>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Catatan admin</label>
                                                <textarea name="packages[{{ $number }}][notes]" rows="4" class="w-full rounded-xl border-gray-200 text-sm focus:ring-{{ $accentFocus }}-500 focus:border-{{ $accentFocus }}-500" placeholder="Catatan internal untuk struktur atau style paket.">{{ $package['notes'] ?? '' }}</textarea>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                @foreach($sectionKeys as $sectionKey)
                                                    @php
                                                        $sectionLabel = str($sectionKey)->replace('_', ' ')->title();
                                                    @endphp
                                                    <div>
                                                        <label class="block text-xs font-semibold text-gray-600 mb-1.5">{{ $sectionLabel }}</label>
                                                        <textarea name="packages[{{ $number }}][sections][{{ $sectionKey }}]" rows="6" class="w-full rounded-xl border-gray-200 text-sm font-mono focus:ring-{{ $accentFocus }}-500 focus:border-{{ $accentFocus }}-500" placeholder="Isi manual outline / draft soal {{ strtolower((string) $sectionLabel) }} paket {{ $number }}.">{{ $packageSections[$sectionKey] ?? '' }}</textarea>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="flex items-center justify-between gap-3 pt-1">
                                                <p class="text-xs text-gray-400">Simpan paket ini bersama paket lain sekali klik.</p>
                                                <span class="text-xs font-semibold px-3 py-1.5 rounded-full bg-{{ $accentBg }} text-{{ $accentText }} border border-{{ $accentBorder }}">Slot {{ $number }}/16</span>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2">
                                <p class="text-sm text-gray-500">Kosongkan field yang belum siap. Semua paket tetap kosong sampai Anda isi manual.</p>
                                <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl {{ $isGeneral ? 'bg-orange-600 hover:bg-orange-700' : 'bg-red-600 hover:bg-red-700' }} text-white font-bold shadow-sm transition-colors">
                                    Simpan Bank Paket
                                </button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </main>
    </div>
</body>
</html>

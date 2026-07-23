<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $test['package_label'] }} - {{ $section['title'] }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gradient-to-br from-red-50 via-white to-slate-100">
    @include('components.impersonation-banner')

    <div class="flex min-h-screen {{ Auth::user()->isAdmin() ? '' : 'max-w-7xl mx-auto w-full' }}">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @endif

        <main class="flex-1 {{ Auth::user()->isAdmin() ? 'md:ml-64' : 'w-full' }} p-4 md:p-8">
            <div class="max-w-5xl mx-auto space-y-6">
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('online-test.show', ['slug' => $test['slug']]) }}" class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-gray-600 hover:text-red-600 hover:border-red-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke online test
                    </a>

                    @if(($test['slug'] ?? '') === 'ielts_academic' && in_array($section['key'], ['listening', 'reading', 'writing', 'speaking'], true))
                        <a href="{{ route('assignments.ielts-academic.mockup.cambridge.test', ['edition' => $test['package_number'], 'id' => 1, 'skill' => $section['key']]) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-sm font-semibold transition-colors">
                            Lihat Referensi Style
                        </a>
                    @endif
                </div>

                <section class="bg-white rounded-3xl border border-red-100 shadow-xl overflow-hidden">
                    <div class="px-8 py-8 bg-gradient-to-r from-red-600 to-rose-600 text-white">
                        <p class="text-red-100 text-xs font-semibold uppercase tracking-[0.25em]">Internal Package Section</p>
                        <h1 class="text-3xl font-bold mt-2">{{ $test['package_label'] }}</h1>
                        <div class="mt-4 flex flex-wrap gap-3 text-sm">
                            <span class="px-3 py-1 rounded-full bg-white/15 border border-white/20">Paket {{ $test['package_number'] }}</span>
                            <span class="px-3 py-1 rounded-full bg-white/15 border border-white/20">{{ $section['title'] }}</span>
                            <span class="px-3 py-1 rounded-full bg-white/15 border border-white/20">{{ $section['minutes'] }} menit</span>
                            <span class="px-3 py-1 rounded-full bg-white/15 border border-white/20">{{ $section['question_count'] }} soal</span>
                        </div>
                    </div>

                    <div class="p-8 space-y-6">
                        @if(!empty($test['package_meta']['subtitle']))
                            <div class="rounded-2xl border border-red-100 bg-red-50 px-5 py-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-red-500">Format Paket</p>
                                <p class="text-lg font-semibold text-red-900 mt-1">{{ $test['package_meta']['subtitle'] }}</p>
                            </div>
                        @endif

                        @if(!empty($test['package_meta']['description']))
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900 mb-2">Deskripsi Paket</h2>
                                <p class="text-sm leading-7 text-slate-600">{{ $test['package_meta']['description'] }}</p>
                            </div>
                        @endif

                        @if(!empty($test['package_meta']['notes']) && Auth::user()->isAdmin())
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Catatan Admin</p>
                                <div class="mt-2 text-sm leading-7 text-slate-700 whitespace-pre-line">{{ $test['package_meta']['notes'] }}</div>
                            </div>
                        @endif

                        <div>
                            <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                                <div>
                                    <h2 class="text-lg font-semibold text-slate-900">Draft Section {{ $section['title'] }}</h2>
                                    <p class="text-sm text-slate-500">Halaman internal ini untuk isi paket Anda. Tidak mengambil konten dari Cambridge.</p>
                                </div>
                                <a href="{{ route('admin.online-tests.package-bank', ['slug' => $test['slug']]) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl bg-white border border-red-200 text-red-700 text-sm font-semibold hover:bg-red-50 transition-colors">
                                    Kelola Bank Soal
                                </a>
                            </div>

                            <div class="rounded-2xl border border-slate-200 bg-slate-50 min-h-[260px] p-5">
                                @if($sectionContent !== '')
                                    <div class="text-sm leading-7 text-slate-700 whitespace-pre-line">{{ $sectionContent }}</div>
                                @else
                                    <div class="h-full min-h-[220px] flex flex-col items-center justify-center text-center text-slate-400">
                                        <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 4v16m8-8H4"></path></svg>
                                        <p class="text-base font-semibold text-slate-500">Section ini masih kosong</p>
                                        <p class="text-sm mt-1 max-w-xl">Isi draft atau soal final untuk {{ strtolower($section['title']) }} di bank paket. Setelah itu halaman ini akan menampilkan konten internal paket {{ $test['package_number'] }}.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if(!empty($section['video_url']))
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900 mb-3">Video Instruksi Section</h2>
                                <div class="rounded-2xl overflow-hidden border border-slate-200 bg-black aspect-video">
                                    <iframe
                                        class="w-full h-full"
                                        src="{{ $section['video_url'] }}"
                                        title="{{ $section['title'] }} Instruction Video"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen
                                    ></iframe>
                                </div>
                            </div>
                        @endif

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <form action="{{ route('online-test.start', ['slug' => $test['slug']]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="section" value="{{ $section['key'] }}">
                                <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold transition-colors shadow-sm">
                                    Mulai {{ $section['title'] }}
                                </button>
                            </form>
                            <span class="text-xs text-slate-500">URL halaman ini: {{ url('/online-test/' . $slugAlias . '/paket' . $test['package_number'] . '/' . $section['key']) }}</span>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>

</html>
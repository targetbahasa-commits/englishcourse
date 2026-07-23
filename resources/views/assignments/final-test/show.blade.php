<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - {{ $selectedProgram['name'] }} Final Test</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50">
    @include('components.impersonation-banner')

    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        @php
            $accentClasses = [
                'green' => ['line' => 'bg-emerald-500', 'text' => 'text-emerald-700', 'soft' => 'bg-emerald-50 text-emerald-700 border-emerald-100', 'button' => 'bg-emerald-600 hover:bg-emerald-700'],
                'purple' => ['line' => 'bg-violet-500', 'text' => 'text-violet-700', 'soft' => 'bg-violet-50 text-violet-700 border-violet-100', 'button' => 'bg-violet-600 hover:bg-violet-700'],
                'red' => ['line' => 'bg-rose-500', 'text' => 'text-rose-700', 'soft' => 'bg-rose-50 text-rose-700 border-rose-100', 'button' => 'bg-rose-600 hover:bg-rose-700'],
                'orange' => ['line' => 'bg-amber-500', 'text' => 'text-amber-700', 'soft' => 'bg-amber-50 text-amber-700 border-amber-100', 'button' => 'bg-amber-600 hover:bg-amber-700'],
                'blue' => ['line' => 'bg-blue-500', 'text' => 'text-blue-700', 'soft' => 'bg-blue-50 text-blue-700 border-blue-100', 'button' => 'bg-blue-600 hover:bg-blue-700'],
                'yellow' => ['line' => 'bg-yellow-500', 'text' => 'text-yellow-700', 'soft' => 'bg-yellow-50 text-yellow-700 border-yellow-100', 'button' => 'bg-yellow-600 hover:bg-yellow-700'],
            ];
            $accent = $accentClasses[$selectedProgram['accent']] ?? $accentClasses['blue'];
            $displayTitle = $selectedProgram['name'] . ($variantLabel ? ' - ' . $variantLabel : '');
        @endphp

        <main class="flex-1 md:ml-64">
            <div class="px-5 py-6 sm:px-8 lg:px-10">
                <div class="mb-6 flex flex-col gap-4 border-b border-slate-200 pb-6 lg:flex-row lg:items-end lg:justify-between">
                    <div>
                        <a href="{{ route('final-test') }}" class="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Final Test Center
                        </a>
                        <p class="mt-5 text-xs font-semibold uppercase tracking-wide {{ $accent['text'] }}">Final Test Workspace</p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight text-slate-950">{{ $displayTitle }}</h1>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">{{ $selectedProgram['description'] }}</p>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-white p-2 shadow-sm">
                        <div class="grid grid-cols-1 gap-2 sm:grid-cols-3">
                            <div class="rounded-md bg-slate-50 px-4 py-3">
                                <p class="text-xs text-slate-500">Program</p>
                                <p class="mt-1 text-sm font-bold text-slate-950">{{ $program }}</p>
                            </div>
                            <div class="rounded-md bg-slate-50 px-4 py-3">
                                <p class="text-xs text-slate-500">Batch</p>
                                <p class="mt-1 text-sm font-bold text-slate-950">{{ $displayBatch }}</p>
                            </div>
                            <div class="rounded-md bg-slate-50 px-4 py-3">
                                <p class="text-xs text-slate-500">Status</p>
                                <p class="mt-1 text-sm font-bold text-emerald-700">Ready</p>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="grid grid-cols-1 gap-4 lg:grid-cols-[1.4fr_0.6fr]">
                    <article class="relative overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                        <div class="absolute inset-x-0 top-0 h-1 {{ $accent['line'] }}"></div>
                        <div class="p-6">
                            <div class="flex items-start gap-4">
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg border {{ $accent['soft'] }}">
                                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-slate-950">Assessment Room</h2>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">Halaman ini sudah terpisah dari Assignment dan memakai route final test khusus.</p>
                                </div>
                            </div>

                            <div class="mt-6 grid grid-cols-1 gap-3 md:grid-cols-3">
                                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">URL</p>
                                    <p class="mt-2 break-all text-sm font-semibold text-slate-900">{{ request()->path() }}</p>
                                </div>
                                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Track</p>
                                    <p class="mt-2 text-sm font-semibold text-slate-900">{{ $variantLabel ?? 'Main Program' }}</p>
                                </div>
                                <div class="rounded-lg border border-slate-200 bg-slate-50 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Access</p>
                                    <p class="mt-2 text-sm font-semibold text-emerald-700">Available</p>
                                </div>
                            </div>

                            <div class="mt-6 rounded-lg border border-dashed border-slate-300 bg-slate-50 p-5">
                                <p class="text-sm font-semibold text-slate-900">Konten final test dapat ditempatkan di area ini.</p>
                                <p class="mt-1 text-sm leading-6 text-slate-600">Struktur halaman sudah siap untuk instruksi, timer, soal, upload jawaban, atau tombol mulai test.</p>
                            </div>

                            <form method="POST" action="{{ route('final-test.complete', array_filter(['program' => $program, 'variant' => $variant])) }}" class="mt-6 rounded-lg border border-slate-200 bg-white p-5">
                                @csrf
                                <input type="hidden" name="score" value="100">
                                <input type="hidden" name="time_spent_seconds" value="0">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-slate-900">Finish Final Test</p>
                                        <p class="mt-1 text-sm text-slate-500">Submitting will save the result, show the score, generate the certificate PDF, and email it to the student.</p>
                                    </div>
                                    <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg px-5 text-sm font-semibold text-white shadow-sm transition {{ $accent['button'] }}">
                                        Submit Final Test
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </article>

                    <aside class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Checklist</p>
                        <div class="mt-4 space-y-3">
                            @foreach(['Route khusus final test', 'Tidak redirect ke Assignment', 'Siap untuk konten ujian'] as $item)
                                <div class="flex items-center gap-3 rounded-md border border-slate-200 bg-slate-50 px-3 py-3">
                                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-md bg-emerald-100 text-emerald-700">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <span class="text-sm font-medium text-slate-700">{{ $item }}</span>
                                </div>
                            @endforeach
                        </div>
                    </aside>
                </section>
            </div>
        </main>
    </div>
</body>
</html>

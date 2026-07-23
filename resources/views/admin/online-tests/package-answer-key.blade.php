<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Answer Key Paket - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100">
@include('components.impersonation-banner')
<div class="flex min-h-screen">
    @include('components.sidebar-admin')

    <main class="flex-1 md:ml-64 p-4 md:p-8">
        <div class="max-w-4xl mx-auto">
            <div class="mb-4">
                <a href="{{ route('online-test.show', ['slug' => $test['slug']]) }}" class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm text-gray-600 hover:text-blue-600 hover:border-blue-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Online Test
                </a>
            </div>

            <section class="bg-white rounded-2xl border border-gray-100 shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6">
                    <p class="text-blue-100 text-xs font-semibold uppercase tracking-wider">Admin - Package Answer Key</p>
                    <h1 class="text-2xl font-bold text-white mt-1">{{ $test['label'] }} Paket {{ $package }} - {{ ucfirst($section) }}</h1>
                </div>

                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.online-tests.package-answer-key.update', ['slug' => $test['slug'], 'package' => $package, 'section' => $section]) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Answer Key JSON</label>
                            <textarea name="answer_key_json" rows="18" class="w-full rounded-xl border-slate-300 text-sm font-mono focus:border-indigo-500 focus:ring-indigo-500">{{ old('answer_key_json', $answerKeyJson) }}</textarea>
                            <p class="mt-2 text-xs text-slate-500">Contoh format: {"q1":"A","q2":"B","q3":["x","y"]}.</p>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold transition-colors">
                                Simpan Answer Key
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>
</div>
</body>
</html>

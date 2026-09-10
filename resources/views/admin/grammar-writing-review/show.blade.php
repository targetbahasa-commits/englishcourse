@extends('layouts.admin')

@section('title', 'Periksa Grammar Writing — Meeting ' . $meetingScore->meeting_number)

@section('content')
<div class="p-6 max-w-5xl mx-auto">

    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.grammar-writing-review.index') }}" class="text-sm text-indigo-600 hover:underline flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m0 7h18"></path></svg>
                Kembali ke daftar
            </a>
            <h1 class="text-2xl font-extrabold text-gray-900">{{ $meetingScore->user->name ?? 'Unknown Student' }}</h1>
            <p class="text-sm text-gray-500">
                <span class="inline-block px-2 py-0.5 rounded text-[11px] font-bold bg-slate-100 text-slate-700 mr-1">{{ $trackLabel ?? 'Grammar Writing' }}</span>
                {{ $meetingScore->user->email ?? '' }} &middot; Meeting {{ $meetingScore->meeting_number }} &middot; Submit {{ $meetingScore->submitted_at ? $meetingScore->submitted_at->format('d M Y H:i') : '-' }}
            </p>
        </div>
        <div class="text-right">
            <div class="text-xs text-gray-500 uppercase font-bold">Skor Otomatis</div>
            <div class="text-3xl font-black text-amber-600">{{ $meetingScore->score }}</div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if(($meetingScore->answers_data['ai_enabled'] ?? true) === false)
        <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm font-medium">
            ⚠️ Penilaian AI dinonaktifkan saat siswa submit jawaban ini — skor otomatis di atas belum mencerminkan penilaian sesungguhnya. Mohon isi Nilai Guru secara manual di bawah.
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Answer breakdown -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-4">Rincian Jawaban</h2>

            <style>
                .word-diff .word-correct { color: #2ecc71; font-weight: bold; }
                .word-diff .word-extra { color: #3498db; font-weight: bold; text-decoration: line-through; }
                .word-diff .word-missing { color: #f1c40f; font-weight: bold; }
                .word-diff .word-wrong { color: #e74c3c; font-weight: bold; text-decoration: underline; }
            </style>

            @if(!empty($meetingScore->answers_data))
                @include('partials.grammar-writing-answers-tree', ['data' => $meetingScore->answers_data])
            @else
                <div class="p-6 text-center text-gray-400 text-sm bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    Tidak ada rincian jawaban tersimpan untuk submission ini (hanya skor akhir yang tercatat).
                </div>
            @endif
        </div>

        <!-- Review form -->
        @include('partials.submission-review-form', ['meetingScore' => $meetingScore, 'reviewRoute' => route('admin.grammar-writing-review.review', $meetingScore->id)])
    </div>
</div>
@endsection

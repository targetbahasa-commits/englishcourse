@extends('layouts.admin')

@section('title', 'Hasil Tes Grammar - ' . $result->student_name)

@section('content')
<div class="p-6 sm:p-8">
    <a href="{{ route('admin.grammar-placement.results.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Kembali ke Hasil Tes</a>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mt-4">{{ session('success') }}</div>
    @endif

    <div class="flex justify-between items-start mt-4 mb-6">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">{{ $result->student_name }}</h2>
            @if($result->student_phone)
                <p class="text-sm text-gray-500">{{ $result->student_phone }}</p>
            @endif
            <p class="text-xs text-gray-400 mt-1">
                Paket: {{ $result->package->title ?? '—' }} &middot; {{ $result->created_at->format('d M Y H:i') }}
                @if($result->administrator)
                    &middot; Dites oleh {{ $result->administrator->name }}
                @endif
            </p>
        </div>
        <div class="text-right">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-bold bg-indigo-100 text-indigo-800">{{ $result->cefr_level }}</span>
            <p class="text-xs text-gray-500 mt-1">Skor: {{ $result->correct_count }}/{{ $result->total_count }} ({{ $result->percentage }}%)</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm mb-6">
        <h3 class="font-semibold text-gray-800 mb-1">Kelas yang Direkomendasikan</h3>
        @if($result->recommendedProgram)
            <div class="flex items-center gap-3 mt-3">
                <span class="inline-flex items-center px-4 py-2 rounded-xl text-base font-bold bg-blue-50 text-blue-700 border border-blue-100">
                    {{ $result->recommendedProgram->name }}
                </span>
                <span class="text-xs text-gray-400">CEFR {{ $result->recommendedProgram->min_cefr_level }}–{{ $result->recommendedProgram->max_cefr_level }}</span>
            </div>
        @else
            <p class="text-sm text-gray-400 italic mt-2">Tidak ada kelas grammar yang cocok ditemukan.</p>
        @endif
    </div>

    @if($result->notes)
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm mb-6">
            <h3 class="font-semibold text-gray-800 mb-2">Catatan</h3>
            <p class="text-sm text-gray-600 whitespace-pre-line">{{ $result->notes }}</p>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <h3 class="font-semibold text-gray-800 p-6 pb-3">Rincian Jawaban</h3>
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 border-y border-gray-100">
                <tr>
                    <th class="px-6 py-2 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">#</th>
                    <th class="px-6 py-2 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Pertanyaan</th>
                    <th class="px-6 py-2 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Jawaban Peserta</th>
                    <th class="px-6 py-2 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Kunci Jawaban</th>
                    <th class="px-6 py-2 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Hasil</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @php
                    $questions = \App\Models\GrammarPlacementQuestion::whereIn('id', array_keys($result->answers_data))->get()->keyBy('id');
                @endphp
                @foreach($result->answers_data as $questionId => $selected)
                    @php $question = $questions->get((int) $questionId); @endphp
                    <tr>
                        <td class="px-6 py-3 text-gray-400">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3 text-gray-800">{{ $question->question_text ?? '(soal dihapus)' }}</td>
                        <td class="px-6 py-3 uppercase font-semibold text-gray-700">{{ $selected }}</td>
                        <td class="px-6 py-3 uppercase font-semibold text-gray-700">{{ $question->correct_option ?? '—' }}</td>
                        <td class="px-6 py-3">
                            @if($question && strtolower($selected) === strtolower($question->correct_option))
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Benar</span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-200">Salah</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

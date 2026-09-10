@extends('layouts.dashboard')

@section('content')
<div class="py-10">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

        @if ($result->status !== 'completed')
            <div class="bg-amber-50 border border-amber-200 text-amber-700 rounded-xl p-6 text-center">
                <p class="font-semibold">Hasil sedang diproses...</p>
                <p class="text-sm mt-1">Silakan muat ulang halaman ini dalam beberapa saat.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center mb-6">
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Level CEFR Kamu</p>
                <p class="text-6xl font-extrabold text-blue-600 my-3">{{ $result->cefr_level }}</p>
                <p class="text-sm text-gray-500">Skor keseluruhan: {{ $result->overall_percentage }}%</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                @foreach ([['Reading', $result->reading_score], ['Listening', $result->listening_score], ['Writing', $result->writing_score], ['Speaking', $result->speaking_score]] as [$label, $score])
                    <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm text-center">
                        <p class="text-xs text-gray-500 uppercase font-semibold">{{ $label }}</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $score !== null ? $score . '%' : '—' }}</p>
                    </div>
                @endforeach
            </div>

            @if ($recommendedPrograms->isNotEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="font-bold text-gray-900 mb-1">Program yang Direkomendasikan Untukmu</h3>
                    <p class="text-sm text-gray-500 mb-4">Berdasarkan level kamu, program berikut paling sesuai:</p>
                    <div class="space-y-3">
                        @foreach ($recommendedPrograms as $program)
                            <div class="flex items-center justify-between p-4 rounded-xl border border-gray-100 bg-gray-50">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $program->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $program->period }}</p>
                                </div>
                                <a href="{{ route('programs.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Lihat &rarr;</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6 text-center text-sm text-gray-500">
                    Belum ada program yang cocok secara otomatis untuk level ini. Hubungi tim kami untuk rekomendasi kelas yang sesuai.
                </div>
            @endif

            @php $writingEval = data_get($result->evaluation_data, 'writing'); @endphp
            @if ($writingEval && data_get($writingEval, 'feedback'))
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="font-bold text-gray-900 mb-2">Feedback Writing</h3>
                    <p class="text-sm text-gray-600">{{ data_get($writingEval, 'feedback') }}</p>
                </div>
            @endif

            @php $speakingEval = data_get($result->evaluation_data, 'speaking'); @endphp
            @if ($speakingEval && data_get($speakingEval, 'feedback'))
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="font-bold text-gray-900 mb-2">Feedback Speaking</h3>
                    <p class="text-sm text-gray-600">{{ data_get($speakingEval, 'feedback') }}</p>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Kelola Soal Grammar - ' . $package->title)

@section('content')
<div class="p-6 sm:p-8" x-data="{ editing: null }">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <a href="{{ route('admin.grammar-placement.packages.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Paket
            </a>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Kelola Soal: {{ $package->title }}</h1>
            <p class="text-sm text-gray-500 mt-1">Bank soal pilihan ganda untuk paket ini. Hanya soal yang aktif yang akan muncul saat tes dijalankan.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
            <ul class="list-disc list-inside text-sm">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        {{-- Existing Questions --}}
        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-lg font-bold text-gray-800">Daftar Soal ({{ $questions->count() }})</h2>

            @if($questions->isEmpty())
                <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-10 text-center text-gray-400">
                    <p class="font-medium">Belum ada soal.</p>
                    <p class="text-sm mt-1">Tambahkan soal pertama menggunakan form di samping.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($questions as $q)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 {{ $q->is_active ? '' : 'opacity-50' }}">
                            <template x-if="editing !== {{ $q->id }}">
                                <div>
                                    <div class="flex items-center justify-between gap-3 mb-2">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            @if($q->cefr_level)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold border bg-indigo-50 text-indigo-700 border-indigo-200">{{ $q->cefr_level }}</span>
                                            @endif
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold border {{ $q->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-gray-100 text-gray-500 border-gray-200' }}">
                                                {{ $q->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1 shrink-0">
                                            <button type="button" @click="editing = {{ $q->id }}" class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            </button>
                                            <form method="POST" action="{{ route('admin.grammar-placement.questions.destroy', [$package, $q]) }}" onsubmit="return confirm('Hapus soal ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="font-semibold text-gray-900 mb-2">{{ $q->question_text }}</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-1.5 text-sm">
                                        @foreach(['a' => $q->option_a, 'b' => $q->option_b, 'c' => $q->option_c, 'd' => $q->option_d] as $letter => $optionText)
                                            <div class="flex items-center gap-1.5 {{ $letter === $q->correct_option ? 'text-emerald-700 font-semibold' : 'text-gray-600' }}">
                                                <span class="uppercase">{{ $letter }}.</span> {{ $optionText }}
                                                @if($letter === $q->correct_option)
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </template>

                            <template x-if="editing === {{ $q->id }}">
                                <form method="POST" action="{{ route('admin.grammar-placement.questions.update', [$package, $q]) }}" class="space-y-3">
                                    @csrf @method('PUT')
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Pertanyaan</label>
                                        <textarea name="question_text" rows="2" required class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 resize-none">{{ $q->question_text }}</textarea>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        @foreach(['a' => $q->option_a, 'b' => $q->option_b, 'c' => $q->option_c, 'd' => $q->option_d] as $letter => $optionText)
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-bold uppercase text-gray-500 w-4">{{ $letter }}</span>
                                                <input type="text" name="option_{{ $letter }}" value="{{ $optionText }}" required class="block w-full border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Jawaban Benar</label>
                                            <select name="correct_option" class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white">
                                                @foreach(['a','b','c','d'] as $letter)
                                                    <option value="{{ $letter }}" {{ $q->correct_option === $letter ? 'selected' : '' }}>{{ strtoupper($letter) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-600 mb-1">Level CEFR</label>
                                            <select name="cefr_level" class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white">
                                                <option value="">—</option>
                                                @foreach(['A1','A2','B1','B2','C1','C2'] as $lvl)
                                                    <option value="{{ $lvl }}" {{ $q->cefr_level === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex items-end pb-2">
                                            <label class="flex items-center gap-2 text-sm font-medium text-gray-600">
                                                <input type="checkbox" name="is_active" value="1" {{ $q->is_active ? 'checked' : '' }} class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                Aktif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">Simpan</button>
                                        <button type="button" @click="editing = null" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-semibold rounded-lg hover:bg-gray-50 transition-colors">Batal</button>
                                    </div>
                                </form>
                            </template>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Add New Question --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">➕ Tambah Soal Baru</h2>

                <form method="POST" action="{{ route('admin.grammar-placement.questions.store', $package) }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pertanyaan <span class="text-red-500">*</span></label>
                        <textarea name="question_text" rows="2" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none" placeholder="e.g., She ___ to school every day."></textarea>
                    </div>

                    @foreach(['a', 'b', 'c', 'd'] as $letter)
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Pilihan {{ strtoupper($letter) }} <span class="text-red-500">*</span></label>
                            <input type="text" name="option_{{ $letter }}" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    @endforeach

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jawaban Benar <span class="text-red-500">*</span></label>
                            <select name="correct_option" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white">
                                @foreach(['a','b','c','d'] as $letter)
                                    <option value="{{ $letter }}">{{ strtoupper($letter) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Level CEFR</label>
                            <select name="cefr_level" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white">
                                <option value="">—</option>
                                @foreach(['A1','A2','B1','B2','C1','C2'] as $lvl)
                                    <option value="{{ $lvl }}">{{ $lvl }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                        <label class="text-sm font-semibold text-gray-700">Aktifkan sekarang</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors shadow-sm">
                        Simpan Soal
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

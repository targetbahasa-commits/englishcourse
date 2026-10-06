@extends('layouts.admin')

@section('title', 'Brosur Program: ' . $program->name)

@section('content')
<div class="p-6 md:p-8 max-w-3xl mx-auto space-y-8 pb-32">

    {{-- Header --}}
    <div>
        <a href="{{ route('programs.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Programs
        </a>
        <h1 class="text-3xl font-bold font-serif text-gray-900">Upload Brosur</h1>
        <p class="text-gray-500 mt-1">Program: <span class="font-semibold text-gray-700">{{ $program->name }}</span></p>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
        <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    {{-- AI Brochure Generator --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
        x-data="{
            provider: 'gemini',
            prompt: @js($aiPrompt),
            generating: false,
            accepting: false,
            draftUrl: null,
            draftPath: null,
            errorMsg: null,
            geminiAvailable: @js($geminiAvailable),
            openaiAvailable: @js($openaiAvailable),
            providerAvailable() {
                return this.provider === 'gemini' ? this.geminiAvailable : this.openaiAvailable;
            },
            async copyPrompt() {
                await navigator.clipboard.writeText(this.prompt);
            },
            async generateImage() {
                this.errorMsg = null;
                this.generating = true;
                this.draftUrl = null;
                this.draftPath = null;
                try {
                    const res = await fetch('{{ route('programs.brochure.ai.generate', $program->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ provider: this.provider, prompt: this.prompt }),
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.draftUrl = data.draft_url;
                        this.draftPath = data.draft_path;
                    } else {
                        this.errorMsg = data.message || 'Gagal generate gambar.';
                    }
                } catch (e) {
                    this.errorMsg = 'Terjadi kesalahan jaringan.';
                } finally {
                    this.generating = false;
                }
            },
            async acceptDraft() {
                this.accepting = true;
                this.errorMsg = null;
                try {
                    const res = await fetch('{{ route('programs.brochure.ai.accept', $program->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ draft_path: this.draftPath }),
                    });
                    const data = await res.json();
                    if (data.success) {
                        window.location.reload();
                    } else {
                        this.errorMsg = data.message || 'Gagal menyimpan gambar.';
                        this.accepting = false;
                    }
                } catch (e) {
                    this.errorMsg = 'Terjadi kesalahan jaringan.';
                    this.accepting = false;
                }
            }
        }">
        <h2 class="text-base font-bold text-gray-800 mb-1 flex items-center gap-2">
            <span class="p-1.5 bg-indigo-50 text-indigo-600 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
            </span>
            AI Brochure Generator
        </h2>
        <p class="text-sm text-gray-500 mb-4">Buat brosur otomatis pakai AI, atau salin prompt di bawah untuk ditempel sendiri ke Gemini/ChatGPT lalu upload hasilnya di bagian bawah.</p>

        <div class="flex items-center gap-3 mb-3">
            <label class="text-sm font-semibold text-gray-700">Pilih AI:</label>
            <select x-model="provider" class="border border-gray-300 rounded-xl px-3 py-2 text-sm text-gray-900 bg-white focus:ring-blue-500 focus:border-blue-500">
                <option value="gemini">Gemini</option>
                <option value="openai">ChatGPT</option>
            </select>
        </div>

        <label class="block text-xs font-semibold text-gray-600 mb-1">Prompt (bisa diedit)</label>
        <textarea x-model="prompt" rows="10" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 font-mono"></textarea>

        <div class="flex flex-wrap items-center gap-3 mt-3">
            <button type="button" @click="copyPrompt()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl border border-gray-200 transition">
                Copy Prompt
            </button>
            <a :href="provider === 'gemini' ? 'https://gemini.google.com/app' : 'https://chatgpt.com/'" target="_blank" rel="noopener"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl border border-gray-200 transition">
                Buka <span x-text="provider === 'gemini' ? 'Gemini' : 'ChatGPT'"></span>
            </a>
            <button type="button" @click="generateImage()" :disabled="generating || !providerAvailable()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white text-sm font-semibold rounded-xl transition">
                <span x-show="!generating">Generate Gambar Otomatis</span>
                <span x-show="generating">Generating...</span>
            </button>
        </div>

        <p x-show="provider === 'openai' && !openaiAvailable" x-cloak class="text-xs text-amber-600 mt-2">
            Tambahkan OPENAI_API_KEY di server untuk mengaktifkan generate otomatis via ChatGPT. Untuk sekarang, pakai tombol Copy Prompt + Buka ChatGPT di atas lalu upload hasilnya secara manual di bawah.
        </p>

        <p x-show="errorMsg" x-cloak x-text="errorMsg" class="text-sm text-red-600 mt-2"></p>

        <div x-show="draftUrl" x-cloak class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-200">
            <p class="text-xs text-gray-500 mb-2 font-medium uppercase tracking-wide">Hasil generate:</p>
            <img :src="draftUrl" alt="Draft brosur AI" class="max-h-80 rounded-xl border border-gray-200 shadow-sm object-contain mb-3">
            <div class="flex items-center gap-3">
                <button type="button" @click="acceptDraft()" :disabled="accepting"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 disabled:bg-gray-300 text-white text-sm font-semibold rounded-xl transition">
                    <span x-show="!accepting">Gunakan Gambar Ini</span>
                    <span x-show="accepting">Menyimpan...</span>
                </button>
                <button type="button" @click="generateImage()" :disabled="generating"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-xl transition">
                    Generate Ulang
                </button>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('programs.brochure.update', $program->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Brochure Image (JPG) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="p-1.5 bg-blue-50 text-blue-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
                Gambar Brosur (JPG/PNG)
            </h2>

            @if($program->brochure_image)
            <div class="mb-4">
                <p class="text-xs text-gray-500 mb-2 font-medium uppercase tracking-wide">Preview saat ini:</p>
                <img src="{{ Storage::url($program->brochure_image) }}"
                    alt="Brochure" class="max-h-64 rounded-xl border border-gray-200 shadow-sm object-contain">
                <div class="flex items-center gap-3 mt-3">
                    <a href="{{ Storage::url($program->brochure_image) }}" download
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-medium rounded-xl border border-blue-200 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download JPG
                    </a>
                    <label class="flex items-center gap-2 text-sm text-red-600 cursor-pointer">
                        <input type="checkbox" name="remove_brochure_image" value="1" class="rounded border-gray-300 text-red-500">
                        Hapus gambar ini
                    </label>
                </div>
            </div>
            @endif

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ $program->brochure_image ? 'Ganti Gambar' : 'Upload Gambar' }}
                    <span class="text-gray-400 font-normal">(maks. 5 MB)</span>
                </label>
                <input type="file" name="brochure_image" accept="image/jpg,image/jpeg,image/png"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition">
                <p class="text-xs text-gray-400 mt-1.5">Format: JPG, JPEG, PNG</p>
            </div>
        </div>

        {{-- Brochure PDF --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="p-1.5 bg-red-50 text-red-600 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </span>
                File PDF Brosur
            </h2>

            @if($program->brochure_pdf)
            <div class="mb-4 p-4 bg-red-50 rounded-xl border border-red-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-10 h-10 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ basename($program->brochure_pdf) }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">PDF tersimpan</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ Storage::url($program->brochure_pdf) }}" download
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-sm font-medium rounded-xl border border-red-200 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download PDF
                    </a>
                    <label class="flex items-center gap-2 text-sm text-red-600 cursor-pointer">
                        <input type="checkbox" name="remove_brochure_pdf" value="1" class="rounded border-gray-300 text-red-500">
                        Hapus PDF
                    </label>
                </div>
            </div>
            @endif

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">
                    {{ $program->brochure_pdf ? 'Ganti PDF' : 'Upload PDF' }}
                    <span class="text-gray-400 font-normal">(maks. 20 MB)</span>
                </label>
                <input type="file" name="brochure_pdf" accept="application/pdf"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition">
                <p class="text-xs text-gray-400 mt-1.5">Format: PDF saja</p>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('programs.index') }}"
                class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl font-medium hover:bg-gray-50 transition-colors shadow-sm">
                Kembali
            </a>
            <button type="submit"
                class="px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-xl transition-colors shadow-sm inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Simpan Brosur
            </button>
        </div>
    </form>
</div>
@endsection

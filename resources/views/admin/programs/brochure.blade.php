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

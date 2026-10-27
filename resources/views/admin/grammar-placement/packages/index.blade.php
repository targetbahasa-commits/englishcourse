@extends('layouts.admin')

@section('title', 'Tes Grammar - Paket')

@section('content')
<div class="p-6 sm:p-8" x-data="{ showCreateForm: false, editing: null }">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Tes Penempatan Grammar</h1>
            <p class="text-sm text-gray-500 mt-1">Buat paket soal, lalu salin link-nya untuk dikirim ke calon siswa. Mereka mengerjakan sendiri secara online, seperti Promo Test.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('admin.grammar-placement.results.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-gray-600 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl transition-colors shadow-sm">
                Hasil Tes
            </a>
            <button type="button" @click="showCreateForm = !showCreateForm" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-sm">
                + Paket Baru
            </button>
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

    {{-- Create Package Form --}}
    <div x-show="showCreateForm" x-cloak class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h2 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wide">Paket Baru</h2>
        <form method="POST" action="{{ route('admin.grammar-placement.packages.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Paket <span class="text-red-500">*</span></label>
                <input type="text" name="title" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="e.g., Paket Grammar - Batch September">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                <textarea name="description" rows="2" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 sm:text-sm resize-none"></textarea>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors shadow-sm">Buat Paket</button>
                <button type="button" @click="showCreateForm = false" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors">Batal</button>
            </div>
        </form>
    </div>

    {{-- Packages List --}}
    @if($packages->isEmpty())
        <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-10 text-center text-gray-400">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <p class="font-medium">Belum ada paket tes grammar.</p>
            <p class="text-sm mt-1">Klik "+ Paket Baru" untuk membuat paket pertama.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($packages as $package)
                @php $publicUrl = route('promo.test.grammar-placement.show', $package); @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <template x-if="editing !== {{ $package->id }}">
                        <div>
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="font-bold text-gray-900">{{ $package->title }}</h3>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-xs font-semibold {{ $package->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-gray-100 text-gray-500 border border-gray-200' }}">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $package->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                            {{ $package->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </div>
                                    @if($package->description)
                                        <p class="text-sm text-gray-500 mt-1">{{ $package->description }}</p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1.5">{{ $package->questions_count }} soal &middot; {{ $package->results_count }} sudah mengerjakan</p>
                                </div>
                                <div class="flex items-center gap-1 shrink-0">
                                    <button type="button" @click="editing = {{ $package->id }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <form method="POST" action="{{ route($package->is_active ? 'admin.grammar-placement.packages.deactivate' : 'admin.grammar-placement.packages.activate', $package) }}">
                                        @csrf
                                        <button type="submit" class="p-2 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="{{ $package->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            @if($package->is_active)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            @endif
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.grammar-placement.packages.destroy', $package) }}" onsubmit="return confirm('Hapus paket ini beserta semua soalnya?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Copy link --}}
                            <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl p-2 mb-3">
                                <input type="text" readonly value="{{ $publicUrl }}" class="flex-1 bg-transparent text-xs text-gray-600 px-2 outline-none" onclick="this.select()">
                                <button type="button" onclick="window.copyGrammarPlacementLink(this, '{{ $publicUrl }}')" class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-gray-800 hover:bg-gray-900 rounded-lg transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    Salin Link
                                </button>
                                <a href="{{ $publicUrl }}" target="_blank" class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-lg transition-colors">
                                    Pratinjau
                                </a>
                            </div>

                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.grammar-placement.questions.index', $package) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">Kelola Soal &rarr;</a>
                                <a href="{{ route('admin.grammar-placement.results.index', ['package_id' => $package->id]) }}" class="text-sm font-semibold text-purple-600 hover:text-purple-800">Lihat Hasil &rarr;</a>
                            </div>
                        </div>
                    </template>

                    <template x-if="editing === {{ $package->id }}">
                        <form method="POST" action="{{ route('admin.grammar-placement.packages.update', $package) }}" class="space-y-3">
                            @csrf @method('PUT')
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Paket</label>
                                <input type="text" name="title" value="{{ $package->title }}" required class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Deskripsi</label>
                                <textarea name="description" rows="2" class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500 resize-none">{{ $package->description }}</textarea>
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

<script>
    window.copyGrammarPlacementLink = function(button, text) {
        const done = () => {
            const original = button.innerHTML;
            button.innerHTML = '✓ Tersalin';
            setTimeout(() => { button.innerHTML = original; }, 1500);
        };
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(done).catch(() => prompt('Salin link ini:', text));
        } else {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try { document.execCommand('copy'); done(); } catch (e) { prompt('Salin link ini:', text); }
            textArea.remove();
        }
    };
</script>
@endsection

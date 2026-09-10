@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto" x-data="audioLibrary()">
    {{-- Page Header --}}
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Audio & Media Library</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola semua file audio yang pernah diunggah untuk materi dan mockup.</p>
        </div>
        
        {{-- Stats Blocks --}}
        <div class="flex gap-4">
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                <p class="text-xs text-gray-500 font-semibold uppercase">Total Files</p>
                <p class="text-xl font-bold text-gray-800">{{ number_format($stats['total_files']) }} <span class="text-xs text-gray-500 font-normal">({{ number_format($stats['total_size'] / 1048576, 2) }} MB)</span></p>
            </div>
            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                <p class="text-xs text-gray-500 font-semibold uppercase">Orphaned Files</p>
                <p class="text-xl font-bold text-rose-600">{{ number_format($stats['orphaned_count']) }}</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-emerald-50 text-emerald-600 border border-emerald-200 p-4 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-rose-50 text-rose-600 border border-rose-200 p-4 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{-- Controls --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6 flex flex-col sm:flex-row justify-between gap-4">
        <form method="GET" action="{{ route('admin.audio-library.index') }}" class="flex flex-col sm:flex-row gap-4 flex-1">
            <div class="relative max-w-sm flex-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama file atau path..." class="pl-10 form-input w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
            </div>
            
            <div class="flex items-center gap-4">
                <select name="module" class="form-select rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" onchange="this.form.submit()">
                    <option value="">Semua Modul</option>
                    <option value="IELTS Mockup" {{ request('module') == 'IELTS Mockup' ? 'selected' : '' }}>IELTS Mockup</option>
                    <option value="IELTS" {{ request('module') == 'IELTS' ? 'selected' : '' }}>IELTS</option>
                    <option value="PTE Academic" {{ request('module') == 'PTE Academic' || request('module') == 'PTE' ? 'selected' : '' }}>PTE Academic</option>
                    <option value="TOEFL ITP" {{ request('module') == 'TOEFL ITP' || request('module') == 'TOEFL' ? 'selected' : '' }}>TOEFL ITP</option>
                    <option value="AI Voice / TTS" {{ request('module') == 'AI Voice / TTS' ? 'selected' : '' }}>AI Voice / TTS</option>
                    <option value="Lainnya" {{ request('module') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>

                <select name="status" class="form-select rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Terpakai (Used)</option>
                    <option value="unused" {{ request('status') == 'unused' ? 'selected' : '' }}>Tidak Terpakai (Orphaned)</option>
                </select>
            </div>
            
            <button type="submit" class="hidden">Submit</button>
        </form>
    </div>

    {{-- File List --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Nama File & Preview</th>
                        <th class="px-6 py-4 font-semibold">Modul</th>
                        <th class="px-6 py-4 font-semibold">Ukuran</th>
                        <th class="px-6 py-4 font-semibold">Diunggah</th>
                        <th class="px-6 py-4 font-semibold text-center">Status DB</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($paginatedFiles as $file)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-start gap-3">
                                <button type="button" @click="playAudio('{{ asset($file['path']) }}', $event.currentTarget)" class="flex-shrink-0 w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-100 transition-colors play-btn">
                                    <svg class="w-4 h-4 play-icon" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                    <svg class="w-4 h-4 pause-icon hidden" fill="currentColor" viewBox="0 0 24 24"><path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z"/></svg>
                                </button>
                                <div>
                                    <p class="font-medium text-gray-900 truncate max-w-xs md:max-w-md lg:max-w-xl" title="{{ $file['name'] }}">
                                        {{ $file['name'] }}
                                    </p>
                                    <p class="text-xs text-gray-500 truncate max-w-xs md:max-w-md lg:max-w-xl mt-0.5 font-mono" title="{{ $file['path'] }}">
                                        {{ $file['path'] }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $file['module'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ number_format($file['size'] / 1048576, 2) }} MB
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-xs">
                            {{ \Carbon\Carbon::createFromTimestamp($file['modified_at'])->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($file['is_used'])
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200" title="Digunakan oleh database">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Terpakai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200" title="Tidak ditemukan referensinya di database">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Orphaned
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" @click="copyToClipboard('{{ $file['path'] }}')" class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded transition-colors tooltip-trigger" title="Copy Path untuk di-paste saat pembuatan soal">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                </button>
                                
                                @if(!$file['is_used'])
                                <form action="{{ route('admin.audio-library.destroy') }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file audio ini permanen dari server?');">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="path" value="{{ $file['path'] }}">
                                    <button type="submit" class="p-1.5 text-gray-500 hover:text-rose-600 hover:bg-rose-50 rounded transition-colors" title="Hapus File Permanen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                                @else
                                <button type="button" disabled class="p-1.5 text-gray-300 cursor-not-allowed" title="Tidak dapat dihapus karena masih dipakai">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                            <p class="text-base font-medium text-gray-900">Tidak ada file audio ditemukan</p>
                            <p class="text-sm">Silakan ubah filter pencarian Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($paginatedFiles->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $paginatedFiles->links() }}
        </div>
        @endif
    </div>

    {{-- Hidden Audio Element for Preview --}}
    <audio id="libraryAudioPlayer" class="hidden" preload="none"></audio>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('audioLibrary', () => ({
            currentAudio: null,
            isPlaying: false,
            currentBtn: null,
            
            init() {
                this.audioElement = document.getElementById('libraryAudioPlayer');
                
                this.audioElement.addEventListener('ended', () => {
                    this.isPlaying = false;
                    this.resetCurrentBtn();
                });
                
                this.audioElement.addEventListener('pause', () => {
                    this.isPlaying = false;
                    this.resetCurrentBtn();
                });
                
                this.audioElement.addEventListener('play', () => {
                    this.isPlaying = true;
                });
            },
            
            playAudio(src, btnElement) {
                if (this.currentAudio === src && !this.audioElement.paused) {
                    this.audioElement.pause();
                    return;
                }
                
                this.resetCurrentBtn();
                
                if (this.currentAudio !== src) {
                    this.audioElement.src = src;
                    this.currentAudio = src;
                }
                
                this.currentBtn = btnElement;
                this.setBtnPlaying(this.currentBtn);
                
                this.audioElement.play().catch(e => {
                    console.error("Error playing audio:", e);
                    alert("Gagal memutar audio. Pastikan format didukung browser.");
                    this.resetCurrentBtn();
                });
            },
            
            resetCurrentBtn() {
                if (this.currentBtn) {
                    this.currentBtn.querySelector('.play-icon').classList.remove('hidden');
                    this.currentBtn.querySelector('.pause-icon').classList.add('hidden');
                    this.currentBtn.classList.remove('bg-indigo-600', 'text-white', 'hover:bg-indigo-700');
                    this.currentBtn.classList.add('bg-indigo-50', 'text-indigo-600', 'hover:bg-indigo-100');
                }
            },
            
            setBtnPlaying(btn) {
                btn.querySelector('.play-icon').classList.add('hidden');
                btn.querySelector('.pause-icon').classList.remove('hidden');
                btn.classList.remove('bg-indigo-50', 'text-indigo-600', 'hover:bg-indigo-100');
                btn.classList.add('bg-indigo-600', 'text-white', 'hover:bg-indigo-700');
            },
            
            copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('Path audio berhasil disalin ke clipboard: ' + text);
                }).catch(err => {
                    console.error('Failed to copy: ', err);
                    prompt('Silakan salin teks ini secara manual:', text);
                });
            }
        }));
    });
</script>
@endsection

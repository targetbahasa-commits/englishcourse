{{-- Directions audio: player for everyone if set; upload UI admin-only. --}}
@php
    $pkg = (int) ($packageNumber ?? request()->route('package') ?? 1);
    $uploadRoute = route('assignments.toefl-itp.mockup.package.upload-audio', $pkg);
    $partLabel = $part ?? 'A';
    $hookId = $formHookId ?? null;
@endphp
@if(!empty($audioPath))
    <div class="mb-4 rounded-lg border border-stone-300 bg-white p-3 shadow-sm">
        <p class="text-xs font-semibold text-stone-700 mb-2 uppercase tracking-wide">Audio directions Part {{ $partLabel }}</p>
        <audio controls preload="metadata" class="w-full max-w-lg h-9" src="{{ asset($audioPath) }}"></audio>
    </div>
@endif
@if(auth()->check() && auth()->user()->isAdmin())
    <div class="mb-4 rounded-xl border border-dashed border-stone-300 bg-[#f7f7f5] p-4 shadow-sm">
        <p class="text-xs font-bold uppercase tracking-wide text-stone-700 mb-2">Admin — unggah audio directions Part {{ $partLabel }}</p>
        @if(empty($audioPath))
            <p class="text-xs text-stone-500 mb-3">Belum ada file audio untuk directions ini.</p>
        @endif

        @if($hookId)
            <div class="flex flex-wrap items-end gap-2">
                <div>
                    <label class="block text-xs text-stone-700 mb-1">File (mp3, wav, ogg, m4a, maks. 50MB)</label>
                    <input type="file" name="audio_file" form="{{ $hookId }}" accept=".mp3,.wav,.ogg,.m4a,audio/*" required
                           class="block w-full text-sm text-stone-700 file:mr-2 file:rounded file:border file:border-stone-300 file:bg-white file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-800 hover:file:bg-stone-100">
                </div>
                <button type="submit" form="{{ $hookId }}"
                        class="shrink-0 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white hover:bg-black">
                    Unggah audio
                </button>
            </div>
        @else
            <form action="{{ $uploadRoute }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-end gap-2">
                @csrf
                <input type="hidden" name="listening_direction_part" value="{{ $partLabel }}">
                <div>
                    <label class="block text-xs text-stone-700 mb-1">File (mp3, wav, ogg, m4a, maks. 50MB)</label>
                    <input type="file" name="audio_file" accept=".mp3,.wav,.ogg,.m4a,audio/*" required
                           class="block w-full text-sm text-stone-700 file:mr-2 file:rounded file:border file:border-stone-300 file:bg-white file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-zinc-800 hover:file:bg-stone-100">
                </div>
                <button type="submit" class="shrink-0 rounded-lg bg-zinc-900 px-4 py-2 text-sm font-semibold text-white hover:bg-black">
                    Unggah audio
                </button>
            </form>
        @endif
    </div>
@endif

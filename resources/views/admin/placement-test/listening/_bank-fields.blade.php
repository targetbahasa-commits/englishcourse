@php $b = $bank ?? null; @endphp
<div>
    <x-input-label value="Title" />
    <x-text-input name="title" type="text" class="mt-1 block w-full" value="{{ $b->title ?? '' }}" required />
</div>
<div>
    <x-input-label value="Audio File" />
    <input type="file" name="audio" accept=".mp3,.wav,.m4a,.ogg,.webm" class="mt-1 block w-full text-sm text-gray-600" {{ $b ? '' : 'required' }} />
    @if($b && $b->audio_url)
        <p class="text-xs text-gray-500 mt-1">Audio saat ini: <audio controls src="{{ $b->audio_url }}" class="h-8 inline-block align-middle"></audio> — upload file baru untuk mengganti.</p>
    @endif
</div>
<div>
    <x-input-label value="Transcript" />
    <textarea name="transcript" rows="5" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ $b->transcript ?? '' }}</textarea>
</div>
<div class="grid grid-cols-3 gap-4">
    <div>
        <x-input-label value="Target CEFR Level" />
        <select name="level" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
            <option value="">—</option>
            @foreach(['A1','A2','B1','B2','C1','C2'] as $lvl)
                <option value="{{ $lvl }}" {{ ($b->level ?? '') === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <x-input-label value="Duration (s)" />
        <x-text-input name="duration" type="number" min="0" class="mt-1 block w-full" value="{{ $b->duration ?? '' }}" />
    </div>
    <div>
        <x-input-label value="Status" />
        <select name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
            <option value="draft" {{ ($b->status ?? 'ready') === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="ready" {{ ($b->status ?? 'ready') === 'ready' ? 'selected' : '' }}>Ready</option>
        </select>
    </div>
</div>

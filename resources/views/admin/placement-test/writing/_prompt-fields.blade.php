@php $p = $prompt ?? null; @endphp
<div>
    <x-input-label value="Title" />
    <x-text-input name="title" type="text" class="mt-1 block w-full" value="{{ $p->title ?? '' }}" required />
</div>
<div>
    <x-input-label value="Prompt Text" />
    <textarea name="prompt_text" rows="5" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ $p->prompt_text ?? '' }}</textarea>
</div>
<div class="grid grid-cols-2 gap-4">
    <div>
        <x-input-label value="Min Words" />
        <x-text-input name="min_words" type="number" min="0" class="mt-1 block w-full" value="{{ $p->min_words ?? 100 }}" required />
    </div>
    <div>
        <x-input-label value="Status" />
        <select name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
            <option value="draft" {{ ($p->status ?? 'ready') === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="ready" {{ ($p->status ?? 'ready') === 'ready' ? 'selected' : '' }}>Ready</option>
        </select>
    </div>
</div>

@php $p = $prompt ?? null; @endphp
<div>
    <x-input-label value="Title" />
    <x-text-input name="title" type="text" class="mt-1 block w-full" value="{{ $p->title ?? '' }}" required />
</div>
<div>
    <x-input-label value="Prompt Text" />
    <textarea name="prompt_text" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ $p->prompt_text ?? '' }}</textarea>
</div>
<div class="grid grid-cols-3 gap-4">
    <div>
        <x-input-label value="Prep Time (s)" />
        <x-text-input name="prep_seconds" type="number" min="0" class="mt-1 block w-full" value="{{ $p->prep_seconds ?? 30 }}" required />
    </div>
    <div>
        <x-input-label value="Response Time (s)" />
        <x-text-input name="response_seconds" type="number" min="1" class="mt-1 block w-full" value="{{ $p->response_seconds ?? 60 }}" required />
    </div>
    <div>
        <x-input-label value="Status" />
        <select name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
            <option value="draft" {{ ($p->status ?? 'ready') === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="ready" {{ ($p->status ?? 'ready') === 'ready' ? 'selected' : '' }}>Ready</option>
        </select>
    </div>
</div>

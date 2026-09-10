@php $q = $question ?? null; $options = $q->options ?? ['', '', '', '']; @endphp
<div>
    <x-input-label value="Question Text" />
    <textarea name="question_text" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ $q->question_text ?? '' }}</textarea>
</div>
@foreach (['A','B','C','D'] as $i => $letter)
    <div>
        <x-input-label value="Option {{ $letter }}" />
        <x-text-input name="options[]" type="text" class="mt-1 block w-full" value="{{ $options[$i] ?? '' }}" required />
    </div>
@endforeach
<div>
    <x-input-label value="Correct Answer" />
    <select name="correct_answer" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
        @foreach (['A','B','C','D'] as $letter)
            <option value="{{ $letter }}" {{ ($q->correct_answer ?? '') === $letter ? 'selected' : '' }}>{{ $letter }}</option>
        @endforeach
    </select>
</div>
<div>
    <x-input-label value="Explanation (optional)" />
    <textarea name="explanation" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $q->explanation ?? '' }}</textarea>
</div>

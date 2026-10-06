@php
    $usesMatchingOptionsLayout = in_array($question['type'], ['matching_headings', 'matching_features', 'matching_sentence_endings', 'matching_paragraph_information']);
    $options = $question['options'] ?? [];
    if (empty($options) && in_array($question['type'] ?? '', ['matching_paragraph_information', 'matching_features'])) {
        $letters = range('A', 'K');
        $options = array_combine($letters, $letters);
    }
@endphp

<!-- List of Headings/Features Box (Top) -->
@if($usesMatchingOptionsLayout && !empty($question['options']) && in_array($question['type'], ['matching_headings', 'matching_features']))
<div class="mb-8 border-2 border-gray-800 p-6 bg-white shadow-sm">
    <h4 class="text-center font-bold text-gray-900 mb-5 text-xl font-serif tracking-wide">{{ $question['box_title'] ?? ($question['type'] === 'matching_features' ? 'List of Categories' : 'List of Headings') }}</h4>
    <ul class="space-y-2.5 max-w-xl mx-auto">
        @foreach($options as $optKey => $optText)
            @php
                $cleanOptText = preg_replace('/^\s*' . preg_quote($optKey, '/') . '\s*[\-\–\.\:]\s*/ui', '', $optText);
            @endphp
            <li class="text-gray-800 text-base md:text-lg leading-relaxed flex items-start gap-4">
                <span class="font-bold min-w-[32px] text-right font-serif text-gray-900 select-none">{{ $optKey }}</span>
                <span class="flex-1">{{ $cleanOptText }}</span>
            </li>
        @endforeach
    </ul>
</div>
@endif

@if($usesMatchingOptionsLayout)
<!-- Questions List with Dropdowns (Existing Layout) -->
<div class="space-y-4 max-w-2xl mx-auto">
    @foreach($question['sub_questions'] ?? [] as $subIndex => $subQuestion)
        <div class="flex items-center justify-between gap-4 py-2 border-b border-gray-100 last:border-0 hover:bg-white transition-colors px-2 rounded-lg">
            <div class="flex items-start gap-3 w-3/4 pt-1">
                <span class="text-gray-500 font-bold text-base md:text-lg mt-0.5">{{ $subIndex + 1 + ($question['start_number'] ?? 0) }}</span>
                <span class="font-normal text-gray-900 text-base md:text-lg leading-relaxed block">{{ $subQuestion['label'] }}</span>
            </div>

            <div class="relative w-1/4 max-w-[140px]">
                <select
                    data-qid="{{ $subQuestion['id'] }}" x-model="selected['{{ $subQuestion['id'] }}']"
                    class="appearance-none w-full bg-white border-2 border-gray-300 text-gray-700 py-2.5 px-3 pr-8 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 font-bold text-center cursor-pointer text-base md:text-lg shadow-sm transition-colors"
                >
                    <option value="" disabled selected>-</option>
                    @foreach($options as $optKey => $optText)
                        <option value="{{ $optKey }}">{{ $optKey }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
        </div>
    @endforeach
</div>
@else
<!-- Table Layout for T/F/NG (No Box) -->
<div class="overflow-x-auto mt-6">
    <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
        <thead>
            <tr class="bg-white border-b border-gray-200">
                <th class="p-4 font-bold text-gray-600 w-12 text-center">#</th>
                <th class="p-4 font-bold text-gray-600">Question Statement</th>
                <th class="p-4 font-bold text-gray-600 w-48 text-center">Answer</th>
            </tr>
        </thead>
        <tbody>
            @foreach($question['sub_questions'] ?? [] as $subIndex => $subQuestion)
                <tr class="group/row border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                    <td class="py-2 px-4 font-bold text-blue-600 text-center">
                        {{ $subIndex + 1 + ($question['start_number'] ?? 0) }}
                    </td>
                    <td class="py-2 px-4 text-sm text-gray-800 font-medium leading-relaxed cursor-text transition-colors relative" title="Click any word to find it in the passage">
                        <span class="block">{{ $subQuestion['label'] }}</span>
                    </td>
                    <td class="py-2 px-4 text-center">
                        <div class="relative inline-block w-full">
                            <select
                                data-qid="{{ $subQuestion['id'] }}" x-model="selected['{{ $subQuestion['id'] }}']"
                                class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer"
                                :class="{'text-blue-600 border-blue-500': selected['{{ $subQuestion['id'] }}']}"
                            >
                                <option value="" disabled selected>-</option>
                                @foreach($options as $optKey => $optText)
                                    <option value="{{ $optKey }}">{{ $optKey }}</option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- List of Endings Box (Bottom) -->
@if($usesMatchingOptionsLayout && !empty($question['options']) && $question['type'] === 'matching_sentence_endings')
<div class="mt-8 border-2 border-gray-300 p-4 rounded-none bg-white">
    <h4 class="text-center font-bold text-gray-800 mb-4 text-lg">{{ $question['box_title'] ?? 'List of Endings' }}</h4>
    <ul class="space-y-2">
        @foreach($options as $optKey => $optText)
            @php
                $cleanOptText = preg_replace('/^\s*' . preg_quote($optKey, '/') . '\s*[\-\–\.\:]\s*/ui', '', $optText);
            @endphp
            <li class="text-gray-700 text-sm md:text-base leading-relaxed pl-8 -indent-8 flex gap-2">
                <span class="font-bold min-w-[25px] inline-block">{{ $optKey }}</span>
                <span>{{ $cleanOptText }}</span>
            </li>
        @endforeach
    </ul>
</div>
@endif

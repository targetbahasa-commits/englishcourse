<!-- Fallback for other sub-question types (like Matching Features) -->
<div class="space-y-6 pl-10">
    @foreach($question['sub_questions'] ?? [] as $subIndex => $subQuestion)
        <div class="p-4 bg-white rounded-xl border border-gray-100">
            <div class="mb-4 flex items-start gap-4">
                <span class="flex-none w-8 h-8 rounded-full bg-white border-2 border-blue-100 text-sm font-bold text-gray-600 flex items-center justify-center shadow-sm relative top-0.5">
                    {{ $subIndex + 1 + ($question['start_number'] ?? 0) }}
                </span>
                <p class="font-medium text-gray-900 text-sm md:text-base leading-relaxed mt-0 mb-0">{{ $subQuestion['label'] }}</p>
            </div>
            <div class="space-y-3">
                @php
                    $optionsToUse = $subQuestion['options'] ?? $question['options'] ?? [];
                @endphp
                @foreach($optionsToUse as $optKey => $optText)
                    <label class="group flex items-center gap-3 p-2.5 rounded-lg border border-gray-200 cursor-pointer hover:bg-white hover:border-blue-300 transition-all duration-200"
                           :class="{
                                'bg-white border-blue-500 ring-1 ring-blue-500 shadow-sm': selected['{{ $subQuestion['id'] }}'] === '{{ $optKey }}',
                                'bg-white': selected['{{ $subQuestion['id'] }}'] !== '{{ $optKey }}'
                           }">

                        <div class="w-7 h-7 flex-shrink-0 rounded-full flex items-center justify-center text-xs font-bold transition-colors duration-200 border"
                             :class="{
                                'bg-blue-600 text-white border-blue-600': selected['{{ $subQuestion['id'] }}'] === '{{ $optKey }}',
                                'bg-gray-200 text-gray-600 border-gray-200 group-hover:bg-gray-300 group-hover:border-blue-400': selected['{{ $subQuestion['id'] }}'] !== '{{ $optKey }}'
                             }">
                            {{ $optKey }}
                        </div>

                        <span class="text-sm md:text-base text-gray-700 font-medium group-hover:text-gray-900 transition-colors"
                                :class="{ 'text-blue-900 font-bold': selected['{{ $subQuestion['id'] }}'] === '{{ $optKey }}' }">
                            {{ $optText }}
                        </span>

                        <input type="radio"
                               name="question_{{ $qIndex }}_{{ $subQuestion['id'] }}"
                               value="{{ $optKey }}"
                               class="hidden"
                               data-qid="{{ $subQuestion['id'] }}"
                               x-model="selected['{{ $subQuestion['id'] }}']">
                    </label>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

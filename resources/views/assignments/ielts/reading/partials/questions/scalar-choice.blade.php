@php
    $isMulti = isset($question['type']) && in_array($question['type'], ['checkbox', 'multiple_choice_multiple']);
    $subIds = [];
    if ($isMulti) {
        if (isset($question['sub_questions']) && is_array($question['sub_questions'])) {
            $subIds = array_column($question['sub_questions'], 'id');
        } elseif (isset($question['correct_answer']) && is_array($question['correct_answer'])) {
            $subIds = array_keys($question['correct_answer']);
        } else {
            $subIds = [$question['id']];
        }
    }
@endphp

<div class="space-y-2.5 pl-2 md:pl-4 mt-3">
    @foreach($question['options'] ?? [] as $optKey => $optText)
        <label class="group flex items-start gap-3 p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-white hover:border-blue-300 transition-all duration-150"
               @if($isMulti)
                    @click.prevent="toggleOption('{{ $optKey }}')"
               @endif
               :class="{
                    'bg-blue-50/40 border-blue-500 ring-1 ring-blue-500 shadow-sm': Array.isArray(selected) ? selected.includes('{{ $optKey }}') : selected === '{{ $optKey }}',
                    'bg-white': !(Array.isArray(selected) ? selected.includes('{{ $optKey }}') : selected === '{{ $optKey }}')
               }">

             <div class="w-7 h-7 flex-shrink-0 rounded-full flex items-center justify-center text-xs font-bold transition-colors duration-200 border mt-0.5"
                  :class="{
                     'bg-blue-600 text-white border-blue-600': Array.isArray(selected) ? selected.includes('{{ $optKey }}') : selected === '{{ $optKey }}',
                     'bg-gray-100 text-gray-700 border-gray-200 group-hover:bg-gray-200 group-hover:border-blue-400': !(Array.isArray(selected) ? selected.includes('{{ $optKey }}') : selected === '{{ $optKey }}')
                  }">
                 {{ $optKey }}
             </div>

             <span class="text-base md:text-lg text-gray-800 font-normal leading-relaxed group-hover:text-gray-900 transition-colors flex-1 pt-0.5"
                   :class="{ 'text-blue-900 font-medium': Array.isArray(selected) ? selected.includes('{{ $optKey }}') : selected === '{{ $optKey }}' }">
                 {{ $optText }}
             </span>

             @if($isMulti)
                 <input type="checkbox"
                        value="{{ $optKey }}"
                        class="mt-1.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 pointer-events-none"
                        :checked="Array.isArray(selected) && selected.includes('{{ $optKey }}')">
             @else
                 <input type="radio"
                        name="question_{{ $qIndex }}"
                        value="{{ $optKey }}"
                        class="mt-1.5 border-gray-300 text-blue-600 focus:ring-blue-500"
                        x-model="selected"
                        data-qid="{{ $question['id'] }}">
             @endif
         </label>
     @endforeach

    @if($isMulti)
        <div class="mt-4 pt-3 border-t border-gray-100 space-y-2">
            @foreach($subIds as $idx => $sId)
                <div class="multi-sub-feedback-wrapper" data-subid="{{ $sId }}">
                    <input type="hidden"
                           name="question_{{ $qIndex }}_{{ $sId }}"
                           data-qid="{{ $sId }}"
                           :value="Array.isArray(selected) && selected[{{ $idx }}] ? selected[{{ $idx }}] : ''">
                </div>
            @endforeach
        </div>
    @endif
</div>

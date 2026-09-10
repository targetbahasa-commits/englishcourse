<div class="space-y-2.5 pl-2 md:pl-4 mt-3">
    @foreach($question['options'] ?? [] as $optKey => $optText)
        <label class="group flex items-start gap-3 p-3 rounded-lg border border-gray-200 cursor-pointer hover:bg-white hover:border-blue-300 transition-all duration-150"
               @if(isset($question['type']) && in_array($question['type'], ['checkbox', 'multiple_choice_multiple']))
                    @click.prevent="toggleOption('{{ $optKey }}')"
               @endif
               :class="{
                    'bg-white border-blue-500 ring-1 ring-blue-500 shadow-sm': Array.isArray(selected) ? selected.includes('{{ $optKey }}') : selected === '{{ $optKey }}',
                    'bg-white': !(Array.isArray(selected) ? selected.includes('{{ $optKey }}') : selected === '{{ $optKey }}')
               }">

             <span class="font-bold text-gray-900 min-w-[24px] text-base md:text-lg select-none pt-0.5"
                   :class="{ 'text-blue-700': Array.isArray(selected) ? selected.includes('{{ $optKey }}') : selected === '{{ $optKey }}' }">
                 {{ $optKey }}
             </span>

             <span class="text-base md:text-lg text-gray-800 font-normal leading-relaxed group-hover:text-gray-900 transition-colors flex-1"
                   :class="{ 'text-blue-900 font-medium': Array.isArray(selected) ? selected.includes('{{ $optKey }}') : selected === '{{ $optKey }}' }">
                 {{ $optText }}
             </span>

             @if(isset($question['type']) && in_array($question['type'], ['checkbox', 'multiple_choice_multiple']))
                 <input type="checkbox" name="question_{{ $qIndex }}[]" value="{{ $optKey }}" class="mt-1.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 pointer-events-none" :checked="Array.isArray(selected) && selected.includes('{{ $optKey }}')" data-qid="{{ $question['id'] }}">
             @else
                 <input type="radio" name="question_{{ $qIndex }}" value="{{ $optKey }}" class="mt-1.5 border-gray-300 text-blue-600 focus:ring-blue-500" x-model="selected" data-qid="{{ $question['id'] }}">
             @endif
         </label>
     @endforeach
 </div>

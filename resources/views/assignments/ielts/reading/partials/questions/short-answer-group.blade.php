{{-- Short Answer Group: numbered questions with inline or block text inputs --}}
<div class="space-y-4 mt-4">
    @foreach($question['sub_questions'] ?? [] as $subIndex => $subQuestion)
        @php
            $sqNum = $subQuestion['id'] ?? ($subIndex + 1 + ($question['start_number'] ?? 0));
            $labelText = $subQuestion['label'] ?? '';
            // If label contains leading dots like "...... What affects...", strip them
            $cleanLabel = preg_replace('/^[.…\s]+/u', '', $labelText);
            $dotPattern = '/([.…]{3,}|…)/u';
            $hasBlank = preg_match($dotPattern, $cleanLabel);
        @endphp
        <div class="py-3.5 border-b border-gray-100 last:border-0">
            <div class="flex items-start gap-3">
                <span class="flex-none w-7 h-7 bg-blue-50 text-blue-700 rounded-lg flex items-center justify-center font-bold text-sm border border-blue-200 shadow-sm">
                    {{ $sqNum }}
                </span>
                <div class="flex-1 leading-relaxed">
                    @if($hasBlank)
                        @php
                            $inputHtml = '<span class="inline-flex items-baseline mx-1 align-middle">' .
                                         '<span class="text-blue-600 font-bold text-sm md:text-base mr-1 select-none pointer-events-none">' . $sqNum . '</span>' .
                                         '<input type="text" data-qid="' . $subQuestion['id'] . '" x-model="selected[\'' . $subQuestion['id'] . '\']" placeholder="......" class="user-answer border-0 border-b-2 border-gray-400 focus:border-blue-600 rounded-none outline-none bg-transparent px-1 py-0.5 w-36 text-gray-900 font-medium transition-all focus:ring-0 placeholder-gray-400 text-sm md:text-base">' .
                                         '</span>';
                            $renderedText = preg_replace($dotPattern, $inputHtml, $cleanLabel, 1);
                        @endphp
                        <span class="font-normal text-gray-800 text-base">{!! $renderedText !!}</span>
                    @else
                        <div class="text-base font-medium text-gray-900 mb-2">{!! $cleanLabel !!}</div>
                        <div class="flex items-center gap-2 max-w-md">
                            <span class="text-xs font-bold uppercase tracking-wider text-gray-400 select-none">Answer:</span>
                            <input type="text" 
                                   data-qid="{{ $subQuestion['id'] }}" 
                                   x-model="selected['{{ $subQuestion['id'] }}']" 
                                   placeholder="Type your answer here..." 
                                   class="user-answer flex-1 border border-gray-300 focus:border-blue-600 focus:ring-2 focus:ring-blue-100 rounded-lg outline-none bg-white px-3 py-1.5 text-gray-900 font-medium text-sm md:text-base transition-all shadow-sm">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

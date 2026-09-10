{{-- Short Answer Group: numbered questions with inline text inputs --}}
<div class="space-y-5 mt-4">
    @foreach($question['sub_questions'] ?? [] as $subIndex => $subQuestion)
        <div class="py-3 border-b border-gray-100 last:border-0">
            <div class="flex items-start gap-3">
                <span class="flex-none w-7 h-7 bg-white text-blue-600 rounded-lg flex items-center justify-center font-bold text-sm border border-blue-100">
                    {{ $subIndex + 1 + ($question['start_number'] ?? 0) }}
                </span>
                <span class="font-normal text-gray-700 leading-relaxed block pt-0.5">
                    @php
                        $labelText = $subQuestion['label'] ?? '';
                        $sqNum = $subIndex + 1 + ($question['start_number'] ?? 0);
                        // Replace dots/ellipsis pattern with inline input
                        $dotPattern = '/([.\x{2026}]{3,})/u';
                        $hasBlank = preg_match($dotPattern, $labelText);
                        if ($hasBlank) {
                            $inputHtml = '<span class="inline-inline-flex items-baseline mx-1 align-middle">' .
                                         '<span class="text-blue-600 font-bold text-sm md:text-base mr-1 select-none pointer-events-none">' . $sqNum . '</span>' .
                                         '<input type="text" data-qid="' . $subQuestion['id'] . '" x-model="selected[\'' . $subQuestion['id'] . '\']" placeholder="......" class="user-answer border-0 border-b-2 border-gray-400 focus:border-blue-600 rounded-none outline-none bg-transparent px-1 py-0.5 w-32 text-gray-900 font-medium transition-all focus:ring-0 placeholder-gray-400 text-sm md:text-base">' .
                                         '</span>';
                            $labelText = preg_replace($dotPattern, $inputHtml, $labelText, 1);
                        }
                    @endphp
                    {!! $labelText !!}
                    @if(!$hasBlank)
                        <input type="text" data-qid="{{ $subQuestion['id'] }}" x-model="selected['{{ $subQuestion['id'] }}']" placeholder="......" class="user-answer block mt-2 border-0 border-b-2 border-gray-400 focus:border-blue-600 rounded-none outline-none bg-transparent px-2 py-0.5 w-full max-w-sm text-gray-900 font-medium transition-all focus:ring-0 placeholder-gray-400 text-sm md:text-base">
                    @endif
                </span>
            </div>
        </div>
    @endforeach
</div>

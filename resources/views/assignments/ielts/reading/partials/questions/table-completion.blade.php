<!-- Table Completion -->
<div class="mt-6 mb-8">
    @if(!empty($question['instruction']))
        <p class="mb-4 italic text-gray-700">{!! $question['instruction'] !!}</p>
    @endif

    <div class="border-2 border-gray-800 rounded-lg overflow-hidden shadow-sm">
        @if(!empty($question['box_title']))
            <div class="bg-white text-center font-bold text-blue-700 text-lg md:text-xl p-3 border-b-2 border-gray-800">
                {{ $question['box_title'] }}
            </div>
        @endif

        <div class="overflow-x-auto w-full">
            <table class="w-full min-w-[650px] text-left border-collapse bg-white text-sm md:text-base">
            @if(!empty($question['columns']))
                <thead>
                    <tr class="bg-white border-b-2 border-gray-800">
                        @foreach($question['columns'] as $col)
                            <th class="p-3.5 font-bold text-blue-700 border-r-2 border-gray-800 last:border-0 align-top text-base md:text-lg">{{ $col }}</th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody>
                @foreach($question['rows'] ?? [] as $rowIndex => $row)
                    <tr class="border-b-2 border-gray-800 last:border-0 hover:bg-white transition-colors">
                        @foreach($row as $cellIndex => $cellContent)
                            <td class="p-3.5 border-r-2 border-gray-800 last:border-0 align-top text-gray-900 leading-relaxed font-medium">
                                @php
                                    $cellText = $cellContent;
                                    $subQuestions = $question['sub_questions'] ?? [];
                                    $placeholders = $question['placeholders'] ?? [];
                                    
                                    // Build mapping of qNum => qKey
                                    $map = [];
                                    if (!empty($placeholders)) {
                                        foreach($placeholders as $k => $num) { $map[$num] = (string)$k; }
                                    }
                                    if (!empty($subQuestions)) {
                                        foreach($subQuestions as $sq) {
                                            $sqId = (string)($sq['id'] ?? '');
                                            $num = (int)preg_replace('/\D/', '', $sqId);
                                            if ($num) { $map[$num] = $sqId; }
                                        }
                                    }

                                    foreach($map as $qNum => $qKey) {
                                        $inputHtml = '<span class="inline-flex items-baseline mx-1 align-middle my-1">' .
                                                     '<span class="text-blue-600 font-bold text-sm md:text-base mr-1 select-none pointer-events-none">' . $qNum . '</span>' .
                                                     '<input type="text" x-model="selected[\'' . $qKey . '\']" data-qid="' . $qKey . '" placeholder="......" class="user-answer border-0 border-b-2 border-gray-400 focus:border-blue-600 rounded-none outline-none bg-transparent px-1 py-0.5 w-36 text-gray-900 font-medium transition-all focus:ring-0 placeholder-gray-400 text-sm md:text-base">' .
                                                     '</span>';

                                        if (str_contains($cellText, "[$qKey]")) {
                                            $cellText = str_replace("[$qKey]", $inputHtml, $cellText);
                                        } elseif (str_contains($cellText, "[$qNum]")) {
                                            $cellText = str_replace("[$qNum]", $inputHtml, $cellText);
                                        } else {
                                            $cellText = preg_replace('/' . $qNum . '[\s\.\…\_]{1,}/u', $inputHtml, $cellText, 1);
                                        }
                                    }
                                @endphp
                                {!! $cellText !!}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>

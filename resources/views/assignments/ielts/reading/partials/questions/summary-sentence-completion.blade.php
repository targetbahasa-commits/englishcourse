<!-- Summary / Sentence Completion -->
<div class="{{ !empty($question['box_title']) ? 'border-2 border-gray-800 p-6 rounded-none mb-6' : 'border border-gray-100 rounded-xl p-5 bg-white mb-6' }}">
    @if(!empty($question['box_title']))
        <h3 class="text-xl font-bold text-gray-900 mb-4 text-center font-serif">{{ $question['box_title'] }}</h3>
    @endif

    @if(!empty($question['instruction']) && trim(strip_tags($question['instruction'])) !== trim(strip_tags($question['text'] ?? '')))
        <p class="mb-4 italic text-gray-700">{!! $question['instruction'] !!}</p>
    @endif

    <div class="text-gray-800 leading-loose text-lg font-medium">
        @php
            $rawSummary = $question['summary_text'] ?? '';
            if (empty($rawSummary) && !empty($question['text'])) {
                if (preg_match('/\[\d+\]|\b\d{1,2}\s*[\.\…\_]{2,}/u', $question['text'])) {
                    $rawSummary = $question['text'];
                }
            }
            $summaryText = $rawSummary;

            // Format 1: legacy 'placeholders' → ['q10' => 10, ...]
            $placeholderMap = [];
            if (!empty($question['placeholders'])) {
                foreach ($question['placeholders'] as $key => $qNum) {
                    $placeholderMap[$key] = $qNum;
                }
            }

            // Format 2: 'blanks' → [['id'=>'q10','blank_number'=>10], ...]
            if (!empty($question['blanks'])) {
                foreach ($question['blanks'] as $blank) {
                    $placeholderMap[$blank['id']] = $blank['blank_number'];
                }
            }

            // Format 3: 'sub_questions' → [['id'=>'q28', ...]]
            if (empty($placeholderMap) && !empty($question['sub_questions'])) {
                foreach ($question['sub_questions'] as $sq) {
                    $sqId = $sq['id'] ?? '';
                    $numMatch = preg_replace('/\D/', '', $sqId);
                    if ($numMatch) {
                        $placeholderMap[$sqId] = (int)$numMatch;
                    }
                }
            }

            // Format 4: Fallback regex match for numbers with dots (e.g. 28......)
            if (empty($placeholderMap) && !empty($summaryText)) {
                preg_match_all('/\b(\d{1,2})\s*[\.\…\_]{2,}/u', $summaryText, $matches);
                if (!empty($matches[1])) {
                    foreach ($matches[1] as $mNum) {
                        $placeholderMap['q' . $mNum] = (int)$mNum;
                    }
                }
            }

            $hasOptions = !empty($question['options']) || !empty($question['box_options']);
            $optionsData = !empty($question['options']) ? $question['options'] : (!empty($question['box_options']) ? $question['box_options'] : []);

            $subQuestionLabels = [];
            if (!empty($question['sub_questions'])) {
                foreach ($question['sub_questions'] as $sq) {
                    if (!empty($sq['id']) && !empty($sq['label'])) {
                        $subQuestionLabels[$sq['id']] = $sq['label'];
                    }
                }
            }
            $unresolvedListItems = [];

            foreach ($placeholderMap as $key => $qNum) {
                if ($hasOptions) {
                    $selectOptions = '<option value="" selected>____</option>';
                    foreach ($optionsData as $optKey => $optVal) {
                        $optKeyLabel = is_numeric($optKey) ? $optVal : $optKey;
                        $selectOptions .= '<option value="' . htmlspecialchars($optKeyLabel) . '">' . htmlspecialchars($optKeyLabel) . '</option>';
                    }
                    $inputHtml = '<span class="inline-inline-flex items-baseline mx-1 align-middle my-1">' .
                                 '<span class="text-blue-600 font-bold text-sm md:text-base mr-1 select-none pointer-events-none">' . $qNum . '</span>' .
                                 '<select x-model="selected[\'' . $key . '\']" data-qid="' . $key . '" class="user-answer border-0 border-b-2 border-gray-400 focus:border-blue-600 rounded-none outline-none bg-transparent px-1 py-0.5 w-auto min-w-[3rem] text-blue-600 font-medium transition-all focus:ring-0 text-sm md:text-base cursor-pointer">' .
                                 $selectOptions .
                                 '</select>' .
                                 '</span>';
                } else {
                    $inputHtml = '<span class="inline-inline-flex items-baseline mx-1 align-middle my-1">' .
                                 '<span class="text-blue-600 font-bold text-sm md:text-base mr-1 select-none pointer-events-none">' . $qNum . '</span>' .
                                 '<input type="text" x-model="selected[\'' . $key . '\']" data-qid="' . $key . '" placeholder="......" class="user-answer border-0 border-b-2 border-gray-400 focus:border-blue-600 rounded-none outline-none bg-transparent px-1 py-0.5 w-32 text-gray-900 font-medium transition-all focus:ring-0 placeholder-gray-400 text-sm md:text-base">' .
                                 '</span>';
                }

                $oldSummaryText = $summaryText;

                if (!empty($summaryText)) {
                    // Match [N] bracket style (e.g. [8]) in summary_text
                    $summaryText = str_replace('[' . $qNum . ']', $inputHtml, $summaryText);
                    
                    // Match [key] style (e.g. [q8]) if different from [N]
                    if ((string)$key !== (string)$qNum) {
                        $summaryText = str_replace('[' . $key . ']', $inputHtml, $summaryText);
                    }

                    // ONLY run dot pattern preg_replace if bracket style was NOT found
                    if ($summaryText === $oldSummaryText) {
                        $summaryText = preg_replace('/' . $qNum . '[\s\.\…\_]{2,}/u', $inputHtml, $summaryText, 1);
                    }
                }

                // No marker found anywhere in the text to attach this input to.
                // If this placeholder came from a sub_question with its own label,
                // replace placeholder inline in the label if present, or render it as standalone item
                if (($summaryText === $oldSummaryText || empty($summaryText)) && isset($subQuestionLabels[$key])) {
                    $lbl = $subQuestionLabels[$key];
                    $oldLbl = $lbl;
                    $lbl = str_replace(['[' . $qNum . ']', '[' . $key . ']'], $inputHtml, $lbl);
                    if ($lbl === $oldLbl) {
                        $lbl = preg_replace('/' . $qNum . '[\s\.\…\_]{1,}/u', $inputHtml, $lbl, 1);
                    }

                    if ($lbl !== $oldLbl) {
                        $unresolvedListItems[] = ['qNum' => $qNum, 'label' => $lbl, 'input' => ''];
                    } else {
                        $unresolvedListItems[] = ['qNum' => $qNum, 'label' => $lbl, 'input' => $inputHtml];
                    }
                }
            }
        @endphp
        {!! $summaryText !!}
    </div>

    @if(!empty($unresolvedListItems))
        <div class="mt-6 space-y-3">
            @foreach($unresolvedListItems as $item)
                <div class="text-gray-800 text-lg font-medium flex flex-wrap items-baseline gap-1">
                    <span class="mr-1">{!! $item['label'] !!}</span>
                    {!! $item['input'] !!}
                </div>
            @endforeach
        </div>
    @endif

    @if(isset($question['box_options']))
        <div class="bg-white p-4 rounded-lg border border-gray-200 mt-6">
            <strong class="block text-gray-700 mb-2 uppercase text-sm tracking-wide">List of Words</strong>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($question['box_options'] ?? [] as $key => $option)
                    <div class="text-sm">
                        <span class="font-bold text-gray-900 mr-1">{{ $key }}</span>
                        <span class="text-gray-700">{{ $option }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

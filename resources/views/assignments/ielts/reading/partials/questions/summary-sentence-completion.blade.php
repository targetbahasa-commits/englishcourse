<!-- Summary / Sentence Completion -->
<div class="{{ !empty($question['box_title']) ? 'border-2 border-gray-800 p-6 rounded-none mb-6' : 'border border-gray-100 rounded-xl p-5 bg-white mb-6' }}">
    @if(!empty($question['box_title']))
        <h3 class="text-xl font-bold text-gray-900 mb-4 text-center font-serif">{{ $question['box_title'] }}</h3>
    @endif

    @if(!empty($question['instruction']) && empty($question['text']))
        <p class="mb-4 italic text-gray-700">{!! $question['instruction'] !!}</p>
    @endif

    @php
        $rawSummary = $question['summary_text'] ?? ($question['summary'] ?? '');
        $hasExplicitSummary = (array_key_exists('summary_text', $question) && $question['summary_text'] !== null)
            || (array_key_exists('summary', $question) && $question['summary'] !== null);

        if (!$hasExplicitSummary && empty($rawSummary) && !empty($question['text'])) {
            if (preg_match('/\[\d+\]|\b\d{1,2}\s*[\.\…\_]{2,}/u', $question['text'])) {
                $rawSummary = $question['text'];
            } elseif (!empty($question['sub_questions'])) {
                $leadText = '';
                $patterns = [
                    '/(.*?on your answer sheet\.?)(.*)$/si',
                    '/(.*?in boxes \d+[-–]\d+\.?)(.*)$/si',
                    '/(.*?each answer\.?)(.*)$/si',
                ];
                foreach ($patterns as $p) {
                    if (preg_match($p, $question['text'], $m)) {
                        $leadText = trim(strip_tags($m[2]));
                        break;
                    }
                }
                $reconstructed = $leadText ? $leadText . ' ' : '';
                foreach ($question['sub_questions'] as $sq) {
                    $num = preg_replace('/\D/', '', $sq['id'] ?? '');
                    $label = $sq['label'] ?? $sq['text'] ?? '';
                    $cleanLabel = preg_replace('/^[.\x{2026}\s]+/u', '', $label);
                    if (preg_match('/[\.\…\_]{2,}/u', $cleanLabel)) {
                        $cleanLabel = preg_replace('/[\.\…\_]{2,}/u', '[' . $num . ']', $cleanLabel, 1);
                        $reconstructed .= $cleanLabel . ' ';
                    } else {
                        $reconstructed .= '[' . $num . '] ' . $cleanLabel . ' ';
                    }
                }
                $rawSummary = trim($reconstructed);
            }
        }

        // Strip leading instruction lines (e.g. "Complete the following summary...", "Using NO MORE THAN...", "Write your answers...", etc.),
        // so they don't duplicate the question header instructions.
        if (!empty($rawSummary)) {
            $instructionPattern = '/^(?:Questions?\s+\d+|Complete\s+(?:the|each|sentences?)\b|Choose\s+(?:NO|the|ONE|TWO|THREE|a\b)\b|Write\s+(?:your|the|NO|ONE|TWO|THREE)\b|Using\s+(?:NO|the|words?)\b|Use\s+(?:NO|the|words?)\b|In\s+boxes?\b|You\s+may\s+use\b|NB\b|Reading\s+Test\s+\d+|Do\s+the\s+following\b|Look\s+at\b|Match\s+each\b|Classify\b|Answers?\s+in\b|,?\s*write\s+the\s+correct)/i';
            $lines = preg_split('/<br\s*\/?>|\n/i', $rawSummary);
            $strippedLines = [];
            $stripping = true;
            foreach ($lines as $line) {
                $cleanLine = trim(strip_tags($line));
                $cleanNoPunct = ltrim($cleanLine, " \t\n\r\0\x0B,.:;–-");
                if ($stripping && (empty($cleanLine) || preg_match($instructionPattern, $cleanLine) || preg_match($instructionPattern, $cleanNoPunct))) {
                    continue;
                }
                $stripping = false;
                // Check if trailing metadata line
                if (preg_match('/^(?:Reading\s+Test\s+\d+|Advertisements)$/i', $cleanLine)) {
                    continue;
                }
                $strippedLines[] = $line;
            }
            $rawSummary = trim(implode('<br>', $strippedLines));
        }

        $summaryText = preg_replace('/\s*Advertisements\s*/i', '', $rawSummary);


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

            // Ignore bogus TRUE/FALSE/NOT GIVEN options mistakenly stored on completion questions
            if (isset($optionsData['TRUE']) || isset($optionsData['YES'])) {
                $hasOptions = false;
                $optionsData = [];
            }

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
                    $safeKey = preg_quote((string)$key, '/');
                    $safeNum = preg_quote((string)$qNum, '/');

                    // Case B: [qNum] or [key] followed immediately by dots e.g. [27] .....................
                    if (preg_match('/\[(?:' . $safeNum . '|' . $safeKey . ')\]\s*[\.\…\_]{2,}/u', $summaryText)) {
                        $summaryText = preg_replace('/\[(?:' . $safeNum . '|' . $safeKey . ')\]\s*[\.\…\_]{2,}/u', $inputHtml, $summaryText, 1);
                    }
                    // Case A: [qNum] or [key] followed by text and then dots in the same clause e.g. [23] sentence text .....
                    elseif (preg_match('/\[(?:' . $safeNum . '|' . $safeKey . ')\]\s*([^\[<]+?)[\.\…\_]{2,}/u', $summaryText)) {
                        $summaryText = preg_replace_callback('/\[(?:' . $safeNum . '|' . $safeKey . ')\]\s*([^\[<]+?)[\.\…\_]{2,}/u', function($m) use ($inputHtml) {
                            return trim($m[1]) . ' ' . $inputHtml;
                        }, $summaryText, 1);
                    }
                    // Standard replacement if no dots attached
                    else {
                        $summaryText = str_replace(['[' . $qNum . ']', '[' . $key . ']'], $inputHtml, $summaryText);
                    }

                    // Case C: Line starts with qNum, text, and then dots (e.g. "19 Farmers was founded as a ...... in Auckland")
                    if ($summaryText === $oldSummaryText) {
                        $cPattern = '/(^|<br\s*\/?>|\n)\s*' . $safeNum . '[\s\x{00A0}]+([^<\n\r\[]*?)[\.\…\_]{2,}/u';
                        if (preg_match($cPattern, $summaryText)) {
                            $summaryText = preg_replace_callback($cPattern, function($m) use ($inputHtml) {
                                return $m[1] . trim($m[2]) . ' ' . $inputHtml;
                            }, $summaryText, 1);
                        }
                    }

                    // ONLY run dot pattern preg_replace if bracket/line style was NOT found
                    // Require at least one dot or underscore so we do not match spaces
                    if ($summaryText === $oldSummaryText) {
                        $summaryText = preg_replace('/' . $safeNum . '[\s\x{00A0}]*[\.\…\_]{2,}/u', $inputHtml, $summaryText, 1);
                    }
                }

                // No marker found anywhere in the text to attach this input to.
                // If this placeholder came from a sub_question with its own label,
                // replace placeholder inline in the label if present, or render it as standalone item
                if (($summaryText === $oldSummaryText || empty($summaryText)) && isset($subQuestionLabels[$key])) {
                    $lbl = $subQuestionLabels[$key];
                    $oldLbl = $lbl;
                    $lbl = preg_replace('/\[(?:' . $qNum . '|' . preg_quote((string)$key, '/') . ')\]\s*[\.\…\_]{2,}/u', $inputHtml, $lbl);
                    if ($lbl === $oldLbl) {
                        $lbl = str_replace(['[' . $qNum . ']', '[' . $key . ']'], $inputHtml, $lbl);
                    }
                    if ($lbl === $oldLbl) {
                        $lbl = preg_replace('/' . $qNum . '[\s\.\…\_]{1,}/u', $inputHtml, $lbl, 1);
                    }
                    if ($lbl === $oldLbl) {
                        $lbl = preg_replace('/[\.\…\_]{2,}/u', $inputHtml, $lbl, 1);
                    }

                    if ($lbl !== $oldLbl) {
                        $unresolvedListItems[] = ['qNum' => $qNum, 'label' => $lbl, 'input' => ''];
                    } else {
                        $unresolvedListItems[] = ['qNum' => $qNum, 'label' => $lbl, 'input' => $inputHtml];
                    }
                }
            }
        @endphp

        @if(filled(trim(strip_tags($summaryText))))
            <div class="text-gray-800 leading-loose text-lg font-medium mb-4">
                {!! $summaryText !!}
            </div>
        @endif

        @if(!empty($unresolvedListItems))
            <div class="{{ filled(trim(strip_tags($summaryText))) ? 'mt-6' : '' }} space-y-3">
            @foreach($unresolvedListItems as $item)
                <div class="text-gray-800 text-lg font-medium flex flex-wrap items-baseline gap-1">
                    <span class="mr-1">{!! $item['label'] !!}</span>
                    {!! $item['input'] !!}
                </div>
            @endforeach
        </div>
    @endif

    @php
        $boxList = !empty($question['box_options']) ? $question['box_options'] : (!empty($optionsData) ? $optionsData : []);
    @endphp
    @if(!empty($boxList))
        <div class="bg-white p-4 rounded-lg border border-gray-200 mt-6">
            <strong class="block text-gray-700 mb-2 uppercase text-sm tracking-wide">{{ $question['box_title'] ?? 'List of Words' }}</strong>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($boxList as $key => $option)
                    <div class="text-sm">
                        <span class="font-bold text-gray-900 mr-1">{{ $key }}</span>
                        <span class="text-gray-700">{{ $option }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

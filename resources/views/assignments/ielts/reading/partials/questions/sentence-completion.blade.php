<!-- Sentence Completion -->
<div class="mt-6 mb-8 space-y-4">
    @if(!empty($question['instruction']) && empty($question['text']))
        <p class="mb-4 italic text-gray-700">{!! $question['instruction'] !!}</p>
    @endif

    @php
        $subQuestions = $question['sub_questions'] ?? [];
        $placeholders = $question['placeholders'] ?? [];
        
        // Build items
        $items = [];
        if (!empty($subQuestions)) {
            foreach ($subQuestions as $sq) {
                $sqId = (string)($sq['id'] ?? '');
                $num = (int)preg_replace('/\D/', '', $sqId);
                $items[] = [
                    'key' => $sqId,
                    'num' => $num ?: $sqId,
                    'label' => $sq['label'] ?? ''
                ];
            }
        } elseif (!empty($placeholders)) {
            foreach ($placeholders as $k => $num) {
                $items[] = [
                    'key' => (string)$k,
                    'num' => $num,
                    'label' => ''
                ];
            }
        }
    @endphp

    @foreach($items as $item)
        @php
            $qKey = $item['key'];
            $qNum = $item['num'];
            $rawLabel = $item['label'];

            // Input element without qNum inside (since qNum is rendered on the left margin)
            $inputHtml = '<span class="inline-inline-flex items-baseline mx-1 align-middle my-1">' .
                         '<input type="text" x-model="selected[\'' . $qKey . '\']" data-qid="' . $qKey . '" placeholder="...................................." class="user-answer border-0 border-b-2 border-gray-400 focus:border-blue-600 rounded-none outline-none bg-transparent px-2 py-0.5 w-44 md:w-56 text-blue-700 font-semibold text-base md:text-lg transition-all focus:ring-0 placeholder-gray-400">' .
                         '</span>';

            $sentenceHtml = $rawLabel;
            $oldSentence = $sentenceHtml;

            // Replace bracket placeholders e.g. [21] or [q21]
            $sentenceHtml = str_replace(['[' . $qNum . ']', '[' . $qKey . ']'], $inputHtml, $sentenceHtml);

            // Replace dot patterns e.g. 21...... or 21... or 21.
            if ($sentenceHtml === $oldSentence) {
                $sentenceHtml = preg_replace('/' . $qNum . '[\s\.\…\_]{1,}/u', $inputHtml, $sentenceHtml, 1);
            }

            if ($sentenceHtml === $oldSentence) {
                $sentenceHtml = preg_replace('/[\.\…\_]{2,}/u', $inputHtml, $sentenceHtml, 1);
            }

            // Fallback if no placeholder pattern matched
            if ($sentenceHtml === $oldSentence) {
                $sentenceHtml = $rawLabel . ' ' . $inputHtml;
            }
        @endphp

        <div class="flex items-baseline gap-3 md:gap-4 text-base md:text-lg text-gray-900 leading-relaxed font-medium py-1">
            <span class="font-bold text-blue-700 text-base md:text-lg w-7 md:w-9 flex-shrink-0 text-left select-none">{{ $qNum }}</span>
            <div class="flex-1 font-sans">{!! $sentenceHtml !!}</div>
        </div>
    @endforeach
</div>

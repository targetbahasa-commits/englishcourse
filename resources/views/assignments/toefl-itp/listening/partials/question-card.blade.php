<div class="py-3 group transition-colors hover:bg-white rounded-lg px-2 -mx-2 relative">
    <div class="flex items-baseline gap-3">
        <div class="flex-none flex items-center justify-end gap-2 w-8">
            <span class="font-bold text-gray-500 text-xl">{{ $question->question_number }}.</span>
        </div>
        @php
            $currentUser = auth()->user();
            $baseRole = strtolower(trim((string) ($currentUser->role ?? '')));
            $hasAdminBaseRole = $baseRole === 'admin' || str_contains($baseRole, 'admin');
            $isAdminImpersonating = $currentUser && $baseRole === 'admin' && request()->hasSession() && session()->has('view_as_role');
            $hasPrivilegedAccess = $currentUser && (
                (method_exists($currentUser, 'isAdmin') && $currentUser->isAdmin())
                || $hasAdminBaseRole
                || $isAdminImpersonating
            );
            $canEditQuestion = $currentUser && (
                $hasPrivilegedAccess
            );
        @endphp
        @if(isset($transcript_enabled) && $transcript_enabled)
            <button type="button" 
                    onclick="jumpToTime({{ $questionTimestamps[$question->id] ?? 'null' }})" 
                    class="absolute top-3 right-2 w-6 h-6 rounded-full bg-white text-purple-600 hover:bg-purple-200 flex items-center justify-center text-xs font-bold transition-all shadow-sm hover:scale-110" 
                    title="Lihat Transkrip & Dengar Audio">
                ?
            </button>
        @endif
        @php
            $rawQuestionText = trim((string) ($question->question_text ?? ''));
            $displayQuestionText = $rawQuestionText;

            if (isset($instructionQuestionId) && (int) $instructionQuestionId === (int) $question->id) {
                $normalizedQuestionText = str_replace('\\n', "\n", $rawQuestionText);
                if (stripos($normalizedQuestionText, 'Focus:') === 0 && stripos($normalizedQuestionText, 'Directions:') !== false) {
                    $displayQuestionText = '';
                }
            }
        @endphp
        <div class="flex flex-col gap-2 flex-1">
            @if(auth()->check() && $canEditQuestion)
                <div class="flex justify-end mb-1">
                    <button type="button"
                            onclick="openEditQuestionById({{ $question->id }})"
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-white text-amber-700 hover:bg-amber-200 text-xs font-semibold transition-colors"
                            title="Edit Text Soal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Edit Text Soal
                    </button>
                </div>
            @endif
            {{-- Display Question Text if available and valid (not just 'Question N') --}}
            @if($displayQuestionText && !Str::startsWith($displayQuestionText, 'Question '))
                <div class="mb-2 text-lg text-gray-800 font-medium">
                    {{ $displayQuestionText }}
                </div>
            @endif

            @foreach(['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d] as $option => $text)
                @if($text !== 'N/A' && $text !== '')
                    @php
                        $canSeeKey = auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isTeacher());
                        $isCorrectVal = $canSeeKey ? ($question->correct_answer === $option ? 'true' : 'false') : '';
                        
                        // Student Result Highlighting
                        $studentClass = '';
                        $evalAnswers = session('score_data')['user_answers'] ?? ($existingScore->answers ?? null);
                        if ($evalAnswers) {
                            $userAns = $evalAnswers[$question->id] ?? null;
                            $correctAns = $question->correct_answer;
                            
                            if ($option === $correctAns) {
                                // Correct Answer always Green
                                $studentClass = 'is-correct'; 
                            } elseif ($option === $userAns && $userAns !== $correctAns) {
                                // Wrong User Answer Red
                                $studentClass = 'is-wrong'; 
                            }
                        }
                    @endphp
                    <label class="answer-label flex items-center cursor-pointer group/option w-full py-1 hover:bg-white rounded-lg px-2 transition-colors has-[:checked]:bg-white has-[:checked]:shadow-sm has-[:checked]:border-blue-200 border border-transparent {{ $studentClass }}"
                           @if($canSeeKey) data-is-correct="{{ $isCorrectVal }}" @endif>
                        {{-- Hidden Radio Input --}}
                        <input type="radio" 
                               name="question_{{ $question->id }}" 
                               value="{{ $option }}" 
                               class="sr-only peer"
                               @if(isset($evalAnswers[$question->id]) && $evalAnswers[$question->id] === $option) checked @elseif($existingScore && isset($existingScore->answers[$question->id]) && $existingScore->answers[$question->id] === $option) checked @endif
                               @if(!$evalAnswers) required @endif>
                        
                        {{-- Visual Bubble --}}
                        <div class="flex items-center justify-center mr-3 flex-none">
                            <div class="w-10 h-10 aspect-square rounded-full border-2 border-gray-300 peer-checked:border-red-600 peer-checked:bg-red-600 group-hover/option:border-red-400 transition-all duration-200 flex items-center justify-center shrink-0">
                                <span class="text-sm font-bold text-gray-500 peer-checked:text-white transition-colors duration-200">{{ $option }}</span>
                            </div>
                        </div>
                        
                        {{-- Label Text --}}
                        <span class="text-xl text-gray-800 font-medium peer-checked:text-blue-600 peer-checked:font-semibold group-hover/option:text-blue-700 transition-colors">{{ $text }}</span>
                    </label>
                @endif
            @endforeach
        </div>
    </div>
</div>

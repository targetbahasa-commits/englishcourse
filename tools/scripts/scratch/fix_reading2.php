<?php

$file = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/online-test/packages/toefl-itp/paket1/reading.blade.php';
$content = file_get_contents($file);

$phpCode = <<<'PHP'
    @php
        $packageNumber = (int) ($test['package_number'] ?? 1);
        $packageContentResolver = app(\App\Application\ToeflMockup\ResolveMockupPackageContent::class);
        $readingResolution = $packageContentResolver->resolveReadingPassages($packageNumber);
        $readingPassagesData = $readingResolution['passages'];
        $readingPassages = collect($readingPassagesData)
            ->map(fn ($passage) => \App\Application\ToeflMockup\ViewData\ReadingPassageViewData::fromModel($passage)->toArray())
            ->values()
            ->all();
        
        $readingQuestions = collect($readingPassages)->flatMap(function ($passage) {
            return $passage['questions'] ?? [];
        })->values()->all();

        $dbAnswerKey = [];
        foreach ($readingQuestions as $q) {
            $dbAnswerKey['q' . $q['question_number']] = $q['correct_answer'] ?? '';
        }
        
        $reportRedirectUrl = route('online-test.result', [
            'slug' => $slugAlias ?? 'toefl-itp',
            'onlineTestResult' => 0 // This will be handled dynamically in JS
        ]);
    @endphp

    <script>
        window._readingData = {
            dbAnswerKey: @json($dbAnswerKey),
            customAnswerKey: @json($packageAnswerKey ?? []),
            submitUrl: @json($packageSectionSubmitUrl ?? null),
            redirectUrl: @json($reportRedirectUrl)
        };
    </script>
PHP;

$content = preg_replace('/@php.*?@endphp/s', $phpCode, $content);

$jsCode = <<<'JS'
    <div x-data="{
        currentReadingSection: 'instructions',
        currentReadingPassageIndex: 0,
        readingCountdown: 3300,
        readingTimer: null,
        isSubmitting: false,
        startReadingTimer() {
            if (this.readingTimer) return;
            this.readingTimer = setInterval(() => {
                if (this.readingCountdown > 0) {
                    this.readingCountdown--;
                } else {
                    clearInterval(this.readingTimer);
                    this.submitReadingSection();
                }
            }, 1000);
        },
        formatReadingTime() {
            const m = Math.floor(this.readingCountdown / 60).toString().padStart(2, '0');
            const s = (this.readingCountdown % 60).toString().padStart(2, '0');
            return `${m}:${s}`;
        },
        goToReadingPassage(index) {
            this.currentReadingPassageIndex = index;
            this.currentReadingSection = 'questions';
            this.startReadingTimer();
            window.scrollTo(0,0);
        },
        readAnswer(num) {
            const checked = document.querySelector(`input[type='radio'][name='question_${num}']:checked`);
            return checked ? checked.value : '';
        },
        collectAnswersPayload() {
            const payload = {};
            // reading questions are 1-50, but in DB they might have specific IDs, so we need to map them properly
            // Wait, the input name in mockup is `question_{{ $question['id'] }}` or `question_{{ $question['question_number'] }}`
            // Actually, let's just collect all checked inputs that start with 'question_'
            const inputs = document.querySelectorAll(`input[type='radio']:checked`);
            inputs.forEach(input => {
                const name = input.name;
                if (name.startsWith('question_')) {
                    const qId = name.replace('question_', '');
                    // We need to map qId back to question_number? No, wait. 
                    // Let's change the name in HTML to `q{{ $question['question_number'] }}` to match dbAnswerKey!
                }
            });
            return payload;
        },
        submitReadingSection() {
            if (this.isSubmitting) return;
            this.isSubmitting = true;

            const dbAnswerKey = window._readingData.dbAnswerKey;
            const customAnswerKey = window._readingData.customAnswerKey;
            const submitUrl = window._readingData.submitUrl;
            const csrfToken = document.querySelector('meta[name=csrf-token]')?.getAttribute('content') || '';

            const getAnswerForQuestion = (number) => {
                const qKey = `q${number}`;
                const raw = customAnswerKey[qKey] ?? customAnswerKey[String(number)] ?? dbAnswerKey[qKey] ?? '';
                return String(raw || '').trim().toUpperCase();
            };

            let correct = 0;
            const wrong = [];
            const payloadAnswers = {};

            // Collect all radio buttons (name format: q1, q2... q50)
            for (let i = 1; i <= 50; i++) {
                const checked = document.querySelector(`input[type='radio'][name='q${i}']:checked`);
                const user = checked ? checked.value : '';
                payloadAnswers[`q${i}`] = user;
                
                const expected = getAnswerForQuestion(i);
                const ok = user !== '' && expected !== '' && user === expected;
                if (ok) {
                    correct++;
                } else {
                    wrong.push(i);
                }
            }

            fetch(submitUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    score: correct,
                    total_questions: 50,
                    wrong_numbers: wrong,
                    answers: payloadAnswers
                })
            })
            .then(response => {
                if (!response.ok) throw new Error('HTTP error');
                return response.json();
            })
            .then(data => {
                if (data.result_id) {
                    window.location.href = window._readingData.redirectUrl.replace('0', data.result_id);
                } else {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menyambung ke server.');
                this.isSubmitting = false;
            });
        }
    }">
JS;

$content = preg_replace('/<div x-data="\{.*?\}">/s', $jsCode, $content);

// Change input name from question_{{ $question['id'] }} to q{{ $question['question_number'] }}
$content = preg_replace('/name="question_\{\{ \$question\[\'id\'\] \}\}"/', 'name="q{{ $question[\'question_number\'] }}"', $content);

file_put_contents($file, $content);

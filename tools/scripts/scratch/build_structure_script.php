<?php
$content = file_get_contents('resources/views/online-test/packages/toefl-itp/paket1/structure.blade.php');
$scriptPos = strpos($content, '<script>', 800); // Find the script tag around line 815
if ($scriptPos !== false) {
    $newScript = <<<HTML
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const partIntroBodies = Array.from(document.querySelectorAll('[data-part-intro-body]'));
            const questionBodies = Array.from(document.querySelectorAll('[data-question-body]'));
            const partJumpButtons = Array.from(document.querySelectorAll('[data-part-jump]'));
            const partBeginButtons = Array.from(document.querySelectorAll('[data-part-begin-btn]'));
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const submitBtn = document.getElementById('submitStructureAnswersBtn');
            const activeQuestionNumberEl = document.getElementById('activeQuestionNumber');
            const paginationContainer = document.getElementById('paginationContainer');

            const allQuestionNumbers = [
                @foreach(\$structureQuestions as \$q)
                    {{ (int) \$q->number }},
                @endforeach
            ];

            const partConfigs = {
                'A': { start: 1, end: 15 },
                'B': { start: 16, end: 40 },
            };

            let activeQuestionIndex = 0;
            let activeNumber = allQuestionNumbers[0];
            let activePartStart = null;
            let showingPartIntro = true;
            let introSeenByPart = { 'A': false, 'B': false };

            function getPartKey(num) {
                if (num >= partConfigs.A.start && num <= partConfigs.A.end) return 'A';
                if (num >= partConfigs.B.start && num <= partConfigs.B.end) return 'B';
                return 'A';
            }

            function updateUI() {
                activeNumber = allQuestionNumbers[activeQuestionIndex];
                const currentPartKey = getPartKey(activeNumber);
                activePartStart = partConfigs[currentPartKey].start;

                showingPartIntro = activeNumber === activePartStart && !introSeenByPart[currentPartKey];

                partIntroBodies.forEach(intro => {
                    if (showingPartIntro && intro.dataset.partIntroBody === currentPartKey) {
                        intro.classList.remove('hidden');
                    } else {
                        intro.classList.add('hidden');
                    }
                });

                questionBodies.forEach(qBody => {
                    const qNum = Number(qBody.dataset.questionBody);
                    if (!showingPartIntro && qNum === activeNumber) {
                        qBody.classList.remove('hidden');
                    } else {
                        qBody.classList.add('hidden');
                    }
                });

                partJumpButtons.forEach(btn => {
                    if (btn.dataset.partJump === currentPartKey) {
                        btn.classList.add('ring-2', 'ring-teal-500', 'ring-offset-2');
                    } else {
                        btn.classList.remove('ring-2', 'ring-teal-500', 'ring-offset-2');
                    }
                });

                const paginators = paginationContainer.querySelectorAll('[data-paginator-btn]');
                paginators.forEach(btn => {
                    const pNum = Number(btn.dataset.paginatorBtn);
                    btn.classList.remove('bg-teal-600', 'text-white', 'border-teal-600');
                    if (pNum === activeNumber && !showingPartIntro) {
                        btn.classList.add('bg-teal-600', 'text-white', 'border-teal-600');
                    } else {
                        btn.classList.add('bg-white', 'text-gray-700', 'border-gray-300');
                    }
                });

                if (showingPartIntro) {
                    activeQuestionNumberEl.textContent = 'Part ' + currentPartKey + ' Directions';
                    prevBtn.disabled = true;
                    nextBtn.disabled = true;
                } else {
                    activeQuestionNumberEl.textContent = 'Question ' + activeNumber;
                    prevBtn.disabled = activeQuestionIndex === 0;
                    nextBtn.disabled = activeQuestionIndex === allQuestionNumbers.length - 1;
                }

                if (activeQuestionIndex === allQuestionNumbers.length - 1 && !showingPartIntro) {
                    nextBtn.classList.add('hidden');
                    if (submitBtn) submitBtn.classList.remove('hidden');
                } else {
                    nextBtn.classList.remove('hidden');
                    if (submitBtn) submitBtn.classList.add('hidden');
                }
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    if (showingPartIntro) return;
                    if (activeQuestionIndex > 0) {
                        activeQuestionIndex--;
                        updateUI();
                    }
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    if (showingPartIntro) return;
                    if (activeQuestionIndex < allQuestionNumbers.length - 1) {
                        activeQuestionIndex++;
                        const currentPartKey = getPartKey(allQuestionNumbers[activeQuestionIndex]);
                        if (!introSeenByPart[currentPartKey]) {
                            introSeenByPart[currentPartKey] = true;
                        }
                        updateUI();
                    }
                });
            }

            partJumpButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetPart = btn.dataset.partJump;
                    const targetStart = partConfigs[targetPart].start;
                    const index = allQuestionNumbers.indexOf(targetStart);
                    if (index !== -1) {
                        activeQuestionIndex = index;
                        introSeenByPart[targetPart] = false;
                        updateUI();
                    }
                });
            });

            partBeginButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetPart = btn.dataset.partBeginBtn;
                    introSeenByPart[targetPart] = true;
                    updateUI();
                });
            });

            paginationContainer.addEventListener('click', (e) => {
                const btn = e.target.closest('[data-paginator-btn]');
                if (!btn) return;
                const target = Number(btn.dataset.paginatorBtn);
                const index = allQuestionNumbers.indexOf(target);
                if (index !== -1) {
                    const targetPartKey = getPartKey(target);
                    introSeenByPart[targetPartKey] = true;
                    activeQuestionIndex = index;
                    updateUI();
                }
            });

            function submitStructureSection() {
                const form = document.querySelector('#structureForm');
                if (!form) return;

                let formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        window.location.href = "{{ \$readingRedirectUrl }}";
                    } else {
                        alert('Terdapat kesalahan saat menyimpan jawaban.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menyambung ke server.');
                });
            }

            if (submitBtn) {
                submitBtn.addEventListener('click', () => {
                    submitStructureSection();
                });
            }

            const radioInputs = document.querySelectorAll('input[type="radio"][name^="q"]');
            radioInputs.forEach(radio => {
                radio.addEventListener('change', () => {
                    const checkedRadios = document.querySelectorAll('input[type="radio"][name^="q"]:checked');
                    if (allQuestionNumbers.length > 0 && checkedRadios.length === allQuestionNumbers.length) {
                        submitStructureSection();
                    }
                });
            });

            updateUI();
        });
    </script>
</body>
</html>
HTML;
    $content = substr($content, 0, $scriptPos) . $newScript;
    file_put_contents('resources/views/online-test/packages/toefl-itp/paket1/structure.blade.php', $content);
}

<?php
$content = file_get_contents('resources/views/online-test/packages/toefl-itp/paket1/listening.blade.php');

// Replace Title
$content = str_replace("Listening - Paket", "Structure - Paket", $content);

// Remove Admin Modals
$content = preg_replace("/@if\(auth\(\)->check\(\) && auth\(\)->user\(\)->isAdmin\(\)\).*?@endif/s", "", $content);

// Change listeningQuestions to structureQuestions
$content = str_replace('$listeningQuestions =', '$structureQuestions =', $content);
$content = str_replace('$listeningQuestions as $q', '$structureQuestions as $q', $content);
$content = str_replace('where(\'section\', \'listening\')', 'where(\'section\', \'structure\')', $content);

// Change redirects
$content = str_replace('structureRedirectUrl', 'readingRedirectUrl', $content);
$content = str_replace('["section" => "structure"]', '["section" => "reading"]', $content);
$content = str_replace('isSubmittingListening', 'isSubmittingStructure', $content);
$content = str_replace('submitListeningAnswersBtn', 'submitStructureAnswersBtn', $content);
$content = str_replace('submitListeningSection', 'submitStructureSection', $content);

// Replace part calculation
$content = preg_replace("/\\\$part = strtoupper\(\(string\) \(\\\$q->part \?: \(\\\$number <= 30 \? 'A' : \(\\\$number <= 38 \? 'B' : 'C'\)\)\)\);/", "\$part = strtoupper((string) (\$q->part ?: (\$number <= 15 ? 'A' : 'B')));", $content);

// Replace part loop
$content = str_replace("@foreach(['A', 'B', 'C'] as \$partKey)", "@foreach(['A', 'B'] as \$partKey)", $content);

// Remove Audio Player UI
$content = preg_replace("/<div class=\"mt-8 mb-6 flex flex-wrap gap-2 items-center\">.*?<\/div>\\n\\s*<div class=\"h-px w-full bg-gray-200 mb-6\">.*?<\/div>/s", "", $content);

// Replace PHP block for partConfigs and dialogGroups
$phpBlockPattern = '/\$partConfigs = \[.*?\];/s';
$newPartConfigs = <<<'PHP'
$partConfigs = [
            'A' => [
                'range' => 'Questions 1-15',
                'directions' => [
                    'Questions 1-15 are incomplete sentences. Beneath each sentence you will see four words or phrases, marked (A), (B), (C), and (D). Choose the one word or phrase that best completes the sentence. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.',
                ],
            ],
            'B' => [
                'range' => 'Questions 16-40',
                'directions' => [
                    'In questions 16-40, each sentence has four underlined words or phrases. The four underlined parts of the sentence are marked (A), (B), (C), and (D). Identify the one underlined word or phrase that must be changed in order for the sentence to be correct. Then, on your answer sheet, find the number of the question and fill in the space that corresponds to the letter of the answer you have chosen.',
                ],
            ],
        ];
PHP;
$content = preg_replace($phpBlockPattern, $newPartConfigs, $content);

// Remove dialogGroups and talkGroups
$content = preg_replace('/\$dialogGroups = \[.*?\];/s', '', $content);
$content = preg_replace('/\$talkGroups = \[.*?\];/s', '', $content);
$content = preg_replace('/\$mockupDirectionAudio = .*?;/s', '', $content);

// Remove Part C from intro views rendering
$content = preg_replace("/@if\(\\$partKey === 'C'\).*?@endif/s", "", $content);

// Remove Dialog Intro HTML logic inside question rendering
$content = preg_replace("/@if\(\\$partKey !== 'A'\).*?@endif\n/s", "", $content);
// Wait, we still need to remove `<div id="dialogIntroContainer" class="hidden">...</div>`
$content = preg_replace('/<div id="dialogIntroContainer" class="hidden">.*?<\/div>\n\s*<\/div>/s', '', $content);

// Let's write the modified content back
file_put_contents('resources/views/online-test/packages/toefl-itp/paket1/structure.blade.php', $content);
echo "Done replacing content.\n";

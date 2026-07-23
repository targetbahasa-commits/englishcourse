<?php
$topics = [
    1 => "Suffixes",
    2 => "Reducing",
    3 => "Abridgement",
    4 => "Omitting",
    5 => "Inversion",
    6 => "Appositives",
    7 => "Adjective & Adverb",
    8 => "Fronting",
    9 => "Clef Sentence",
    10 => "Conditional Sentences"
];

// Let's just create an empty trait first
$content = "<?php\n\nnamespace App\Http\Controllers\Concerns;\n\ntrait HasProficiencyMeetingContent\n{\n    private function proficiencyMeetingQuestions(int \$meeting): array\n    {\n        return match (\$meeting) {\n";

for (\$i = 1; \$i <= 10; \$i++) {
    \$content .= "            \$i => [\n";
    for (\$j = 1; \$j <= 15; \$j++) {
        \$content .= "                'Question \$j for \$topics[\$i]',\n";
    }
    \$content .= "            ],\n";
}
\$content .= "            default => [],\n        };\n    }\n}\n";

echo "Draft trait created";

<?php

namespace App\Application\IeltsListening;

class BuildIeltsListeningWarmUpData
{
    private const VALID_TYPES = ['spelling', 'times-dates', 'addresses', 'numbers', 'names', 'geographical-names', 'direction'];

    public function handle(string $type, int $practice): array
    {
        if (!in_array($type, self::VALID_TYPES, true)) {
            abort(404);
        }

        $audioFiles = [
            'spelling' => 'audio/ielts/listening/warmup/spelling_practice_1.mp3',
            'times-dates' => 'audio/ielts/listening/warmup/times_dates_practice_1.mp3',
            'addresses' => 'audio/ielts/listening/warmup/addresses_practice_1.mp3',
            'numbers' => 'audio/ielts/listening/warmup/numbers_practice_1.mp3',
            'names' => 'audio/ielts/listening/warmup/names_practice_1.mp3',
            'geographical-names' => 'audio/ielts/listening/warmup/geographical_names_practice_1.mp3',
            'direction' => 'audio/ielts/listening/warmup/direction_practice_1.mp3',
        ];

        $titles = [
            'spelling' => 'Spelling Practice',
            'times-dates' => 'Times and Dates Practice',
            'addresses' => 'Addresses Practice',
            'numbers' => 'Numbers Practice',
            'names' => 'Names Practice',
            'geographical-names' => 'Geographical Names Practice',
            'direction' => 'Direction Practice',
        ];

        $descriptions = [
            'spelling' => 'Listen and type the words you hear.',
            'times-dates' => 'Listen and write down the times or time phrases you hear.',
            'addresses' => 'Listen and write down the addresses you hear.',
            'numbers' => 'Listen and write down the numbers (and letters) you hear.',
            'names' => 'Listen and write down the names you hear.',
            'geographical-names' => 'Listen and write down the geographical names you hear.',
            'direction' => 'Listen and write down the directions or location instructions you hear.',
        ];

        if ($type === 'spelling') {
            $practice = max(1, min(30, $practice));
            $audioFiles['spelling'] = "audio/ielts/listening/warmup/spelling_practice_{$practice}.mp3";
            $titles['spelling'] = "Spelling Practice - Paket {$practice}";
        }

        if ($type === 'names' && $practice === 2) {
            $practiceAudio = 'audio/ielts/listening/warmup/names_practice_2.mp3';
            $audioFiles['names'] = file_exists(public_path($practiceAudio)) ? $practiceAudio : $audioFiles['names'];
            $titles['names'] = 'Names Practice 2';
            $descriptions['names'] = 'Listen and tick the surnames you hear.';
        }

        return [
            'section' => (object) [
                'audio_file' => $audioFiles[$type] ?? 'audio/ielts/listening/warmup/default.mp3',
                'transcript_en' => null,
                'transcript_id' => null,
                'title' => $titles[$type] ?? 'Practice',
                'description' => $descriptions[$type] ?? 'Listen to the audio.',
            ],
            'type' => $type,
            'practice' => $practice,
        ];
    }
}
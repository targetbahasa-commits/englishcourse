<?php

namespace App\Application\ToeflReadingPractice;

use App\Application\ToeflReadingPractice\Support\ToeflReadingPracticeData;

class BuildReadingPracticePackageViewData
{
    public function handle(int $package): ?array
    {
        $packageData = ToeflReadingPracticeData::package($package);

        if (!$packageData) {
            return null;
        }

        $answerKey = collect($packageData['passages'])
            ->flatMap(function ($passage) {
                return collect($passage['questions'])->mapWithKeys(function ($question) {
                    return [(string) $question['number'] => $question['answer']];
                });
            })
            ->all();

        return [
            'packageData' => $packageData,
            'answerKey' => $answerKey,
        ];
    }
}
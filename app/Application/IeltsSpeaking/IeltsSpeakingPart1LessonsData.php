<?php

namespace App\Application\IeltsSpeaking;

class IeltsSpeakingPart1LessonsData
{
    public function __construct(
        private readonly IeltsSpeakingPart1LessonsDataA $dataA,
        private readonly IeltsSpeakingPart1LessonsDataB $dataB,
    ) {}

    public function getLessons(): array
    {
        return array_merge(
            $this->dataA->getLessons(),
            $this->dataB->getLessons()
        );
    }
}

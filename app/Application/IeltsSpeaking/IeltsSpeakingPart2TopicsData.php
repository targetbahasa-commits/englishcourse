<?php

namespace App\Application\IeltsSpeaking;

class IeltsSpeakingPart2TopicsData
{
    public function __construct(
        private readonly IeltsSpeakingPart2TopicsDataA $dataA,
        private readonly IeltsSpeakingPart2TopicsDataB $dataB,
    ) {}

    public function getTopics(): array
    {
        return array_merge(
            $this->dataA->getTopics(),
            $this->dataB->getTopics()
        );
    }
}

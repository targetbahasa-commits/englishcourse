<?php

namespace App\Application\IeltsSpeaking;

class BuildIeltsSpeakingPart2Topics
{
    public function __construct(
        private readonly IeltsSpeakingPart2TopicsData $topicsData,
    ) {}

    public function handle(): array
    {
        return $this->topicsData->getTopics();
    }
}

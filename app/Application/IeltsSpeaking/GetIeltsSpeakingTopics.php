<?php

namespace App\Application\IeltsSpeaking;

class GetIeltsSpeakingTopics
{
    public function __construct(
        private readonly BuildIeltsSpeakingPart1Topics $buildIeltsSpeakingPart1Topics,
        private readonly BuildIeltsSpeakingPart2Topics $buildIeltsSpeakingPart2Topics
    ) {
    }

    public function part1(): array
    {
        return $this->buildIeltsSpeakingPart1Topics->handle();
    }

    public function part1Practice(): array
    {
        return $this->buildIeltsSpeakingPart1Topics->handle(false);
    }

    public function part2(): array
    {
        return $this->buildIeltsSpeakingPart2Topics->handle();
    }

    public function part3(): array
    {
        return $this->part2();
    }
}
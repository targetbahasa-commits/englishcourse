<?php

namespace App\Application\IeltsSpeaking;

class GetIeltsSpeakingTopics
{
    public function part1(): array
    {
        return \App\Models\IeltsSpeakingTopic::where('part', 1)->orderBy('id')->get()->toArray();
    }

    public function part1Practice(): array
    {
        return $this->part1();
    }

    public function part2(): array
    {
        return \App\Models\IeltsSpeakingTopic::where('part', 2)->orderBy('id')->get()->toArray();
    }

    public function part3(): array
    {
        return $this->part2();
    }
}
<?php

namespace App\Application\ToeflMockup\ViewData;

class ListeningDirectionAudioViewData
{
    public function __construct(
        public readonly ?string $audio_part_a,
        public readonly ?string $audio_part_b,
        public readonly ?string $audio_part_c,
    ) {
    }

    public static function fromModel(object $audio): self
    {
        return new self(
            audio_part_a: $audio->audio_part_a,
            audio_part_b: $audio->audio_part_b,
            audio_part_c: $audio->audio_part_c,
        );
    }
}
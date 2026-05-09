<?php

namespace App\Application\IeltsWriting;

use App\Application\IeltsShared\IeltsTopicPhraseBank;
use App\Domain\IeltsWriting\Repositories\IeltsWritingRepository;
use App\Models\IeltsWritingMeeting;

class HydrateIeltsWritingSupportData
{
    public function __construct(
        private readonly IeltsTopicPhraseBank $ieltsTopicPhraseBank,
        private readonly IeltsWritingRepository $repository,
    ) {}

    public function handle(IeltsWritingMeeting $meeting): void
    {
        $topicSlug = $this->inferWritingTopicSlug($meeting);

        if (empty($meeting->collocations)) {
            $meeting->collocations = $this->normalizeSupportItems(
                $this->ieltsTopicPhraseBank->collocationsFor($topicSlug)
            );
        }

        if (empty($meeting->idioms)) {
            $meeting->idioms = $this->normalizeSupportItems(
                $this->ieltsTopicPhraseBank->idiomsFor($topicSlug)
            );
        }
    }

    private function inferWritingTopicSlug(mixed $meeting): string
    {
        $raw = strtolower(trim(($meeting->title ?? '') . ' ' . ($meeting->prompt ?? '')));
        $slug = preg_replace('/[^a-z0-9]+/', '-', $raw);
        $slug = trim($slug ?? '', '-');

        $aliases = [
            'working-from-home' => 'work',
            'tourism' => 'travel-holidays',
            'social-media' => 'technology',
            'online-education' => 'study',
            'electric-vehicles' => 'transportation',
            'nuclear-energy' => 'technology',
            'artificial-intelligence' => 'artificial-intelligence',
            'globalization' => 'work',
            'globalisation' => 'work',
            'urbanisation' => 'hometown',
            'urbanization' => 'hometown',
            'fast-food' => 'food-cooking',
            'keeping-animals-in-zoos' => 'animals',
            'zoos' => 'animals',
            'space-exploration' => 'space-exploration',
            'gap-year' => 'study',
            'online-shopping' => 'shopping',
            'living-abroad' => 'travel-holidays',
        ];

        foreach ($aliases as $needle => $mappedSlug) {
            if (str_contains($slug, $needle)) {
                return $mappedSlug;
            }
        }

        return $slug;
    }

    private function normalizeSupportItems(mixed $items): array
    {
        if (!is_array($items)) {
            return [];
        }

        $normalized = [];

        foreach ($items as $item) {
            if (is_array($item) && array_key_exists('phrase', $item)) {
                $normalized[] = $item;
                continue;
            }

            if (is_array($item)) {
                $normalized = array_merge($normalized, $this->normalizeSupportItems($item));
            }
        }

        return $normalized;
    }
}
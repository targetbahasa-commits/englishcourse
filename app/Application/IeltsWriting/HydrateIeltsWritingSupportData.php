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
            'artificial-intelligence' => 'artificial-intelligence',
            'ai' => 'artificial-intelligence',
            'nuclear-energy' => 'technology',
            'social-media' => 'technology',
            'internet' => 'technology',
            'computer' => 'technology',
            'space-exploration' => 'space-exploration',
            'space' => 'space-exploration',
            'electric-vehicles' => 'transportation',
            'public-transport' => 'transportation',
            'private-cars' => 'transportation',
            'transport' => 'transportation',
            'traffic' => 'transportation',
            'vehicle' => 'transportation',
            'vehicles' => 'transportation',
            'car' => 'transportation',
            'cars' => 'transportation',
            'fast-food' => 'food-cooking',
            'food' => 'food-cooking',
            'cooking' => 'food-cooking',
            'diet' => 'food-cooking',
            'keeping-animals-in-zoos' => 'animals',
            'wildlife' => 'animals',
            'zoos' => 'animals',
            'zoo' => 'animals',
            'animal' => 'animals',
            'online-shopping' => 'shopping',
            'shopping' => 'shopping',
            'shop' => 'shopping',
            'store' => 'shopping',
            'tourism' => 'travel-holidays',
            'vacation' => 'travel-holidays',
            'travel' => 'travel-holidays',
            'living-abroad' => 'travel-holidays',
            'online-education' => 'study',
            'education' => 'study',
            'university' => 'study',
            'school' => 'study',
            'college' => 'study',
            'gap-year' => 'study',
            'working-from-home' => 'work',
            'globalization' => 'work',
            'globalisation' => 'work',
            'job' => 'work',
            'employment' => 'work',
            'business' => 'successful-small-business',
            'businesses' => 'successful-small-business',
            'company' => 'successful-small-business',
            'urbanisation' => 'hometown',
            'urbanization' => 'hometown',
            'city' => 'hometown',
            'cities' => 'hometown',
            'town' => 'hometown',
            'family' => 'family-friends',
            'friends' => 'family-friends',
            'friend' => 'family-friends',
            'housing' => 'accommodation',
            'apartment' => 'accommodation',
            'house' => 'accommodation',
            'hobby' => 'hobbies-interests',
            'hobbies' => 'hobbies-interests',
            'interest' => 'hobbies-interests',
            'leisure' => 'hobbies-interests',
            'film' => 'movies',
            'cinema' => 'movies',
            'sports' => 'sport',
            'clothes' => 'clothes-fashion',
            'clothing' => 'clothes-fashion',
            'fashion' => 'clothes-fashion',
            'gift' => 'gifts',
            'present' => 'gifts',
            'routine' => 'daily-routine',
            'reading' => 'book',
            'literature' => 'book',
        ];

        foreach ($aliases as $needle => $mappedSlug) {
            $escapedNeedle = preg_quote($needle, '/');
            if (preg_match("/\b{$escapedNeedle}\b/i", $slug)) {
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
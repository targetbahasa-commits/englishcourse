<?php

namespace App\Http\Controllers;

use App\Application\WHV\GetFeaturedWHVApplication;
use App\Models\WHVApplication;

class WHVApplicationController extends Controller
{
    public function __construct(
        private readonly GetFeaturedWHVApplication $getFeaturedWHVApplication,
    ) {
    }

    public function index()
    {
        $featuredApplication = $this->getFeaturedWHVApplication->handle();

        return view('whv-applications.index', [
            'featuredApplication' => $featuredApplication,
            'requirementCards' => $this->parseLabeledBlocks($featuredApplication?->requirements),
            'benefitCards' => $this->parseLabeledBlocks($featuredApplication?->benefits),
            'costCards' => $this->parseLabeledBlocks($featuredApplication?->cost_breakdown),
            'applicationSteps' => $this->parseSteps($featuredApplication?->how_to_apply),
            'faqItems' => $this->parseFaqs($featuredApplication?->faqs),
            'workSectors' => $this->extractWorkSectors($featuredApplication?->job_opportunities),
        ]);
    }

    /**
     * Display the specified WHV application.
     */
    public function show(WHVApplication $whvApplication)
    {
        return redirect()->route('whv-applications.index');
    }

    private function parseParagraphBlocks(?string $text): array
    {
        if (!$text) {
            return [];
        }

        return collect(preg_split('/\n\s*\n/', trim($text)))
            ->map(fn ($block) => trim((string) $block))
            ->filter()
            ->values()
            ->all();
    }

    private function parseLabeledBlocks(?string $text): array
    {
        return collect($this->parseParagraphBlocks($text))
            ->map(function ($block) {
                [$title, $body] = array_pad(explode(':', $block, 2), 2, '');

                return [
                    'title' => trim($title),
                    'body' => trim($body) !== '' ? trim($body) : trim($block),
                ];
            })
            ->values()
            ->all();
    }

    private function parseSteps(?string $text): array
    {
        if (!$text) {
            return [];
        }

        return collect(preg_split('/\r?\n/', trim($text)))
            ->map(fn ($line) => preg_replace('/^\d+\.\s*/', '', trim((string) $line)))
            ->filter()
            ->values()
            ->all();
    }

    private function parseFaqs(?string $text): array
    {
        return collect($this->parseParagraphBlocks($text))
            ->map(function ($block) {
                $lines = collect(preg_split('/\r?\n/', $block))
                    ->map(fn ($line) => trim((string) $line))
                    ->filter()
                    ->values();

                return [
                    'question' => $lines->first(),
                    'answer' => $lines->slice(1)->implode("\n"),
                ];
            })
            ->filter(fn ($faq) => !empty($faq['question']) && !empty($faq['answer']))
            ->values()
            ->all();
    }

    private function extractWorkSectors(?string $text): array
    {
        if (!$text) {
            return [];
        }

        $sectorMap = [
            'Hospitality' => 'hospitality',
            'Pertanian' => 'pertanian',
            'Konstruksi' => 'konstruksi',
            'Housekeeping' => 'housekeeping',
            'Kitchen Hand' => 'kitchen hand',
            'Cafe Assistant' => 'cafe assistant',
            'Farm Worker' => 'farm worker',
            'General Labour' => 'general labour',
        ];

        $lowerText = strtolower($text);

        return collect($sectorMap)
            ->filter(fn ($keyword) => str_contains($lowerText, $keyword))
            ->keys()
            ->values()
            ->all();
    }
}

<?php

namespace App\Application\GrammarWriting\Concerns;

trait ResolvesLegacyGrammarWritingParagraph
{
    protected function resolveLegacyParagraphRecord(int $meetingNumber, bool $hasSectionColumn): mixed
    {
        return $this->repository->getParagraphQuestion($meetingNumber, $hasSectionColumn);
    }
}
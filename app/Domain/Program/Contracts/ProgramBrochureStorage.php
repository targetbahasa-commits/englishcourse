<?php

namespace App\Domain\Program\Contracts;

interface ProgramBrochureStorage
{
    public function storeUploadedFile(mixed $file): string;

    public function deleteFile(?string $path): void;

    /**
     * Stages a freshly AI-generated image under a drafts subfolder, separate
     * from confirmed brochure images, so an un-accepted generation doesn't
     * get confused with the program's actual saved brochure.
     */
    public function storeDraftImage(string $binaryContents, string $extension): string;

    /**
     * Moves a staged draft (from storeDraftImage) into the program's
     * permanent brochure storage location and returns its new path.
     */
    public function promoteDraft(string $draftPath): string;
}

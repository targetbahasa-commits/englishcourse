<?php

namespace App\Application\ToeflStructure;

class StructureExplanationPathResolver
{
    public function resolve(int $meetingNumber): string
    {
        return public_path('uploads/structure-explanations/meeting-' . $meetingNumber . '.png');
    }
}
<?php

namespace App\Infrastructure\FreeTest;

use App\Domain\FreeTest\Repositories\FreeTestRepository;
use App\Models\FreeTestCertificate;
use App\Models\FreeTestResult;
use App\Models\OutreachMessage;

class EloquentFreeTestRepository implements FreeTestRepository
{
    public function createResult(array $data): mixed
    {
        return FreeTestResult::create($data);
    }

    public function findResultOrFail(int $id, int $userId): mixed
    {
        return FreeTestResult::where('user_id', $userId)->findOrFail($id);
    }

    public function getOutreachMessage(string $testType, string $targetRole, int $minScore, int $maxScore): mixed
    {
        return OutreachMessage::where('test_type', $testType)
            ->where('target_role', $targetRole)
            ->where('min_score', '<=', $minScore)
            ->where('max_score', '>=', $maxScore)
            ->first();
    }

    public function findCertificate(string $testType): mixed
    {
        return FreeTestCertificate::where('test_type', $testType)
            ->where('is_active', true)
            ->first();
    }

    public function getLatestResultForUser(int $userId): mixed
    {
        return FreeTestResult::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->first();
    }

    public function getHistoryForUser(int $userId): array
    {
        return FreeTestResult::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get()->all();
    }

    public function allCertificates(array $testTypes): mixed
    {
        $certificates = collect();
        foreach ($testTypes as $type) {
            $cert = $this->firstOrCreateCertificate($type, [
                'program_id'       => null,
                'background_image' => null,
                'description'      => 'Certificate for ' . ucwords(str_replace('_', ' ', $type)),
                'text_color'       => '#000000',
                'template_config' => [
                    'eyebrow' => 'Certificate of Achievement',
                    'title' => 'Certificate of Completion',
                    'subtitle' => 'Free Test Practice Result',
                    'score_label' => 'Final Score',
                    'body' => 'This certificate is awarded to the candidate for successfully completing the free test.',
                    'footer_left_label' => 'Date',
                    'footer_right_label' => 'Authorized Signature',
                    'signature_name' => 'Target Bahasa',
                ],
                'is_active'        => true,
            ]);
            $certificates->push($cert);
        }
        return $certificates;
    }

    public function firstOrCreateCertificate(string $testType, array $defaults): mixed
    {
        return FreeTestCertificate::firstOrCreate(
            ['test_type' => $testType, 'program_id' => null],
            $defaults
        );
    }

    public function findCertificateById(int $id): mixed
    {
        return FreeTestCertificate::findOrFail($id);
    }

    public function updateCertificate(mixed $certificate, array $data): void
    {
        $certificate->update($data);
    }


}

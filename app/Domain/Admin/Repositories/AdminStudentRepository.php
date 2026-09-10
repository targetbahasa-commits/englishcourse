<?php

namespace App\Domain\Admin\Repositories;

interface AdminStudentRepository
{
    public function listStudents(array $filters, int $perPage): mixed;

    public function findOrFail(int $id): mixed;

    public function getTeacherOptions(): array;

    public function getTeacherOrFail(int $teacherId): mixed;

    public function getProgramOptions(): array;

    public function getStudentMetrics(): array;

    public function getRecentActivity(int $userId): mixed;

    public function getProgressStats(int $userId): array;

    public function getLatestTest(int $userId): mixed;

    public function getLatestFinalTest(int $userId): mixed;

    public function assignTeacher(mixed $student, ?int $teacherId): string;

    public function quickUpdate(mixed $student, array $data): void;

    public function bulkGenerateReferralCodes(): int;

    public function getLatestSessionForStudent(int $userId): mixed;

    public function getLatestReportedListeningScore(int $userId): mixed;

    public function findToeflListeningQuestion(int $questionId): mixed;

    public function getLatestReportedMockupResult(int $userId): mixed;

    public function getGrammarQuestionsForMeeting(int $meetingNumber, bool $hasSectionColumn): mixed;

    public function getAllAssignmentScores(int $userId): mixed;
}

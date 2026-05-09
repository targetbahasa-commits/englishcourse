<?php

namespace App\Domain\Registration\Repositories;

interface RegistrationRepository
{
    public function getActivePrograms(): array;

    public function getActiveAndUpcomingClassPeriods(): array;

    public function findClassPeriod(int $id): mixed;

    public function findProgram(int $id): mixed;

    public function findProgramByNameLike(string $name): mixed;

    public function createRegistrationLead(array $data): void;

    // Admin CRUD methods
    public function listLeads(array $filters, int $perPage): mixed;

    public function getLeadMetrics(): array;

    public function getAttributionInsights(array $filters): array;

    public function getQuickAttributionFilters(): array;

    public function findLeadOrFail(int $id): mixed;

    public function updateLead(mixed $lead, array $data): void;

    public function updateConvertedUserFromLead(mixed $lead, array $validated): void;

    public function convertLeadToStudent(mixed $lead): array;

    public function deleteLead(mixed $lead): void;
}

<?php

namespace App\Application\Registration;

use App\Domain\Registration\Repositories\RegistrationRepository;
use Illuminate\Support\Collection;

class ManageRegistrationLeads
{
    public function __construct(
        private readonly RegistrationRepository $repository
    ) {}

    public function index(array $filters): array
    {
        $leads = $this->repository->listLeads($filters, 20);
        $programs = $this->collect($this->repository->getActivePrograms())
            ->map(fn ($p) => (object) ['id' => $p->id, 'name' => $p->name]);
        $classPeriods = $this->collect($this->repository->getActiveAndUpcomingClassPeriods())
            ->map(fn ($c) => (object) [
            'id' => $c->id,
            'name' => $c->name,
            'program_id' => $c->program_id,
            'start_date' => $c->start_date,
            'learning_mode' => $c->learning_mode,
            'program' => $c->program,
        ]);

        $attributionInsights = $this->repository->getAttributionInsights($filters);
        $quickAttributionFilters = $this->repository->getQuickAttributionFilters();
        $metrics = $this->repository->getLeadMetrics();

        return compact('leads', 'programs', 'classPeriods', 'attributionInsights', 'quickAttributionFilters', 'metrics');
    }

    public function update(mixed $lead, array $validated): void
    {
        $this->repository->updateLead($lead, $validated);

        $this->repository->updateConvertedUserFromLead($lead, $validated);
    }

    public function updateStatus(mixed $lead, string $status, ?string $adminNotes): void
    {
        $data = ['status' => $status, 'admin_notes' => $adminNotes];

        if ($status === 'contacted' && !$lead->contacted_at) {
            $data['contacted_at'] = now();
        }
        if ($status === 'converted' && !$lead->converted_at) {
            $data['converted_at'] = now();
        }
        if ($status !== 'converted') {
            $data['converted_at'] = null;
        }

        $this->repository->updateLead($lead, $data);
    }

    public function delete(mixed $lead): void
    {
        $this->repository->deleteLead($lead);
    }

    public function convertToStudent(mixed $lead): array
    {
        return $this->repository->convertLeadToStudent($lead);
    }

    private function collect(array $items): Collection
    {
        return collect($items);
    }
}

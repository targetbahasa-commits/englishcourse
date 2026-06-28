<?php

namespace App\Application\Program;

use App\Domain\Program\Contracts\ProgramBrochureStorage;
use App\Domain\Program\Repositories\ProgramRepository;
use App\Domain\FreeTest\Repositories\FreeTestRepository;
use Illuminate\Support\Str;

class ManagePrograms
{
    private const TOEFL_MOCK_PACKAGES = [
        [
            'slug'        => 'toefl-itp-mock-package-1',
            'name'        => 'TOEFL ITP Mock Package 1',
            'description' => 'Longman TOEFL ITP Series. Full simulation test covering Listening (50 questions), Structure & Written Expression (40 questions), and Reading Comprehension (50 questions). Total 140 soal.',
            'period'      => 'Full Mock Package',
            'price'       => 0,
            'is_active'   => true,
            'color'       => '#dc2626',
            'icon'        => 'clipboard-check',
        ],
        [
            'slug'        => 'toefl-itp-mock-package-2',
            'name'        => 'TOEFL ITP Mock Package 2',
            'description' => 'TOEFL ITP Practice Set 2. Full simulation test dengan set soal yang berbeda untuk meningkatkan kemampuan Anda.',
            'period'      => 'Full Mock Package',
            'price'       => 0,
            'is_active'   => true,
            'color'       => '#dc2626',
            'icon'        => 'clipboard-check',
        ],
        [
            'slug'        => 'toefl-itp-mock-package-3',
            'name'        => 'TOEFL ITP Mock Package 3',
            'description' => 'TOEFL ITP Practice Set 3. Paket latihan tambahan untuk persiapan optimal menghadapi ujian TOEFL ITP.',
            'period'      => 'Full Mock Package',
            'price'       => 0,
            'is_active'   => false,
            'color'       => '#dc2626',
            'icon'        => 'clipboard-check',
        ],
    ];

    public function __construct(
        private readonly ProgramRepository $repository,
        private readonly ProgramBrochureStorage $brochureStorage,
        private readonly FreeTestRepository $freeTestRepository,
    ) {}

    public function listAll(): mixed
    {
        return $this->repository->listWithCounts();
    }

    public function listMockTests(): array
    {
        $this->repository->syncToeflMockTestPrograms(self::TOEFL_MOCK_PACKAGES);
        return [
            'programs'        => $this->repository->listMockTests(),
            'isMockTestView'  => true,
        ];
    }

    public function store(array $validated, mixed $request): void
    {
        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('brochure_image')) {
            $validated['brochure_image'] = $this->brochureStorage->storeUploadedFile($request->file('brochure_image'));
        }
        if ($request->hasFile('brochure_pdf')) {
            $validated['brochure_pdf'] = $this->brochureStorage->storeUploadedFile($request->file('brochure_pdf'));
        }

        $subprograms = $validated['subprograms'] ?? [];
        unset($validated['subprograms']);

        $program = $this->repository->create($validated);

        if ($validated['program_type'] === 'paket') {
            $program->subprograms()->sync($subprograms);
        }

        // Auto-create a certificate for the new program
    }

    public function update(mixed $program, array $validated, mixed $request): void
    {
        $subprograms = $validated['subprograms'] ?? [];
        unset($validated['subprograms']);

        if ($validated['name'] !== $program->name) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('brochure_image')) {
            $this->brochureStorage->deleteFile($program->brochure_image);
            $validated['brochure_image'] = $this->brochureStorage->storeUploadedFile($request->file('brochure_image'));
        }
        if ($request->hasFile('brochure_pdf')) {
            $this->brochureStorage->deleteFile($program->brochure_pdf);
            $validated['brochure_pdf'] = $this->brochureStorage->storeUploadedFile($request->file('brochure_pdf'));
        }

        if ($request->has('remove_brochure_image') && $program->brochure_image) {
            $this->brochureStorage->deleteFile($program->brochure_image);
            $validated['brochure_image'] = null;
        }
        if ($request->has('remove_brochure_pdf') && $program->brochure_pdf) {
            $this->brochureStorage->deleteFile($program->brochure_pdf);
            $validated['brochure_pdf'] = null;
        }

        $this->repository->update($program, $validated);

        if ($validated['program_type'] === 'paket') {
            $program->subprograms()->sync($subprograms);
        } else {
            $program->subprograms()->sync([]);
        }
    }

    public function updateBrochure(mixed $program, mixed $request): bool
    {
        $data = [];

        if ($request->hasFile('brochure_image')) {
            $this->brochureStorage->deleteFile($program->brochure_image);
            $data['brochure_image'] = $this->brochureStorage->storeUploadedFile($request->file('brochure_image'));
        }
        if ($request->hasFile('brochure_pdf')) {
            $this->brochureStorage->deleteFile($program->brochure_pdf);
            $data['brochure_pdf'] = $this->brochureStorage->storeUploadedFile($request->file('brochure_pdf'));
        }
        if ($request->has('remove_brochure_image') && $program->brochure_image) {
            $this->brochureStorage->deleteFile($program->brochure_image);
            $data['brochure_image'] = null;
        }
        if ($request->has('remove_brochure_pdf') && $program->brochure_pdf) {
            $this->brochureStorage->deleteFile($program->brochure_pdf);
            $data['brochure_pdf'] = null;
        }

        if (!empty($data)) {
            $this->repository->update($program, $data);
            return true;
        }

        return false;
    }

    public function deactivate(mixed $program): void
    {
        $this->repository->deactivate($program);
    }

    public function delete(mixed $program): string
    {
        $name = $program->name;
        $this->repository->delete($program);
        return $name;
    }

    public function getSyllabus(mixed $program): array
    {
        $meetings = $this->repository->getMeetingsForSyllabus($program);
        return compact('program', 'meetings');
    }

    public function addMeeting(mixed $program, array $data): void
    {
        $this->repository->addMeeting($program, $data);
    }

    public function updateMeeting(mixed $program, mixed $meeting, array $data): void
    {
        $this->repository->updateMeeting($meeting, $data);
    }

    public function deleteMeeting(mixed $meeting): void
    {
        $this->repository->deleteMeeting($meeting);
    }

    public function reorderMeetings(mixed $program, array $order): void
    {
        $this->repository->reorderMeetings($program, $order);
    }
}

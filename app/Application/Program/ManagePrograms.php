<?php

namespace App\Application\Program;

use App\Domain\Program\Contracts\ProgramBrochureStorage;
use App\Domain\Program\Repositories\ProgramRepository;
use App\Domain\FreeTest\Repositories\FreeTestRepository;
use App\Services\AiBrochureImageGenerator;
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

        $validated['is_active'] = $request->boolean('is_active');
        $priceKeys = ['price', 'price_offline', 'price_private', 'price_private_offline', 'price_semi_private', 'price_semi_private_offline'];
        foreach ($priceKeys as $pk) {
            $validated[$pk] = $validated[$pk] ?? 0;
        }

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

    /**
     * Builds a ready-to-use marketing-brochure prompt from a program's own
     * data (name, description, price, CEFR level, delivery mode) - shared by
     * both the "copy this into Gemini/ChatGPT yourself" flow and the
     * "generate the image for me" flow below, so both stay consistent.
     */
    public function buildBrochurePrompt(mixed $program): string
    {
        $modeLabel = $program->delivery_mode === 'offline' ? 'Offline (Pare)' : 'Online';

        $tierFields = $program->delivery_mode === 'offline'
            ? ['Reguler' => 'price_offline', 'Semi Private' => 'price_semi_private_offline', 'Private' => 'price_private_offline']
            : ['Reguler' => 'price', 'Semi Private' => 'price_semi_private', 'Private' => 'price_private'];

        $priceLines = [];
        foreach ($tierFields as $label => $field) {
            $amount = $program->discountedPrice($field);
            if ($amount > 0) {
                $priceLines[] = $label . ': Rp ' . number_format($amount, 0, ',', '.');
            }
        }
        $priceText = $priceLines ? implode(', ', $priceLines) : 'Hubungi kami untuk info harga';

        $levelText = '';
        if ($program->min_cefr_level || $program->max_cefr_level) {
            $levelText = 'Target level CEFR: ' . ($program->min_cefr_level ?: 'A1') . ' - ' . ($program->max_cefr_level ?: $program->min_cefr_level ?: 'C2') . ".\n";
        }

        return trim(
            "Buatkan desain gambar brosur promosi digital untuk program kursus bahasa Inggris berikut, dengan gaya modern, profesional, dan mudah dibaca - mirip flyer promosi kursus online/edukasi.\n\n"
            . "Nama Program: {$program->name}\n"
            . "Mode Kelas: {$modeLabel}\n"
            . "Durasi: {$program->period}\n"
            . $levelText
            . "Deskripsi: {$program->description}\n"
            . "Harga: {$priceText}\n\n"
            . "Ketentuan desain:\n"
            . "- Ukuran potret (rasio kira-kira 4:5, cocok untuk Instagram/WhatsApp)\n"
            . "- Palet warna utama biru tua dan kuning/emas, dengan aksen putih\n"
            . "- Judul program ditulis besar dan tebal sebagai fokus utama\n"
            . "- Sertakan badge kecil mode kelas ('{$modeLabel}')\n"
            . "- Tampilkan 3-5 poin fokus/manfaat program dalam bentuk list singkat, berdasarkan deskripsi di atas\n"
            . "- Cantumkan harga dengan jelas\n"
            . "- Sertakan area untuk nama brand 'TARGET BAHASA' dan tagline 'English Skills. Global Success.' di bagian bawah\n"
            . "- Gunakan foto/ilustrasi yang relevan dengan tema belajar bahasa Inggris (buku, laptop, orang belajar, dsb) sebagai elemen visual pendukung\n"
            . "- Jangan sertakan teks placeholder seperti 'lorem ipsum' - gunakan teks asli sesuai data program di atas"
        );
    }

    /**
     * Calls the chosen AI provider to generate a brochure image and stages
     * it as a draft (not yet saved onto the program) so the admin can review
     * it before it replaces any existing brochure image.
     *
     * @return array{success: true, draft_path: string, draft_url: string}|array{success: false, message: string}
     */
    public function generateAiBrochureImage(string $provider, string $prompt): array
    {
        $result = AiBrochureImageGenerator::generate($provider, $prompt);
        if (!$result['success']) {
            return $result;
        }

        $extension = str_contains($result['mime'], 'jpeg') ? 'jpg' : 'png';
        $draftPath = $this->brochureStorage->storeDraftImage($result['binary'], $extension);

        return [
            'success' => true,
            'draft_path' => $draftPath,
            'draft_url' => \Illuminate\Support\Facades\Storage::disk('public')->url($draftPath),
        ];
    }

    /**
     * Promotes a previously generated draft into the program's actual
     * brochure_image, replacing whatever was there before.
     */
    public function acceptAiBrochureImage(mixed $program, string $draftPath): string
    {
        $this->brochureStorage->deleteFile($program->brochure_image);
        $finalPath = $this->brochureStorage->promoteDraft($draftPath);
        $this->repository->update($program, ['brochure_image' => $finalPath]);

        return $finalPath;
    }

    public function deactivate(mixed $program): void
    {
        $this->repository->deactivate($program);
    }

    public function toggleActive(mixed $program): mixed
    {
        return $this->repository->toggleActive($program);
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

    public function listSplittableCandidates(): array
    {
        return $this->repository->findSplittableCandidates();
    }

    public function splitIntoOfflineVariant(mixed $program, ?string $nameSuffix = null): mixed
    {
        return $this->repository->splitIntoOfflineVariant($program, $nameSuffix);
    }
}

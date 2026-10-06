<?php

namespace App\Infrastructure\Program;

use App\Domain\Program\Repositories\ProgramRepository;
use App\Models\Meeting;
use App\Models\Program;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EloquentProgramRepository implements ProgramRepository
{
    public function create(array $data): mixed
    {
        return Program::create(array_merge($data, [
            'slug' => Str::slug($data['name']),
        ]));
    }

    public function listWithCounts(): array
    {
        return Program::with(['subprograms', 'onlineSibling', 'offlineSibling', 'classPeriods' => function ($q) {
                $q->withCount('users')->orderBy('created_at', 'desc');
            }])
            ->withCount([
                'meetings',
                'users as active_enrollees_count' => function ($query) {
                    $query->where('role', 'student')->where('status', 'active');
                },
            ])
            ->where('slug', 'not like', 'cambridge-%')
            ->where('slug', 'not like', 'toefl-itp-mock-package-%')
            ->orderBy('created_at', 'desc')
            ->get()
            ->all();
    }

    public function listMockTests(): array
    {
        return Program::with('classPeriods')->withCount([
            'meetings',
            'users as active_enrollees_count' => function ($query) {
                $query->where('role', 'student')->where('status', 'active');
            },
        ])->where(function ($q) {
            $q->where('slug', 'like', 'cambridge-%')
              ->orWhere('slug', 'like', 'toefl-itp-mock-package-%');
        })->orderBy('created_at', 'desc')
          ->get()
          ->all();
    }

    public function syncToeflMockTestPrograms(array $packages): void
    {
        foreach ($packages as $package) {
            Program::updateOrCreate(['slug' => $package['slug']], $package);
        }
    }

    public function findOrFail(int $id): mixed
    {
        return Program::findOrFail($id);
    }

    public function update(mixed $program, array $data): void
    {
        $program->update($data);
    }

    public function deactivate(mixed $program): void
    {
        $program->update(['is_active' => false]);
    }

    public function toggleActive(mixed $program): mixed
    {
        $program->update(['is_active' => !$program->is_active]);

        return $program;
    }

    public function delete(mixed $program): void
    {
        $program->delete();
    }

    public function getMeetingsForSyllabus(mixed $program): array
    {
        return $program->meetings()->orderBy('meeting_number')->get()->all();
    }

    public function addMeeting(mixed $program, array $data): void
    {
        $maxMeetingNumber = $program->meetings()->max('meeting_number') ?? 0;
        $program->meetings()->create([
            'title'          => $data['title'],
            'meeting_number' => $maxMeetingNumber + 1,
            'is_locked'      => $data['is_locked'] ?? false,
        ]);
    }

    public function updateMeeting(mixed $meeting, array $data): void
    {
        $meeting->update([
            'title'     => $data['title'],
            'is_locked' => $data['is_locked'] ?? false,
        ]);
    }

    public function deleteMeeting(mixed $meeting): void
    {
        $meeting->delete();
    }

    public function reorderMeetings(mixed $program, array $order): void
    {
        foreach ($order as $index => $meetingId) {
            Meeting::where('id', $meetingId)
                ->where('program_id', $program->id)
                ->update(['meeting_number' => $index + 1]);
        }
    }

    public function findMeetingOrFail(int $id): mixed
    {
        return Meeting::findOrFail($id);
    }

    public function findSplittableCandidates(): array
    {
        return Program::where(function ($q) {
                $q->where('price_offline', '>', 0)
                    ->orWhere('price_private_offline', '>', 0)
                    ->orWhere('price_semi_private_offline', '>', 0);
            })
            ->whereNull('linked_program_id')
            ->whereDoesntHave('offlineSibling')
            ->get()
            ->all();
    }

    public function splitIntoOfflineVariant(mixed $program, ?string $nameSuffix = null): mixed
    {
        $nameSuffix ??= ' (Offline)';

        return DB::transaction(function () use ($program, $nameSuffix) {
            $offlineProgram = Program::create([
                'name'                       => $program->name . $nameSuffix,
                'slug'                       => Str::slug($program->name . $nameSuffix),
                'period'                     => $program->period,
                'description'                => $program->description,
                'color'                      => $program->color,
                'icon'                       => $program->icon,
                'price'                      => $program->price_offline,
                'price_private'              => $program->price_private_offline,
                'price_semi_private'         => $program->price_semi_private_offline,
                'price_offline'              => 0,
                'price_private_offline'      => 0,
                'price_semi_private_offline' => 0,
                'is_active'                  => $program->is_active,
                'brochure_image'             => $program->brochure_image,
                'brochure_pdf'               => $program->brochure_pdf,
                'program_type'               => $program->program_type,
                'min_cefr_level'             => $program->min_cefr_level,
                'max_cefr_level'             => $program->max_cefr_level,
                'delivery_mode'              => 'offline',
                'linked_program_id'          => $program->id,
            ]);

            foreach ($program->meetings()->orderBy('meeting_number')->get() as $meeting) {
                $offlineProgram->meetings()->create([
                    'meeting_number' => $meeting->meeting_number,
                    'title'          => $meeting->title,
                    'is_locked'      => $meeting->is_locked,
                    'is_free_tier'   => $meeting->is_free_tier,
                    'promo_start'    => $meeting->promo_start,
                    'promo_deadline' => $meeting->promo_deadline,
                ]);
            }

            $program->update([
                'delivery_mode'              => 'online',
                'price_offline'              => 0,
                'price_private_offline'      => 0,
                'price_semi_private_offline' => 0,
            ]);

            return $offlineProgram;
        });
    }
}

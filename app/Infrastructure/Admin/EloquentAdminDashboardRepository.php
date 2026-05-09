<?php

namespace App\Infrastructure\Admin;

use App\Domain\Admin\Repositories\AdminDashboardRepository;
use App\Models\Meeting;
use App\Models\Program;
use App\Models\Scholarship;
use App\Models\User;

class EloquentAdminDashboardRepository implements AdminDashboardRepository
{
    public function countStudents(): int
    {
        return User::where('role', 'student')->count();
    }

    public function countTeachers(): int
    {
        return User::where('role', 'teacher')->count();
    }

    public function countPrograms(): int
    {
        return Program::count();
    }

    public function countUnlockedMeetings(): int
    {
        return Meeting::where('is_locked', false)->count();
    }

    public function recentlyActiveStudents(int $hours, int $limit): array
    {
        return User::whereNotNull('last_activity')
            ->where('last_activity', '>=', now()->subHours($hours)->timestamp)
            ->orderByDesc('last_activity')
            ->limit($limit)
            ->get()
            ->map(function ($user) {
                $user->program_name = optional($user->program)->name;

                return $user;
            })
            ->all();
    }

    public function scholarshipsClosingSoon(int $days, int $limit): array
    {
        return Scholarship::where('is_active', true)
            ->whereBetween('deadline', [now()->startOfDay(), now()->addDays($days)->endOfDay()])
            ->orderBy('deadline')
            ->limit($limit)
            ->get()
            ->all();
    }
}

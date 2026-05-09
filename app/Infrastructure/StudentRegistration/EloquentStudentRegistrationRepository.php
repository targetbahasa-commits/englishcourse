<?php

namespace App\Infrastructure\StudentRegistration;

use App\Domain\StudentRegistration\Repositories\StudentRegistrationRepository;
use App\Models\Program;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EloquentStudentRegistrationRepository implements StudentRegistrationRepository
{
    public function getActivePrograms(): array
    {
        return Program::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'color', 'icon'])
            ->all();
    }

    public function findProgram(int $id): mixed
    {
        return Program::find($id);
    }

    public function createStudent(array $data): mixed
    {
        return User::create([
            ...$data,
            'password' => Hash::make($data['password']),
        ]);
    }
}

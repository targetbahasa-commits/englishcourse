<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@targetbahasa.com',
            'password' => 'password',
            'role' => 'admin',
        ]);

        // Create Teacher User
        User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@targetbahasa.com',
            'password' => 'password',
            'role' => 'teacher',
        ]);

        // Create Student User
        User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@targetbahasa.com',
            'password' => 'password',
            'role' => 'student',
        ]);

        $program = \App\Models\Program::create([
            'name' => 'Grammar for Writing',
            'slug' => 'grammar-for-writing',
            'period' => 'September 2024',
        ]);

        for ($i = 1; $i <= 20; $i++) {
            \App\Models\Meeting::create([
                'program_id' => $program->id,
                'meeting_number' => $i,
                'title' => "Meeting $i",
                'is_locked' => true,
            ]);
        }

        $this->call(IeltsReadingPractice10Seeder::class);
        $this->call(IeltsReadingPractice11Seeder::class);
    }
}

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

        $program = \App\Models\Program::firstOrCreate(
            ['slug' => 'grammar-for-writing'],
            [
                'name' => 'Grammar for Writing',
                'period' => 'September 2024',
                'description' => 'Master the fundamentals of English grammar specifically tailored for academic and professional writing.',
                'color' => 'blue',
            ]
        );

        \App\Models\Program::firstOrCreate(
            ['slug' => 'toefl-itp'],
            [
                'name' => 'TOEFL ITP',
                'period' => 'All Time',
                'description' => 'Master the TOEFL ITP exam with comprehensive practice tests and vocabulary builders.',
                'color' => 'green',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>'
            ]
        );

        \App\Models\Program::firstOrCreate(
            ['slug' => 'ielts-academic'],
            [
                'name' => 'IELTS Academic',
                'period' => 'All Time',
                'description' => 'Prepare for the IELTS Academic test with full-length practice materials covering all sections.',
                'color' => 'purple',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>'
            ]
        );

        \App\Models\Program::firstOrCreate(
            ['slug' => 'pte-academic'],
            [
                'name' => 'PTE Academic',
                'period' => 'All Time',
                'description' => 'Comprehensive PTE Academic preparation with computer-based practice material.',
                'color' => 'orange',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5"></path>'
            ]
        );

        \App\Models\Program::firstOrCreate(
            ['slug' => 'ielts-general'],
            [
                'name' => 'IELTS General',
                'period' => 'All Time',
                'description' => 'Get ready for IELTS General Training with practical scenarios and comprehensive drills.',
                'color' => 'red',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z"></path>'
            ]
        );

        \App\Models\Program::firstOrCreate(
            ['slug' => 'speaking'],
            [
                'name' => 'Speaking',
                'period' => 'All Time',
                'description' => 'Develop your English speaking skills with interactive lessons and pronunciation practice.',
                'color' => 'yellow',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2v4c0 1.105 1.343 2 3 2s3-.895 3-2V10c0-1.105-1.343-2-3-2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 18h6a2 2 0 002-2v-3l4 3V5l-4 3V5a2 2 0 00-2-2H9a2 2 0 00-2 2v11a2 2 0 002 2z"></path>'
            ]
        );

        for ($i = 1; $i <= 20; $i++) {
            \App\Models\Meeting::firstOrCreate(
                ['program_id' => $program->id, 'meeting_number' => $i],
                [
                    'title' => "Meeting $i",
                    'is_locked' => true,
                ]
            );
        }

        $this->call([
            IeltsReadingPractice10Seeder::class,
            IeltsReadingPractice11Seeder::class,
            ToeflListeningMeetingSeeder::class,
            ToeflListeningMeeting1Seeder::class,
            ToeflListeningMeeting2Seeder::class,
            ToeflListeningMeeting3Seeder::class,
            ToeflListeningMeeting4Seeder::class,
            M4S2Seeder::class,
            M4S3Seeder::class,
            M4S4Seeder::class,
            M4S5Seeder::class,
            ToeflListeningMeeting5Seeder::class,
            ToeflListeningMeeting6Seeder::class,
            M7Seeder::class,
            M7S2Seeder::class,
            ToeflListeningMeeting7Seeder::class,
            ToeflListeningMeeting8Seeder::class,
            ToeflListeningMeeting9Seeder::class,
            ToeflListeningMeeting10Seeder::class,
            ToeflListeningMeeting12Seeder::class,
            ToeflListeningMeeting15Seeder::class,
            ToeflListeningMeeting16Seeder::class,
            
            // TOEFL Structure
            ToeflStructureMeetingSeeder::class,
            ToeflStructureMeeting1Seeder::class,
            StructureMeeting2Seeder::class,
            ToeflStructureMeeting3Seeder::class,
            ToeflStructureMeeting4Seeder::class,
            ToeflStructureMeeting5Seeder::class,
            ToeflStructureMeeting6Seeder::class,
            ToeflStructureMeeting62Seeder::class,
            ToeflStructureMeeting7Seeder::class,
            ToeflStructureMeeting67Seeder::class,
            ToeflStructureMeeting68Seeder::class,
            ToeflStructureMeeting69Seeder::class,
            ToeflStructureMeeting71Seeder::class,
            ToeflStructureMeeting74Seeder::class,
            ToeflStructureMeeting76Seeder::class,
            ToeflStructureMeeting78Seeder::class,
            ToeflStructureMeeting8Seeder::class,
            ToeflStructureMeeting9Seeder::class,
            ToeflStructureMeeting10Seeder::class,
            ToeflStructureMeeting11Seeder::class,
            ToeflStructureMeeting12Seeder::class,
            ToeflStructureMeeting14Seeder::class,
            ToeflStructureMeeting15Seeder::class,
            ToeflStructureMeeting16Seeder::class,

            // TOEFL Reading
            ToeflReadingSeeder::class,
            ToeflReadingMeeting1Seeder::class,
            ToeflReadingMeeting2Seeder::class,
            ToeflReadingMeeting3Seeder::class,
            ToeflReadingMeeting4Seeder::class,
            ToeflReadingMeeting5Seeder::class,
            ToeflReadingMeeting6Seeder::class,
            ToeflReadingMeeting7Seeder::class,
            ToeflReadingMeeting8SeederWithTranslation::class,
            ToeflReadingMeeting9Seeder::class,
            ToeflReadingMeeting10Seeder::class,
            ToeflReadingMeeting11Seeder::class,
            ToeflReadingMeeting12Seeder::class,
        ]);
    }
}

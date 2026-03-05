<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassPeriod;
use App\Models\Program;
use App\Models\User;
use App\Models\Meeting;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ClassPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure 'Grammar for Speaking' program exists (or get the first available)
        $program = Program::firstWhere('slug', 'grammar-for-speaking') ?? Program::first();

        if (!$program) {
            $this->command->error('No programs found. Please run ProgramEnrollmentSeeder first.');
            return;
        }

        $this->command->info("Using Program: {$program->name}");

        // 2. Create Class Periods
        $periods = [
            [
                'name' => 'September 2024 Batch (Active)',
                'program_id' => $program->id,
                'start_date' => Carbon::now()->subWeeks(2),
                'end_date' => Carbon::now()->addWeeks(10),
                'status' => 'active',
            ],
            [
                'name' => 'July 2024 Batch (Closed)',
                'program_id' => $program->id,
                'start_date' => Carbon::now()->subMonths(3),
                'end_date' => Carbon::now()->subMonth(1),
                'status' => 'closed',
            ],
            [
                'name' => 'December 2024 Batch (Upcoming)',
                'program_id' => $program->id,
                'start_date' => Carbon::now()->addMonths(1),
                'end_date' => Carbon::now()->addMonths(4),
                'status' => 'upcoming',
            ],
        ];

        foreach ($periods as $periodData) {
            $period = ClassPeriod::create($periodData);
            $this->command->info("Created Class Period: {$period->name}");

            // 3. Create Dummy Students for this period
            $studentCount = 5;
            for ($i = 1; $i <= $studentCount; $i++) {
                $email = strtolower(str_replace([' ', '(', ')'], '', $period->name)) . "_student{$i}@targetbahasa.com";
                
                User::create([
                    'name' => "Student {$i} - " . explode(' ', $periodData['name'])[0],
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'role' => 'student',
                    'status' => 'active',
                    'class_period_id' => $period->id, // Assign to class period
                ]);
            }
            $this->command->info("  - Created {$studentCount} students for this period.");

            // 4. Setup Meeting Access
            if ($period->status === 'active') {
                // Unlock first 5 meetings for active period
                $meetings = Meeting::where('program_id', $program->id)->orderBy('meeting_number')->limit(5)->get();
                $period->meetings()->syncWithPivotValues($meetings->pluck('id'), ['is_unlocked' => true]);
                $this->command->info("  - Unlocked first 5 meetings.");
            } elseif ($period->status === 'closed') {
                // Unlock all meetings for closed period
                $meetings = Meeting::where('program_id', $program->id)->get();
                $period->meetings()->syncWithPivotValues($meetings->pluck('id'), ['is_unlocked' => true]);
                $this->command->info("  - Unlocked all meetings.");
            }
            // Upcoming has no unlocked meetings by default
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data to prevent unique constraint issues when re-running
        \App\Models\Attendance::truncate();
        \App\Models\ClassMeeting::query()->delete();

        $classPeriods = \App\Models\ClassPeriod::all();
        $admin = \App\Models\User::where('role', 'admin')->first();
        
        if ($classPeriods->isEmpty() || !$admin) {
            $this->command->info('No class periods or admin found. Skipping attendance seeding.');
            return;
        }

        foreach ($classPeriods as $period) {
            // Get enrolled students for this period
            $enrolledStudents = $period->users()->where('role', 'student')->get();
            
            if ($enrolledStudents->isEmpty()) {
                continue;
            }

            // Create 5 meetings for each period
            for ($i = 1; $i <= 5; $i++) {
                $meeting = \App\Models\ClassMeeting::create([
                    'class_period_id' => $period->id,
                    'meeting_date' => now()->copy()->subDays((5 - $i) * 3), // e.g., meetings every 3 days
                    'meeting_number' => $i,
                    'topic' => "Meeting $i: " . fake()->sentence(3),
                ]);

                // Record attendance for each student in this meeting
                foreach ($enrolledStudents as $student) {
                    $status = fake()->randomElement(['present', 'present', 'present', 'absent', 'late', 'excused']); // Weight towards present
                    $notes = '';
                    
                    if ($status === 'late') {
                        $notes = fake()->randomElement(['Macet', 'Ban bocor', 'Bangun kesiangan']);
                    } elseif ($status === 'excused') {
                        $notes = fake()->randomElement(['Sakit (ada surat)', 'Acara keluarga', 'Izin sekolah']);
                    }
                    
                    \App\Models\Attendance::create([
                        'user_id' => $student->id,
                        'class_meeting_id' => $meeting->id,
                        'status' => $status,
                        'notes' => $notes,
                        'recorded_by' => $admin->id,
                    ]);
                }
            }
        }
    }
}

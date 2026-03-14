<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DummyTestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password123');

        // 4 Students
        $students = [];
        for ($i = 1; $i <= 4; $i++) {
            $students[] = User::updateOrCreate(
                ['email' => "student$i@dummy.com"],
                [
                    'name' => "Student Dummy $i",
                    'password' => $password,
                    'role' => 'student',
                    'status' => 'active',
                ]
            );
        }

        // 2 Teachers
        for ($i = 1; $i <= 2; $i++) {
            User::updateOrCreate(
                ['email' => "teacher$i@dummy.com"],
                [
                    'name' => "Teacher Dummy $i",
                    'password' => $password,
                    'role' => 'teacher',
                    'status' => 'active',
                ]
            );
        }

        // 4 Guests
        $guests = [];
        for ($i = 1; $i <= 4; $i++) {
            $guests[] = User::updateOrCreate(
                ['email' => "guest$i@dummy.com"],
                [
                    'name' => "Guest Dummy $i",
                    'password' => $password,
                    'role' => 'guest',
                    'status' => 'active',
                ]
            );
        }

        // Create Active Sessions for Recently Active feature
        // threshold is 24 hours ago
        $now = Carbon::now();

        // Mix of active times within last 24 hours
        $usersToMakeActive = array_merge($students, $guests);
        
        foreach ($usersToMakeActive as $index => $user) {
            // Distribute last activity across the last 24 hours
            // Some "Just now", some hours ago
            $minutesAgo = [5, 15, 45, 120, 300, 600, 900, 1400]; // in minutes
            $activityTime = $now->copy()->subMinutes($minutesAgo[$index % count($minutesAgo)]);

            DB::table('sessions')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    'id' => Str::random(40),
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'Mozilla/5.0 (Dummy Testing)',
                    'payload' => base64_encode('dummy'),
                    'last_activity' => $activityTime->timestamp,
                ]
            );
        }
    }
}

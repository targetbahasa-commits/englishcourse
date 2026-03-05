<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@targetbahasa.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Create Teacher Users
        User::create([
            'name' => 'John Teacher',
            'email' => 'teacher1@targetbahasa.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Sarah Teacher',
            'email' => 'teacher2@targetbahasa.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'status' => 'active',
        ]);

        // Create Student Users
        $students = [
            ['name' => 'Alice Student', 'email' => 'student1@targetbahasa.com'],
            ['name' => 'Bob Student', 'email' => 'student2@targetbahasa.com'],
            ['name' => 'Charlie Student', 'email' => 'student3@targetbahasa.com'],
            ['name' => 'Diana Student', 'email' => 'student4@targetbahasa.com'],
            ['name' => 'Eve Student', 'email' => 'student5@targetbahasa.com'],
        ];

        foreach ($students as $student) {
            User::create([
                'name' => $student['name'],
                'email' => $student['email'],
                'password' => Hash::make('password'),
                'role' => 'student',
                'status' => 'active',
            ]);
        }

        // Create one inactive user
        User::create([
            'name' => 'Inactive User',
            'email' => 'inactive@targetbahasa.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'status' => 'inactive',
        ]);
    }
}

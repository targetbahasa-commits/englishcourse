<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyStudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['name' => 'Andi Pratama', 'email' => 'andi.test1@targetbahasa.com', 'phone' => '081234567891', 'program_slug' => 'toefl-itp', 'class_type' => 'regular', 'channel' => 'bank_transfer', 'learning_mode' => 'online'],
            ['name' => 'Budi Santoso', 'email' => 'budi.test2@targetbahasa.com', 'phone' => '081234567892', 'program_slug' => 'introductory-grammar-for-writing', 'class_type' => 'regular', 'channel' => 'qris', 'learning_mode' => 'offline'],
            ['name' => 'Citra Lestari', 'email' => 'citra.test3@targetbahasa.com', 'phone' => '081234567893', 'program_slug' => 'fast-track-grammar-for-writing', 'class_type' => 'private', 'channel' => 'cash', 'learning_mode' => 'online'],
            ['name' => 'Dewi Anggraeni', 'email' => 'dewi.test4@targetbahasa.com', 'phone' => '081234567894', 'program_slug' => 'complexity-grammar-for-writing', 'class_type' => 'regular', 'channel' => 'qris', 'learning_mode' => 'offline'],
            ['name' => 'Eko Saputra', 'email' => 'eko.test5@targetbahasa.com', 'phone' => '081234567895', 'program_slug' => 'pte-academic', 'class_type' => 'regular', 'channel' => 'cash', 'learning_mode' => 'online'],
            ['name' => 'Fitri Yani', 'email' => 'fitri.test6@targetbahasa.com', 'phone' => '081234567896', 'program_slug' => 'ielts-complete-package', 'class_type' => 'regular', 'channel' => 'bank_transfer', 'learning_mode' => 'online'],
            ['name' => 'Gilang Ramadhan', 'email' => 'gilang.ielts1@targetbahasa.com', 'phone' => '081234567897', 'program_slug' => 'ielts-complete-package', 'class_type' => 'regular', 'channel' => 'qris', 'learning_mode' => 'offline'],
            ['name' => 'Hani Pertiwi', 'email' => 'hani.ielts2@targetbahasa.com', 'phone' => '081234567898', 'program_slug' => 'ielts-listening', 'class_type' => 'private', 'channel' => 'cash', 'learning_mode' => 'online'],
            ['name' => 'Iqbal Maulana', 'email' => 'iqbal.ielts3@targetbahasa.com', 'phone' => '081234567899', 'program_slug' => 'ielts-reading', 'class_type' => 'regular', 'channel' => 'bank_transfer', 'learning_mode' => 'online'],
            ['name' => 'Julia Vania', 'email' => 'julia.ielts4@targetbahasa.com', 'phone' => '081234567800', 'program_slug' => 'ielts-writing', 'class_type' => 'semi_private', 'channel' => 'qris', 'learning_mode' => 'offline'],
            ['name' => 'Kiki Saputri', 'email' => 'kiki.ielts5@targetbahasa.com', 'phone' => '081234567801', 'program_slug' => 'ielts-speaking', 'class_type' => 'private', 'channel' => 'bank_transfer', 'learning_mode' => 'online'],
        ];

        $initiatePayment = app(\App\Application\Payment\InitiatePayment::class);

        foreach ($students as $data) {
            // Find program. Sometimes the slug might not match perfectly if it was auto-generated differently
            // We'll try to find by slug or a loose like match
            $program = Program::where('slug', $data['program_slug'])
                ->orWhere('slug', 'like', '%' . str_replace('-', '%', $data['program_slug']) . '%')
                ->first();

            if (!$program) {
                // Fallback to finding by name loosely
                $nameParts = explode('-', $data['program_slug']);
                $program = Program::where('name', 'like', '%' . $nameParts[0] . '%')->first();
            }

            if (!$program) {
                echo "Program not found for slug: {$data['program_slug']} ";
                continue;
            }

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'phone_number' => $data['phone'],
                    'password' => Hash::make('Target2026!'),
                    'role' => 'student',
                    'referral_code' => 'TB-' . strtoupper(Str::random(6)),
                    'learning_mode' => $data['learning_mode'], // Include if User model has it
                ]
            );

            // Create Payment
            try {
                $result = $initiatePayment->handle($user, $program->id, $data['channel'], $data['class_type']);
                if (isset($result['payment'])) {
                    echo "Created student {$data['name']} with payment {$result['payment']->invoice_number} ";
                }
            } catch (\Exception $e) {
                echo "Failed to create payment for {$data['name']}: " . $e->getMessage() . " ";
            }
        }
    }
}

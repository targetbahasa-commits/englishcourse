<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all users who have a class_period_id
        $users = \Illuminate\Support\Facades\DB::table('users')
            ->whereNotNull('class_period_id')
            ->select('id', 'class_period_id')
            ->get();

        foreach ($users as $user) {
            // Find the program of this class period
            $classPeriod = \Illuminate\Support\Facades\DB::table('class_periods')
                ->where('id', $user->class_period_id)
                ->first();

            if ($classPeriod && $classPeriod->program_id) {
                // Update the matching enrollment
                \Illuminate\Support\Facades\DB::table('enrollments')
                    ->where('user_id', $user->id)
                    ->where('program_id', $classPeriod->program_id)
                    ->update(['class_period_id' => $user->class_period_id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reversal logic for data sync isn't strict, but we can dump enrollments class_period_id back to users if needed.
    }
};

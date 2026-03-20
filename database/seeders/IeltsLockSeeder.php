<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IeltsLockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lock all IELTS meetings
        DB::table('meetings')->where('program_id', 4)->update(['is_locked' => true]); // Listening
        DB::table('meetings')->where('program_id', 8)->update(['is_locked' => true]); // Reading
        DB::table('ielts_writing_meetings')->update(['is_locked' => true]); // Writing
        DB::table('ielts_speaking_topics')->update(['is_locked' => true]); // Speaking

        // Unlock only the first meeting for each section
        DB::table('meetings')->where('program_id', 4)->where('meeting_number', 1)->update(['is_locked' => false]);
        DB::table('meetings')->where('program_id', 8)->where('meeting_number', 1)->update(['is_locked' => false]);
        DB::table('ielts_writing_meetings')->where('meeting_number', 1)->update(['is_locked' => false]);
        DB::table('ielts_speaking_topics')->where('slug', 'part-1')->update(['is_locked' => false]);
    }
}

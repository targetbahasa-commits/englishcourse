<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Find the record with meeting_number=1125 in ielts_writing_meetings
$r = DB::table('ielts_writing_meetings')->where('meeting_number', 1125)->first();
if ($r) {
    echo "Found: id=" . $r->id . ", title=" . $r->title . "\n";
    DB::table('ielts_writing_meetings')
        ->where('id', $r->id)
        ->update(['title' => 'Life Cycle of Sea Turtles']);
    $updated = DB::table('ielts_writing_meetings')->where('id', $r->id)->first();
    echo "Updated title: " . $updated->title . "\n";
} else {
    // Try by id=166
    $r2 = DB::table('ielts_writing_meetings')->where('id', 166)->first();
    if ($r2) {
        echo "Found by id=166: meeting_number=" . $r2->meeting_number . ", title=" . $r2->title . "\n";
        DB::table('ielts_writing_meetings')
            ->where('id', 166)
            ->update(['title' => 'Life Cycle of Sea Turtles']);
        echo "Updated.\n";
    } else {
        echo "Not found. Listing records around meeting_number 1120-1129:\n";
        $rows = DB::table('ielts_writing_meetings')
            ->whereBetween('meeting_number', [1120, 1129])
            ->get(['id', 'meeting_number', 'title']);
        foreach ($rows as $row) {
            echo "  id={$row->id}, mn={$row->meeting_number}, title={$row->title}\n";
        }
    }
}

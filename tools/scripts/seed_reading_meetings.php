<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Meeting;
use App\Models\IeltsSpeakingTopic;
use Illuminate\Support\Facades\Artisan;

$readingMeetingsCount = Meeting::where('program_id', 8)->count();
echo "Reading meetings count: $readingMeetingsCount\n";
if ($readingMeetingsCount == 0) {
    echo "Creating 20 reading meetings...\n";
    for ($i = 1; $i <= 20; $i++) {
        Meeting::create([
            'program_id' => 8,
            'meeting_number' => $i,
            'title' => 'IELTS Reading Practice ' . $i,
            'is_locked' => $i > 1
        ]);
    }
} else {
    echo "Updating 20 reading meetings locks...\n";
    Meeting::where('program_id', 8)->update(['is_locked' => true]);
    Meeting::where('program_id', 8)->where('meeting_number', 1)->update(['is_locked' => false]);
}

$speakingTopicsCount = IeltsSpeakingTopic::count();
echo "Speaking topics count: $speakingTopicsCount\n";
if ($speakingTopicsCount == 0) {
    echo "Running IeltsSpeakingTopicsSeeder...\n";
    Artisan::call('db:seed', ['--class' => 'IeltsSpeakingTopicsSeeder']);
    
    echo "Updating Speaking locks...\n";
    IeltsSpeakingTopic::query()->update(['is_locked' => true]);
    IeltsSpeakingTopic::where('slug', 'lesson-1')->update(['is_locked' => false]);
} else {
    echo "Updating Speaking locks...\n";
    IeltsSpeakingTopic::query()->update(['is_locked' => true]);
    IeltsSpeakingTopic::where('slug', 'lesson-1')->update(['is_locked' => false]);
}

echo "Done\n";

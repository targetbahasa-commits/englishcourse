<?php

use App\Models\IeltsWritingMeeting;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$meeting = IeltsWritingMeeting::find(116);
if ($meeting) {
    print_r($meeting->toArray());
} else {
    echo "Meeting 116 not found.\n";
}

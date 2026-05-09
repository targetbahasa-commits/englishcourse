<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Running Reading Passage Seeder...\n";
\Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'ToeflReadingPassagePackage1Seeder', '--force' => true]);
echo \Illuminate\Support\Facades\Artisan::output();

echo "Verifying...\n";
$passages = \App\Models\ToeflReadingPassage::where('package_number', 1)->withCount('questions')->get();
foreach ($passages as $p) {
    echo "Passage {$p->passage_number}: {$p->questions_count} questions\n";
}

echo "Done. Deleting self...\n";
unlink(__FILE__);

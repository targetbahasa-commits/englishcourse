<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Running Structure Seeder...\n";
\Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'ToeflStructurePaket1Seeder', '--force' => true]);
echo \Illuminate\Support\Facades\Artisan::output();

echo "Done. Deleting self...\n";
unlink(__FILE__);

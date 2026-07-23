<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$support = $app->make(App\Application\IeltsWriting\IeltsWritingAiSupport::class);
$builder = $app->make(App\Application\IeltsWriting\BuildIeltsWritingAiPrompt::class);

$essay = 'Social media is very popular today. Some people think social media has a negative impact on society, while others think it helps people connect with each other. This essay will discuss both views and give my opinion. On the one hand, social media can have a negative impact on society. Many people spend too much time on social media every day.';
$prompt = $builder->taskResponse($essay, '2');

echo "Sending to AI...\n";
$start = microtime(true);
$json = $support->runJsonPrompt($prompt, 300, 4096, false, true);
$end = microtime(true);

echo "Time taken: " . ($end - $start) . "s\n";
echo "Result:\n";
var_dump($json);

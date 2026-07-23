<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$questions = DB::table('grammar_topic_questions')
    ->whereIn('grammar_topic_id', [1, 2, 3, 4, 5])
    ->where('type', 'sentence')
    ->get(['id', 'grammar_topic_id', 'content', 'example']);

echo json_encode($questions, JSON_PRETTY_PRINT);

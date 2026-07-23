<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$questions = DB::table('grammar_topic_questions')
    ->whereIn('grammar_topic_id', [31, 32, 33, 34, 35])
    ->where('type', 'sentence')
    ->get(['id', 'grammar_topic_id', 'question', 'answer']);

file_put_contents('fetched_qs_31_35.json', json_encode($questions, JSON_PRETTY_PRINT));

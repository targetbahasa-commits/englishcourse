<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$topic = config('pte_listening_mcma')[5];
$html = view('assignments.pte-academic.listening-multiple-choice-multiple-answer.practice', ['topicId' => 6, 'topic' => $topic])->render();
preg_match('/const kokoroUrl = `([^`]+)`/', $html, $matches);
echo $matches[1] ?? 'NOT FOUND';

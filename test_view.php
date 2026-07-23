<?php
require 'vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$topic = config('pte_listening_mcma')[5];
echo view('assignments.pte-academic.listening-multiple-choice-multiple-answer.practice', ['topicId' => 6, 'topic' => $topic])->render();

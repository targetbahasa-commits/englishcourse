<?php
$logPath = __DIR__ . '/../storage/logs/laravel.log';
if (!file_exists($logPath)) {
    echo "Log file not found.";
    exit;
}
$file = new SplFileObject($logPath, 'r');
$file->seek(PHP_INT_MAX);
$lastLine = $file->key();

$lines = [];
$start = max(0, $lastLine - 3000);
$file->seek($start);
while (!$file->eof()) {
    $lines[] = $file->current();
    $file->next();
}
echo implode("", $lines);

<?php

use App\Models\IeltsReadingPassage;
use App\Models\IeltsReadingQuestion;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "Checking IELTS Reading Data...\n";

$materialId = 12;
$passages = IeltsReadingPassage::where('material_id', $materialId)->get();
echo "Material $materialId Passages Count: " . $passages->count() . "\n";
foreach($passages as $p) {
    echo " - Passage: " . substr($p->title, 0, 50) . "...\n";
}

$questions = IeltsReadingQuestion::whereHas('passage', function($q) use ($materialId) {
    $q->where('material_id', $materialId);
})->get();

echo "Material $materialId Questions Count: " . $questions->count() . "\n";

if ($questions->count() > 0) {
    echo "Questions data:\n";
    foreach($questions as $q) {
        echo "ID: " . $q->id . " | Type: " . $q->type . "\n";
        echo "  -> Data: " . substr(json_encode($q->data), 0, 100) . "...\n";
    }
} else {
    echo "No questions found for Material $materialId.\n";
}

echo "Done.\n";

<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$repo = app(App\Domain\Admin\Repositories\AdminStudentRepository::class);
$hasSection = Illuminate\Support\Facades\Schema::hasColumn('grammar_questions', 'section');
$questions = $repo->getGrammarQuestionsForMeeting(3, $hasSection);

echo "Count: " . count($questions) . "\n";
echo "Type: " . get_class($questions) . "\n";
echo json_encode($questions);

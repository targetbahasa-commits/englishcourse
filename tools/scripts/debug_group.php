<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$programs = App\Models\Program::all();
$programPaket = collect();
$satuanGrammar = collect();
$satuanIelts = collect();
$satuanSpeaking = collect();
$satuanLainnya = collect();

foreach($programs as $program) {
    if ($program->program_type === 'satuan') {
        $name = strtolower($program->name);
        if ($program->slug === 'fast-track-grammar-for-writing' || str_contains($name, 'grammar fast track')) {
            $satuanIelts->push($program);
        } elseif (str_contains($name, 'grammar')) {
            $satuanGrammar->push($program);
        } elseif (str_contains($name, 'ielts')) {
            $satuanIelts->push($program);
        } elseif (str_contains($name, 'speaking')) {
            $satuanSpeaking->push($program);
        } else {
            $satuanLainnya->push($program);
        }
    } else {
        $programPaket->push($program);
    }
}

$groups = [
    ['title' => 'PROGRAM PAKET', 'desc' => 'Persiapan komprehensif untuk seluruh sesi tes (IELTS, TOEFL, PTE).', 'items' => $programPaket]
];

$type = 'online';

foreach($groups as $group) {
    echo "Group: " . $group['title'] . "\n";
    $hasRegular = false;
    foreach($group['items'] as $prog) {
        $is_default = !in_array($prog->slug, ['ielts-academic-full-package', 'toefl-itp', 'toefl-ibt', 'ielts-general', 'pte-academic']);
        
        if ($is_default) {
            $bp = $type === 'offline' ? ($prog->price_offline ?? $prog->price ?? 0) : ($prog->price ?? 0);
        } else {
            $bp = $type === 'offline' ? ($prog ? ($prog->price_offline ?? $prog->price ?? 1999000) : 1999000) : ($prog ? $prog->price : 1999000);
        }
        
        echo " - Program: " . $prog->slug . " | is_default: " . ($is_default ? 'yes' : 'no') . " | db_price: " . $prog->price . " | final_bp: " . $bp . "\n";
        if ($bp > 0) $hasRegular = true;
    }
    echo " hasRegular: " . ($hasRegular ? 'true' : 'false') . "\n";
}

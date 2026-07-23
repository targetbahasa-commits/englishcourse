<?php
$file = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/brochure.blade.php';
$content = file_get_contents($file);

$mapping = [
    'IELTS PREPARATION' => ['slug' => 'ielts-academic-full-package', 'default' => 1999000],
    'TOEFL PREPARATION' => ['slug' => 'toefl-itp', 'default' => 1999000],
    'PTE ACADEMIC' => ['slug' => 'pte-academic', 'default' => 1999000],
    'GRAMMAR FOUNDATION' => ['slug' => 'fast-track-grammar-for-writing', 'default' => 1200000],
    'SPEAKING FLUENCY' => ['slug' => 'speaking', 'default' => 1200000],
    'LISTENING MASTERY' => ['slug' => 'ielts-academic-listening', 'default' => 1200000],
];

foreach ($mapping as $title => $data) {
    $slug = $data['slug'];
    $defaultPrice = $data['default'];
    $formattedDefault = number_format($defaultPrice, 0, ',', '.');
    
    // We will find the block starting from the title
    $titlePos = strpos($content, ">$title<");
    if ($titlePos === false) continue;
    
    // Find the next "INVESTASI:"
    $investasiPos = strpos($content, 'INVESTASI:', $titlePos);
    if ($investasiPos === false) continue;
    
    // Find the start of the <div class="flex items-center justify-between p-4 bg-gray-50
    $divStart = strrpos(substr($content, 0, $investasiPos), '<div class="flex items-center justify-between');
    if ($divStart === false) continue;
    
    // Find the end of this div, which is right before <div class="flex gap-3 mt-auto">
    $divEnd = strpos($content, '<div class="flex gap-3 mt-auto">', $divStart);
    if ($divEnd === false) continue;
    
    // Extract the original block
    $originalBlock = substr($content, $divStart, $divEnd - $divStart);
    
    // Extract the "core" price that was crossed out
    preg_match('/<div class="text-gray-400 line-through text-sm font-semibold">(.*?)<\/div>/', $originalBlock, $matches1);
    $crossedOut = $matches1[1] ?? 'Rp 2.500.000';
    
    // Build the new block
    $varName = '$p_' . str_replace('-', '_', $slug);
    $newBlock = <<<BLADE
@php \$$varName = \$programs['$slug'] ?? null; @endphp
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6">
                        <div>
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block">INVESTASI:</span>
                            <div class="text-gray-400 line-through text-sm font-semibold">$crossedOut</div>
                            <div class="text-highlight text-2xl font-black font-heading leading-none mt-1">
                                Rp {{ number_format((\$$varName && \$$varName->price > 0) ? \$$varName->price : $defaultPrice, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-1">MODE KELAS:</span>
                            <div class="flex gap-1.5 justify-end">
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-[10px] font-bold">ONLINE</span>
                                @if(\$$varName && \$$varName->price_offline > 0)
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold" title="Rp {{ number_format(\$$varName->price_offline, 0, ',', '.') }}">OFFLINE</span>
                                @else
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold">OFFLINE</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
BLADE;
    
    $content = substr_replace($content, $newBlock, $divStart, $divEnd - $divStart);
}

file_put_contents($file, $content);
echo "Replaced properly.\n";


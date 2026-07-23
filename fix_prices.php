<?php
$file = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/brochure.blade.php';
$content = file_get_contents($file);

// We need to fix the broken parts.
// The broken pattern is:
// @php $$p_xxx = $programs['xxx'] ?? null; @endphp
// <div class="flex items-center ...
// ...
// Rp {{ number_format(($$p_xxx && $ > 0) ? $ : 1999000, 0, ',', '.') }}
// ...
// @if($$p_xxx && $ > 0)
// <span ... title="Rp {{ number_format($, 0, ',', '.') }}">OFFLINE</span>

$content = preg_replace_callback('/@php \$\$p_([a-zA-Z0-9_]+) = \$programs\[\'([a-zA-Z0-9-]+)\'\] \?\? null; @endphp(.*?)<a href="http:\/\/targetbahasacourse\.test\/daftar"/s', function($matches) {
    $varBase = $matches[1];
    $slug = $matches[2];
    $inner = $matches[3];
    
    // Fix $$ to $
    $fixedInner = str_replace('$$p_' . $varBase, '$p_' . $varBase, $inner);
    
    // Fix $ > 0 to $p_xxx->price > 0 (for the price) and $p_xxx->price_offline > 0 (for offline)
    // Actually, let's just rewrite the block!
    
    $defaultPrice = 1200000;
    if (strpos($slug, 'ielts') !== false || strpos($slug, 'toefl') !== false || strpos($slug, 'pte') !== false) {
        $defaultPrice = 1999000;
    }
    
    // We need to get the crossedOut price from the inner text
    preg_match('/<div class="text-gray-400 line-through text-sm font-semibold">(.*?)<\/div>/', $inner, $m);
    $crossedOut = $m[1] ?? 'Rp 2.500.000';
    
    $newBlock = <<<BLADE

                    @php \$p_{$varBase} = \$programs['{$slug}'] ?? null; @endphp
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6">
                        <div>
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block">INVESTASI:</span>
                            <div class="text-gray-400 line-through text-sm font-semibold">{$crossedOut}</div>
                            <div class="text-highlight text-2xl font-black font-heading leading-none mt-1">
                                Rp {{ number_format((\$p_{$varBase} && \$p_{$varBase}->price > 0) ? \$p_{$varBase}->price : {$defaultPrice}, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-1">MODE KELAS:</span>
                            <div class="flex gap-1.5 justify-end">
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-[10px] font-bold">ONLINE</span>
                                @if(\$p_{$varBase} && \$p_{$varBase}->price_offline > 0)
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold" title="Rp {{ number_format(\$p_{$varBase}->price_offline, 0, ',', '.') }}">OFFLINE</span>
                                @else
                                <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold">OFFLINE</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-auto">
                        <a href="http://targetbahasacourse.test/daftar"
BLADE;
    
    return $newBlock;
}, $content);

file_put_contents($file, $content);
echo "Fixed brochure.\n";


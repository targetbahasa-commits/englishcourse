<?php
$file = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/brochure.blade.php';
$content = file_get_contents($file);

$content = preg_replace_callback('/(@if\(\$p_([a-zA-Z0-9_]+) && \$p_[a-zA-Z0-9_]+->price_offline > 0\).*?<\/div>\s*<\/div>\s*<\/div>\s*)(<div class="flex gap-3 mt-auto">)/s', function($matches) {
    $varBase = $matches[2];
    $before = $matches[1];
    $after = $matches[3];
    
    $batchBlock = <<<BLADE

                    @if(\$p_{$varBase} && \$p_{$varBase}->classPeriods->whereIn('status', ['active', 'upcoming'])->isNotEmpty())
                    <div class="mb-4">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">JADWAL KELAS AKTIF:</span>
                        <div class="space-y-1.5">
                            @foreach(\$p_{$varBase}->classPeriods->whereIn('status', ['active', 'upcoming'])->take(2) as \$batch)
                            <div class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border border-gray-100 shadow-sm">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full {{ \$batch->status === 'active' ? 'bg-emerald-400' : 'bg-blue-400' }}"></span>
                                    <span class="text-xs font-bold text-gray-800">{{ \$batch->name }}</span>
                                </div>
                                <span class="text-[10px] font-medium text-gray-500">{{ \Carbon\Carbon::parse(\$batch->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse(\$batch->end_date)->format('d M Y') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
BLADE;
    
    return $before . $batchBlock . $after;
}, $content);

file_put_contents($file, $content);
echo "Added batches to brochure.\n";


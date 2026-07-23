<?php
$file = 'resources/views/promo/promo_toolbar.blade.php';
$content = file_get_contents($file);

// Map button text to tooltip description
$tooltips = [
    'Linking Words'          => 'Kosakata penghubung antar kalimat & paragraf',
    'Irregular Verbs'        => 'Daftar kata kerja tak beraturan (V1, V2, V3)',
    'Describing Trends'      => 'Kosakata mendeskripsikan tren pada grafik',
    'Making Comparisons'     => 'Kosakata untuk membandingkan data grafik',
    'Collocations'           => 'Kumpulan kata yang alami dipasangkan bersama',
    'Idioms'                 => 'Ungkapan khas / peribahasa bahasa Inggris',
    'Ideas'                  => 'Kumpulan ide dan argumen untuk topik esai',
    'Magic Sentence'         => 'Ketik Indonesia → jadi kalimat gaya IELTS otomatis',
    'Collocation Dictionary' => 'Kamus khusus pencarian pasangan kata',
    'Dictionary'             => 'Kamus terjemahan Bahasa Inggris ↔ Indonesia',
];

foreach ($tooltips as $text => $tip) {
    // Add data-tooltip attribute to every button containing that text
    // Button pattern: <button ... class="...">  \n  Text \n </button>
    // We add data-tooltip="..." to the button opening tag
    $content = preg_replace_callback(
        '/(<button\b)([^>]*?)(>\s*' . preg_quote($text, '/') . '\s*<\/button>)/s',
        function($m) use ($tip) {
            // Only add if data-tooltip not already present
            if (strpos($m[0], 'data-tooltip') !== false) return $m[0];
            return $m[1] . $m[2] . ' data-tooltip="' . htmlspecialchars($tip) . '"' . $m[3];
        },
        $content
    );
}

// Append JS tooltip system at the end of the file (before closing div)
$jsTooltip = <<<'JSEOF'

<div id="tb-tooltip"
     style="position:fixed;z-index:9999;background:#1f2937;color:#fff;font-size:11px;padding:6px 10px;border-radius:6px;pointer-events:none;opacity:0;transition:opacity 0.15s;max-width:200px;text-align:center;line-height:1.5;box-shadow:0 4px 12px rgba(0,0,0,0.3);white-space:normal;">
</div>
<script>
(function(){
    const tip = document.getElementById('tb-tooltip');
    let hideTimer;
    document.addEventListener('mouseover', function(e){
        const btn = e.target.closest('[data-tooltip]');
        if(!btn) return;
        clearTimeout(hideTimer);
        tip.textContent = btn.dataset.tooltip;
        const r = btn.getBoundingClientRect();
        tip.style.opacity = '1';
        // Position below the button
        const tw = tip.offsetWidth || 180;
        let left = r.left + r.width/2 - tw/2;
        left = Math.max(8, Math.min(left, window.innerWidth - tw - 8));
        tip.style.left = left + 'px';
        tip.style.top  = (r.bottom + 6) + 'px';
    });
    document.addEventListener('mouseout', function(e){
        const btn = e.target.closest('[data-tooltip]');
        if(!btn) return;
        hideTimer = setTimeout(()=>{ tip.style.opacity='0'; }, 80);
    });
})();
</script>
JSEOF;

// Insert before the last closing </div>
$content = preg_replace('/<\/div>\s*$/', $jsTooltip . "\n</div>", $content);

file_put_contents($file, $content);
echo "Done. Lines: " . count(explode("\n", $content)) . "\n";

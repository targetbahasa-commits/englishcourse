<?php
$content = file_get_contents('resources/views/promo/promo_toolbar.blade.php');

$tooltips = [
    'Linking Words' => 'Kosakata penghubung antar kalimat/paragraf',
    'Irregular Verbs' => 'Daftar kata kerja tak beraturan (V1, V2, V3)',
    'Describing Trends' => 'Kosakata untuk mendeskripsikan tren pada grafik',
    'Making Comparisons' => 'Kosakata untuk membandingkan data grafik',
    'Collocations' => 'Kumpulan kata yang alami dipasangkan',
    'Idioms' => 'Ungkapan khas / peribahasa bahasa Inggris',
    'Ideas' => 'Kumpulan ide dan argumen untuk topik esai',
    'Magic Sentence' => 'Ketik bahasa Indonesia & otomatis jadi kalimat gaya IELTS',
    'Collocation Dictionary' => 'Kamus khusus pencarian pasangan kata',
    'Dictionary' => 'Kamus terjemahan Bahasa Inggris - Indonesia'
];

foreach ($tooltips as $btnText => $tooltipText) {
    // We look for a button containing the text. 
    // Usually: <button ...> \s* Text \s* </button>
    // or <button ...> \s* <svg...> \s* Text \s* </button>
    
    // Regex to match the button that ends with $btnText and </button>
    $pattern = '/(<button[^>]+)(class=")([^"]+)(")(.*?)('.$btnText.'\s*)(<\/button>)/is';
    
    $content = preg_replace_callback($pattern, function($matches) use ($tooltipText) {
        $buttonTagStart = $matches[1];
        $classAttrStr = $matches[2];
        $classes = $matches[3];
        $classAttrEnd = $matches[4];
        $innerHtml = $matches[5];
        $textContent = $matches[6];
        $buttonTagEnd = $matches[7];
        
        // Add relative group to classes if not present
        if (strpos($classes, 'relative') === false) {
            $classes .= ' relative group';
        }
        
        $tooltipHtml = '<div class="absolute top-full left-1/2 -translate-x-1/2 mt-2 w-max max-w-[200px] p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg normal-case font-normal text-center whitespace-normal leading-relaxed">
            '.$tooltipText.'
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 border-4 border-transparent border-b-gray-900"></div>
        </div>';
        
        return $buttonTagStart . $classAttrStr . $classes . $classAttrEnd . $innerHtml . $textContent . $tooltipHtml . "\n        " . $buttonTagEnd;
        
    }, $content);
}

file_put_contents('resources/views/promo/promo_toolbar.blade.php', $content);
echo "Done.\n";

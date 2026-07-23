<?php

function addNav($file, $currentSectionStr) {
    $content = file_get_contents($file);

    $navHtml = <<<HTML
    <!-- Section Navigation -->
    <div class="fixed bottom-8 right-8 flex flex-col md:flex-row gap-3 z-50">
        <a href="{{ \$listeningUrl ?? route('online-test.package-section', ['slugAlias' => \$slugAlias ?? 'toefl-itp', 'package' => \$packageNumber, 'section' => 'listening']) }}" 
                class="px-6 py-3 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 {{ $currentSectionStr === 'listening' ? 'bg-teal-600 text-white' : 'bg-white text-teal-600 border-2 border-teal-600' }}">
            Section 1: Listening
        </a>
        <a href="{{ \$structureRedirectUrl ?? route('online-test.package-section', ['slugAlias' => \$slugAlias ?? 'toefl-itp', 'package' => \$packageNumber, 'section' => 'structure']) }}" 
                class="px-6 py-3 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 {{ $currentSectionStr === 'structure' ? 'bg-teal-600 text-white' : 'bg-white text-teal-600 border-2 border-teal-600' }}">
            Section 2: Structure
        </a>
        <a href="{{ \$readingRedirectUrl ?? route('online-test.package-section', ['slugAlias' => \$slugAlias ?? 'toefl-itp', 'package' => \$packageNumber, 'section' => 'reading']) }}" 
                class="px-6 py-3 font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 {{ $currentSectionStr === 'reading' ? 'bg-teal-600 text-white' : 'bg-white text-teal-600 border-2 border-teal-600' }}">
            Section 3: Reading
        </a>
    </div>
HTML;

    // Check if the file already contains the nav
    if (strpos($content, 'Section Navigation') !== false) {
        echo "Already has nav: $file\n";
        return;
    }
    
    // Inject before closing </body>
    $content = str_replace('</body>', $navHtml . "\n</body>", $content);
    file_put_contents($file, $content);
    echo "Added nav to: $file\n";
}

$dir = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/online-test/packages/toefl-itp/paket1';
addNav("$dir/listening.blade.php", "'listening'");
addNav("$dir/structure.blade.php", "'structure'");
addNav("$dir/reading.blade.php", "'reading'");


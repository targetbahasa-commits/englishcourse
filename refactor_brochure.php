<?php
$file = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/brochure.blade.php';
$content = file_get_contents($file);

// Find the grid container start
$gridStartPos = strpos($content, '<div class="grid grid-cols-1 lg:grid-cols-2 gap-10 max-w-6xl mx-auto">');
if ($gridStartPos === false) die("Grid start not found");

// The end of the grid is before the </section>
$sectionEndPos = strpos($content, '</section>', $gridStartPos);
if ($sectionEndPos === false) die("Section end not found");

$gridContent = substr($content, $gridStartPos, $sectionEndPos - $gridStartPos);

// We know the structure:
// <!-- IELTS -->
// <div class="card theme-ielts ...">...</div>
// <!-- TOEFL -->
// <div class="card theme-toefl ...">...</div>
// <!-- PTE -->
// <div class="card theme-pte ...">...</div>
// <!-- Grammar -->
// <div class="card theme-grammar ...">...</div>
// <!-- Speaking -->
// <div class="card theme-speaking ...">...</div>
// <!-- Listening -->
// <div class="card theme-listening ...">...</div>

function extractCard($html, $marker, $nextMarker = null) {
    $start = strpos($html, $marker);
    if ($start === false) return "";
    if ($nextMarker) {
        $end = strpos($html, $nextMarker, $start);
        return substr($html, $start, $end - $start);
    } else {
        // Find last </div> before the end of gridContent
        $end = strrpos($html, '</div>', -10); // heuristic
        return substr($html, $start, $end - $start + 6);
    }
}

$ielts = extractCard($gridContent, '<!-- IELTS -->', '<!-- TOEFL -->');
$toefl = extractCard($gridContent, '<!-- TOEFL -->', '<!-- PTE -->');
$pte = extractCard($gridContent, '<!-- PTE -->', '<!-- Grammar -->');
$grammar = extractCard($gridContent, '<!-- Grammar -->', '<!-- Speaking -->');
$speaking = extractCard($gridContent, '<!-- Speaking -->', '<!-- Listening -->');
$listening = extractCard($gridContent, '<!-- Listening -->', null);

// Clean up the ending of listening card
$listening = preg_replace('/<\/div>\s*$/', '', rtrim($listening));
if (substr($listening, -6) !== '</div>') {
    $listening .= "\n                </div>";
}

$genericCard = <<<'BLADE'
                <!-- GENERIC CARD -->
                <div class="card overflow-hidden relative group" style="--theme-color: {{ $program->color ?? '#3b82f6' }};">
                    <!-- Background Image -->
                    <div class="absolute inset-0 w-full h-full bg-cover bg-top z-0 transition-transform duration-700 group-hover:scale-105" 
                         style="background-color: {{ $program->color ?? '#3b82f6' }}; {{ $program->brochure_image ? 'background-image: url(\''.asset('storage/'.$program->brochure_image).'\');' : 'background-image: linear-gradient(135deg, '.($program->color ?? '#3b82f6').' 0%, #1e293b 100%);' }}">
                    </div>
                    <!-- Image Overlay -->
                    <div class="absolute inset-0 z-0 pointer-events-none" style="background: linear-gradient(to bottom, rgba(255,255,255,0.92) 0%, rgba(255,255,255,0.4) 100%);"></div>
                    
                    <!-- Content Wrapper -->
                    <div class="relative z-10 w-full h-full flex flex-col flex-grow pt-2">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="card-icon mb-0 shrink-0" style="color: {{ $program->color ?? '#3b82f6' }}; background: rgba(255,255,255,0.8);">
                                @if($program->icon)
                                    {!! $program->icon !!}
                                @else
                                    <span class="text-xl font-bold">{{ substr($program->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <h3 class="title text-2xl font-black font-heading mb-1" style="color: {{ $program->color ?? '#3b82f6' }}">{{ strtoupper($program->name) }}</h3>
                                @if($program->period)
                                <p class="text-sm font-semibold italic text-gray-600">"{{ $program->period }}"</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Glass Body Container -->
                        <div class="flex-grow flex flex-col mt-32 p-6 rounded-2xl" style="background: rgba(255, 255, 255, 0.90); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); box-shadow: 0 8px 32px rgba(0,0,0,0.1); border: 1px solid rgba(255,255,255,0.8); margin-left: -8px; margin-right: -8px;">
                            <p class="text-[13.5px] text-gray-700 mb-6 leading-relaxed flex-grow">
                                {{ $program->description ?? 'Program intensif yang dirancang untuk membantu Anda menguasai materi dengan metode belajar yang efektif dan terstruktur.' }}
                            </p>

                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100 mb-6">
                                <div>
                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block">INVESTASI:</span>
                                    <div class="text-highlight text-2xl font-black font-heading leading-none mt-1" style="color: {{ $program->color ?? '#3b82f6' }}">
                                        Rp {{ number_format($program->price > 0 ? $program->price : 0, 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-1">MODE KELAS:</span>
                                    <div class="flex gap-1.5 justify-end">
                                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-[10px] font-bold">ONLINE</span>
                                        @if($program->price_offline > 0)
                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold" title="Rp {{ number_format($program->price_offline, 0, ',', '.') }}">OFFLINE</span>
                                        @else
                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded text-[10px] font-bold">OFFLINE</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($program->classPeriods->whereIn('status', ['active', 'upcoming'])->isNotEmpty())
                            <div class="mb-4">
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wide block mb-2">JADWAL KELAS AKTIF:</span>
                                <div class="space-y-1.5">
                                    @foreach($program->classPeriods->whereIn('status', ['active', 'upcoming'])->take(2) as $batch)
                                    <div class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border border-gray-100 shadow-sm">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full {{ $batch->status === 'active' ? 'bg-emerald-400' : 'bg-blue-400' }}"></span>
                                            <span class="text-xs font-bold text-gray-800">{{ $batch->name }}</span>
                                        </div>
                                        <span class="text-[10px] font-medium text-gray-500">{{ \Carbon\Carbon::parse($batch->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($batch->end_date)->format('d M Y') }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="flex gap-3 mt-auto">
                                <a href="http://targetbahasacourse.test/daftar" class="btn-primary flex-1 py-3.5 rounded-lg font-bold text-sm uppercase tracking-wider hover:opacity-90 transition shadow-md text-center" style="background-color: {{ $program->color ?? '#3b82f6' }};">Daftar Sekarang</a>
                                <a href="https://api.whatsapp.com/send?phone=6285706615607" target="_blank" rel="noopener" class="flex items-center justify-center px-5 py-3.5 rounded-lg shadow-md hover:opacity-90 transition" style="background-color: #25D366; color: white;"><i class="fab fa-whatsapp text-2xl"></i></a>
                            </div>
                        </div><!-- End Glass Body Container -->
                    </div><!-- End Content Wrapper -->
                </div>
BLADE;

$newGridContent = '<div class="grid grid-cols-1 lg:grid-cols-2 gap-10 max-w-6xl mx-auto">' . "\n";
$newGridContent .= '                @foreach($programs as $program)' . "\n";
$newGridContent .= '                    @switch($program->slug)' . "\n";
$newGridContent .= '                        @case(\'ielts-academic-full-package\')' . "\n";
$newGridContent .= $ielts . "\n";
$newGridContent .= '                            @break' . "\n";
$newGridContent .= '                        @case(\'toefl-itp\')' . "\n";
$newGridContent .= $toefl . "\n";
$newGridContent .= '                            @break' . "\n";
$newGridContent .= '                        @case(\'pte-academic\')' . "\n";
$newGridContent .= $pte . "\n";
$newGridContent .= '                            @break' . "\n";
$newGridContent .= '                        @case(\'fast-track-grammar-for-writing\')' . "\n";
$newGridContent .= $grammar . "\n";
$newGridContent .= '                            @break' . "\n";
$newGridContent .= '                        @case(\'speaking\')' . "\n";
$newGridContent .= $speaking . "\n";
$newGridContent .= '                            @break' . "\n";
$newGridContent .= '                        @case(\'ielts-academic-listening\')' . "\n";
$newGridContent .= $listening . "\n";
$newGridContent .= '                            @break' . "\n";
$newGridContent .= '                        @default' . "\n";
$newGridContent .= $genericCard . "\n";
$newGridContent .= '                    @endswitch' . "\n";
$newGridContent .= '                @endforeach' . "\n";
$newGridContent .= '            </div>';

$content = substr_replace($content, $newGridContent, $gridStartPos, $sectionEndPos - $gridStartPos);

file_put_contents($file, $content);
echo "Brochure refactored successfully.\n";

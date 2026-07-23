<?php
$content = file_get_contents('resources/views/brochure.blade.php');

// Reset everything to the base format first to make matching easier
$content = preg_replace('/<div class="bg-white rounded p-2 border border-gray-200 text-center shadow-sm cursor-help" title="[^"]+">/', '<div class="bg-white rounded p-2 border border-gray-200 text-center shadow-sm">', $content);
$content = preg_replace('/<div class="bg-blue-50 rounded p-2 border border-blue-200 text-center shadow-sm cursor-help" title="[^"]+">/', '<div class="bg-blue-50 rounded p-2 border border-blue-200 text-center shadow-sm">', $content);
$content = preg_replace('/<div class="bg-yellow-50 rounded p-2 border border-yellow-300 text-center shadow-sm cursor-help" title="[^"]+">/', '<div class="bg-yellow-50 rounded p-2 border border-yellow-300 text-center shadow-sm">', $content);

// Regular Block Replacement
$patternReg = '/<div class="bg-white rounded p-2 border border-gray-200 text-center shadow-sm">\s*<div class="text-\[10px\] font-bold text-gray-500 uppercase">Regular<\/div>\s*<div class="text-xs font-black text-tb-blue mt-0\.5" style="white-space: nowrap;">(.*?)<\/div>\s*<\/div>/s';
$replaceReg = '<div class="relative group bg-white rounded p-2 border border-gray-200 text-center shadow-sm cursor-help">
                                <div class="text-[10px] font-bold text-gray-500 uppercase">Regular</div>
                                <div class="text-xs font-black text-tb-blue mt-0.5" style="white-space: nowrap;">$1</div>
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">
                                    Belajar bersama teman-teman lainnya. Cocok untuk diskusi kelompok.
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
                                </div>
                            </div>';

// Semi Private Block Replacement
$patternSemi = '/<div class="bg-blue-50 rounded p-2 border border-blue-200 text-center shadow-sm">\s*<div class="text-\[10px\] font-bold text-blue-700 uppercase">Semi Private<\/div>\s*<div class="text-xs font-black text-tb-blue mt-0\.5" style="white-space: nowrap;">(.*?)<\/div>\s*<\/div>/s';
$replaceSemi = '<div class="relative group bg-blue-50 rounded p-2 border border-blue-200 text-center shadow-sm cursor-help">
                                <div class="text-[10px] font-bold text-blue-700 uppercase">Semi Private</div>
                                <div class="text-xs font-black text-tb-blue mt-0.5" style="white-space: nowrap;">$1</div>
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">
                                    Kelas dengan grup kecil (2-4 orang). Lebih fokus.
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
                                </div>
                            </div>';

// Private Block Replacement
$patternPriv = '/<div class="bg-yellow-50 rounded p-2 border border-yellow-300 text-center shadow-sm">\s*<div class="text-\[10px\] font-bold text-yellow-700 uppercase">Private<\/div>\s*<div class="text-xs font-black text-tb-blue mt-0\.5" style="white-space: nowrap;">(.*?)<\/div>\s*<\/div>/s';
$replacePriv = '<div class="relative group bg-yellow-50 rounded p-2 border border-yellow-300 text-center shadow-sm cursor-help">
                                <div class="text-[10px] font-bold text-yellow-700 uppercase">Private</div>
                                <div class="text-xs font-black text-tb-blue mt-0.5" style="white-space: nowrap;">$1</div>
                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-900 text-white text-[10px] rounded opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none shadow-lg leading-relaxed normal-case font-normal text-center">
                                    Fokus penuh 1-on-1 dengan tutor. Jadwal lebih fleksibel.
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></div>
                                </div>
                            </div>';

$content = preg_replace($patternReg, $replaceReg, $content);
$content = preg_replace($patternSemi, $replaceSemi, $content);
$content = preg_replace($patternPriv, $replacePriv, $content);

file_put_contents('resources/views/brochure.blade.php', $content);
echo "Tooltips updated successfully!\n";
?>

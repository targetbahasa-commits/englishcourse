<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Writing Mock Test {{ $testId }} - {{ config('app.name', 'Target Bahasa') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body { height: 100%; overflow: hidden; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')

<div class="fixed inset-0 z-0 flex flex-col">

    {{-- Top header --}}
    <div class="flex-none bg-white border-b border-gray-200 shadow-sm z-10 w-full pl-0">
        <div class="px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-2.5 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">IELTS Writing – Mock Test {{ $testId }}</h1>
                    <p class="text-sm text-gray-500">Cambridge {{ $edition }} Writing Practice</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg border border-indigo-100 font-semibold" id="time-remaining">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    60:00
                </div>
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId]) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
                    Exit
                </a>
            </div>
        </div>
    </div>

    {{-- Split screen --}}
    <div class="flex-1 min-h-0 grid overflow-hidden" style="grid-template-columns: 1fr 1fr;">

        {{-- LEFT: Writing Prompt --}}
        <div class="h-full overflow-y-auto bg-white border-r border-gray-200 custom-scrollbar">

            {{-- TASK 1 PROMPT --}}
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto" id="task-1-prompt">
                {{-- WRITING header --}}
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">WRITING</span>
                </div>

                <div class="mb-6 space-y-3 text-gray-800 text-[15px] leading-relaxed">
                    <p class="font-bold text-base tracking-wide uppercase">WRITING TASK 1</p>
                    <p>You should spend about 20 minutes on this task.</p>

                    <div class="border-2 border-gray-800 p-5 font-bold italic bg-white shadow-sm mt-4 mb-4">
                        <p class="mb-3">The maps below show an industrial area in the town of Norbiton, and planned future development of the site.</p>
                        <p>Summarise the information by selecting and reporting the main features, and make comparisons where relevant.</p>
                    </div>

                    <p>Write at least 150 words.</p>
                </div>

                {{-- MAP 1: Norbiton industrial area now --}}
                <div class="mb-8">
                    <h4 class="text-center font-bold text-[14px] text-gray-900 mb-4">Norbiton industrial area now</h4>

                    <svg viewBox="0 0 420 260" xmlns="http://www.w3.org/2000/svg" class="w-full border border-gray-300 bg-white" font-family="Arial,sans-serif">
                        <!-- Compass -->
                        <g transform="translate(370,20)">
                            <text x="0" y="8" text-anchor="middle" font-size="8" font-weight="bold">N</text>
                            <line x1="0" y1="10" x2="0" y2="22" stroke="#000" stroke-width="1"/>
                            <polygon points="0,10 -3,22 0,19 3,22" fill="#000"/>
                            <text x="-12" y="20" text-anchor="middle" font-size="8">W</text>
                            <text x="12" y="20" text-anchor="middle" font-size="8">E</text>
                            <text x="0" y="32" text-anchor="middle" font-size="8">S</text>
                        </g>

                        <!-- River (wavy path at top) -->
                        <path d="M0,60 Q30,50 60,60 Q90,70 120,60 Q150,50 180,60 Q210,70 240,60 Q270,50 300,60 Q330,70 360,60 Q390,50 420,60"
                              fill="none" stroke="#999" stroke-width="14" stroke-linecap="round"/>
                        <path d="M0,60 Q30,50 60,60 Q90,70 120,60 Q150,50 180,60 Q210,70 240,60 Q270,50 300,60 Q330,70 360,60 Q390,50 420,60"
                              fill="none" stroke="#ccc" stroke-width="10" stroke-linecap="round"/>
                        <text x="185" y="57" font-size="9" fill="#555" font-style="italic">River</text>

                        <!-- Farmland label -->
                        <text x="240" y="40" font-size="11" fill="#555" font-style="italic">Farmland</text>

                        <!-- Town label (left) -->
                        <text x="5" y="155" font-size="11" fill="#333">Town</text>
                        <!-- Dashed boundary line -->
                        <line x1="60" y1="70" x2="60" y2="245" stroke="#333" stroke-width="1.5" stroke-dasharray="5,4"/>

                        <!-- Main horizontal road -->
                        <rect x="60" y="145" width="360" height="14" fill="#bbb"/>
                        <!-- Road from roundabout going right -->
                        <rect x="60" y="145" width="360" height="14" fill="#bbb"/>
                        <!-- Bottom road -->
                        <rect x="60" y="235" width="360" height="14" fill="#bbb"/>

                        <!-- Roundabout -->
                        <circle cx="145" cy="152" r="20" fill="white" stroke="#888" stroke-width="2"/>
                        <circle cx="145" cy="152" r="10" fill="#ddd" stroke="#888" stroke-width="1.5"/>
                        <!-- Road segments connecting roundabout -->
                        <rect x="120" y="145" width="50" height="14" fill="#bbb"/>
                        <rect x="138" y="100" width="14" height="52" fill="#bbb"/>
                        <rect x="138" y="152" width="14" height="90" fill="#bbb"/>

                        <!-- Factories (hatched rectangles) - current -->
                        <!-- Factory 1 (above roundabout, left) -->
                        <g transform="translate(100,90)">
                            <rect x="0" y="0" width="32" height="22" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="32" y2="22" stroke="#666" stroke-width="1"/>
                            <line x1="8" y1="0" x2="32" y2="15" stroke="#666" stroke-width="1"/>
                            <line x1="16" y1="0" x2="32" y2="11" stroke="#666" stroke-width="1"/>
                            <line x1="24" y1="0" x2="32" y2="5" stroke="#666" stroke-width="1"/>
                            <line x1="0" y1="7" x2="24" y2="22" stroke="#666" stroke-width="1"/>
                            <line x1="0" y1="15" x2="13" y2="22" stroke="#666" stroke-width="1"/>
                        </g>
                        <!-- Factory 2 (left of roundabout) -->
                        <g transform="translate(76,128) rotate(-35,16,11)">
                            <rect x="0" y="0" width="32" height="22" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="32" y2="22" stroke="#666" stroke-width="1"/>
                            <line x1="8" y1="0" x2="32" y2="15" stroke="#666" stroke-width="1"/>
                            <line x1="16" y1="0" x2="32" y2="11" stroke="#666" stroke-width="1"/>
                            <line x1="24" y1="0" x2="32" y2="5" stroke="#666" stroke-width="1"/>
                            <line x1="0" y1="7" x2="24" y2="22" stroke="#666" stroke-width="1"/>
                        </g>
                        <!-- Factory 3 below roundabout -->
                        <g transform="translate(128,178)">
                            <rect x="0" y="0" width="32" height="22" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="32" y2="22" stroke="#666" stroke-width="1"/>
                            <line x1="8" y1="0" x2="32" y2="15" stroke="#666" stroke-width="1"/>
                            <line x1="16" y1="0" x2="32" y2="11" stroke="#666" stroke-width="1"/>
                            <line x1="24" y1="0" x2="32" y2="5" stroke="#666" stroke-width="1"/>
                            <line x1="0" y1="7" x2="24" y2="22" stroke="#666" stroke-width="1"/>
                        </g>
                        <!-- Factories on right side of road -->
                        <!-- Row 1 -->
                        <g transform="translate(175,133)">
                            <rect x="0" y="0" width="40" height="22" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="40" y2="22" stroke="#666" stroke-width="1"/>
                            <line x1="10" y1="0" x2="40" y2="16" stroke="#666" stroke-width="1"/>
                            <line x1="20" y1="0" x2="40" y2="11" stroke="#666" stroke-width="1"/>
                            <line x1="30" y1="0" x2="40" y2="5" stroke="#666" stroke-width="1"/>
                            <line x1="0" y1="7" x2="32" y2="22" stroke="#666" stroke-width="1"/>
                            <line x1="0" y1="15" x2="18" y2="22" stroke="#666" stroke-width="1"/>
                        </g>
                        <g transform="translate(225,133)">
                            <rect x="0" y="0" width="40" height="22" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="40" y2="22" stroke="#666" stroke-width="1"/>
                            <line x1="10" y1="0" x2="40" y2="16" stroke="#666" stroke-width="1"/>
                            <line x1="20" y1="0" x2="40" y2="11" stroke="#666" stroke-width="1"/>
                            <line x1="30" y1="0" x2="40" y2="5" stroke="#666" stroke-width="1"/>
                            <line x1="0" y1="7" x2="32" y2="22" stroke="#666" stroke-width="1"/>
                        </g>
                        <g transform="translate(290,133)">
                            <rect x="0" y="0" width="40" height="22" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="40" y2="22" stroke="#666" stroke-width="1"/>
                            <line x1="10" y1="0" x2="40" y2="16" stroke="#666" stroke-width="1"/>
                            <line x1="20" y1="0" x2="40" y2="11" stroke="#666" stroke-width="1"/>
                            <line x1="30" y1="0" x2="40" y2="5" stroke="#666" stroke-width="1"/>
                            <line x1="0" y1="7" x2="32" y2="22" stroke="#666" stroke-width="1"/>
                        </g>
                        <!-- Row 2 -->
                        <g transform="translate(175,163)">
                            <rect x="0" y="0" width="40" height="22" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="40" y2="22" stroke="#666" stroke-width="1"/>
                            <line x1="10" y1="0" x2="40" y2="16" stroke="#666" stroke-width="1"/>
                            <line x1="20" y1="0" x2="40" y2="11" stroke="#666" stroke-width="1"/>
                            <line x1="30" y1="0" x2="40" y2="5" stroke="#666" stroke-width="1"/>
                            <line x1="0" y1="7" x2="32" y2="22" stroke="#666" stroke-width="1"/>
                        </g>
                        <g transform="translate(225,163)">
                            <rect x="0" y="0" width="40" height="22" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="40" y2="22" stroke="#666" stroke-width="1"/>
                            <line x1="10" y1="0" x2="40" y2="16" stroke="#666" stroke-width="1"/>
                            <line x1="20" y1="0" x2="40" y2="11" stroke="#666" stroke-width="1"/>
                            <line x1="30" y1="0" x2="40" y2="5" stroke="#666" stroke-width="1"/>
                            <line x1="0" y1="7" x2="32" y2="22" stroke="#666" stroke-width="1"/>
                        </g>
                        <g transform="translate(290,163)">
                            <rect x="0" y="0" width="55" height="22" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="55" y2="22" stroke="#666" stroke-width="1"/>
                            <line x1="13" y1="0" x2="55" y2="17" stroke="#666" stroke-width="1"/>
                            <line x1="27" y1="0" x2="55" y2="11" stroke="#666" stroke-width="1"/>
                            <line x1="40" y1="0" x2="55" y2="6" stroke="#666" stroke-width="1"/>
                            <line x1="0" y1="8" x2="44" y2="22" stroke="#666" stroke-width="1"/>
                            <line x1="0" y1="16" x2="24" y2="22" stroke="#666" stroke-width="1"/>
                        </g>

                        <!-- Legend -->
                        <rect x="62" y="242" width="28" height="14" fill="white" stroke="#333" stroke-width="1.5"/>
                        <line x1="62" y1="242" x2="90" y2="256" stroke="#666" stroke-width="1"/>
                        <line x1="69" y1="242" x2="90" y2="253" stroke="#666" stroke-width="1"/>
                        <line x1="76" y1="242" x2="90" y2="249" stroke="#666" stroke-width="1"/>
                        <line x1="83" y1="242" x2="90" y2="245" stroke="#666" stroke-width="1"/>
                        <line x1="62" y1="249" x2="79" y2="256" stroke="#666" stroke-width="1"/>
                        <text x="96" y="253" font-size="10" fill="#333">= Factory</text>
                    </svg>
                </div>

                {{-- MAP 2: Planned future development --}}
                <div class="mb-8">
                    <h4 class="text-center font-bold text-[14px] text-gray-900 mb-4">Planned future development</h4>

                    <svg viewBox="0 0 420 290" xmlns="http://www.w3.org/2000/svg" class="w-full border border-gray-300 bg-white" font-family="Arial,sans-serif">
                        <!-- River (wavy) -->
                        <path d="M0,65 Q30,55 60,65 Q90,75 120,65 Q150,55 180,65 Q210,75 220,65"
                              fill="none" stroke="#999" stroke-width="14" stroke-linecap="round"/>
                        <path d="M0,65 Q30,55 60,65 Q90,75 120,65 Q150,55 180,65 Q210,75 220,65"
                              fill="none" stroke="#ccc" stroke-width="10" stroke-linecap="round"/>
                        <text x="80" y="62" font-size="9" fill="#555" font-style="italic">River</text>

                        <!-- Farmland label -->
                        <text x="240" y="48" font-size="11" fill="#555" font-style="italic">Farmland</text>

                        <!-- Town label -->
                        <text x="5" y="168" font-size="11" fill="#333">Town</text>
                        <!-- Dashed boundary -->
                        <line x1="60" y1="75" x2="60" y2="270" stroke="#333" stroke-width="1.5" stroke-dasharray="5,4"/>

                        <!-- Roads -->
                        <rect x="60" y="155" width="360" height="14" fill="#bbb"/>
                        <rect x="60" y="255" width="360" height="14" fill="#bbb"/>
                        <!-- New vertical road at top (bridge over river) -->
                        <rect x="185" y="35" width="14" height="170" fill="#bbb"/>

                        <!-- Roundabout 1 (main) -->
                        <circle cx="192" cy="162" r="20" fill="white" stroke="#888" stroke-width="2"/>
                        <circle cx="192" cy="162" r="10" fill="#ddd" stroke="#888" stroke-width="1.5"/>

                        <!-- Roundabout 2 (bottom) -->
                        <circle cx="192" cy="262" r="14" fill="white" stroke="#888" stroke-width="2"/>
                        <circle cx="192" cy="262" r="7" fill="#ddd" stroke="#888" stroke-width="1.5"/>
                        <!-- Road connecting two roundabouts -->
                        <rect x="185" y="162" width="14" height="100" fill="#bbb"/>

                        <!-- Housing pattern: crosshatch rectangles -->
                        <!-- Helper macro-like: just repeat the pattern -->
                        <!-- Top housing (above river, center) -->
                        <g transform="translate(145,40)">
                            <rect x="0" y="0" width="70" height="22" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="0" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="10" y1="0" x2="10" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="20" y1="0" x2="20" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="30" y1="0" x2="30" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="40" y1="0" x2="40" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="50" y1="0" x2="50" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="60" y1="0" x2="60" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="0" y1="0" x2="70" y2="0" stroke="#555" stroke-width="1"/>
                            <line x1="0" y1="11" x2="70" y2="11" stroke="#555" stroke-width="1"/>
                            <line x1="0" y1="22" x2="70" y2="22" stroke="#555" stroke-width="1"/>
                        </g>

                        <!-- Housing blocks left side -->
                        <g transform="translate(68,100) rotate(-30,20,15)">
                            <rect x="0" y="0" width="42" height="26" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="0" y2="26" stroke="#555" stroke-width="1"/>
                            <line x1="10" y1="0" x2="10" y2="26" stroke="#555" stroke-width="1"/>
                            <line x1="21" y1="0" x2="21" y2="26" stroke="#555" stroke-width="1"/>
                            <line x1="31" y1="0" x2="31" y2="26" stroke="#555" stroke-width="1"/>
                            <line x1="0" y1="0" x2="42" y2="0" stroke="#555" stroke-width="1"/>
                            <line x1="0" y1="13" x2="42" y2="13" stroke="#555" stroke-width="1"/>
                            <line x1="0" y1="26" x2="42" y2="26" stroke="#555" stroke-width="1"/>
                        </g>
                        <g transform="translate(90,130) rotate(-30,20,15)">
                            <rect x="0" y="0" width="28" height="26" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="0" y2="26" stroke="#555" stroke-width="1"/>
                            <line x1="14" y1="0" x2="14" y2="26" stroke="#555" stroke-width="1"/>
                            <line x1="0" y1="0" x2="28" y2="0" stroke="#555" stroke-width="1"/>
                            <line x1="0" y1="13" x2="28" y2="13" stroke="#555" stroke-width="1"/>
                            <line x1="0" y1="26" x2="28" y2="26" stroke="#555" stroke-width="1"/>
                        </g>

                        <!-- Shops label (lower left, diagonal) -->
                        <text x="120" y="205" font-size="10" fill="#333" transform="rotate(-45,120,205)">Shops</text>
                        <!-- Medical centre label -->
                        <text x="158" y="222" font-size="10" fill="#333" transform="rotate(-45,158,222)">Medical</text>
                        <text x="164" y="232" font-size="10" fill="#333" transform="rotate(-45,164,232)">centre</text>

                        <!-- Playground area (right side) -->
                        <rect x="240" y="110" width="80" height="45" fill="white" stroke="#333" stroke-width="1.5"/>
                        <text x="248" y="137" font-size="11" fill="#333">Playground</text>

                        <!-- Housing right side row 1 -->
                        <g transform="translate(240,162)">
                            <rect x="0" y="0" width="40" height="22" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="0" y2="22" stroke="#555" stroke-width="1"/><line x1="10" y1="0" x2="10" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="20" y1="0" x2="20" y2="22" stroke="#555" stroke-width="1"/><line x1="30" y1="0" x2="30" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="0" y1="11" x2="40" y2="11" stroke="#555" stroke-width="1"/>
                        </g>
                        <g transform="translate(290,162)">
                            <rect x="0" y="0" width="40" height="22" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="0" y2="22" stroke="#555" stroke-width="1"/><line x1="10" y1="0" x2="10" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="20" y1="0" x2="20" y2="22" stroke="#555" stroke-width="1"/><line x1="30" y1="0" x2="30" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="0" y1="11" x2="40" y2="11" stroke="#555" stroke-width="1"/>
                        </g>

                        <!-- Housing right side row 2 -->
                        <g transform="translate(240,192)">
                            <rect x="0" y="0" width="40" height="22" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="0" y2="22" stroke="#555" stroke-width="1"/><line x1="10" y1="0" x2="10" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="20" y1="0" x2="20" y2="22" stroke="#555" stroke-width="1"/><line x1="30" y1="0" x2="30" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="0" y1="11" x2="40" y2="11" stroke="#555" stroke-width="1"/>
                        </g>
                        <g transform="translate(290,192)">
                            <rect x="0" y="0" width="40" height="22" fill="white" stroke="#333" stroke-width="1.5"/>
                            <line x1="0" y1="0" x2="0" y2="22" stroke="#555" stroke-width="1"/><line x1="10" y1="0" x2="10" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="20" y1="0" x2="20" y2="22" stroke="#555" stroke-width="1"/><line x1="30" y1="0" x2="30" y2="22" stroke="#555" stroke-width="1"/>
                            <line x1="0" y1="11" x2="40" y2="11" stroke="#555" stroke-width="1"/>
                        </g>

                        <!-- School box (far right) -->
                        <rect x="348" y="130" width="30" height="90" fill="white" stroke="#333" stroke-width="1.5"/>
                        <text x="356" y="185" font-size="10" fill="#333" transform="rotate(90,356,175)">School</text>

                        <!-- Legend -->
                        <rect x="62" y="272" width="28" height="14" fill="white" stroke="#333" stroke-width="1.5"/>
                        <line x1="62" y1="272" x2="62" y2="286" stroke="#555" stroke-width="1"/>
                        <line x1="71" y1="272" x2="71" y2="286" stroke="#555" stroke-width="1"/>
                        <line x1="80" y1="272" x2="80" y2="286" stroke="#555" stroke-width="1"/>
                        <line x1="62" y1="272" x2="90" y2="272" stroke="#555" stroke-width="1"/>
                        <line x1="62" y1="279" x2="90" y2="279" stroke="#555" stroke-width="1"/>
                        <line x1="62" y1="286" x2="90" y2="286" stroke="#555" stroke-width="1"/>
                        <text x="96" y="283" font-size="10" fill="#333">= Housing</text>
                    </svg>
                </div>
            </div>

            {{-- TASK 2 PROMPT --}}
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto hidden" id="task-2-prompt">
                {{-- WRITING header --}}
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">WRITING</span>
                </div>

                <div class="mb-8 space-y-4 text-gray-800 text-[15px] leading-relaxed">
                    <p class="font-bold text-base tracking-wide uppercase">WRITING TASK 2</p>
                    <p>You should spend about 40 minutes on this task.</p>
                    <p>Write about the following topic:</p>

                    <div class="border-2 border-gray-800 p-5 font-bold italic bg-white shadow-sm mt-4 mb-4 space-y-4">
                        <p>It is important for people to take risks, both in their professional lives and their personal lives.</p>
                        <p>Do you think the advantages of taking risks outweigh the disadvantages?</p>
                    </div>

                    <p>Give reasons for your answer and include any relevant examples from your own knowledge or experience.</p>
                    <p class="mt-4">Write at least 250 words.</p>
                </div>
            </div>
        </div>

        {{-- RIGHT: Text editor area --}}
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar flex flex-col">
            <div class="px-4 py-6 flex-1 flex flex-col w-full">

                <form id="writing-form-1" class="flex-1 flex flex-col bg-white rounded-2xl shadow-sm border border-gray-200">

                    {{-- Toolbar --}}
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 bg-gray-50/50 rounded-t-2xl">
                        <div>
                            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Your Answer (Task 1)</h3>
                        </div>
                        <div class="text-sm text-gray-500 font-medium">
                            Status: <span class="text-green-600 font-semibold flex items-center gap-1 inline-flex"><span class="w-2 h-2 rounded-full bg-green-500"></span> Saved</span>
                        </div>
                    </div>

                    {{-- Textarea --}}
                    <div class="flex-1 relative">
                        <textarea
                            id="essay-input"
                            name="essay"
                            class="absolute inset-0 w-full h-full p-6 resize-none border-none focus:ring-0 focus:outline-none text-gray-800 text-base leading-relaxed"
                            placeholder="Type your answer here..."
                            spellcheck="false"
                        ></textarea>
                    </div>

                    {{-- Footer --}}
                    <div class="border-t border-gray-200 px-6 py-4 bg-gray-50/50 rounded-b-2xl flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold text-gray-700 font-mono" id="word-count">0</span>
                            <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Words</span>
                        </div>
                        <button type="button" id="btn-go-to-task-2" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm transition-all focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Go to Task 2
                        </button>
                    </div>

                </form>

                <form id="writing-form-2" class="hidden flex-1 flex-col bg-white rounded-2xl shadow-sm border border-gray-200">

                    {{-- Toolbar --}}
                    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 bg-gray-50/50 rounded-t-2xl">
                        <div>
                            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Your Answer (Task 2)</h3>
                        </div>
                        <div class="text-sm text-gray-500 font-medium">
                            Status: <span class="text-green-600 font-semibold flex items-center gap-1 inline-flex"><span class="w-2 h-2 rounded-full bg-green-500"></span> Saved</span>
                        </div>
                    </div>

                    {{-- Textarea --}}
                    <div class="flex-1 relative">
                        <textarea
                            id="essay-input-2"
                            name="essay_2"
                            class="absolute inset-0 w-full h-full p-6 resize-none border-none focus:ring-0 focus:outline-none text-gray-800 text-base leading-relaxed"
                            placeholder="Type your answer here..."
                            spellcheck="false"
                        ></textarea>
                    </div>

                    {{-- Footer --}}
                    <div class="border-t border-gray-200 px-6 py-4 bg-gray-50/50 rounded-b-2xl flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <div class="flex flex-col">
                                <span class="text-2xl font-bold text-gray-700 font-mono" id="word-count-2">0</span>
                                <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Words</span>
                            </div>
                            <button type="button" id="btn-go-to-task-1" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all text-sm">
                                Back to Task 1
                            </button>
                        </div>
                        <button type="button" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm transition-all focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Submit Tasks
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const setupWordCounter = (inputId, counterId, minWords) => {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(counterId);
            if (!input || !counter) return;
            input.addEventListener('input', () => {
                const text = input.value.trim();
                const words = text ? text.split(/\s+/) : [];
                counter.textContent = words.length;
                if (words.length > 0 && words.length < minWords) {
                    counter.classList.add('text-orange-500');
                    counter.classList.remove('text-green-600', 'text-gray-700');
                } else if (words.length >= minWords) {
                    counter.classList.add('text-green-600');
                    counter.classList.remove('text-orange-500', 'text-gray-700');
                } else {
                    counter.classList.add('text-gray-700');
                    counter.classList.remove('text-orange-500', 'text-green-600');
                }
            });
        };

        setupWordCounter('essay-input', 'word-count', 150);
        setupWordCounter('essay-input-2', 'word-count-2', 250);

        // Task toggle
        const btnGoToTask2 = document.getElementById('btn-go-to-task-2');
        const btnGoToTask1 = document.getElementById('btn-go-to-task-1');
        const task1Prompt  = document.getElementById('task-1-prompt');
        const task2Prompt  = document.getElementById('task-2-prompt');
        const writingForm1 = document.getElementById('writing-form-1');
        const writingForm2 = document.getElementById('writing-form-2');

        btnGoToTask2?.addEventListener('click', () => {
            task1Prompt.classList.add('hidden');
            writingForm1.classList.add('hidden');
            writingForm1.classList.remove('flex');
            task2Prompt.classList.remove('hidden');
            writingForm2.classList.remove('hidden');
            writingForm2.classList.add('flex');
        });

        btnGoToTask1?.addEventListener('click', () => {
            task2Prompt.classList.add('hidden');
            writingForm2.classList.add('hidden');
            writingForm2.classList.remove('flex');
            task1Prompt.classList.remove('hidden');
            writingForm1.classList.remove('hidden');
            writingForm1.classList.add('flex');
        });

        // Timer
        let timeLeft = 60 * 60;
        const timerEl = document.getElementById('time-remaining');
        setInterval(() => {
            if (timeLeft > 0) {
                timeLeft--;
                const m = Math.floor(timeLeft / 60);
                const s = timeLeft % 60;
                timerEl.innerHTML = `<svg class="w-5 h-5 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> ${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`;
                if (timeLeft < 300) {
                    timerEl.classList.replace('bg-indigo-50','bg-red-50');
                    timerEl.classList.replace('text-indigo-700','text-red-700');
                    timerEl.classList.replace('border-indigo-100','border-red-200');
                }
            }
        }, 1000);
    });
</script>

</body>
</html>

@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 relative overflow-hidden py-8 font-sans">
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] rounded-full bg-indigo-200/40 blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] rounded-full bg-purple-200/30 blur-3xl"></div>
        <div class="absolute top-[20%] left-[20%] w-[300px] h-[300px] rounded-full bg-white blur-2xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 max-w-5xl">
        <div class="mb-8 flex items-center justify-between">
            <a href="{{ route('assignments.ielts-academic.listening.index') }}"
               class="inline-flex items-center text-gray-500 hover:text-indigo-600 transition-colors group text-sm font-medium tracking-wide">
                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center mr-3 group-hover:bg-white transition-all">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>
                <span>Back to Skills</span>
            </a>
            <div class="text-gray-500 text-xs font-bold tracking-widest uppercase">IELTS Listening • Warm Up</div>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-800/10 ring-1 ring-white/10">
            <div class="px-6 md:px-12 pt-10 pb-4">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-4 py-1.5 rounded-lg text-sm font-bold bg-orange-500 text-white uppercase tracking-wider shadow-lg shadow-orange-500/30">Exercise 1.07</span>
                    <span class="text-slate-400 text-sm font-medium">Part 1</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 mb-3">
                    Direction Practice
                    <span class="block h-1 w-32 bg-orange-500 rounded-full mt-3"></span>
                </h1>
                <p class="text-slate-600 text-base md:text-lg max-w-2xl leading-relaxed">
                    Listen to the audio. Write down the <span class="text-amber-600 font-bold">direction phrases</span> and place instructions exactly as you hear them.
                </p>
            </div>

            <div class="p-6 md:px-10 md:pb-10 bg-white min-h-[400px] space-y-8">
                <form class="space-y-8">
                    <section class="rounded-2xl border border-indigo-100 bg-white p-5 md:p-6">
                        <h2 class="text-xl font-bold text-slate-900 mb-2">Part A: Map Labelling</h2>
                        <p class="text-slate-600 text-sm mb-5">Write the correct letters, <span class="font-bold">B-G</span>, next to Questions 1 and 2. 'A' is already given as an example.</p>

                        <div class="mb-5 rounded-xl border border-slate-200 bg-white p-3">
                            <img src="{{ asset('images/listening/warmup/direction/map-labelling.png') }}" alt="Map labelling worksheet" class="w-full rounded-lg object-contain">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center gap-3">
                                <label class="w-36 text-sm font-semibold text-slate-700">1. Katie's house</label>
                                <select name="q1" class="flex-1 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select</option>
                                    <option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option>
                                </select>
                            </div>
                            <div class="flex items-center gap-3">
                                <label class="w-36 text-sm font-semibold text-slate-700">2. Helen's house</label>
                                <select name="q2" class="flex-1 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select</option>
                                    <option>B</option><option>C</option><option>D</option><option>E</option><option>F</option><option>G</option>
                                </select>
                            </div>
                        </div>
                    </section>

                    <section class="rounded-2xl border border-amber-100 bg-white p-5 md:p-6">
                        <h2 class="text-xl font-bold text-slate-900 mb-2">Part B: Prepositional Phrases</h2>
                        <p class="text-slate-600 text-sm mb-5">Write the prepositional phrases next to the correct pictures (a-h).</p>

                        <div class="mb-5 rounded-xl border border-slate-200 bg-white p-3">
                            <img src="{{ asset('images/listening/warmup/direction/prepositional-phrases.png') }}" alt="Prepositional phrase worksheet" class="w-full rounded-lg object-contain">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(range('a','h') as $label)
                            <div class="flex items-center gap-3">
                                <label class="w-12 text-sm font-semibold text-slate-700 uppercase">{{ $label }}.</label>
                                <input type="text" name="q_pre_{{ $label }}" class="flex-1 rounded-lg border-slate-300 focus:border-amber-500 focus:ring-amber-500" placeholder="X is ...">
                            </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="rounded-2xl border border-emerald-100 bg-white p-5 md:p-6">
                        <h2 class="text-xl font-bold text-slate-900 mb-2">Part C: Direction Phrases</h2>
                        <p class="text-slate-600 text-sm mb-5">Write the phrases next to the correct pictures (a-k).</p>

                        <div class="mb-5 rounded-xl border border-slate-200 bg-white p-3 overflow-x-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 980 1480" width="980" height="1480" class="min-w-[860px] w-full rounded-lg bg-white" role="img" aria-label="Direction phrases worksheet a to k">
                                <defs>
                                    <marker id="arrowHead" markerWidth="10" markerHeight="10" refX="8" refY="3" orient="auto" markerUnits="strokeWidth">
                                        <path d="M0,0 L0,6 L9,3 z" fill="#111827"></path>
                                    </marker>
                                </defs>

                                <text x="20" y="42" font-size="18" fill="#111827" font-style="italic">Write the phrases next to the correct pictures below.</text>

                                <!-- a -->
                                <text x="26" y="112" font-size="28" fill="#374151">a.</text>
                                <ellipse cx="210" cy="100" rx="115" ry="70" fill="none" stroke="#6b7280" stroke-width="2"></ellipse>
                                <text x="200" y="58" font-size="22" fill="#374151">N</text>
                                <text x="122" y="106" font-size="22" fill="#374151">W</text>
                                <text x="202" y="148" font-size="22" fill="#374151">S</text>
                                <line x1="175" y1="100" x2="260" y2="100" stroke="#111827" stroke-width="4" marker-end="url(#arrowHead)"></line>
                                <line x1="360" y1="100" x2="790" y2="100" stroke="#94a3b8" stroke-width="1.5"></line>

                                <!-- b -->
                                <text x="26" y="236" font-size="28" fill="#374151">b.</text>
                                <ellipse cx="210" cy="220" rx="115" ry="70" fill="none" stroke="#6b7280" stroke-width="2"></ellipse>
                                <text x="200" y="178" font-size="22" fill="#374151">N</text>
                                <text x="281" y="226" font-size="22" fill="#374151">E</text>
                                <text x="202" y="268" font-size="22" fill="#374151">S</text>
                                <line x1="245" y1="220" x2="160" y2="220" stroke="#111827" stroke-width="4" marker-end="url(#arrowHead)"></line>
                                <line x1="360" y1="220" x2="790" y2="220" stroke="#94a3b8" stroke-width="1.5"></line>

                                <!-- c -->
                                <text x="26" y="360" font-size="28" fill="#374151">c.</text>
                                <ellipse cx="210" cy="340" rx="115" ry="70" fill="none" stroke="#6b7280" stroke-width="2"></ellipse>
                                <text x="122" y="346" font-size="22" fill="#374151">W</text>
                                <text x="282" y="346" font-size="22" fill="#374151">E</text>
                                <text x="202" y="388" font-size="22" fill="#374151">S</text>
                                <line x1="210" y1="375" x2="210" y2="285" stroke="#111827" stroke-width="4" marker-end="url(#arrowHead)"></line>
                                <line x1="360" y1="340" x2="790" y2="340" stroke="#94a3b8" stroke-width="1.5"></line>

                                <!-- d -->
                                <text x="26" y="484" font-size="28" fill="#374151">d.</text>
                                <ellipse cx="210" cy="460" rx="115" ry="70" fill="none" stroke="#6b7280" stroke-width="2"></ellipse>
                                <text x="200" y="418" font-size="22" fill="#374151">N</text>
                                <text x="122" y="466" font-size="22" fill="#374151">W</text>
                                <text x="282" y="466" font-size="22" fill="#374151">E</text>
                                <line x1="210" y1="425" x2="210" y2="515" stroke="#111827" stroke-width="4" marker-end="url(#arrowHead)"></line>
                                <line x1="360" y1="460" x2="790" y2="460" stroke="#94a3b8" stroke-width="1.5"></line>

                                <!-- e -->
                                <text x="26" y="608" font-size="28" fill="#374151">e.</text>
                                <rect x="95" y="558" width="230" height="84" fill="none" stroke="#6b7280" stroke-width="2"></rect>
                                <line x1="140" y1="600" x2="280" y2="600" stroke="#111827" stroke-width="4" marker-end="url(#arrowHead)"></line>
                                <line x1="360" y1="600" x2="790" y2="600" stroke="#94a3b8" stroke-width="1.5"></line>

                                <!-- f -->
                                <text x="26" y="752" font-size="28" fill="#374151">f.</text>
                                <rect x="95" y="680" width="230" height="130" fill="none" stroke="#6b7280" stroke-width="2"></rect>
                                <path d="M95 745 H325 M210 680 V810" stroke="#9ca3af" stroke-width="2" fill="none"></path>
                                <path d="M230 785 V735 Q230 720 210 720 H160" stroke="#111827" stroke-width="10" fill="none" marker-end="url(#arrowHead)"></path>
                                <line x1="360" y1="745" x2="790" y2="745" stroke="#94a3b8" stroke-width="1.5"></line>

                                <!-- g -->
                                <text x="26" y="896" font-size="28" fill="#374151">g.</text>
                                <rect x="95" y="824" width="230" height="130" fill="none" stroke="#6b7280" stroke-width="2"></rect>
                                <path d="M95 889 H325 M210 824 V954" stroke="#9ca3af" stroke-width="2" fill="none"></path>
                                <path d="M190 929 V879 Q190 864 210 864 H262" stroke="#111827" stroke-width="10" fill="none" marker-end="url(#arrowHead)"></path>
                                <line x1="360" y1="889" x2="790" y2="889" stroke="#94a3b8" stroke-width="1.5"></line>

                                <!-- h -->
                                <text x="26" y="1040" font-size="28" fill="#374151">h.</text>
                                <rect x="95" y="968" width="230" height="130" fill="none" stroke="#6b7280" stroke-width="2"></rect>
                                <path d="M95 1033 H325 M210 968 V1098" stroke="#9ca3af" stroke-width="2" fill="none"></path>
                                <line x1="210" y1="1078" x2="210" y2="995" stroke="#111827" stroke-width="10" marker-end="url(#arrowHead)"></line>
                                <line x1="360" y1="1033" x2="790" y2="1033" stroke="#94a3b8" stroke-width="1.5"></line>

                                <!-- i -->
                                <text x="26" y="1184" font-size="28" fill="#374151">i.</text>
                                <rect x="185" y="1118" width="70" height="130" fill="none" stroke="#6b7280" stroke-width="2"></rect>
                                <line x1="220" y1="1228" x2="220" y2="1140" stroke="#111827" stroke-width="4" marker-end="url(#arrowHead)"></line>
                                <line x1="360" y1="1183" x2="790" y2="1183" stroke="#94a3b8" stroke-width="1.5"></line>

                                <!-- j -->
                                <text x="26" y="1328" font-size="28" fill="#374151">j.</text>
                                <rect x="185" y="1262" width="70" height="130" fill="none" stroke="#6b7280" stroke-width="2"></rect>
                                <line x1="220" y1="1282" x2="220" y2="1370" stroke="#111827" stroke-width="4" marker-end="url(#arrowHead)"></line>
                                <line x1="360" y1="1327" x2="790" y2="1327" stroke="#94a3b8" stroke-width="1.5"></line>

                                <!-- k -->
                                <text x="26" y="1468" font-size="28" fill="#374151">k.</text>
                                <rect x="95" y="1402" width="290" height="72" fill="none" stroke="#6b7280" stroke-width="2"></rect>
                                <text x="235" y="1432" font-size="28" fill="#374151">X</text>
                                <line x1="140" y1="1450" x2="325" y2="1450" stroke="#111827" stroke-width="5" marker-end="url(#arrowHead)"></line>
                                <line x1="400" y1="1450" x2="790" y2="1450" stroke="#94a3b8" stroke-width="1.5"></line>
                            </svg>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach(range('a','k') as $label)
                            <div class="flex items-center gap-3">
                                <label class="w-12 text-sm font-semibold text-slate-700 uppercase">{{ $label }}.</label>
                                <input type="text" name="q_dir_{{ $label }}" class="flex-1 rounded-lg border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Type phrase...">
                            </div>
                            @endforeach
                        </div>
                    </section>
                </form>
            </div>

            <div class="bg-white border-t border-slate-100 p-6 md:px-12 md:py-8 flex justify-between items-center">
                <button type="button" class="text-slate-400 hover:text-slate-600 text-base font-medium transition-colors">
                    Reset Form
                </button>
                <button type="button" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg shadow-lg shadow-orange-500/30 text-base font-bold tracking-wide transition-all transform hover:-translate-y-0.5 hover:shadow-xl">
                    Submit Answers
                </button>
            </div>

            <div id="transcriptDrawer" class="hidden border-t border-slate-100 bg-white p-6 md:p-8 animate-slide-down">
               <div class="max-w-3xl mx-auto prose prose-sm text-slate-600">
                    <h3 class="text-slate-900 mb-2">Transcript</h3>
                    <p class="italic text-slate-500">Transcript content will appear here if available.</p>
               </div>
            </div>
        </div>
    </div>

    <div class="h-24"></div>

    @include('assignments.ielts.listening.partials.audio-player', ['set' => 1, 'fixed' => true])
</div>

@push('scripts')
<style>
    @keyframes slide-down {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-down {
        animation: slide-down 0.3s ease-out forwards;
    }
</style>
@endpush

@endsection

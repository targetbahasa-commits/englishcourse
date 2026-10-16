<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Reading Mock Test {{ $testId }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body { height: 100%; overflow: hidden; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .dotted-answer { border-bottom: 1px dotted #000; display: inline-block; min-width: 120px; }

        .reading-fixed-shell {
            position: fixed;
            top: 0;
            bottom: 0;
            right: 0;
            left: 0;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @media (min-width: 768px) {
            .reading-fixed-shell {
                left: var(--student-sidebar-offset, var(--admin-sidebar-offset, var(--teacher-sidebar-offset, var(--program-sidebar-offset, 0px))));
            }
            body.has-student-sidebar .reading-fixed-shell {
                left: var(--student-sidebar-offset, 16rem);
            }
            body.has-student-sidebar.sidebar-collapsed .reading-fixed-shell {
                left: var(--student-sidebar-offset, 4rem);
            }
            body.has-admin-sidebar .reading-fixed-shell {
                left: var(--admin-sidebar-offset, 16rem);
            }
            body.has-admin-sidebar.sidebar-collapsed .reading-fixed-shell {
                left: var(--admin-sidebar-offset, 3.5rem);
            }
            body.has-teacher-sidebar .reading-fixed-shell {
                left: var(--teacher-sidebar-offset, 16rem);
            }
            body.has-teacher-sidebar.sidebar-collapsed .reading-fixed-shell {
                left: var(--teacher-sidebar-offset, 4rem);
            }
            body.program-sidebar-open .reading-fixed-shell {
                left: 18rem;
            }
            body.program-sidebar-collapsed .reading-fixed-shell {
                left: 4rem;
            }
            body.sidebar-collapsed .reading-fixed-shell {
                left: 4rem;
            }
            body:has(#sidebar.w-64) .reading-fixed-shell,
            body:has(aside.w-64) .reading-fixed-shell {
                left: 16rem;
            }
            body:has(#sidebar.w-72) .reading-fixed-shell,
            body:has(aside.w-72) .reading-fixed-shell {
                left: 18rem;
            }
            body:has(#sidebar.w-16) .reading-fixed-shell,
            body:has(#sidebar.w-14) .reading-fixed-shell,
            body:has(aside.w-16) .reading-fixed-shell,
            body:has(aside.w-14) .reading-fixed-shell {
                left: 4rem;
            }
        }
        @media (max-width: 767px) {
            .reading-fixed-shell {
                left: 0 !important;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-white">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')

{{-- Fixed full-screen layout --}}
<div class="reading-fixed-shell bg-white flex flex-col font-sans z-0">

    {{-- Top header --}}
    <div class="flex-none bg-white border-b border-gray-200 shadow-sm z-10">
        <div class="px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-2.5 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">IELTS Reading – Mock Test {{ $testId }}</h1>
                    <p class="text-sm text-gray-500">Cambridge IELTS Reading Practice</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isTeacher()))
                <form action="{{ route('assignments.ielts-academic.mockup.cambridge.toggle-submit') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            title="Klik untuk mengubah status tombol submit bagi semua siswa"
                            class="px-3.5 py-1.5 text-xs font-semibold rounded-lg flex items-center gap-2 transition shadow-sm border {{ ($submitEnabled ?? true) ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border-emerald-300' : 'bg-rose-50 text-rose-700 hover:bg-rose-100 border-rose-300' }}">
                        <span class="w-2.5 h-2.5 rounded-full {{ ($submitEnabled ?? true) ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                        <span>Tombol Submit: <strong>{{ ($submitEnabled ?? true) ? 'Aktif' : 'Nonaktif' }}</strong></span>
                    </button>
                </form>
                @endif
                <button type="button"
                        onclick="window.openReadingDictionary ? window.openReadingDictionary() : window.dispatchEvent(new CustomEvent('open-reading-dict', { detail: { word: '' } }))"
                        title="Buka Kamus (Dictionary & Thesaurus)"
                        class="px-3.5 py-1.5 text-xs font-semibold rounded-lg flex items-center gap-1.5 transition shadow-sm border border-emerald-200 bg-emerald-50 text-emerald-800 hover:bg-emerald-100 hover:border-emerald-300">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span>Dictionary</span>
                </button>
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId]) }}" class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back
                </a>
            </div>
        </div>
        @if(session('success'))
        <div class="bg-emerald-50 border-t border-emerald-200 px-6 py-2 text-xs text-emerald-700 font-semibold flex items-center justify-between">
            <span>{{ session('success') }}</span>
        </div>
        @endif
    </div>

    {{-- Split screen --}}
    <div class="flex-1 min-h-0 grid overflow-hidden" style="grid-template-columns: 2.5fr 2fr;">

        {{-- LEFT: Reading Passage --}}
        <div class="h-full overflow-y-auto bg-gray-50 border-r border-gray-200 custom-scrollbar relative" id="passage-pane">

            <div class="px-4 sm:px-6 md:px-8 py-8 pb-32 w-full relative">

                {{-- READING header --}}
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest shadow-sm">READING</span>
                </div>

                {-- Passage 1 Card --}
                <div id="passage-1" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mb-8 relative group"
                     x-data="{
                         translateMode: false,
                         highlightMode: false,
                         pencilMode: false,
                         eraserMode: false,
                         highlightColor: 'yellow',
                         canvasObj: null
                     }"
                     x-init="
                         $watch('pencilMode', value => {
                             if (value && !canvasObj) { canvasObj = window.initDrawingCanvas($refs.drawingCanvas); }
                             if (value && canvasObj) canvasObj.setMode('draw');
                         });
                         $watch('eraserMode', value => {
                             if (value && !canvasObj) { canvasObj = window.initDrawingCanvas($refs.drawingCanvas); }
                             if (value && canvasObj) canvasObj.setMode('erase');
                         });
                         new ResizeObserver(() => { window.initDrawingCanvas($refs.drawingCanvas).resize(); }).observe($el);
                     "
                >
                    {-- Drawing canvas for Passage 1 --}
                    <canvas x-ref="drawingCanvas"
                            class="absolute inset-0 w-full h-full z-10 rounded-2xl"
                            :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'">
                    </canvas>

                    <div class="relative z-20" :class="pencilMode ? 'pointer-events-none' : ''">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                            <span class="bg-pink-50 text-pink-600 font-bold px-3 py-1 rounded-lg text-sm tracking-wide uppercase">READING PASSAGE 1</span>
                        </div>

<p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong>, which are based on Reading Passage 1 below.</p>

                    <h3 class="text-3xl font-bold text-center text-gray-900 mb-8 mt-4">The kākāpō</h3>


                    {{-- Passage text --}}
                    <div class="passage-content text-[16px] leading-[1.8] text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">
                         
                        <p class="italic font-bold text-center text-lg mb-6 max-w-2xl mx-auto text-gray-700">The kākāpō is a nocturnal, flightless parrot that is critically endangered and one of New Zealand's unique treasures</p>

                        <p>The kākāpō, also known as the owl parrot, is a large, forest-dwelling bird, with a pale owl-like face. Up to 64 cm in length, it has predominantly yellow-green feathers, forward-facing eyes, a large grey beak, large blue feet, and relatively short wings and tail. It is the world's only flightless parrot, and is also possibly one of the world's longest-living birds, with a reported lifespan of up to 100 years.</p>
                        
                        <p>Kākāpō are solitary birds and tend to occupy the same home range for many years. They forage on the ground and climb high into trees. They often leap from trees and flap their wings, but at best manage a controlled descent to the ground. They are entirely vegetarian, with their diet including the leaves, roots and bark of trees as well as bulbs, and fern fronds.</p>
                        
                        <p>Kākāpō breed in summer and autumn, but only in years when food is plentiful. Males play no part in incubation or chick-rearing – females alone incubate eggs and feed the chicks. The 1–4 eggs are laid in soil, which is repeatedly turned over before and during incubation. The female kākāpō has to spend long periods away from the nest searching for food, which leaves the unattended eggs and chicks particularly vulnerable to predators.</p>
                        
                        <p>Before humans arrived, kākāpō were common throughout New Zealand's forests. However, this all changed with the arrival of the first Polynesian settlers about 700 years ago. For the early settlers, the flightless kākāpō was easy prey. They ate its meat and used its feathers to make soft cloaks. With them came the Polynesian dog and rat, which also preyed on kākāpō. By the time European colonisers arrived in the early 1800s, kākāpō had become confined to the central North Island and forested parts of the South Island. The fall in kākāpō numbers was accelerated by European colonisation. A great deal of habitat was lost through forest clearance, and introduced species such as deer depleted the remaining forests of food. Other predators such as cats, stoats and two more species of rat were also introduced. The kākāpō were in serious trouble.</p>

                        <p>In 1894, the New Zealand government launched its first attempt to save the kākāpō. Conservationist Richard Henry led an effort to relocate several hundred of the birds to predator-free Resolution Island in Fiordland. Unfortunately, the island didn't remain predator free – stoats arrived within six years, eventually destroying the kākāpō population. By the mid-1900s, the kākāpō was practically a lost species. Only a few clung to life in the most isolated parts of New Zealand.</p>
                        
                        <p>From 1949 to 1973, the newly formed New Zealand Wildlife Service made over 60 expeditions to find kākāpō, focusing mainly on Fiordland. Six were caught, but there were no females amongst them and all but one died within a few months of captivity. In 1974, a new initiative was launched, and by 1977, 18 more kākāpō were found in Fiordland. However, there were still no females. In 1977, a large population of males was spotted in Rakiura – a large island free from stoats, ferrets and weasels. There were about 200 individuals, and in 1980 it was confirmed females were also present. These birds have been the foundation of all subsequent work in managing the species.</p>
                        
                        <p>Unfortunately, predation by feral cats on Rakiura Island led to a rapid decline in kākāpō numbers. As a result, during 1980–97, the surviving population was evacuated to three island sanctuaries: Codfish Island, Maud Island and Little Barrier Island. However, breeding success was hard to achieve. Rats were found to be a major predator of kākāpō chicks and an insufficient number of chicks survived to offset adult mortality. By 1995, although at least 12 chicks had been produced on the islands, only three had survived. The kākāpō population had dropped to 51 birds. The critical situation prompted an urgent review of kākāpō management in New Zealand.</p>
                        
                        <p>In 1996, a new Recovery Plan was launched, together with a specialist advisory group called the Kākāpō Scientific and Technical Advisory Committee and a higher amount of funding. Renewed steps were taken to control predators on the three islands. Cats were eradicated from Little Barrier Island in 1980, and possums were eradicated from Codfish Island by 1986. However, the population did not start to increase until rats were removed from all three islands, and the birds were more intensively managed. This involved moving the birds between islands, supplementary feeding of adults and rescuing and hand-raising any failing chicks.</p>
                        
                        <p>After the first five years of the Recovery Plan, the population was on target. By 2000, five new females had been produced, and the total population had grown to 62 birds. For the first time, there was cautious optimism for the future of kākāpō and by June 2020, a total of 210 birds was recorded.</p>
                        
                        <p>Today, kākāpō management continues to be guided by the kākāpō Recovery Plan. Its key goals are: minimise the loss of genetic diversity in the kākāpō population, restore or maintain sufficient habitat to accommodate the expected increase in the kākāpō population, and ensure stakeholders continue to be fully engaged in the preservation of the species.</p>

                        {-- Floating Toolbar for Passage 1 --}
                        @include('assignments.ielts.mockup.partials.reading-toolbar')
                    </div>
                </div>

                {-- Passage 2 Card --}
                <div id="passage-2" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mb-8 relative group"
                     x-data="{
                         translateMode: false,
                         highlightMode: false,
                         pencilMode: false,
                         eraserMode: false,
                         highlightColor: 'yellow',
                         canvasObj: null
                     }"
                     x-init="
                         $watch('pencilMode', value => {
                             if (value && !canvasObj) { canvasObj = window.initDrawingCanvas($refs.drawingCanvas); }
                             if (value && canvasObj) canvasObj.setMode('draw');
                         });
                         $watch('eraserMode', value => {
                             if (value && !canvasObj) { canvasObj = window.initDrawingCanvas($refs.drawingCanvas); }
                             if (value && canvasObj) canvasObj.setMode('erase');
                         });
                         new ResizeObserver(() => { window.initDrawingCanvas($refs.drawingCanvas).resize(); }).observe($el);
                     "
                >
                    {-- Drawing canvas for Passage 2 --}
                    <canvas x-ref="drawingCanvas"
                            class="absolute inset-0 w-full h-full z-10 rounded-2xl"
                            :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'">
                    </canvas>

                    <div class="relative z-20" :class="pencilMode ? 'pointer-events-none' : ''">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                            <span class="bg-pink-50 text-pink-600 font-bold px-3 py-1 rounded-lg text-sm tracking-wide uppercase">READING PASSAGE 2</span>
                        </div>

<p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 below.</p>

                    <h3 class="text-3xl font-bold text-center text-gray-900 mb-8 mt-4">Reintroducing elms to Britain</h3>
                    
                    <p class="text-center italic text-gray-700 mb-8 font-serif">Mark Rowe investigates attempts to reintroduce elms to Britain</p>

                    <div class="passage-content text-[16px] leading-[1.8] text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">
                         
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none text-lg">A</span>
                            <p>Around 25 million elms, accounting for 90% of all elm trees in the UK, died during the 1960s and '70s of Dutch elm disease. In the aftermath, the elm, once so dominant in the British landscape, was largely forgotten. However, there's now hope the elm may be reintroduced to the countryside of central and southern England. Any reintroduction will start from a very low base. 'The impact of the disease is difficult to picture if you hadn't seen what was there before,' says Matt Elliot of the Woodland Trust. 'You look at old photographs from the 1960s and it's only then that you realise the impact [elms had] ... They were significant, large trees ... then they were gone.'</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none text-lg">B</span>
                            <p>The disease is caused by a fungus that blocks the elms' vascular (water, nutrient and food transport) system, causing branches to wilt and die. A first epidemic, which occurred in the 1920s, gradually died down, but in the '70s a second epidemic was triggered by shipments of elm from Canada. The wood came in the form of logs destined for boat building and its intact bark was perfect for the elm bark beetles that spread the deadly fungus. This time, the beetles carried a much more virulent strain that destroyed the vast majority of British elms.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none text-lg">C</span>
                            <p>Today, elms still exist in the southern English countryside but mostly only in low hedgerows between fields. 'We have millions of small elms in hedgerows but they get targeted by the beetle as soon as they reach a certain size,' says Karen Russell, co-author of the report 'Where we are with elm'. Once the trunk of the elm reaches 10–15 centimetres or so in diameter, it becomes a perfect size for beetles to lay eggs and for the fungus to take hold. Yet mature specimens have been identified, in counties such as Cambridgeshire, that are hundreds of years old, and have mysteriously escaped the epidemic.<br><br>The key, Russell says, is to identify and study those trees that have survived and work out why they stood tall when millions of others succumbed. Nevertheless, opportunities are limited as the number of these mature survivors is relatively small. 'What are the reasons for their survival?' asks Russell. 'Avoidance, tolerance, resistance? We don't know where the balance lies between the three. I don't see how it can be entirely down to luck.'</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none text-lg">D</span>
                            <p>For centuries, elm ran a close second to oak as the hardwood tree of choice in Britain and was in many instances the most prominent tree in the landscape. Not only was elm common in European forests, it became a key component of birch, ash and hazel woodlands. The use of elm is thought to go back to the Bronze Age, when it was widely used for tools. Elm was also the preferred material for shields and early swords. In the 18th century, it was planted more widely and its wood was used for items such as storage crates and flooring. It was also suitable for items that experienced high levels of impact and was used to build the keel of the 19th-century sailing ship Cutty Sark as well as mining equipment.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none text-lg">E</span>
                            <p>Given how ingrained elm is in British culture, it's unsurprising the tree has many advocates. Amongst them is Peter Bourne of the National Elm Collection in Brighton. 'I saw Dutch elm disease unfold as a small boy,' he says. 'The elm seemed to be part of rural England, but I remember watching trees just lose their leaves and that really stayed with me.' Today, the city of Brighton's elms total about 17,000. Local factors appear to have contributed to their survival. Strong winds from the sea make it difficult for the determined elm bark beetle to attack this coastal city's elm population. However, the situation is precarious. 'The beetles can just march in if we're not careful, as the threat is right on our doorstep,' says Bourne.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none text-lg">F</span>
                            <p>Any prospect of the elm returning relies heavily on trees being either resistant to, or tolerant of, the disease. This means a widespread reintroduction would involve existing or new hybrid strains derived from resistant, generally non-native elm species. A new generation of seedlings have been bred and tested to see if they can withstand the fungus by cutting a small slit on the bark and injecting a tiny amount of the pathogen. 'The effects are very quick,' says Russell. 'You return in four to six weeks and trees that are resistant show no symptoms, whereas those that are susceptible show leaf loss and may even have died completely.'</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none text-lg">G</span>
                            <p>All of this raises questions of social acceptance, acknowledges Russell. 'If we're putting elm back into the landscape, a small element of it is not native – are we bothered about that?' For her, the environmental case for reintroducing elm is strong. 'They will host wildlife, which is a good thing.' Others are more wary. 'On the face of it, it seems like a good idea,' says Elliot. The problem, he suggests, is that, 'You're replacing a native species with a horticultural analogue*. You're effectively cloning.' There's also the risk of introducing new diseases. Rather than plant new elms, the Woodland Trust emphasises providing space to those elms that have survived independently. 'Sometimes the best thing you can do is just give nature time to recover ... over time, you might get resistance,' says Elliot.<br><br>
                            <span class="text-sm italic">* horticultural analogue: a cultivated plant species that is genetically similar to an existing species</span></p>

                        {-- Floating Toolbar for Passage 2 --}
                        @include('assignments.ielts.mockup.partials.reading-toolbar')
                    </div>
                </div>

                {-- Passage 3 Card --}
                <div id="passage-3" class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 mb-8 relative group"
                     x-data="{
                         translateMode: false,
                         highlightMode: false,
                         pencilMode: false,
                         eraserMode: false,
                         highlightColor: 'yellow',
                         canvasObj: null
                     }"
                     x-init="
                         $watch('pencilMode', value => {
                             if (value && !canvasObj) { canvasObj = window.initDrawingCanvas($refs.drawingCanvas); }
                             if (value && canvasObj) canvasObj.setMode('draw');
                         });
                         $watch('eraserMode', value => {
                             if (value && !canvasObj) { canvasObj = window.initDrawingCanvas($refs.drawingCanvas); }
                             if (value && canvasObj) canvasObj.setMode('erase');
                         });
                         new ResizeObserver(() => { window.initDrawingCanvas($refs.drawingCanvas).resize(); }).observe($el);
                     "
                >
                    {-- Drawing canvas for Passage 3 --}
                    <canvas x-ref="drawingCanvas"
                            class="absolute inset-0 w-full h-full z-10 rounded-2xl"
                            :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'">
                    </canvas>

                    <div class="relative z-20" :class="pencilMode ? 'pointer-events-none' : ''">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                            <span class="bg-pink-50 text-pink-600 font-bold px-3 py-1 rounded-lg text-sm tracking-wide uppercase">READING PASSAGE 3</span>
                        </div>

<p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                    <h3 class="text-3xl font-bold text-center text-gray-900 mb-8 mt-4">How stress affects our judgement</h3>

                    <div class="passage-content text-[16px] leading-[1.8] text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">
                         
                        <p>Some of the most important decisions of our lives occur while we're feeling stressed and anxious. From medical decisions to financial and professional ones, we are all sometimes required to weigh up information under stressful conditions. But do we become better or worse at processing and using information under such circumstances?</p>

                        <p>My colleague and I, both neuroscientists, wanted to investigate how the mind operates under stress, so we visited some local fire stations. Firefighters' workdays vary quite a bit. Some are pretty relaxed; they'll spend their time washing the truck, cleaning equipment, cooking meals and reading. Other days can be hectic, with numerous life-threatening incidents to attend to; they'll enter burning homes to rescue trapped residents, and assist with medical emergencies. These ups and downs presented the perfect setting for an experiment on how people's ability to use information changes when they feel under pressure.</p>

                        <p>We found that perceived threat acted as a trigger for a stress reaction that made the task of processing information easier for the firefighters – but only as long as it conveyed bad news.</p>

                        <p>This is how we arrived at these results. We asked the firefighters to estimate their likelihood of experiencing 40 different adverse events in their life, such as being involved in an accident or becoming a victim of card fraud. We then gave them either good news (that their likelihood of experiencing these events was lower than they'd thought) or bad news (that it was higher) and asked them to provide new estimates.</p>

                        <p>People are normally quite optimistic – they will ignore bad news and embrace the good. This is what happened when the firefighters were relaxed; but when they were under stress, a different pattern emerged. Under these conditions, they became hyper-vigilant to bad news, even when it had nothing to do with their job (such as learning that the likelihood of card fraud was higher than they'd thought), and altered their beliefs in response. In contrast, stress didn't change how they responded to good news (such as learning that the likelihood of card fraud was lower than they'd thought).</p>

                        <p>Back in our lab, we observed the same pattern in students who were told they had to give a surprise public speech, which would be judged by a panel, recorded and posted online. Sure enough, their cortisol levels spiked, their heart rates went up and they suddenly became better at processing unrelated, yet alarming, information about rates of disease and violence.</p>

                        <p>When we experience stressful events, a physiological change is triggered that causes us to take in warnings and focus on what might go wrong. Brain imaging reveals that this 'switch' is related to a sudden boost in a neural signal important for learning, specifically in response to unexpected warning signs, such as faces expressing fear.</p>

                        <p>Such neural engineering could have helped prehistoric humans to survive. When our ancestors found themselves surrounded by hungry animals, they would have benefited from an increased ability to learn about hazards. In a safe environment, however, it would have been wasteful to be on high alert constantly. So, a neural switch that automatically increases or decreases our ability to process warnings in response to changes in our environment could have been useful. In fact, people with clinical depression and anxiety seem unable to switch away from a state in which they absorb all the negative messages around them.</p>

                        <p>It is also important to realise that stress travels rapidly from one person to the next. If a co-worker is stressed, we are more likely to tense up and feel stressed ourselves. We don't even need to be in the same room with someone for their emotions to influence our behaviour. Studies show that if we observe positive feeds on social media, such as images of a pink sunset, we are more likely to post uplifting messages ourselves. If we observe negative posts, such as complaints about a long queue at the coffee shop, we will in turn create more negative posts.</p>

                        <p>In some ways, many of us now live as if we are in danger, constantly ready to tackle demanding emails and text messages, and respond to news alerts and comments on social media. Repeatedly checking your phone, according to a survey conducted by the American Psychological Association, is related to stress. In other words, a pre-programmed physiological reaction, which evolution has equipped us with to help us avoid famished predators, is now being triggered by an online post. Social media posting, according to one study, raises your pulse, makes you sweat, and enlarges your pupils more than most daily activities.</p>

                        <p>The fact that stress increases the likelihood that we will focus more on alarming messages, together with the fact that it spreads extremely rapidly, can create collective fear that is not always justified. After a stressful public event, such as a natural disaster or major financial crash, there is often a wave of alarming information in traditional and social media, which individuals become very aware of. But that has the effect of exaggerating existing danger. And so, a reliable pattern emerges – stress is triggered, spreading from one person to the next, which temporarily enhances the likelihood that people will take in negative reports, which increases stress further. As a result, trips are cancelled, even if the disaster took place across the globe; stocks are sold, even when holding on is the best thing to do.</p>

                        <p>The good news, however, is that positive emotions, such as hope, are contagious too, and are powerful in inducing people to act to find solutions. Being aware of the close relationship between people's emotional state and how they process information can help us frame our messages more effectively and become conscientious agents of change.</p>

                        {-- Floating Toolbar for Passage 3 --}
                        @include('assignments.ielts.mockup.partials.reading-toolbar')
                    </div>
                </div>

            </div>
        </div>

        {{-- RIGHT: Questions --}}
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar" id="questions-panel">
            <div class="px-4 sm:px-6 md:px-8 py-8 pb-24 w-full relative">

{{-- Questions 1–6: True/False/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–6</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 1?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 1–6 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-white">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic">TRUE</span></div><div class="italic">if the statement agrees with the information</div>
                            <div><span class="font-bold italic">FALSE</span></div><div class="italic">if the statement contradicts the information</div>
                            <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if there is no information on this</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mt-2">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-white border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-36 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [1, "There are other parrots that share the kakapo's inability to fly."],
                                    [2, "Adult kakapo produce chicks every year."],
                                    [3, "Adult male kakapo bring food back to nesting females."],
                                    [4, "The Polynesian rat was a greater threat to the kakapo than Polynesian settlers."],
                                    [5, "Kakapo were transferred from Rakiura Island to other locations because they were at risk from feral cats."],
                                    [6, "One Recovery Plan initiative that helped increase the kakapo population size was caring for struggling young birds."],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                <option value="TRUE">TRUE</option>
                                                <option value="FALSE">FALSE</option>
                                                <option value="NOT GIVEN">NOT GIVEN</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Questions 7–13: Note Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 7–13</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Choose <strong>ONE WORD AND/OR A NUMBER</strong> from the passage for each answer.</p>

                    <div class="border border-blue-200 bg-[#eef4fc] rounded-lg p-5 text-sm">
                        <h4 class="text-base font-bold text-center mb-5 text-gray-900">New Zealand's kākāpō</h4>

                        <p class="font-bold text-gray-900 mb-3">A type of parrot:</p>
                        <ul class="list-disc ml-5 space-y-4 mb-6">
                            <li class="text-gray-800">
                                diet consists of fern fronds, various parts of a tree and <span class="font-bold text-blue-700">7</span>
                                <input type="text" name="q7" class="border border-gray-300 rounded outline-none p-1.5 w-28 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1">
                            </li>
                            <li class="text-gray-800">
                                nests are created in <span class="font-bold text-blue-700">8</span>
                                <input type="text" name="q8" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1"> where eggs are laid.
                            </li>
                        </ul>

                        <p class="font-bold text-gray-900 mb-3">Arrival of Polynesian settlers</p>
                        <ul class="list-disc ml-5 space-y-4 mb-6">
                            <li class="text-gray-800">
                                the <span class="font-bold text-blue-700">9</span>
                                <input type="text" name="q9" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1"> of the kākāpō were used to make clothes.
                            </li>
                        </ul>

                        <p class="font-bold text-gray-900 mb-3">Arrival of European colonisers</p>
                        <ul class="list-disc ml-5 space-y-4 mb-6">
                            <li class="text-gray-800 flex flex-wrap items-center gap-y-2">
                                <span class="font-bold text-blue-700 mr-1">10</span>
                                <input type="text" name="q10" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mr-2"> 
                                were an animal which they introduced that ate the kākāpō's food sources.
                            </li>
                        </ul>
                    </div>

                    <div class="border border-blue-200 bg-[#eef4fc] rounded-lg p-5 text-sm mt-3 border-t-0 rounded-t-none">
                        <p class="font-bold text-gray-900 mb-3">Protecting kākāpō</p>
                        <ul class="list-disc ml-5 space-y-4">
                            <li class="text-gray-800">
                                Richard Henry, a conservationist, tried to protect the kākāpō.
                            </li>
                            <li class="text-gray-800 flex flex-wrap items-center gap-y-2">
                                a definite sighting of female kākāpō on Rakiura Island was reported in the year
                                <span class="font-bold text-blue-700 mx-1">11</span>
                                <input type="text" name="q11" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1"> .
                            </li>
                            <li class="text-gray-800">
                                the Recovery Plan included an increase in <span class="font-bold text-blue-700">12</span>
                                <input type="text" name="q12" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1"> .
                            </li>
                            <li class="text-gray-800 flex flex-wrap items-center gap-y-2">
                                a current goal of the Recovery Plan is to maintain the involvement of 
                                <span class="font-bold text-blue-700 mx-1">13</span>
                                <input type="text" name="q13" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1"> in kākāpō protection.
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- ── PASSAGE 2 Questions ── --}}
                <div class="mt-12 mb-6">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Q14-18: Matching Information --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–18</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 2 has seven sections, <strong>A–G</strong>.</p>
                    <p class="text-sm text-gray-800 mb-1">Which section contains the following information?</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–G</strong>, in boxes 14–18 on your answer sheet.</p>
                    <p class="text-sm font-bold text-gray-800 mb-4">NB <span class="font-normal italic">You may use any letter more than once.</span></p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-white border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Information</th>
                                    <th class="p-3 font-bold text-gray-600 w-28 text-center">Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [14, 'reference to the research problems that arise from there being only a few surviving large elms'],
                                    [15, 'details of a difference of opinion about the value of reintroducing elms to Britain'],
                                    [16, 'reference to how Dutch elm disease was brought into Britain'],
                                    [17, 'a description of the conditions that have enabled a location in Britain to escape Dutch elm disease'],
                                    [18, 'reference to the stage at which young elms become vulnerable to Dutch elm disease'],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                @foreach(['A','B','C','D','E','F','G'] as $section)
                                                <option value="{{ $section }}">{{ $section }}</option>
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Q19-23: Matching Features --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 19–23</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Look at the following statements (Questions 19–23) and the list of people below.</p>
                    <p class="text-sm text-gray-800 mb-1">Match each statement with the correct person, <strong>A, B, or C</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct letter, <strong>A, B, or C</strong>, in boxes 19–23 on your answer sheet.</p>
                    <p class="text-sm font-bold text-gray-800 mb-5">NB <span class="font-normal italic">You may use any letter more than once.</span></p>

                    {{-- List of people --}}
                    <div class="border border-gray-300 rounded-lg p-5 bg-white text-sm mb-6 w-full max-w-sm mx-auto block">
                        <p class="font-bold text-center mb-4 text-base">List of People</p>
                        <div class="space-y-3 pl-8">
                            <div class="flex"><span class="font-bold w-12">A</span> Matt Elliot</div>
                            <div class="flex"><span class="font-bold w-12">B</span> Karen Russell</div>
                            <div class="flex"><span class="font-bold w-12">C</span> Peter Bourne</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-white border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-28 text-center">Person</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [19, 'If a tree gets infected with Dutch elm disease, the damage rapidly becomes visible.'],
                                    [20, 'It may be better to wait and see if the mature elms that have survived continue to flourish.'],
                                    [21, 'There must be an explanation for the survival of some mature elms.'],
                                    [22, 'We need to be aware that insects carrying Dutch elm disease are not very far away.'],
                                    [23, 'You understand the effect Dutch elm disease has had when you see evidence of how prominent the tree once was.'],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- Q24-26: Summary Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 24–26</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>

                    <div class="border border-blue-200 bg-[#f8fafc] rounded-lg p-6 text-sm">
                        <h4 class="text-base font-bold text-center mb-5 text-gray-900">Uses of a popular tree</h4>
                        <div class="text-gray-800 leading-loose">
                            For hundreds of years, the only tree that was more popular in Britain than elm was 
                            <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">24</span>
                            <input type="text" name="q24" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1"> . 
                            Starting in the Bronze Age, many tools were made from elm and people also used it to make weapons. In the 18th century, it was grown to provide wood for boxes and 
                            <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">25</span>
                            <input type="text" name="q25" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1"> . 
                            Due to its strength, elm was often used for mining equipment and the Cutty Sark's 
                            <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">26</span>
                            <input type="text" name="q26" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1"> 
                            was also constructed from elm.
                        </div>
                    </div>
                </div>

                {{-- ── PASSAGE 3 Questions ── --}}
                <div class="mt-12 mb-6">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>

                {{-- Q27-30: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–30</strong></p>
                    <p class="text-sm text-gray-800 mb-4">Choose the correct letter, <strong>A, B, C or D</strong>.</p>

                    <div class="space-y-6">
                        @foreach([
                            [27, 'In the first paragraph, the writer introduces the topic of the text by', [
                                'A' => 'defining some commonly used terms.',
                                'B' => 'questioning a widely held assumption.',
                                'C' => 'mentioning a challenge faced by everyone.',
                                'D' => 'specifying a situation which makes us most anxious.'
                            ]],
                            [28, 'What point does the writer make about firefighters in the second paragraph?', [
                                'A' => 'The regular changes of stress levels in their working lives make them ideal study subjects.',
                                'B' => 'The strategies they use to handle stress are of particular interest to researchers.',
                                'C' => 'The stressful nature of their job is typical of many public service professions.',
                                'D' => 'Their personalities make them especially well-suited to working under stress.'
                            ]],
                            [29, 'What is the writer doing in the fourth paragraph?', [
                                'A' => 'explaining their findings',
                                'B' => 'justifying their approach',
                                'C' => 'setting out their objectives',
                                'D' => 'describing their methodology'
                            ]],
                            [30, 'In the seventh paragraph, the writer describes a mechanism in the brain which', [
                                'A' => 'enables people to respond more quickly to stressful situations.',
                                'B' => 'results in increased ability to control our levels of anxiety.',
                                'C' => 'produces heightened sensitivity to indications of external threats.',
                                'D' => 'is activated when there is a need to communicate a sense of danger.'
                            ]],
                        ] as [$num, $question, $options])
                        
                        <div class="mb-4">
                            <p class="font-bold text-gray-900 mb-3">{{ $num }} <span class="font-normal">{{ $question }}</span></p>
                            <div class="space-y-3 pl-6">
                                @foreach($options as $letter => $text)
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="mt-1 flex-none text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer">
                                    <span class="text-sm text-gray-800 group-hover:text-black mt-0.5"><strong class="mr-2">{{ $letter }}</strong> {{ $text }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Q31-35: Matching Features --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 31–35</strong></p>
                    <p class="text-sm text-gray-800 mb-4">Complete each sentence with the correct ending, <strong>A–G</strong>, below.</p>

                    {{-- List of endings --}}
                    <div class="border border-gray-300 rounded-lg p-5 bg-white text-sm mb-6 inline-block w-full">
                        <div class="space-y-3">
                            <div class="flex"><span class="font-bold w-12 shrink-0">A</span> made them feel optimistic.</div>
                            <div class="flex"><span class="font-bold w-12 shrink-0">B</span> took relatively little notice of bad news.</div>
                            <div class="flex"><span class="font-bold w-12 shrink-0">C</span> responded to negative and positive information in the same way.</div>
                            <div class="flex"><span class="font-bold w-12 shrink-0">D</span> were feeling under stress.</div>
                            <div class="flex"><span class="font-bold w-12 shrink-0">E</span> put them in a stressful situation.</div>
                            <div class="flex"><span class="font-bold w-12 shrink-0">F</span> behaved in a similar manner, regardless of the circumstances.</div>
                            <div class="flex"><span class="font-bold w-12 shrink-0">G</span> thought it more likely that they would experience something bad.</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-white border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Sentence Beginning</th>
                                    <th class="p-3 font-bold text-gray-600 w-28 text-center">Ending</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [31, 'At times when they were relaxed, the firefighters usually'],
                                    [32, 'The researchers noted that when the firefighters were stressed, they'],
                                    [33, 'When the firefighters were told good news, they always'],
                                    [34, 'The students\' cortisol levels and heart rates were affected when the researchers'],
                                    [35, 'In both experiments, negative information was processed better when the subjects'],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                @foreach(['A','B','C','D','E','F','G'] as $section)
                                                <option value="{{ $section }}">{{ $section }}</option>
                                                @endforeach
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                {{-- Q36-40: YES / NO / NOT GIVEN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 36–40</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the claims of the writer in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 36–40 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-white">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic">YES</span></div><div class="italic">if the statement agrees with the claims of the writer</div>
                            <div><span class="font-bold italic">NO</span></div><div class="italic">if the statement contradicts the claims of the writer</div>
                            <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if it is impossible to say what the writer thinks about this</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mt-2">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-white border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-36 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [36, 'The tone of the content we post on social media tends to reflect the nature of the posts in our feeds.'],
                                    [37, 'Phones have a greater impact on our stress levels than other electronic media devices.'],
                                    [38, 'The more we read about a stressful public event on social media, the less able we are to take the information in.'],
                                    [39, 'Stress created by social media posts can lead us to take unnecessary precautions.'],
                                    [40, 'Our tendency to be affected by other people\'s moods can be used in a positive way.'],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                <option value="YES">YES</option>
                                                <option value="NO">NO</option>
                                                <option value="NOT GIVEN">NOT GIVEN</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Final Submit --}}
                @if($submitEnabled ?? true)
                <div class="mt-6 flex justify-end">
                    <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                        Submit All Answers
                    </button>
                </div>
                @else
                <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-xl text-center text-sm text-amber-700 font-medium">
                    <svg class="w-5 h-5 inline-block mr-1 text-amber-500 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Fitur pengumpulan jawaban (Submit) dinonaktifkan sementara oleh Admin/Guru.
                </div>
                @endif

            </div>
        </div>

    </div>
</div>

@include('assignments.ielts.mockup.partials.reading-annotations')

@include('assignments.ielts.mockup.partials.reading-dictionary')
@include('assignments.ielts.mockup.partials.c20-reading-test-1-evaluator')
</body>
</html>

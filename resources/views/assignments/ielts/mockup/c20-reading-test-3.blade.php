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
            body:has(#sidebar.w-64) .reading-fixed-shell,
            body:has(aside.w-64) .reading-fixed-shell {
                left: 16rem;
            }
            body:has(#sidebar.w-16) .reading-fixed-shell,
            body:has(#sidebar.w-14) .reading-fixed-shell,
            body:has(aside.w-16) .reading-fixed-shell,
            body:has(aside.w-14) .reading-fixed-shell {
                left: 4rem;
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

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-2">Frozen Food</h3>
                    <h4 class="text-lg text-center text-gray-700 mb-6">A US perspective on the development of the frozen food industry</h4>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">
                        <p>At some point in history, humans discovered that ice preserved food. There is evidence that winter ice was stored to preserve food in the summer as far back as 10,000 years ago. Two thousand years ago, the inhabitants of South America's Andean mountains had a unique means of conserving potatoes for later consumption. They froze them overnight, then trampled them to squeeze out the moisture, then dried them in the sun. This preserved their nutritional value—if not their aesthetic appeal.</p>
                        <p>Natural ice remained the main form of refrigeration until late in the 19th century. In the early 1800s, ship owners from Boston, USA, had enormous blocks of Arctic ice towed all over the Atlantic for the purpose of food preservation. In 1851, railroads first began putting blocks of ice in insulated rail cars to send butter from Ogdensburg, New York, to Boston.</p>
                        <p>Finally, in 1870, Australian inventors found a way to make 'mechanical ice'. They used a compressor to force a gas—ammonia at first and later Freon—through a condenser. The compressed gas gave up some of its heat as it moved through the condenser. Then the gas was released quickly into a low-pressure evaporator coil where it became liquid and cold. Air was blown over the evaporator coil and then this cooled air passed into an insulated compartment, lowering its temperature to freezing point.</p>
                        <p>Initially, this process was invented to keep Australian beer cool even in hot weather. But Australian cattlemen were quick to realize that, if they could put this new invention on a ship, they could export meat across the oceans. In 1880, a shipment of Australian beef and mutton was sent, frozen, to England. While the food frozen this way was still palatable, there was some deterioration. During the freezing process, crystals formed within the cells of the food, and when the ice expanded and the cells burst, this spoilt the flavor and texture of the food.</p>
                        <p>The modern frozen food industry began with the indigenous Inuit people of Canada. In 1912, a biology student in Massachusetts, USA, named Clarence Birdseye, ran out of money and went to Labrador in Canada to trap and trade furs. While he was there, he became fascinated with how the Inuit would quickly freeze fish in the Arctic air. The fish looked and tasted fresh even months later.</p>
                        <p>Birdseye returned to the USA in 1917 and began developing mechanical freezers capable of quick-freezing food. Birdseye methodically kept inventing better freezers and gradually built a business selling frozen fish from Gloucester, Massachusetts. In 1929, his business was sold and became General Foods, but he stayed with the company as director of research, and his division continued to innovate.</p>
                        <p>Birdseye was responsible for several key innovations that made the frozen food industry possible. He developed quick-freezing techniques that reduced the damage that crystals caused, as well as the technique of freezing the product in the package it was to be sold in. He also introduced the use of cellophane, the first transparent material for food packaging, which allowed consumers to see the quality of the product. Birdseye products also came in convenient size packages that could be prepared with a minimum of effort.</p>
                        <p>But there were still obstacles. In the 1930s, few grocery stores could afford to buy freezers for a market that wasn't established yet. So, Birdseye leased inexpensive freezer cases to them. He also leased insulated railroad cars so that he could ship his products nationwide. However, few consumers had freezers large enough or efficient enough to take advantage of the products.</p>
                        <p>Sales increased in the early 1940s, when World War II gave a boost to the frozen food industry because tin was being used for munitions. Canned foods were rationed to save tin for the war effort, while frozen foods were abundant and cheap. Finally, by the 1950s, refrigerator technology had developed far enough to make these appliances affordable for the average family. By 1953, 33 million US families owned a refrigerator, and manufacturers were gradually increasing the size of the freezer compartments in them.</p>
                        <p>1950s families were also looking for convenience at mealtimes, so the moment was right for the arrival of the 'TV Dinner'. Swanson Foods was a large, nationally recognized producer of canned and frozen poultry. In 1954, the company adapted some of Birdseye's freezing techniques, and with the help of a clever name and a huge advertising budget, it launched the first 'TV Dinner'. This consisted of frozen turkey, potatoes and vegetables served in the same segmented aluminum tray that was used by airlines. The product was an instant success. Within a year, Swanson had sold 13 million TV dinners. American consumers couldn't resist the combination of a trusted brand name, a single-serving package and the convenience of a meal that could be ready after only 25 minutes in a hot oven. By 1959, Americans were spending $2.7 billion annually on frozen foods, and half a billion of that was spent on ready-prepared meals such as the TV Dinner.</p>
                        <p>Today, the US frozen food industry has a turnover of over $67 billion annually, with $26.6 billion of that sold to consumers for home consumption. The remaining $40 billion in frozen food sales come through restaurants, cafeterias, hospitals and schools, and that represents a third of the total food service sales.</p>

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

                    <h3 class="text-3xl font-bold text-center text-gray-900 mb-2 mt-4">Can the planet's coral reefs be saved?</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">A</span>
                            <div class="space-y-4">
                                <p>Conservationists have put the final touches to a giant artificial reef they have been assembling at the world-renowned Zoological Society of London (London Zoo). Samples of the planet's most spectacular corals – vivid green branching coral, yellow scroll, blue ridge and many more species – have been added to the giant tank along with fish that thrive in their presence: blue tang, clownfish and many others. The reef is in the zoo's new gallery, <em>Tiny Giants</em>, which is dedicated to the minuscule invertebrate creatures that sustain life across the planet. The coral reef tank and its seven-metre-wide window form the core of the exhibition. 'Coral reefs are the most diverse ecosystems on Earth and we want to show people how wonderful they are,' said Paul Pearce-Kelly, senior curator of invertebrates and fish at the Zoological Society of London. 'However, we also want to highlight the research and conservation efforts that are now being carried out to try to save them from the threat of global warming.'</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">B</span>
                            <div class="space-y-4">
                                <p>Corals are composed of tiny animals, known as polyps, with tentacles for capturing small marine creatures in the sea water. These polyps are transparent but get their brilliant tones of pink, orange, blue, green, etc. from algae that live within them, which in turn get protection, while their photosynthesising of the sun's rays provides nutrients for the polyps. This comfortable symbiotic relationship has led to the growth of coral reefs that cover 0.1% of the planet's ocean bed while providing homes for more than 25% of marine species, including fish, molluscs, sponges and shellfish.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">C</span>
                            <div class="space-y-4">
                                <p>As a result, coral reefs are often described as the 'rainforests of the sea', though the comparison is dismissed by some naturalists, including David Attenborough. 'People say you cannot beat the rainforest,' Attenborough has stated. 'But that is simply not true. You go there and the first thing you think is: where … are the birds? Where are the animals? They are hiding in the trees, of course. No, if you want beauty and wildlife, you want a coral reef. Put on a mask and stick your head under the water. The sight is mind-blowing.'</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">D</span>
                            <div class="space-y-4">
                                <p>Unfortunately, these majestic sights are now under very serious threat, with the most immediate problem coming in the form of thermal stress. Rising ocean temperatures are triggering bleaching events that strip reefs of their colour and eventually kill them. And that is just the start. Other menaces include ocean acidification, sea level increase, pollution by humans, deoxygenation and ocean current changes, while the climate crisis is also increasing habitat destruction. As a result, vast areas — including massive chunks of Australia's Great Barrier Reef — have already been destroyed, and scientists advise that more than 90% of reefs could be lost by 2050 unless urgent action is taken to tackle global heating and greenhouse gas emissions. Pearce-Kelly says that coral reefs have to survive really harsh conditions — wave erosion and other factors. And 'when things start to go wrong in the oceans, then corals will be the first to react.'</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">E</span>
                            <div class="space-y-4">
                                <p>However, scientists are trying to pinpoint hardy types of coral that could survive our overheated oceans, and some of this research will be carried out at London Zoo. 'Behind our … coral reef tank we have built laboratories where scientists will be studying coral species,' said Pearce-Kelly. One aim will be to carry out research on species to find those that can survive best in warm, acidic waters. Another will be to try to increase coral breeding rates. 'Coral spawn just once a year,' he added. 'However, aquarium-based research has enabled some corals to spawn artificially, which can assist coral reef restoration efforts. And if this can be extended for all species, we could consider the launching of coral-spawning programmes several times a year. That would be a big help in restoring blighted reefs.'</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">F</span>
                            <div class="space-y-4">
                                <p>Research in these fields is being conducted in laboratories around the world, with the London Zoo centre linked to this global network. Studies carried out in one centre can then be tested in others. The resulting young coral can then be displayed in the tank in <em>Tiny Giants</em>. 'The crucial point is that the progress we make in making coral better able to survive in a warming world can be shown to the public and encourage them to believe that we can do something to save the planet's reefs,' said Pearce-Kelly. 'Saving our coral reefs is now a critically important ecological goal.'</p>
                            </div>
                        </div>

                    </div>

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

                    <h3 class="text-3xl font-bold text-center text-gray-900 mb-2 mt-4">Robots and us</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p>Robots and artificial intelligence are developing at an extraordinary pace, prompting urgent discussions about how machines will reshape our future. In this debate, three leading thinkers — cosmologist and astrophysicist <strong>Professor Martin Rees</strong>, engineer <strong>Professor Daniel Wolpert</strong>, and anthropologist <strong>Professor Kathleen Richardson</strong> — share their distinct perspectives on human-robot relationships, artificial intelligence safety, machine limitations, space exploration, and science fiction.</p>

                        <p>When considering the potential threats posed by autonomous machines, Martin Rees argues that for our own safety, humans will need to place strict boundaries on robotic intelligence and capability. While machine learning offers great promise, unsupervised development could pose existential hazards if machines surpass human control. Furthermore, Rees champions the idea that when it comes to the exploration and colonization of space, robotic probes and automated systems represent a far safer, more practical, and economically sensible path than sending vulnerable human bodies to distant worlds.</p>

                        <p>Daniel Wolpert, approaching robotics from the mechanics of movement and the human nervous system, offers a sobering perspective on machine capabilities. While computers can easily outplay world grandmasters at chess or analyze vast datasets, developing a robot with the dexterity, agility, and motor control of a five-year-old child remains an immensely difficult hurdle. Wolpert notes that the human brain devotes enormous evolutionary hardware to motor control and sensory processing. Creating machines that can physically navigate and manipulate the real world with human versatility requires breakthrough engineering that is still in its infancy.</p>

                        <p>Kathleen Richardson, an anthropologist studying human-machine relations, cautions against the emotional projection and anxiety often stirred by robotics. Rather than viewing machines as emerging conscious companions or inevitable conquerors, Richardson emphasizes that robots are tools that reflect human social dynamics and societal values. The fear of robotic replacement or subjugation frequently mirrors underlying societal anxieties about human relationships and worker exploitation in modern economic systems.</p>

                        <p>Finally, when addressing what creative literature can teach us about our technological trajectory, Martin Rees famously remarks that he sometimes advises students that it is more stimulating, and perhaps no more likely to be wrong, to read first-rate science fiction than second-rate science. Science fiction serves as a playground of ideas where moral dilemmas, societal transformations, and technological futures can be rigorously imagined and debated before they become reality.</p>

                    </div>

                        {-- Floating Toolbar for Passage 3 --}
                        @include('assignments.ielts.mockup.partials.reading-toolbar')
                    </div>
                </div>

            </div>
        </div>

        {{-- RIGHT: Questions --}}
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar" id="questions-panel">
            <div class="px-4 sm:px-6 md:px-8 py-8 pb-24 w-full relative">

{{-- Questions 1–7: Note Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–7</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 1–7 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-white text-sm">
                        <h4 class="text-base font-bold text-center mb-4">The history of frozen food</h4>
                        
                        <p class="font-bold text-gray-800 mb-2">2,000 years ago, South America</p>
                        <ul class="list-disc ml-5 space-y-2 mb-4">
                            <li class="text-gray-800 leading-loose">
                                People conserved the nutritional value of <span class="font-bold text-blue-500">1</span>
                                <input type="text" name="q1" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">, using a method of freezing then drying.
                            </li>
                        </ul>

                        <p class="font-bold text-gray-800 mb-2">1851, USA</p>
                        <ul class="list-disc ml-5 space-y-2 mb-4">
                            <li class="text-gray-800 leading-loose">
                                <span class="font-bold text-blue-500">2</span>
                                <input type="text" name="q2" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> was kept cool by ice during transportation in specially adapted trains.
                            </li>
                        </ul>

                        <p class="font-bold text-gray-800 mb-2">1880, Australia</p>
                        <ul class="list-disc ml-5 space-y-2 mb-4">
                            <li class="text-gray-800 leading-loose">
                                Two kinds of <span class="font-bold text-blue-500">3</span>
                                <input type="text" name="q3" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> were the first frozen food shipped to England.
                            </li>
                        </ul>

                        <p class="font-bold text-gray-800 mb-2">1917 onwards, USA</p>
                        <ul class="list-disc ml-5 space-y-2 mb-4">
                            <li class="text-gray-800 leading-loose">
                                Clarence Birdseye introduced innovations including:
                                <ul class="list-disc ml-5 mt-2 space-y-2">
                                    <li class="text-gray-800">quick-freezing methods, so that <span class="font-bold text-blue-500">4</span>
                                        <input type="text" name="q4" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> did not spoil the food.</li>
                                    <li class="text-gray-800">packaging products with <span class="font-bold text-blue-500">5</span>
                                        <input type="text" name="q5" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">, so the product was visible.</li>
                                </ul>
                            </li>
                        </ul>

                        <p class="font-bold text-gray-800 mb-2">Early 1940s, USA</p>
                        <ul class="list-disc ml-5 space-y-2 mb-4">
                            <li class="text-gray-800 leading-loose">
                                Frozen food became popular because of a shortage of <span class="font-bold text-blue-500">6</span>
                                <input type="text" name="q6" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">.
                            </li>
                        </ul>

                        <p class="font-bold text-gray-800 mb-2">1950s, USA</p>
                        <ul class="list-disc ml-5 space-y-2 mb-2">
                            <li class="text-gray-800 leading-loose">
                                A large number of homes now had a <span class="font-bold text-blue-500">7</span>
                                <input type="text" name="q7" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">.
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Questions 8–13: TRUE/FALSE/NOT GIVEN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 8–13</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 1?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 8–13 on your answer sheet, write</p>

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
                                    [8, "The ice transportation business made some Boston ship owners very wealthy in the early 1800s."],
                                    [9, "A disadvantage of the freezing process invented in Australia was that it affected the taste of food."],
                                    [10, "Clarence Birdseye travelled to Labrador in order to learn how the Inuit people froze fish."],
                                    [11, "Swanson Foods invested a great deal of money in the promotion of the TV Dinner."],
                                    [12, "Swanson Foods developed a new style of container for the launch of the TV Dinner."],
                                    [13, "The US frozen food industry is currently the largest in the world."],
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
                
                {{-- ── PASSAGE 2 Questions ── --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Q14-19: Matching Headings --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–19</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 2 has six sections, <strong>A–F</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose the correct heading for each section from the list of headings below.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct number, <strong><em>i–vii</em></strong>, in boxes 14–19 on your answer sheet.</p>

                    <div class="border border-gray-400 p-4 rounded-lg mb-6 bg-white text-sm">
                        <p class="text-center font-bold mb-3">List of Headings</p>
                        @foreach([
                            ['i',    'Tried and tested solutions'],
                            ['ii',   'Cooperation beneath the waves'],
                            ['iii',  'Working to lessen the problems'],
                            ['iv',   'Disagreement about the accuracy of a certain phrase'],
                            ['v',    'Two clear educational goals'],
                            ['vi',   'Promoting hope'],
                            ['vii',  'A warning of further trouble ahead'],
                        ] as [$roman, $text])
                        <div class="flex gap-3 py-1">
                            <span class="font-bold italic w-10 flex-none text-right">{{ $roman }}</span>
                            <span>{{ $text }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-white border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Section</th>
                                    <th class="p-3 font-bold text-gray-600 w-36 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [14, 'A'], [15, 'B'], [16, 'C'], [17, 'D'], [18, 'E'], [19, 'F']
                                ] as [$num, $para])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm font-medium">Paragraph <strong>{{ $para }}</strong></td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                @foreach(['i','ii','iii','iv','v','vi','vii'] as $opt)
                                                <option value="{{ $opt }}">{{ $opt }}</option>
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
                
                {{-- Q20-21: Choose TWO --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6" x-data="{ selected: [] }">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 20 and 21</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Write the correct letters in boxes 20 and 21 on your answer sheet.</p>
                    <p class="text-sm text-gray-800 mb-4 mt-3">Which <strong>TWO</strong> of these causes of damage to coral reefs are mentioned by the writer of the text?</p>

                    <div class="space-y-3">
                        @foreach([
                            ['A', 'a rising number of extreme storms'],
                            ['B', 'the removal of too many fish from the sea'],
                            ['C', 'the contamination of the sea from waste'],
                            ['D', 'increased disease among marine species'],
                            ['E', 'alterations in the usual flow of water in the seas'],
                        ] as [$letter, $text])
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="q20_21[]" value="{{ $letter }}"
                                   x-model="selected" @change="if(selected.length > 2) selected.shift();"
                                   class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none">
                            <span class="text-sm text-gray-800 group-hover:text-blue-700 transition-colors">
                                <strong>{{ $letter }}</strong>&nbsp; {{ $text }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 mt-3 italic">Select exactly two options.</p>
                </div>

                {{-- Q22-23: Choose TWO --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6" x-data="{ selected: [] }">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 22 and 23</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Write the correct letters in boxes 22 and 23 on your answer sheet.</p>
                    <p class="text-sm text-gray-800 mb-4 mt-3">Which <strong>TWO</strong> of the following statements are true of the researchers at London Zoo?</p>

                    <div class="space-y-3">
                        @foreach([
                            ['A', 'They are hoping to expand the numbers of different corals being bred in laboratories.'],
                            ['B', 'They want to identify corals that can cope well with the changed sea conditions.'],
                            ['C', 'They are looking at ways of creating artificial reefs that corals could grow on.'],
                            ['D', 'They are trying out methods that would speed up reproduction in some corals.'],
                            ['E', 'They are investigating materials that might protect reefs from higher temperatures.'],
                        ] as [$letter, $text])
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="q22_23[]" value="{{ $letter }}"
                                   x-model="selected" @change="if(selected.length > 2) selected.shift();"
                                   class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none">
                            <span class="text-sm text-gray-800 group-hover:text-blue-700 transition-colors">
                                <strong>{{ $letter }}</strong>&nbsp; {{ $text }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 mt-3 italic">Select exactly two options.</p>
                </div>

                {{-- Q24-26: Sentence Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 24–26</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the sentences below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 24–26 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-white text-sm space-y-4">
                        <div class="flex items-start gap-2">
                            <span class="font-bold text-gray-800 flex-none w-5 text-right mt-1">24</span>
                            <p class="text-gray-800 leading-loose">
                                Corals have a number of
                                <input type="text" name="q24" class="border-b border-gray-500 outline-none px-2 mx-1 w-32 bg-transparent text-sm placeholder-gray-400 font-semibold" placeholder="Answer">
                                which they use to collect their food.
                            </p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="font-bold text-gray-800 flex-none w-5 text-right mt-1">25</span>
                            <p class="text-gray-800 leading-loose">
                                Algae gain
                                <input type="text" name="q25" class="border-b border-gray-500 outline-none px-2 mx-1 w-32 bg-transparent text-sm placeholder-gray-400 font-semibold" placeholder="Answer">
                                from being inside the coral.
                            </p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="font-bold text-gray-800 flex-none w-5 text-right mt-1">26</span>
                            <p class="text-gray-800 leading-loose">
                                Increases in the warmth of the sea water can remove the
                                <input type="text" name="q26" class="border-b border-gray-500 outline-none px-2 mx-1 w-32 bg-transparent text-sm placeholder-gray-400 font-semibold" placeholder="Answer">
                                from coral.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ── PASSAGE 3 Questions ── --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>

                {{-- Q27-33: Matching Statements to Experts --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–33</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Look at the following statements (Questions 27–33) and the list of experts below.</p>
                    <p class="text-sm text-gray-800 mb-1">Match each statement with the correct expert, <strong>A, B or C</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Write the correct letter, <strong>A, B or C</strong>, in boxes 27–33 on your answer sheet.</p>
                    <p class="text-sm font-bold text-gray-800 mb-4"><em>NB You may use any letter more than once.</em></p>

                    <div class="border border-gray-400 p-4 rounded-lg mb-6 bg-white text-sm">
                        <p class="text-center font-bold mb-3">List of Experts</p>
                        @foreach([
                            ['A', 'Martin Rees'],
                            ['B', 'Daniel Wolpert'],
                            ['C', 'Kathleen Richardson'],
                        ] as [$letter, $name])
                        <div class="flex gap-3 py-1 justify-center">
                            <span class="font-bold w-4 flex-none text-right">{{ $letter }}</span>
                            <span>{{ $name }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="overflow-x-auto mt-4">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-white border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-32 text-center">Expert</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [27, 'For our own safety, humans will need to restrict the abilities of robots.'],
                                    [28, 'The risk of robots harming us is less serious than humans believe it to be.'],
                                    [29, 'It will take many decades for robot intelligence to be as imaginative as human intelligence.'],
                                    [30, 'We may have to start considering whether we are treating robots fairly.'],
                                    [31, 'Robots are probably of more help to us on Earth than in space.'],
                                    [32, 'The ideas in high-quality science fiction may prove to be just as accurate as those found in the work of mediocre scientists.'],
                                    [33, 'There are those who look forward to robots developing greater intelligence.']
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center w-36">
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

                {{-- Q34-36: Matching Sentence Endings --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 34–36</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete each sentence with the correct ending, <strong>A–D</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct letter, <strong>A–D</strong>, in boxes 34–36 on your answer sheet.</p>

                    <div class="border border-gray-400 p-4 rounded-lg mb-6 bg-white text-sm">
                        @foreach([
                            ['A', 'robots to explore outer space.'],
                            ['B', 'advances made in machine intelligence so far.'],
                            ['C', 'changes made to other planets for our own benefit.'],
                            ['D', 'the harm already done by artificial intelligence.'],
                        ] as [$letter, $text])
                        <div class="flex gap-3 py-1">
                            <span class="font-bold italic w-6 flex-none text-right">{{ $letter }}</span>
                            <span>{{ $text }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-4">
                        @foreach([
                            [34, 'Richardson and Rees express similar views regarding the ethical aspect of'],
                            [35, 'Rees and Wolpert share an opinion about the extent of'],
                            [36, 'Wolpert disagrees with Richardson on the question of'],
                        ] as [$num, $sentence])
                        <div class="flex items-start gap-3 bg-white p-4 border border-gray-100 rounded-lg">
                            <span class="font-bold text-gray-800 w-5 flex-none mt-1">{{ $num }}</span>
                            <div class="flex-1 flex flex-col xl:flex-row xl:items-center gap-3">
                                <span class="text-gray-800 text-sm leading-relaxed">{{ $sentence }}</span>
                                <div class="relative inline-block w-24 flex-none xl:ml-auto">
                                    <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1.5 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Q37-40: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 37–40</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Choose the correct letter, <strong>A, B, C or D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 37–40 on your answer sheet.</p>

                    <div class="space-y-6">
                        @php
                        $mcqs = [
                            [
                                'num' => 37,
                                'q' => 'What point does Richardson make about fear of machines?',
                                'options' => [
                                    'A' => 'It has grown alongside the development of ever more advanced robots.',
                                    'B' => 'It is the result of our inclination to attribute human characteristics to non-human entities.',
                                    'C' => 'It has its origins in basic misunderstandings about how inanimate objects function.',
                                    'D' => 'It demonstrates a key difference between human intelligence and machine intelligence.'
                                ]
                            ],
                            [
                                'num' => 38,
                                'q' => 'What potential advance does Rees see as a cause for concern?',
                                'options' => [
                                    'A' => 'robots outnumbering people',
                                    'B' => 'robots having abilities which humans do not',
                                    'C' => 'artificial intelligence developing independent thought',
                                    'D' => 'artificial intelligence taking over every aspect of our lives'
                                ]
                            ],
                            [
                                'num' => 39,
                                'q' => 'What does Wolpert emphasise in his response to the question about science fiction?',
                                'options' => [
                                    'A' => 'how science fiction influences our attitudes to robots',
                                    'B' => 'how fundamental robots are to the science fiction genre',
                                    'C' => 'how the image of robots in science fiction has changed over time',
                                    'D' => 'how reactions to similar portrayals of robots in science fiction may vary'
                                ]
                            ],
                            [
                                'num' => 40,
                                'q' => 'What is Richardson doing in her comment about reality and fantasy?',
                                'options' => [
                                    'A' => 'warning people not to confuse one with the other',
                                    'B' => 'outlining ways in which one has impacted on the other',
                                    'C' => 'recommending a change of approach in how people view them',
                                    'D' => 'explaining why scientists have a different perspective on them from other people'
                                ]
                            ]
                        ];
                        @endphp

                        @foreach($mcqs as $mcq)
                        <div class="bg-white border border-gray-200 rounded-xl p-5">
                            <div class="flex items-start gap-3 mb-4">
                                <span class="font-bold text-lg text-gray-900 flex-none">{{ $mcq['num'] }}</span>
                                <p class="text-base text-gray-900 font-medium">{{ $mcq['q'] }}</p>
                            </div>
                            <div class="ml-7 space-y-2.5">
                                @foreach($mcq['options'] as $letter => $text)
                                <label class="flex items-start gap-3 cursor-pointer group p-2 hover:bg-white rounded-lg transition-colors border border-transparent hover:border-gray-200">
                                    <input type="radio" name="q{{ $mcq['num'] }}" value="{{ $letter }}" class="mt-1 w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <div class="text-sm text-gray-700">
                                        <span class="font-bold mr-1">{{ $letter }}</span>
                                        <span class="group-hover:text-blue-700 transition-colors">{{ $text }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Final Submit Button --}}
                <div class="mt-10 mb-8 flex justify-center sticky bottom-6 z-40">
                    <button class="px-10 py-3 bg-green-600 hover:bg-green-700 text-white font-bold text-lg rounded-2xl transition-all shadow-[0_8px_30px_rgb(0,0,0,0.12)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.2)] hover:-translate-y-1 w-full max-w-md">
                        Submit Reading Test
                    </button>

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
</body>
</html>

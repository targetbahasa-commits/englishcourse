<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Reading Mock Test {{ $testId }} - {{ config('app.name', 'Target Bahasa') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
                    <p class="text-sm text-gray-500">Cambridge {{ $edition }} Reading Practice</p>
                </div>
            </div>
            <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId]) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back
            </a>
        </div>
    </div>

    {{-- Split screen --}}
    <div class="flex-1 min-h-0 grid overflow-hidden" style="grid-template-columns: 2.5fr 2fr;">

        {{-- LEFT: Reading Passage --}}
        <div class="h-full overflow-y-auto bg-white border-r border-gray-200 custom-scrollbar relative"
             x-data="{
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
                 new ResizeObserver(() => { if (canvasObj) canvasObj.resize(); }).observe($el);
             "
        >
            <canvas x-ref="drawingCanvas"
                    class="absolute inset-x-0 inset-y-0 w-full z-10"
                    :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'">
            </canvas>

            <div class="px-10 py-8 pb-32 max-w-3xl mx-auto relative z-20">

                {{-- READING header --}}
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">READING</span>
                </div>

                {{-- Passage 1 --}}
                <div class="mb-6">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 1</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong>, which are based on Reading Passage 1 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">Stonehenge</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p>For centuries, historians and archaeologists have puzzled over the many mysteries of Stonehenge, a prehistoric monument that took an estimated 1,500 years to erect. Located on Salisbury Plain in southern England, it is comprised of roughly 100 massive upright stones placed in a circular layout.</p>

                        <p>Archaeologists believe England's most iconic prehistoric ruin was built in several stages, with the earliest constructed 5,000 or more years ago. First, Neolithic* Britons used primitive tools, which may have been fashioned out of deer antlers, to dig a massive circular ditch and bank, or henge. Deep pits dating back to that era and located within the circle may have once held a ring of timber posts, according to some scholars.</p>

                        <p>Several hundred years later, it is thought, Stonehenge's builders hoisted an estimated 80 bluestones, 43 of which remain today, into standing positions and placed them in either a horseshoe or circular formation. These stones have been traced all the way to the Preseli Hills in Wales, some 300 kilometres from Stonehenge. How, then, did prehistoric builders without sophisticated tools or engineering haul these boulders, which weigh up to four tons, over such a great distance?</p>

                        <p>According to one long-standing theory among archaeologists, Stonehenge's builders fashioned sledges and rollers out of tree trunks to lug the bluestones from the Preseli Hills. They then transferred the boulders onto rafts and floated them first along the Welsh coast and then up the River Avon toward Salisbury Plain; alternatively, they may have towed each stone with a fleet of vessels. More recent archaeological hypotheses have them transporting the bluestones with supersized wicker baskets on a combination of ball bearings and long grooved planks, hauled by oxen.</p>

                        <p>As early as the 1970s, geologists have been adding their voices to the debate over how Stonehenge came into being. Challenging the classic image of industrious builders pushing, carting, rolling or hauling giant stones from faraway Wales, some scientists have suggested that it was glaciers, not humans, that carried the bluestones to Salisbury Plain. Most archaeologists have remained sceptical about this theory, however, wondering how the forces of nature could possibly have delivered the exact number of stones needed to complete the circle.</p>

                        <p>The third phase of construction took place around 2000 BCE. At this point, sandstone slabs – known as 'sarsens' – were arranged into an outer crescent or ring; some were assembled into the iconic three-pieced structures called trilithons that stand tall in the centre of Stonehenge. Some 50 of these stones are now visible on the site, which may once have contained many more. Radiocarbon dating has revealed that work continued at Stonehenge until roughly 1600 BCE, with the bluestones in particular being repositioned multiple times.</p>

                        <p>But who were the builders of Stonehenge? In the 17th century, archaeologist John Aubrey made the claim that Stonehenge was the work of druids, who had important religious, judicial and political roles in Celtic** society. This theory was widely popularized by the antiquarian William Stukeley, who had unearthed primitive graves at the site. Even today, people who identify as modern druids continue to gather at Stonehenge for the summer solstice. However, in the mid-20th century, radiocarbon dating demonstrated that Stonehenge stood more than 1,000 years before the Celts inhabited the region.</p>

                        <p>Many modern historians and archaeologists now agree that several distinct tribes of people contributed to Stonehenge, each undertaking a different phase of its construction. Bones, tools and other artefacts found on the site seem to support this hypothesis. The first stage was achieved by Neolithic agrarians who were likely to have been indigenous to the British Isles. Later, it is believed, groups with advanced tools and a more communal way of life left their mark on the site. Some believe that they were immigrants from the European continent, while others maintain that they were probably native Britons, descended from the original builders.</p>

                        <p>If the facts surrounding the architects and construction of Stonehenge remain shadowy at best, the purpose of the striking monument is even more of a mystery. While there is consensus among the majority of modern scholars that Stonehenge once served the function of burial ground, they have yet to determine what other purposes it had.</p>

                        <p>In the 1960s, the astronomer Gerald Hawkins suggested that the cluster of megalithic stones operated as a form of calendar, with different points corresponding to astrological phenomena such as solstices, equinoxes and eclipses occurring at different times of the year. While his theory has received a considerable amount of attention over the decades, critics maintain that Stonehenge's builders probably lacked the knowledge necessary to predict such events or that England's dense cloud cover would have obscured their view of the skies.</p>

                        <p>More recently, signs of illness and injury in the human remains unearthed at Stonehenge led a group of British archaeologists to speculate that it was considered a place of healing, perhaps because bluestones were thought to have curative powers.</p>

                        <p class="text-xs text-gray-500 mt-4 border-t pt-2">* Neolithic – The era, also known as the New Stone Age, which began around 12,000 years ago and ended around 3500 BCE</p>
                        <p class="text-xs text-gray-500">** Celtic – The Celts were people who lived in Britain and northwest Europe during the Iron Age from 600 BCE to 43 CE</p>
                    </div>
                </div>

                {{-- Passage 2 --}}
                <div class="mb-6 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-2">Living with artificial intelligence</h3>
                    <p class="text-center italic text-gray-600 mb-6 text-[15px]">Powerful artificial intelligence (AI) needs to be reliably aligned with human values, but does this mean AI will eventually have to police those values?</p>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p>This has been the decade of AI, with one astonishing feat after another. A chess-playing AI that can defeat not only all human chess players, but also all previous human-programmed chess machines, after learning the game in just four hours? That's yesterday's news, what's next? True, these prodigious accomplishments are all in so-called narrow AI, where machines perform highly specialised tasks. But many experts believe this restriction is very temporary. By mid-century, we may have artificial general intelligence (AGI) – machines that can achieve human-level performance on the full range of tasks that we ourselves can tackle.</p>

                        <p>If so, there's little reason to think it will stop there. Machines will be free of many of the physical constraints on human intelligence. Our brains run at slow biochemical processing speeds on the power of a light bulb, and their size is restricted by the dimensions of the human birth canal. It is remarkable what they accomplish, given these handicaps. But they may be as far from the physical limits of thought as our eyes are from the incredibly powerful Webb Space Telescope.</p>

                        <p>Once machines are better than us at designing even smarter machines, progress towards these limits could accelerate. What would this mean for us? Could we ensure a safe and worthwhile coexistence with such machines? On the plus side, AI is already useful and profitable for many things, and super AI might be expected to be super useful, and super profitable. But the more powerful AI becomes, the more important it will be to specify its goals with great care. Folklore is full of tales of people who ask for the wrong thing, with disastrous consequences – King Midas, for example, might have wished that everything he touched turned to gold, but didn't really intend this to apply to his breakfast.</p>

                        <p>So we need to create powerful AI machines that are 'human-friendly' – that have goals reliably aligned with our own values. One thing that makes this task difficult is that we are far from reliably human-friendly ourselves. We do many terrible things to each other and to many other creatures with whom we share the planet. If superintelligent machines don't do a lot better than us, we'll be in deep trouble. We'll have powerful new intelligence amplifying the dark sides of our own fallible natures.</p>

                        <p>For safety's sake, then, we want the machines to be ethically as well as cognitively superhuman. We want them to aim for the moral high ground, not for the troughs in which many of us spend some of our time. Luckily they'll be smart enough for the job. If there are routes to the moral high ground, they'll be better than us at finding them, and steering us in the right direction.</p>

                        <p>However, there are two big problems with this utopian vision. One is how we get the machines started on the journey, the other is what it would mean to reach this destination. The 'getting started' problem is that we need to tell the machines what they're looking for with sufficient clarity that we can be confident they will find it – whatever 'it' actually turns out to be. This won't be easy, given that we are tribal creatures and conflicted about the ideals ourselves. We often ignore the suffering of strangers, and even contribute to it, at least indirectly. How then, do we point machines in the direction of something better?</p>

                        <p>As for the 'destination' problem, we might, by putting ourselves in the hands of these moral guides and gatekeepers, be sacrificing our own autonomy – an important part of what makes us human. Machines who are better than us at sticking to the moral high ground may be expected to discourage some of the lapses we presently take for granted. We might lose our freedom to discriminate in favour of our own communities, for example.</p>

                        <p>Loss of freedom to behave badly isn't always a bad thing, of course: denying ourselves the freedom to put children to work in factories, or to smoke in restaurants are signs of progress. But are we ready for ethical silicon police limiting our options? They might be so good at doing it that we won't notice them; but few of us are likely to welcome such a future.</p>

                        <p>These issues might seem far-fetched, but they are to some extent already here. AI already has some input into how resources are used in our National Health Service (NHS) here in the UK, for example. If it was given a greater role, it might do so much more efficiently than humans can manage, and act in the interests of taxpayers and those who use the health system. However, we'd be depriving some humans (e.g. senior doctors) of the control they presently enjoy. Since we'd want to ensure that people are treated equally and that policies are fair, the goals of AI would need to be specified correctly.</p>

                        <p>We have a new powerful technology to deal with – itself, literally, a new way of thinking. For our own safety, we need to point these new thinkers in the right direction, and get them to act well for us. It is not yet clear whether this is possible, but if it is, it will require a cooperative spirit, and a willingness to set aside self-interest.</p>

                        <p>Both general intelligence and moral reasoning are often thought to be uniquely human capacities. But safety seems to require that we think of them as a package: if we are to give general intelligence to machines, we'll need to give them moral authority, too. And where exactly would that leave human beings? All the more reason to think about the destination now, and to be careful about what we wish for.</p>
                    </div>
                </div>

                {{-- Passage 3 - placeholder --}}
                <div class="mb-6 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-2">An ideal city</h3>
                    <p class="text-center italic text-gray-600 mb-6 text-[15px]">Leonardo da Vinci's ideal city was centuries ahead of its time</p>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p>The word 'genius' is universally associated with the name of Leonardo da Vinci. A true Renaissance man, he embodied scientific spirit, artistic talent and humanist sensibilities. Five hundred years have passed since Leonardo died in his home at Château du Clos Lucé, outside Tours, France. Yet far from fading into insignificance, his thinking has carried down the centuries and still surprises today.</p>

                        <p>The Renaissance marked the transition from the 15th century to modernity and took place after the spread of the plague in the 14th century, which caused a global crisis resulting in some 200 million deaths across Europe and Asia. Today, the world is on the cusp of a climate crisis, which is predicted to cause widespread displacement, extinctions and death, if left unaddressed. Then, as now, radical solutions were called for to revolutionise the way people lived and safeguard humanity against catastrophe.</p>

                        <p>Around 1486 – after a pestilence that killed half the population in Milan, Italy – Leonardo turned his thoughts to urban planning problems. Following a typical Renaissance trend, he began to work on an 'ideal city' project, which – due to its excessive costs – would remain unfulfilled. Yet given that unsustainable urban models are a key cause of global climate change today, it's only natural to wonder how Leonardo might have changed the shape of modern cities.</p>

                        <p>Although the Renaissance is renowned as an era of incredible progress in art and architecture, it is rarely noted that the 15th century also marked the birth of urbanism as a true academic discipline. The rigour and method behind the conscious conception of a city had been largely missing in Western thought until the moment when prominent Renaissance men pushed forward large-scale urban projects in Italy, such as the reconfiguration of the town of Pienza and the expansion of the city of Ferrara. These works surely inspired Leonardo's decision to rethink the design of medieval cities, with their winding and overcrowded streets and with houses piled against one another.</p>

                        <p>It is not easy to identify a coordinated vision of Leonardo's ideal city because of his disordered way of working with notes and sketches. But from the largest collection of Leonardo's papers ever assembled, a series of innovative thoughts can be reconstructed regarding the foundation of a new city along the Ticino River, which runs from Switzerland into Italy and is 248 kilometres long. He designed the city for the easy transport of goods and clean urban spaces, and he wanted a comfortable and spacious city, with well-ordered streets and architecture. He recommended 'high, strong walls', with 'towers and battlements of all necessary and pleasant beauty'.</p>

                        <p>His plans for a modern and 'rational' city were consistent with Renaissance ideals. But, in keeping with his personality, Leonardo included several innovations in his urban design. Leonardo wanted the city to be built on several levels, linked with vertical outdoor staircases. This design can be seen in some of today's high-rise buildings but was unconventional at the time. Indeed, this idea of taking full advantage of the interior spaces wasn't implemented until the 1920s and 1930s, with the birth of the Modernist movement.</p>

                        <p>While in the upper layers of the city, people could walk undisturbed between elegant palaces and streets, the lower layer was the place for services, trade, transport and industry. But the true originality of Leonardo's vision was its fusion of architecture and engineering. Leonardo designed extensive hydraulic plants to create artificial canals throughout the city. The canals, regulated by clocks and basins, were supposed to make it easier for boats to navigate inland. Leonardo also thought that the width of the streets ought to match the average height of the adjacent houses: a rule still followed in many contemporary cities across Italy, to allow access to sun and reduce the risk of damage from earthquakes.</p>

                        <p>Although some of these features existed in Roman cities, before Leonardo's drawings there had never been a multi-level, compact modern city which was thoroughly technically conceived. Indeed, it wasn't until the 19th century that some of his ideas were applied. For example, the subdivision of the city by function – with services and infrastructures located in the lower levels and wide and well-ventilated boulevards and walkways above for residents – is an idea that can be found in Georges-Eugène Haussmann's renovation of Paris under Emperor Napoleon III between 1853 and 1870.</p>

                        <p>Today, Leonardo's ideas are not simply valid, they actually suggest a way forward for urban planning. Many scholars think that the compact city, built upwards instead of outwards, integrated with nature (especially water systems), with efficient transport infrastructure, could help modern cities become more efficient and sustainable. This is yet another reason why Leonardo was aligned so closely with modern urban planning and centuries ahead of his time.</p>
                    </div>
                </div>

                {{-- Floating Annotation Toolbar --}}
                <div class="sticky bottom-6 w-full flex flex-col items-center pointer-events-none z-30 mt-4 mb-2">
                    <div x-show="highlightMode"
                         class="flex gap-2 p-2 bg-white/95 backdrop-blur-md rounded-full shadow-xl border border-gray-100 mb-3 pointer-events-auto"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         style="display:none;">
                        <button @click.prevent.stop="highlightColor='yellow'" class="w-8 h-8 rounded-full bg-yellow-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all" :class="highlightColor==='yellow' ? 'ring-2 ring-yellow-500 scale-110' : 'hover:ring-yellow-400'"></button>
                        <button @click.prevent.stop="highlightColor='green'"  class="w-8 h-8 rounded-full bg-green-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all" :class="highlightColor==='green'  ? 'ring-2 ring-green-500 scale-110'  : 'hover:ring-green-400'"></button>
                        <button @click.prevent.stop="highlightColor='blue'"   class="w-8 h-8 rounded-full bg-blue-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all" :class="highlightColor==='blue'   ? 'ring-2 ring-blue-500 scale-110'   : 'hover:ring-blue-400'"></button>
                        <button @click.prevent.stop="highlightColor='pink'"   class="w-8 h-8 rounded-full bg-pink-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all" :class="highlightColor==='pink'   ? 'ring-2 ring-pink-500 scale-110'   : 'hover:ring-pink-400'"></button>
                    </div>
                    <div class="flex justify-center items-center gap-3 pointer-events-auto bg-white/40 p-1.5 rounded-full backdrop-blur-md shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-200/50">
                        <button @click="highlightMode=!highlightMode; pencilMode=false; eraserMode=false;"
                                class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white opacity-90 hover:opacity-100 hover:shadow-md hover:text-green-600 hover:border-green-400 hover:scale-105 transition-all"
                                :class="{ '!bg-green-500 !text-white !border-green-600 shadow-md !opacity-100': highlightMode }"
                                title="Highlight Tool">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                        </button>
                        <button @click="pencilMode=!pencilMode; highlightMode=false; eraserMode=false;"
                                class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white opacity-90 hover:opacity-100 hover:shadow-md hover:text-blue-600 hover:border-blue-400 hover:scale-105 transition-all"
                                :class="{ '!bg-blue-500 !text-white !border-blue-600 shadow-md !opacity-100': pencilMode }"
                                title="Pencil Tool">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <button @click="eraserMode=!eraserMode; pencilMode=false; highlightMode=false;"
                                class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white opacity-90 hover:opacity-100 hover:shadow-md hover:text-indigo-600 hover:border-indigo-400 hover:scale-105 transition-all"
                                :class="{ '!bg-indigo-500 !text-white !border-indigo-600 shadow-md !opacity-100': eraserMode }"
                                title="Eraser Tool">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 21-4.3-4.3c-1-1-1-2.5 0-3.4l9.6-9.6c1-1 2.5-1 3.4 0l5.6 5.6c1 1 1 2.5 0 3.4L13 21"/><path d="M22 21H7"/><path d="m5 11 9 9"/></svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>

        {{-- RIGHT: Questions --}}
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar">
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto">

                {{-- PASSAGE 1 QUESTIONS header --}}
                <div class="flex justify-center mb-6">
                    <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 1</span>
                </div>

                {{-- Questions 1–8: Note Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–8</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>NO MORE THAN TWO WORDS</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 1–8 on your answer sheet.</p>

                    <div class="border-2 border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-5">Stonehenge</h4>

                        <p class="font-bold mb-2">Construction</p>

                        <p class="mb-1">Stage 1:</p>
                        <ul class="list-disc ml-6 space-y-3 mb-4">
                            <li class="leading-loose">
                                the ditch and henge were dug, possibly using tools made from <strong>1</strong>
                                <input type="text" name="q1" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            </li>
                            <li class="leading-loose">
                                <strong>2</strong>
                                <input type="text" name="q2" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                may have been arranged in deep pits inside the circle
                            </li>
                        </ul>

                        <p class="mb-1">Stage 2:</p>
                        <ul class="list-disc ml-6 space-y-3 mb-4">
                            <li>bluestones from the Preseli Hills were placed in standing position</li>
                            <li class="leading-loose">
                                theories about the transportation of the bluestones:
                                <ul class="list-none ml-4 mt-2 space-y-2">
                                    <li>
                                        – archaeological:
                                        <ul class="list-none ml-6 mt-1 space-y-2">
                                            <li class="leading-loose">
                                                ○ builders used <strong>3</strong>
                                                <input type="text" name="q3" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                                to make sledges and rollers
                                            </li>
                                            <li class="leading-loose">
                                                ○ <strong>4</strong>
                                                <input type="text" name="q4" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                                pulled them on giant baskets
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        – geological:
                                        <ul class="list-none ml-6 mt-1 space-y-2">
                                            <li class="leading-loose">
                                                ○ they were brought from Wales by <strong>5</strong>
                                                <input type="text" name="q5" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <p class="mb-1">Stage 3:</p>
                        <ul class="list-disc ml-6 space-y-3 mb-4">
                            <li>sandstone slabs were arranged into an outer crescent or ring</li>
                        </ul>

                        <p class="font-bold mb-2">Builders</p>
                        <ul class="list-disc ml-6 space-y-3 mb-4">
                            <li class="leading-loose">
                                a theory arose in the 17th century that its builders were Celtic <strong>6</strong>
                                <input type="text" name="q6" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            </li>
                        </ul>

                        <p class="font-bold mb-2">Purpose</p>
                        <ul class="list-disc ml-6 space-y-3">
                            <li class="leading-loose">
                                many experts agree it has been used as a <strong>7</strong>
                                <input type="text" name="q7" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                site
                            </li>
                            <li class="leading-loose">
                                in the 1960s, it was suggested that it worked as a kind of <strong>8</strong>
                                <input type="text" name="q8" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Questions 9–13: True/False/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 9–13</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 1?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 9–13 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic">TRUE</span></div><div class="italic">if the statement agrees with the information</div>
                            <div><span class="font-bold italic">FALSE</span></div><div class="italic">if the statement contradicts the information</div>
                            <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if there is no information on this</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-36 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [9,  'During the third phase of construction, sandstone slabs were placed in both the outer areas and the middle of the Stonehenge site.'],
                                    [10, 'There is scientific proof that the bluestones stood in the same spot until approximately 1600 BCE.'],
                                    [11, "John Aubrey's claim about Stonehenge was supported by 20th-century findings."],
                                    [12, 'Objects discovered at Stonehenge seem to indicate that it was constructed by a number of different groups of people.'],
                                    [13, "Criticism of Gerald Hawkins' theory about Stonehenge has come mainly from other astronomers."],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
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

                    <div class="mt-6 flex justify-end">
                        <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                            Submit Answers
                        </button>
                    </div>
                </div>

                {{-- PASSAGE 2 QUESTIONS --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Questions 14–19: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–19</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 14–19 on your answer sheet.</p>

                    <div class="pl-4 space-y-6">
                        {{-- Q14 --}}
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">14</span> What point does the writer make about AI in the first paragraph?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q14" value="A" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">A</span>
                                    <span class="group-hover:text-blue-600 transition">It is difficult to predict how quickly AI will progress.</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q14" value="B" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">B</span>
                                    <span class="group-hover:text-blue-600 transition">Much can be learned about the use of AI in chess machines.</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q14" value="C" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">C</span>
                                    <span class="group-hover:text-blue-600 transition">The future is unlikely to see limitations on the capabilities of AI.</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q14" value="D" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">D</span>
                                    <span class="group-hover:text-blue-600 transition">Experts disagree on which specialised tasks AI will be able to perform.</span>
                                </label>
                            </div>
                        </div>

                        {{-- Q15 --}}
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">15</span> What is the writer doing in the second paragraph?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q15" value="A" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">A</span>
                                    <span class="group-hover:text-blue-600 transition">explaining why machines will be able to outperform humans</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q15" value="B" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">B</span>
                                    <span class="group-hover:text-blue-600 transition">describing the characteristics that humans and machines share</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q15" value="C" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">C</span>
                                    <span class="group-hover:text-blue-600 transition">giving information about the development of machine intelligence</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q15" value="D" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">D</span>
                                    <span class="group-hover:text-blue-600 transition">indicating which aspects of humans are the most advanced</span>
                                </label>
                            </div>
                        </div>

                        {{-- Q16 --}}
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">16</span> Why does the writer mention the story of King Midas?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q16" value="A" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">A</span>
                                    <span class="group-hover:text-blue-600 transition">to compare different visions of progress</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q16" value="B" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">B</span>
                                    <span class="group-hover:text-blue-600 transition">to illustrate that poorly defined objectives can go wrong</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q16" value="C" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">C</span>
                                    <span class="group-hover:text-blue-600 transition">to emphasise the need for cooperation</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q16" value="D" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">D</span>
                                    <span class="group-hover:text-blue-600 transition">to point out the financial advantages of a course of action</span>
                                </label>
                            </div>
                        </div>

                        {{-- Q17 --}}
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">17</span> What challenge does the writer refer to in the fourth paragraph?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q17" value="A" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">A</span>
                                    <span class="group-hover:text-blue-600 transition">encouraging humans to behave in a more principled way</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q17" value="B" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">B</span>
                                    <span class="group-hover:text-blue-600 transition">deciding which values we want AI to share with us</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q17" value="C" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">C</span>
                                    <span class="group-hover:text-blue-600 transition">creating a better world for all creatures on the planet</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q17" value="D" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">D</span>
                                    <span class="group-hover:text-blue-600 transition">ensuring AI is more human-friendly than we are ourselves</span>
                                </label>
                            </div>
                        </div>

                        {{-- Q18 --}}
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">18</span> What does the writer suggest about the future of AI in the fifth paragraph?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q18" value="A" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">A</span>
                                    <span class="group-hover:text-blue-600 transition">The safety of machines will become a key issue.</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q18" value="B" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">B</span>
                                    <span class="group-hover:text-blue-600 transition">It is hard to know what impact machines will have on the world.</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q18" value="C" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">C</span>
                                    <span class="group-hover:text-blue-600 transition">Machines will be superior to humans in certain respects.</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q18" value="D" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">D</span>
                                    <span class="group-hover:text-blue-600 transition">Many humans will oppose machines having a wider role.</span>
                                </label>
                            </div>
                        </div>

                        {{-- Q19 --}}
                        <div>
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">19</span> Which of the following best summarises the writer's argument in the sixth paragraph?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q19" value="A" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">A</span>
                                    <span class="group-hover:text-blue-600 transition">More intelligent machines will result in greater abuses of power.</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q19" value="B" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">B</span>
                                    <span class="group-hover:text-blue-600 transition">Machine learning will share very few features with human learning.</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q19" value="C" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">C</span>
                                    <span class="group-hover:text-blue-600 transition">There are a limited number of people with the knowledge to program machines.</span>
                                </label>
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q19" value="D" class="w-5 h-5 mt-0.5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="font-bold w-4 flex-none">D</span>
                                    <span class="group-hover:text-blue-600 transition">Human shortcomings will make creating the machines we need more difficult.</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Questions 20–23: Yes/No/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 20–23</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the claims of the writer in Reading Passage 2?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 20–23 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic">YES</span></div><div class="italic">if the statement agrees with the claims of the writer</div>
                            <div><span class="font-bold italic">NO</span></div><div class="italic">if the statement contradicts the claims of the writer</div>
                            <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if it is impossible to say what the writer thinks about this</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-36 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [20, 'Machines with the ability to make moral decisions may prevent us from promoting the interests of our communities.'],
                                    [21, 'Silicon police would need to exist in large numbers in order to be effective.'],
                                    [22, 'Many people are comfortable with the prospect of their independence being restricted by machines.'],
                                    [23, 'If we want to ensure that machines act in our best interests, we all need to work together.'],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
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

                {{-- Questions 24–26: Summary Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 24–26</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary using the list of phrases, <strong>A–F</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–F</strong>, in boxes 24–26 on your answer sheet.</p>

                    <div class="border-2 border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-5">Using AI in the UK health system</h4>
                        <p class="leading-loose">
                            AI currently has a limited role in the way <strong>24</strong>
                            <select name="q24" class="appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer mx-1">
                                <option value="" disabled selected>–</option>
                                <option value="A">A</option><option value="B">B</option><option value="C">C</option>
                                <option value="D">D</option><option value="E">E</option><option value="F">F</option>
                            </select>
                            are allocated in the health service. The positive aspect of AI having a bigger role is that it would be more efficient and lead to patient benefits. However, such a change would result, for example, in certain <strong>25</strong>
                            <select name="q25" class="appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer mx-1">
                                <option value="" disabled selected>–</option>
                                <option value="A">A</option><option value="B">B</option><option value="C">C</option>
                                <option value="D">D</option><option value="E">E</option><option value="F">F</option>
                            </select>
                            not having their current level of <strong>26</strong>
                            <select name="q26" class="appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer mx-1">
                                <option value="" disabled selected>–</option>
                                <option value="A">A</option><option value="B">B</option><option value="C">C</option>
                                <option value="D">D</option><option value="E">E</option><option value="F">F</option>
                            </select>
                            . It is therefore important that AI goals are appropriate so that discriminatory practices could be avoided.
                        </p>
                    </div>

                    <div class="mt-4 border border-gray-300 rounded-lg p-4 bg-white text-sm">
                        <div class="grid grid-cols-3 gap-x-6 gap-y-3">
                            <div><span class="font-bold mr-2">A</span> medical practitioners</div>
                            <div><span class="font-bold mr-2">B</span> specialised tasks</div>
                            <div><span class="font-bold mr-2">C</span> available resources</div>
                            <div><span class="font-bold mr-2">D</span> reduced illness</div>
                            <div><span class="font-bold mr-2">E</span> professional authority</div>
                            <div><span class="font-bold mr-2">F</span> technology experts</div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                            Submit Answers
                        </button>
                    </div>
                </div>

                {{-- PASSAGE 3 QUESTIONS --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>

                {{-- Questions 27–33: True/False/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–33</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 27–33 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic">TRUE</span></div><div class="italic">if the statement agrees with the information</div>
                            <div><span class="font-bold italic">FALSE</span></div><div class="italic">if the statement contradicts the information</div>
                            <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if there is no information on this</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-36 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [27, 'People first referred to Leonardo da Vinci as a genius 500 years ago.'],
                                    [28, 'The current climate crisis is predicted to cause more deaths than the plague.'],
                                    [29, 'Some of the challenges we face today can be compared to those of earlier times.'],
                                    [30, "Leonardo da Vinci's 'ideal city' was constructed in the 15th century."],
                                    [31, 'Poor town planning is a major contributor to climate change.'],
                                    [32, 'In Renaissance times, local people fought against the changes to Pienza and Ferrara.'],
                                    [33, 'Leonardo da Vinci kept a neat, organised record of his designs.'],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
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

                {{-- Questions 34–40: Summary Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 34–40</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 34–40 on your answer sheet.</p>

                    <div class="border-2 border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-5">Leonardo da Vinci's ideal city</h4>

                        <p class="leading-[2.2] mb-4">
                            A collection of Leonardo da Vinci's paperwork reveals his design of a new city beside the Ticino River. This was to provide better <strong>34</strong>
                            <input type="text" name="q34" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            for trade and a less polluted environment. Although Leonardo da Vinci's city shared many of the ideals of his time, some of his innovations were considered unconventional in their design. They included features that can be seen in some tower blocks today, such as <strong>35</strong>
                            <input type="text" name="q35" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            on the exterior of a building.
                        </p>

                        <p class="leading-[2.2] mb-4">
                            Leonardo da Vinci wasn't only an architect. His expertise in <strong>36</strong>
                            <input type="text" name="q36" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            was evident in his plans for artificial canals within his ideal city. He also believed that the height of houses should relate to the width of streets in case earthquakes occurred. The design of many cities in Italy today follows this <strong>37</strong>
                            <input type="text" name="q37" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            .
                        </p>

                        <p class="leading-[2.2]">
                            While some cities from <strong>38</strong>
                            <input type="text" name="q38" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            times have aspects that can also be found in Leonardo's designs, his ideas weren't put into practice until long after his death. <strong>39</strong>
                            <input type="text" name="q39" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            is one example of a city that was redesigned in the 19th century in the way that Leonardo had envisaged. His ideas are also relevant to today's world, where building <strong>40</strong>
                            <input type="text" name="q40" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            no longer seems to be the best approach.
                        </p>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                            Submit Answers
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
/* ── Drawing canvas ── */
window.initDrawingCanvas = function(canvas) {
    const ctx = canvas.getContext('2d');
    let drawing = false, mode = 'draw', snap;
    const resize = () => {
        const parent = canvas.parentElement;
        snap = ctx.getImageData(0, 0, canvas.width, canvas.height);
        canvas.width  = parent.scrollWidth;
        canvas.height = parent.scrollHeight;
        ctx.putImageData(snap, 0, 0);
    };
    const pos = e => {
        const r = canvas.getBoundingClientRect();
        if (e.touches) { return { x: e.touches[0].clientX - r.left, y: e.touches[0].clientY - r.top }; }
        return { x: e.clientX - r.left, y: e.clientY - r.top };
    };
    const start = e => {
        drawing = true;
        const p = pos(e);
        ctx.beginPath(); ctx.moveTo(p.x, p.y);
        if (mode === 'erase') {
            const allEls = document.elementsFromPoint(e.clientX, e.clientY);
            const mark = allEls.find(el => el.tagName === 'MARK');
            if (mark) { const parent = mark.parentNode; while (mark.firstChild) { parent.insertBefore(mark.firstChild, mark); } parent.removeChild(mark); parent.normalize(); }
        }
    };
    const move = e => {
        if (!drawing) return;
        const p = pos(e);
        if (mode === 'draw') { ctx.globalCompositeOperation = 'source-over'; ctx.strokeStyle = '#2563eb'; ctx.lineWidth = 2; ctx.lineCap = 'round'; }
        else { ctx.globalCompositeOperation = 'destination-out'; ctx.lineWidth = 20; }
        ctx.lineTo(p.x, p.y); ctx.stroke(); ctx.beginPath(); ctx.moveTo(p.x, p.y);
    };
    const end = () => { drawing = false; ctx.globalCompositeOperation = 'source-over'; };
    canvas.addEventListener('mousedown', start); canvas.addEventListener('mousemove', move);
    canvas.addEventListener('mouseup', end); canvas.addEventListener('mouseleave', end);
    canvas.addEventListener('touchstart', e => { e.preventDefault(); start(e); }, { passive: false });
    canvas.addEventListener('touchmove',  e => { e.preventDefault(); move(e);  }, { passive: false });
    canvas.addEventListener('touchend', end);
    resize();
    return { setMode: m => { mode = m; }, resize };
};

/* ── Text highlight ── */
window.applyAnnotation = function(type, color) {
    const sel = window.getSelection();
    if (!sel || sel.rangeCount === 0 || sel.isCollapsed) return;
    const range = sel.getRangeAt(0);
    const mark  = document.createElement('mark');
    const colors = { yellow: '#fef08a', green: '#bbf7d0', blue: '#bfdbfe', pink: '#fbcfe8' };
    mark.style.backgroundColor = colors[color] || colors.yellow;
    mark.style.borderRadius = '2px';
    try { range.surroundContents(mark); } catch(e) { /* cross-node – skip */ }
    sel.removeAllRanges();
};
window.removeHighlight = function(event) {
    let el = event.target;
    while (el && el.tagName !== 'MARK') {
        if (el.classList && el.classList.contains('passage-content')) break;
        el = el.parentElement;
    }
    if (el && el.tagName === 'MARK') {
        const parent = el.parentNode;
        while (el.firstChild) { parent.insertBefore(el.firstChild, el); }
        parent.removeChild(el);
        parent.normalize();
    }
};
</script>

</body>
</html>

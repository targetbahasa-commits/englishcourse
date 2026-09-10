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
    </style>
</head>
<body class="font-sans antialiased bg-white">
    @include('components.impersonation-banner')
    @include('components.cambridge-guest-signup-modal')
    @include('components.program-sidebar')

{{-- Fixed full-screen layout --}}
<div class="fixed inset-0 z-0 flex flex-col" style="padding-left: 0;">

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
            <a href="{{ $backUrl ?? route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId]) }}" class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                {{ $backLabel ?? 'Back' }}
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
            {{-- Drawing canvas --}}
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

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">Why we need to protect polar bears</h3>



                        {{-- Passage text --}}
                        <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                             @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                             @click="if(eraserMode) window.removeHighlight($event);">

                            <p>Polar bears are being increasingly threatened by the effects of climate change, but their disappearance could have far-reaching consequences. They are uniquely adapted to the extreme conditions of the Arctic Circle, where temperatures can reach −40°C. One reason for this is that they have up to 11 centimetres of fat underneath their skin. Humans with comparative levels of adipose tissue would be considered obese and would be likely to suffer from diabetes and heart disease. Yet the polar bear experiences no such consequences.</p>

                            <p>A 2014 study by Shi Ping Liu and colleagues sheds light on this mystery. They compared the genetic structure of polar bears with that of their closest relatives from a warmer climate, the brown bears. This allowed them to determine the genes that have allowed polar bears to survive in one of the toughest environments on Earth. Liu and his colleagues found the polar bears had a gene known as APoB, which reduces levels of low-density lipoproteins (LDLs) – a form of 'bad' cholesterol. In humans, mutations of this gene are associated with increased risk of heart disease. Polar bears may therefore be an important study model to understand heart disease in humans.</p>

                            <p>The genome of the polar bear may also provide the solution for another condition, one that particularly affects our older generation: osteoporosis. This is a disease where bones show reduced density, usually caused by insufficient exercise, reduced calcium intake or food starvation. Bone tissue is constantly being remodelled, meaning that bone is added or removed, depending on nutrient availability and the stress that the bone is under. Female polar bears, however, undergo extreme conditions during every pregnancy. Once autumn comes around, these females will dig maternity dens in the snow and will remain there throughout the winter, both before and after the birth of their cubs. This process results in about six months of fasting, where the female bears have to keep themselves and their cubs alive, depleting their own calcium and calorie reserves. Despite this, their bones remain strong and dense.</p>

                            <p>Physiologists Alanda Lennox and Allen Goodship found an explanation for this paradox in 2008. They discovered that pregnant bears were able to increase the density of their bones before they started to build their dens. In addition, six months later, when they finally emerged from the den with their cubs, there was no evidence of significant loss of bone density. Hibernating brown bears do not have this capacity and must therefore resort to major bone reformation in the following spring. If the mechanism of bone remodelling in polar bears can be understood, many bedridden humans, and even astronauts, could potentially benefit.</p>

                            <p>The medical benefits of the polar bear for humanity certainly have their importance in our conservation efforts, but these should not be the only factors taken into consideration. We tend to want to protect animals we think are intelligent and possess emotions, such as elephants and primates. Bears, on the other hand, seem to be perceived as stupid and in many cases violent. And yet anecdotal evidence from the field challenges those assumptions, suggesting for example that polar bears have good problem-solving abilities. A male bear called GoGo in Tennoji Zoo, Osaka, has even been observed making use of a tool to manipulate his environment. The bear used a tree branch on multiple occasions to dislodge a piece of meat hung out of his reach. Problem-solving ability has also been witnessed in wild polar bears, although not as obviously as with GoGo. A calculated move by a male bear involved running and jumping onto barrels in an attempt to get to a photographer standing on a platform four metres high.</p>

                            <p>In other studies, such as one by Alison Ames in 2008, polar bears showed deliberate and focussed manipulation. For example, Ames observed bears putting objects in piles and then knocking them over in what appeared to be a game. The study demonstrates that bears are capable of agile and thought-out behaviours. These examples suggest bears have greater creativity and problem-solving abilities than previously thought.</p>

                            <p>As for emotions, while the evidence is once again anecdotal, many bears have been seen to hit out at ice and snow – seemingly out of frustration – when they have just missed out on a kill. Moreover, polar bears can form unusual relationships with other species, including playing with the dogs used to pull sleds in the Arctic. Remarkably, one hand-raised polar bear called Agee has formed a close relationship with her owner Mark Dumas to the point where they even swim together. This is even more astonishing since polar bears are known to actively hunt humans in the wild.</p>

                            <p>If climate change were to lead to their extinction, this would mean not only the loss of potential breakthroughs in human medicine, but more importantly, the disappearance of an intelligent, majestic animal.</p>
                        </div>

                        {{-- Floating Annotation Toolbar --}}


                </div>

                {{-- Passage 2 --}}
                <div class="mb-6 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 on pages 21 and 22.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">The Step Pyramid of Djoser</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">A</span>
                            <p>The pyramids are the most famous monuments of ancient Egypt and still hold enormous interest for people in the present day. These grand, impressive tributes to the memory of the Egyptian kings have become linked with the country even though other cultures, such as the Chinese and Mayan, also built pyramids. The evolution of the pyramid form has been written and argued about for centuries. However, there is no question that, as far as Egypt is concerned, it began with one monument to one king designed by one brilliant architect: the Step Pyramid of Djoser at Saqqara.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">B</span>
                            <p>Djoser was the first king of the Third Dynasty of Egypt and the first to build in stone. Prior to Djoser's reign, tombs were rectangular monuments made of dried clay brick, which covered underground passages where the deceased person was buried. For reasons which remain unclear, Djoser's main official, whose name was Imhotep, conceived of building a taller, more impressive tomb for his king by stacking stone slabs on top of one another, progressively making them smaller, to form the shape now known as the Step Pyramid. Djoser is thought to have reigned for 19 years, but some historians and scholars attribute a much longer time for his rule, owing to the number and size of the monuments he built.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">C</span>
                            <p>The Step Pyramid has been thoroughly examined and investigated over the last century, and it is now known that the building process went through many different stages. Historian Marc Van de Mieroop comments on this, writing 'Much experimentation was involved, which is especially clear in the construction of the pyramid in the center of the complex. It had several plans … before it became the first Step Pyramid in history, piling six levels on top of one another … The weight of the enormous mass was a challenge for the builders, who placed the stones at an inward incline in order to prevent the monument breaking up.'</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">D</span>
                            <p>When finally completed, the Step Pyramid rose 62 meters high and was the tallest structure of its time. The complex in which it was built was the size of a city in ancient Egypt and included a temple, courtyards, shrines, and living quarters for the priests. It covered a region of 16 hectares and was surrounded by a wall 10.5 meters high. The wall had 13 false doors cut into it with only one true entrance cut into the south-east corner; the entire wall was then ringed by a trench 750 meters long and 40 meters wide. The false doors and the trench were incorporated into the complex to discourage unwanted visitors. If someone wished to enter, he or she would have needed to know in advance how to find the location of the true opening in the wall. Djoser was so proud of his accomplishment that he broke the tradition of having only his own name on the monument and had Imhotep's name carved on it as well.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">E</span>
                            <p>The burial chamber of the tomb, where the king's body was laid to rest, was dug beneath the base of the pyramid, surrounded by a vast maze of long tunnels that had rooms off them to discourage robbers. One of the most mysterious discoveries found inside the pyramid was a large number of stone vessels. Over 40,000 of these vessels, of various forms and shapes, were discovered in storerooms off the pyramid's underground passages. They are inscribed with the names of rulers from the First and Second Dynasties of Egypt and made from different kinds of stone. There is no agreement among scholars and archaeologists on why the vessels were placed in the tomb of Djoser or what they were supposed to represent. The archaeologist Jean-Philippe Lauer, who excavated most of the pyramid and complex, believes they were originally stored and then given a 'proper burial' by Djoser in his pyramid to honor his predecessors. There are other historians, however, who claim the vessels were dumped into the shafts as yet another attempt to prevent grave robbers from getting to the king's burial chamber.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">F</span>
                            <p>Unfortunately, all of the precautions and intricate design of the underground network did not prevent ancient robbers from finding a way in. Djoser's grave goods, and even his body, were stolen at some point in the past and all archaeologists found were a small number of his valuables overlooked by the thieves. There was enough left throughout the pyramid and its complex, however, to astonish and amaze the archaeologists who excavated it.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">G</span>
                            <p>Egyptologist Miroslav Verner writes, 'Few monuments hold a place in human history as significant as that of the Step Pyramid in Saqqara … It can be said without exaggeration that this pyramid complex constitutes a milestone in the evolution of monumental stone architecture in Egypt and in the world as a whole.' The Step Pyramid was a revolutionary advance in architecture and became the archetype which all the other great pyramid builders of Egypt would follow.</p>
                        </div>
                    </div>
                </div>

                {{-- Passage 3 --}}
                <div class="mb-6 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">The future of work</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">
                        <p>According to a leading business consultancy, 3–14% of the global workforce will need to switch to a different occupation within the next 10–15 years, and all workers will need to adapt as their occupations evolve alongside increasingly capable machines. Automation – or 'embodied artificial intelligence' (AI) – is one aspect of the disruptive effects of technology on the labour market. 'Disembodied AI', like the algorithms running in our smartphones, is another.</p>

                        <p>Dr Stella Pachidi from Cambridge Judge Business School believes that some of the most fundamental changes are happening as a result of the 'algorithmication' of jobs that are dependent on data rather than on production – the so-called knowledge economy. Algorithms are capable of learning from data to undertake tasks that previously needed human judgement, such as reading legal contracts, analysing medical scans and gathering market intelligence.</p>

                        <p>'In many cases, they can outperform humans,' says Pachidi. 'Organisations are attracted to using algorithms because they want to make choices based on what they consider is "perfect information", as well as to reduce costs and enhance productivity.'</p>

                        <p>'But these enhancements are not without consequences,' says Pachidi. 'If routine cognitive tasks are taken over by AI, how do professions develop their future experts?' she asks. 'One way of learning about a job is "legitimate peripheral participation" – a novice stands next to experts and learns by observation. If this isn't happening, then you need to find new ways to learn.'</p>

                        <p>Another issue is the extent to which the technology influences or even controls the workforce. For over two years, Pachidi monitored a telecommunications company. 'The way telecoms salespeople work is through personal and frequent contact with clients, using the benefit of experience to assess a situation and reach a decision. However, the company had started using a[n] … algorithm that defined when account managers should contact certain customers about which kinds of campaigns and what to offer them.'</p>

                        <p>The algorithm – usually built by external designers – often becomes the keeper of knowledge, she explains. In cases like this, Pachidi believes, a short-sighted view begins to creep into working practices whereby workers learn through the 'algorithm's eyes' and become dependent on its instructions. Alternative explorations – where experimentation and human instinct lead to progress and new ideas – are effectively discouraged.</p>

                        <p>Pachidi and colleagues even observed people developing strategies to make the algorithm work to their own advantage. 'We are seeing cases where workers feed the algorithm with false data to reach their targets,' she reports.</p>
                    </div>
                </div>

                {{-- Floating Annotation Toolbar --}}
                <div class="sticky bottom-6 w-full flex flex-col items-center pointer-events-none z-30 mt-4 mb-2">
                    {{-- Colour picker (shows when highlight active) --}}
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

                        {{-- Highlight --}}
                        <button @click="highlightMode=!highlightMode; pencilMode=false; eraserMode=false;"
                                class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white opacity-90 hover:opacity-100 hover:shadow-md hover:text-green-600 hover:border-green-400 hover:scale-105 transition-all"
                                :class="{ '!bg-green-500 !text-white !border-green-600 shadow-md !opacity-100': highlightMode }"
                                title="Highlight Tool">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                        </button>

                        {{-- Pencil --}}
                        <button @click="pencilMode=!pencilMode; highlightMode=false; eraserMode=false;"
                                class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white opacity-90 hover:opacity-100 hover:shadow-md hover:text-blue-600 hover:border-blue-400 hover:scale-105 transition-all"
                                :class="{ '!bg-blue-500 !text-white !border-blue-600 shadow-md !opacity-100': pencilMode }"
                                title="Pencil Tool">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>

                        {{-- Eraser --}}
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
        <div class="h-full overflow-y-auto bg-white custom-scrollbar">
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto">

                {{-- Questions 1–7: True/False/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–7</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 1?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 1–7 on your answer sheet, write</p>

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
                                    [1, "Polar bears suffer from various health problems due to the build-up of fat under their skin."],
                                    [2, "The study done by Liu and his colleagues compared different groups of polar bears."],
                                    [3, "Liu and colleagues were the first researchers to compare polar bears and brown bears genetically."],
                                    [4, "Polar bears are able to control their levels of 'bad' cholesterol by genetic means."],
                                    [5, "Female polar bears are able to survive for about six months without food."],
                                    [6, "It was found that the bones of female polar bears were very weak when they came out of their dens in spring."],
                                    [7, "The polar bear's mechanism for increasing bone density could also be used by people one day."],
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

                {{-- Questions 8–13: Table Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 8–13</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the table below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 8–13 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-white text-sm">
                        <h4 class="text-base font-bold text-center mb-4">Reasons why polar bears should be protected</h4>

                        <p class="mb-3 text-gray-800">People think of bears as unintelligent and <span class="font-bold">8</span>
                            <input type="text" name="q8" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">.</p>

                        <p class="mb-2 text-gray-800">However, this may not be correct. For example:</p>
                        <ul class="list-disc ml-5 space-y-3 mb-4">
                            <li class="text-gray-800">
                                In Tennoji Zoo, a bear has been seen using a branch as a <span class="font-bold">9</span>
                                <input type="text" name="q9" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">.
                                This allowed him to knock down some <span class="font-bold">10</span>
                                <input type="text" name="q10" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">.
                            </li>
                            <li class="text-gray-800">
                                A wild polar bear worked out a method of reaching a platform where a <span class="font-bold">11</span>
                                <input type="text" name="q11" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> was located.
                            </li>
                            <li class="text-gray-800">
                                Polar bears have displayed behaviour such as conscious manipulation of objects and activity similar to a <span class="font-bold">12</span>
                                <input type="text" name="q12" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">.
                            </li>
                        </ul>

                        <p class="mb-2 text-gray-800">Bears may also display emotions. For example:</p>
                        <ul class="list-disc ml-5 space-y-3">
                            <li class="text-gray-800">
                                They may make movements suggesting <span class="font-bold">13</span>
                                <input type="text" name="q13" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> if disappointed when hunting.
                            </li>
                            <li class="text-gray-800">They may form relationships with other species.</li>
                        </ul>
                    </div>

                    {{-- Submit --}}
                    <div class="mt-6 flex justify-end">
                        <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                            Submit Answers
                        </button>
                    </div>
                </div>

                {{-- ── PASSAGE 2 Questions ── --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Q14-20: Matching Headings --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–20</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 2 has seven paragraphs, <strong>A–G</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose the correct heading for each paragraph from the list of headings below.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct number, <strong><em>i–ix</em></strong>, in boxes 14–20 on your answer sheet.</p>

                    {{-- List of Headings box --}}
                    <div class="border-2 border-gray-400 p-4 rounded mb-6 bg-white text-sm">
                        <p class="text-center font-bold mb-3">List of Headings</p>
                        @foreach([
                            ['i',    'The areas and artefacts within the pyramid itself'],
                            ['ii',   'A difficult task for those involved'],
                            ['iii',  'A king who saved his people'],
                            ['iv',   'A single certainty among other less definite facts'],
                            ['v',    'An overview of the external buildings and areas'],
                            ['vi',   'A pyramid design that others copied'],
                            ['vii',  'An idea for changing the design of burial structures'],
                            ['viii', 'An incredible experience despite the few remains'],
                            ['ix',   'The answers to some unexpected questions'],
                        ] as [$roman, $text])
                        <div class="flex gap-3 py-1">
                            <span class="font-bold italic w-8 flex-none text-right">{{ $roman }}</span>
                            <span>{{ $text }}</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-white border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Paragraph</th>
                                    <th class="p-3 font-bold text-gray-600 w-36 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [14, 'A'], [15, 'B'], [16, 'C'], [17, 'D'], [18, 'E'], [19, 'F'], [20, 'G']
                                ] as [$num, $para])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm font-medium">Paragraph <strong>{{ $para }}</strong></td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                @foreach(['i','ii','iii','iv','v','vi','vii','viii','ix'] as $opt)
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

                {{-- Q21-24: Note Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 21–24</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 21–24 on your answer sheet.</p>

                    <div class="border-2 border-gray-400 rounded-lg p-5 bg-white text-sm">
                        <h4 class="text-base font-bold text-center mb-4">The Step Pyramid of Djoser</h4>

                        <p class="mb-4 text-gray-800 leading-loose">
                            The complex that includes the Step Pyramid and its surroundings is considered to be as big as an Egyptian <strong>21</strong>
                            <input type="text" name="q21" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            of the past. The area outside the pyramid included accommodation that was occupied by <strong>22</strong>
                            <input type="text" name="q22" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            , along with many other buildings and features.
                        </p>

                        <p class="text-gray-800 leading-loose">
                            A wall ran around the outside of the complex and a number of false entrances were built into this. In addition, a long <strong>23</strong>
                            <input type="text" name="q23" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            encircled the wall. As a result, any visitors who had not been invited were cleverly prevented from entering the pyramid grounds unless they knew the <strong>24</strong>
                            <input type="text" name="q24" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            of the real entrance.
                        </p>
                    </div>
                </div>

                {{-- Q25-26: Choose TWO --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 25–26</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Write the correct letters in boxes 25 and 26 on your answer sheet.</p>
                    <p class="text-sm text-gray-800 mb-4">Which <strong>TWO</strong> of the following points does the writer make about King Djoser?</p>

                    <div class="space-y-3">
                        @foreach([
                            ['A', 'Initially he had to be persuaded to build in stone rather than clay.'],
                            ['B', 'There is disagreement concerning the length of his reign.'],
                            ['C', 'He failed to appreciate Imhotep\'s part in the design of the Step Pyramid.'],
                            ['D', 'A few of his possessions were still in his tomb when archaeologists found it.'],
                            ['E', 'He criticised the design and construction of other pyramids in Egypt.'],
                        ] as [$letter, $text])
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="q25_26[]" value="{{ $letter }}"
                                   class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none">
                            <span class="text-sm text-gray-800 group-hover:text-blue-700 transition-colors">
                                <strong>{{ $letter }}</strong>&nbsp; {{ $text }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 mt-3 italic">Select exactly two options.</p>
                </div>

                {{-- ── PASSAGE 3 Questions (placeholder) ── --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>

                {{-- Q27-30: MCQ A-D --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–30</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 27–30 on your answer sheet.</p>

                    <div class="space-y-6">
                        @foreach([
                            [27, 'The first paragraph tells us about', [
                                'A' => 'the kinds of jobs that will be most affected by the growth of AI.',
                                'B' => 'the extent to which AI will alter the nature of the work that people do.',
                                'C' => 'the proportion of the world\'s labour force who will have jobs in AI in the future.',
                                'D' => 'the difference between ways that embodied and disembodied AI will impact on workers.',
                            ]],
                            [28, 'According to the second paragraph, what is Stella Pachidi\'s view of the \'knowledge economy\'?', [
                                'A' => 'It is having an influence on the number of jobs available.',
                                'B' => 'It is changing people\'s attitudes towards their occupations.',
                                'C' => 'It is the main reason why the production sector is declining.',
                                'D' => 'It is a key factor driving current developments in the workplace.',
                            ]],
                            [29, 'What did Pachidi observe at the telecommunications company?', [
                                'A' => 'staff disagreeing with the recommendations of AI',
                                'B' => 'staff feeling resentful about the intrusion of AI in their work',
                                'C' => 'staff making sure that AI produces the results that they want',
                                'D' => 'staff allowing AI to carry out tasks they ought to do themselves',
                            ]],
                            [30, 'In his recently published research, Ewan McGaughey', [
                                'A' => 'challenges the idea that redundancy is a negative thing.',
                                'B' => 'shows the profound effect of mass unemployment on society.',
                                'C' => 'highlights some differences between past and future job losses.',
                                'D' => 'illustrates how changes in the job market can be successfully handled.',
                            ]],
                        ] as [$num, $question, $opts])
                        <div>
                            <p class="text-sm font-semibold text-gray-800 mb-2"><span class="text-blue-600 font-bold mr-1">{{ $num }}</span> {{ $question }}</p>
                            <div class="space-y-2 ml-4">
                                @foreach($opts as $letter => $text)
                                <label class="flex items-start gap-4 cursor-pointer group">
                                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}"
                                           class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer flex-none">
                                    <span class="text-sm text-gray-800 group-hover:text-blue-700 transition-colors">
                                        <strong class="inline-block min-w-[1rem]">{{ $letter }}</strong>&nbsp; {{ $text }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Q31-34: Summary completion with word bank A-G --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 31–34</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Complete the summary using the list of words, <strong>A–G</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–G</strong>, in boxes 31–34 on your answer sheet.</p>

                    {{-- Summary box --}}
                    <div class="border border-gray-300 rounded-lg p-5 bg-white text-sm mb-5">
                        <h4 class="text-base font-bold text-center mb-4">The 'algorithmication' of jobs</h4>

                        <p class="text-gray-800 leading-loose mb-4">
                            Stella Pachidi of Cambridge Judge Business School has been focusing on the 'algorithmication' of jobs which rely not on production but on
                            <strong>31</strong>
                            <select name="q31" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>.
                        </p>
                        <p class="text-gray-800 leading-loose mb-4">
                            While monitoring a telecommunications company, Pachidi observed a growing
                            <strong>32</strong>
                            <select name="q32" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            on the recommendations made by AI, as workers begin to learn through the 'algorithm's eyes'. Meanwhile, staff are deterred from experimenting and using their own
                            <strong>33</strong>
                            <select name="q33" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            , and are therefore prevented from achieving innovation.
                        </p>
                        <p class="text-gray-800 leading-loose">
                            To avoid the kind of situations which Pachidi observed, researchers are trying to make AI's decision-making process easier to comprehend, and to increase users'
                            <strong>34</strong>
                            <select name="q34" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            with regard to the technology.
                        </p>
                    </div>

                    {{-- Word bank --}}
                    <div class="border border-gray-400 p-5 bg-white text-sm mx-auto w-fit pr-16 mb-2">
                        <div class="grid gap-x-12 gap-y-3" style="grid-template-columns: repeat(3, minmax(0, 1fr));">
                            @foreach(['A' => 'pressure', 'B' => 'satisfaction', 'C' => 'intuition', 'D' => 'promotion', 'E' => 'reliance', 'F' => 'confidence', 'G' => 'information'] as $l => $w)
                            <div class="flex gap-4"><span class="font-bold text-gray-900 w-4">{{ $l }}</span> <span class="text-gray-800">{{ $w }}</span></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Q35-40: Matching people --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 35–40</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Look at the following statements (Questions 35–40) and the list of people below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Match each statement with the correct person, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Write the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>, in boxes 35–40 on your answer sheet.</p>
                    <p class="text-sm italic text-gray-700 mb-4"><strong>NB</strong> You may use any letter more than once.</p>

                    {{-- List of people --}}
                    <div class="border border-gray-300 rounded p-4 bg-white text-sm mb-5 inline-block">
                        <p class="font-bold text-center mb-2">List of people</p>
                        <div class="space-y-1">
                            <div><span class="font-bold">A</span>&nbsp; Stella Pachidi</div>
                            <div><span class="font-bold">B</span>&nbsp; Hamish Low</div>
                            <div><span class="font-bold">C</span>&nbsp; Ewan McGaughey</div>
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
                                    [35, 'Greater levels of automation will not result in lower employment.'],
                                    [36, 'There are several reasons why AI is appealing to businesses.'],
                                    [37, 'AI\'s potential to transform people\'s lives has parallels with major cultural shifts which occurred in previous eras.'],
                                    [38, 'It is important to be aware of the range of problems that AI causes.'],
                                    [39, 'People are going to follow a less conventional career path than in the past.'],
                                    [40, 'Authorities should take measures to ensure that there will be adequately paid work for everyone.'],
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


                {{-- Final Submit --}}
                <div class="mt-6 flex justify-end">
                    <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                        Submit All Answers
                    </button>
                </div>

            </div>
        </div>


    </div>
</div>

<script>
/* ── Drawing canvas (pencil / eraser) ── */
window.initDrawingCanvas = function(canvas) {
    const ctx = canvas.getContext('2d');
    let drawing = false, mode = 'draw';
    const resize = () => {
        const rect = canvas.parentElement.getBoundingClientRect();
        const dpr  = window.devicePixelRatio || 1;
        const snap = ctx.getImageData(0, 0, canvas.width, canvas.height);
        canvas.width  = rect.width  * dpr;
        canvas.height = rect.height * dpr;
        ctx.scale(dpr, dpr);
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
        ctx.beginPath();
        ctx.moveTo(p.x, p.y);
        // When erasing: also remove any <mark> highlight under the cursor
        if (mode === 'erase') {
            const allEls = document.elementsFromPoint(e.clientX, e.clientY);
            const mark = allEls.find(el => el.tagName === 'MARK');
            if (mark) {
                const parent = mark.parentNode;
                while (mark.firstChild) { parent.insertBefore(mark.firstChild, mark); }
                parent.removeChild(mark);
                parent.normalize();
            }
        }
    };
    const move  = e => {
        if (!drawing) return;
        const p = pos(e);
        if (mode === 'draw') {
            ctx.globalCompositeOperation = 'source-over';
            ctx.strokeStyle = '#2563eb'; ctx.lineWidth = 2; ctx.lineCap = 'round';
        } else {
            ctx.globalCompositeOperation = 'destination-out';
            ctx.lineWidth = 20;
        }
        ctx.lineTo(p.x, p.y); ctx.stroke(); ctx.beginPath(); ctx.moveTo(p.x, p.y);
    };
    const end = () => { drawing = false; ctx.globalCompositeOperation = 'source-over'; };
    canvas.addEventListener('mousedown', start); canvas.addEventListener('mousemove', move);
    canvas.addEventListener('mouseup',   end);   canvas.addEventListener('mouseleave', end);
    canvas.addEventListener('touchstart', e => { e.preventDefault(); start(e); }, { passive: false });
    canvas.addEventListener('touchmove',  e => { e.preventDefault(); move(e);  }, { passive: false });
    canvas.addEventListener('touchend',   end);
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
    try { range.surroundContents(mark); } catch(e) { /* cross-node range – skip */ }
    sel.removeAllRanges();
};
/* ── Remove highlight ── */
window.removeHighlight = function(event) {
    let el = event.target;
    // Walk up to find a <mark> element
    while (el && el.tagName !== 'MARK') {
        if (el.classList && el.classList.contains('passage-content')) break;
        el = el.parentElement;
    }
    if (el && el.tagName === 'MARK') {
        // Replace the <mark> with its text content
        const parent = el.parentNode;
        while (el.firstChild) {
            parent.insertBefore(el.firstChild, el);
        }
        parent.removeChild(el);
        parent.normalize(); // merge adjacent text nodes
    }
};
</script>

</body>
</html>

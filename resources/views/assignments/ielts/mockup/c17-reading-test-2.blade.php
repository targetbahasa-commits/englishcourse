<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Reading Mock Test {{ $testId ?? 2 }} - {{ config('app.name', 'Target Bahasa') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        html, body { height: 100%; overflow: hidden; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .dotted-answer { border-bottom: 1px dotted #000; display: inline-block; min-width: 120px; }
        input[type=text].ans { border: none; border-bottom: 1px solid #6b7280; outline: none; padding: 2px 4px; width: 120px; background: transparent; }
        input[type=text].ans:focus { border-bottom-color: #3b82f6; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')

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
                    <h1 class="text-xl font-bold text-gray-800">IELTS Reading – Mock Test {{ $testId ?? 2 }}</h1>
                    <p class="text-sm text-gray-500">Cambridge {{ $edition ?? 17 }} Reading Practice</p>
                </div>
            </div>
            <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition ?? 17, 'id' => $testId ?? 2]) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
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

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">The Dead Sea Scrolls</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p>In late 1946 or early 1947, three Bedouin teenagers were tending their goats and sheep near the ancient settlement of Qumran, located on the northwest shore of the Dead Sea in what is now known as the West Bank. One of these young shepherds tossed a rock into an opening on the side of a cliff and was surprised to hear a shattering sound. He and his companions later entered the cave and stumbled across a collection of large clay jars, seven of which contained scrolls with writing on them. The teenagers took the seven scrolls to a nearby town where they were sold for a small sum to a local antiquities dealer. Word of the find spread, and Bedouins and archaeologists eventually unearthed tens of thousands of additional scroll fragments from 10 nearby caves; together they make up between 800 and 900 manuscripts. It soon became clear that this was one of the greatest archaeological discoveries ever made.</p>
                        
                        <p>The origin of the Dead Sea Scrolls, which were written around 2,000 years ago between 150 BCE and 70 CE, is still the subject of scholarly debate even today. According to the prevailing theory, they are the work of a population that inhabited the area until Roman troops destroyed the settlement around 70 CE. The area was known as Judea at that time, and the people are thought to have belonged to a group called the Essenes, a devout Jewish sect.</p>
                        
                        <p>The majority of the texts on the Dead Sea Scrolls are in Hebrew, with some fragments written in an ancient version of its alphabet thought to have fallen out of use in the fifth century BCE. But there are other languages as well. Some scrolls are in Aramaic, the language spoken by many inhabitants of the region from the sixth century BCE to the siege of Jerusalem in 70 CE. In addition, several texts feature translations of the Hebrew Bible into Greek.</p>
                        
                        <p>The Dead Sea Scrolls include fragments from every book of the Old Testament of the Bible except for the Book of Esther. The only entire book of the Hebrew Bible preserved among the manuscripts from Qumran is Isaiah; this copy, dated to the first century BCE, is considered the earliest biblical manuscript still in existence. Along with biblical texts, the scrolls include documents about sectarian regulations and religious writings that do not appear in the Old Testament.</p>

                        <p class="italic text-gray-500">[Part 2 of the passage regarding the Copper Scroll and Mar Samuel would continue here...]</p>
                    </div>
                </div>

                {{-- Passage 2 --}}
                <div class="mb-6 mt-10" id="passage-2">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 below.</p>

                    <h3 class="text-3xl font-bold text-center text-gray-900 mb-8">A second attempt at domesticating the tomato</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <div class="flex gap-4">
                            <span class="font-bold text-lg w-6 flex-none mt-1">A</span>
                            <div class="space-y-4">
                                <p>It took at least 3,000 years for humans to learn how to domesticate the wild tomato and cultivate it for food. Now two separate teams in Brazil and China have done it all over again in less than three years. And they have done it better in some ways, as the re-domesticated tomatoes are more nutritious than the ones we eat at present.</p>
                                <p>This approach relies on the revolutionary CRISPR genome editing technique, in which changes are deliberately made to the DNA of a living cell, allowing genetic material to be added, removed or altered. The technique could not only improve existing crops, but could also be used to turn thousands of wild plants into useful and appealing foods. In fact, a third team in the US has already begun to do this with a relative of the tomato called the groundcherry.</p>
                                <p>This fast-track domestication could help make the world's food supply healthier and far more resistant to diseases, such as the rust fungus devastating wheat crops.</p>
                                <p>'This could transform what we eat,' says Jorg Kudla at the University of Munster in Germany, a member of the Brazilian team. 'There are 50,000 edible plants in the world, but 90 percent of our energy comes from just 15 crops.'</p>
                                <p>'We can now mimic the known domestication course of major crops like rice, maize, sorghum or others,' says Caixia Gao of the Chinese Academy of Sciences in Beijing. 'Then we might try to domesticate plants that have never been domesticated.'</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold text-lg w-6 flex-none mt-1">B</span>
                            <div class="space-y-4">
                                <p>Wild tomatoes, which are native to the Andes region in South America, produce pea-sized fruits. Over many generations, peoples such as the Aztecs and Incas transformed the plant by selecting and breeding plants with mutations* in their genetic structure, which resulted in desirable traits such as larger fruit.</p>
                                <p>But every time a single plant with a mutation is taken from a larger population for breeding, much genetic diversity is lost. And sometimes the desirable mutations come with less desirable traits. For instance, the tomato strains grown for supermarkets have lost much of their flavour.</p>
                                <p>By comparing the genomes of modern plants to those of their wild relatives, biologists have been working out what genetic changes occurred as plants were domesticated. The teams in Brazil and China have now used this knowledge to reintroduce these changes from scratch while maintaining or even enhancing the desirable traits of wild strains.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold text-lg w-6 flex-none mt-1">C</span>
                            <div class="space-y-4">
                                <p>Kudla's team made six changes altogether. For instance, they tripled the size of fruit by editing a gene called FRUIT WEIGHT, and increased the number of tomatoes per truss by editing another called MULTIFLORA.</p>
                                <p>While the historical domestication of tomatoes reduced levels of the red pigment lycopene – thought to have potential health benefits – the team in Brazil managed to boost it instead. The wild tomato has twice as much lycopene as cultivated ones; the newly domesticated one has five times as much.</p>
                                <p>'They are quite tasty,' says Kudla. 'A little bit strong. And very aromatic.'</p>
                                <p>The team in China re-domesticated several strains of wild tomatoes with desirable traits lost in domesticated tomatoes. In this way they managed to create a strain resistant to a common disease called bacterial spot race, which can devastate yields. They also created another strain that is more salt tolerant – and has higher levels of vitamin C.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold text-lg w-6 flex-none mt-1">D</span>
                            <div class="space-y-4">
                                <p>Meanwhile, Joyce Van Eck at the Boyce Thompson Institute in New York state decided to use the same approach to domesticate the groundcherry or goldenberry (<em>Physalis pruinosa</em>) for the first time. This fruit looks similar to the closely related Cape gooseberry (<em>Physalis peruviana</em>).</p>
                                <p>Groundcherries are already sold to a limited extent in the US but they are hard to produce because the plant has a sprawling growth habit and the small fruits fall off the branches when ripe. Van Eck's team has edited the plants to increase fruit size, make their growth more compact and to stop fruits dropping. 'There's potential for this to be a commercial crop,' says Van Eck. But she adds that taking the work further would be expensive because of the need to pay for a licence for the CRISPR technology and get regulatory approval.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold text-lg w-6 flex-none mt-1">E</span>
                            <div class="space-y-4">
                                <p>This approach could boost the use of many obscure plants, says Jonathan Jones of the Sainsbury Lab in the UK. But it will be hard for new foods to grow so popular with farmers and consumers that they become new staple crops, he thinks.</p>
                                <p>The three teams already have their eye on other plants that could be 'catapulted into the mainstream', including foxtail, oat-grass and cowpea. By choosing wild plants that are drought or heat tolerant, says Gao, we could create crops that will thrive even as the planet warms.</p>
                                <p>But Kudla didn't want to reveal which species were in his team's sights, because CRISPR has made the process so easy. 'Any one with the right skills could go to their lab and do this.'</p>
                            </div>
                        </div>

                        <p class="text-xs text-gray-500 mt-6 border-t pt-3">* mutations: changes in an organism's genetic structure that can be passed down to later generations</p>
                    </div>
                </div>

                {{-- Passage 3 --}}
                <div class="mb-6 mt-10" id="passage-3">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                    <h3 class="text-3xl font-bold text-center text-gray-900 mb-4">Insight or evolution?</h3>
                    <p class="text-center italic text-gray-700 text-lg mb-8">Two scientists consider the origins of discoveries and other innovative behavior</p>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p>Scientific discovery is popularly believed to result from the sheer genius of such intellectual stars as naturalist Charles Darwin and theoretical physicist Albert Einstein. Our view of such unique contributions to science often disregards the person's prior experience and the efforts of their lesser-known predecessors. Conventional wisdom also places great weight on insight in promoting breakthrough scientific achievements, as if ideas spontaneously pop into someone's head – fully formed and functional.</p>

                        <p>There may be some limited truth to this view. However, we believe that it largely misrepresents the real nature of scientific discovery, as well as that of creativity and innovation in many other realms of human endeavor.</p>

                        <p>Setting aside such greats as Darwin and Einstein – whose monumental contributions are duly celebrated – we suggest that innovation is more a process of trial and error, where two steps forward may sometimes come with one step back, as well as one or more steps to the right or left. This evolutionary view of human innovation undermines the notion of creative genius and recognizes the cumulative nature of scientific progress.</p>

                        <p>Consider one unheralded scientist: John Nicholson, a mathematical physicist working in the 1910s who postulated the existence of 'proto-elements' in outer space. By combining different numbers of weights of these proto-elements' atoms, Nicholson could recover the weights of all the elements in the then-known periodic table. These successes are all the more noteworthy given the fact that Nicholson was wrong about the presence of proto-elements: they do not actually exist. Yet, amid his often fanciful theories and wild speculations, Nicholson also proposed a novel theory about the structure of atoms. Niels Bohr, the Nobel prize-winning father of modern atomic theory, jumped off from this interesting idea to conceive his now-famous model of the atom.</p>

                        <p>What are we to make of this story? One might simply conclude that science is a collective and cumulative enterprise. That may be true, but there may be a deeper insight to be gleaned. We propose that science is constantly evolving, much as species of animals do. In biological systems, organisms may display new characteristics that result from random genetic mutations. In the same way, random, arbitrary or accidental mutations of ideas may help pave the way for advances in science. If mutations prove beneficial, then the animal or the scientific theory will continue to thrive and perhaps reproduce.</p>

                        <p>Support for this evolutionary view of behavioral innovation comes from many domains. Consider one example of an influential innovation in US horseracing. The so-called 'acey-deucy' stirrup placement, in which the rider's foot in his left stirrup is placed as much as 25 centimeters lower than the right, is believed to confer important speed advantages when turning on oval tracks. It was developed by a relatively unknown jockey named Jackie Westrope. Had Westrope conducted methodical investigations or examined extensive film records in a shrewd plan to outrun his rivals? Had he foreseen the speed advantage that would be conferred by riding acey-deucy? No. He suffered a leg injury, which left him unable to fully bend his left knee. His modification just happened to coincide with enhanced left-hand turning performance. This led to the rapid and widespread adoption of riding acey-deucy by many riders, a racing style which continues in today's thoroughbred racing.</p>

                        <p>Plenty of other stories show that fresh advances can arise from error, misadventure, and also pure serendipity – a happy accident. For example, in the early 1970s, two employees of the company 3M each had a problem: Spencer Silver had a product – a glue which was only slightly sticky – and no use for it, while his colleague Art Fry was trying to figure out how to affix temporary bookmarks in his hymn book without damaging its pages. The solution to both these problems was the invention of the brilliantly simple yet phenomenally successful Post-It note. Such examples give lie to the claim that ingenious, designing minds are responsible for human creativity and invention. Far more banal and mechanical forces may be at work; forces that are fundamentally connected to the laws of science.</p>

                        <p>The notions of insight, creativity and genius are often invoked, but they remain vague and of doubtful scientific utility, especially when one considers the diverse and enduring contributions of individuals such as Plato, Leonardo da Vinci, Shakespeare, Beethoven, Galileo, Newton, Kepler, Curie, Pasteur and Edison. These notions merely label rather than explain the evolution of human innovations. We need another approach, and there is a promising candidate.</p>

                        <p>The Law of Effect was advanced by psychologist Edward Thorndike in 1898, some 40 years after Charles Darwin published his groundbreaking work on biological evolution, <em>On the Origin of Species</em>. This simple law holds that organisms tend to repeat successful behaviors and to refrain from performing unsuccessful ones. Just like Darwin's Law of Natural Selection, the Law of Effect involves an entirely mechanical process of variation and selection, without any end objective in sight.</p>

                        <p>Of course, the origin of human innovation demands much further study. In particular, the provenance of the raw material on which the Law of Effect operates is not as clearly known as that of the genetic mutations on which the Law of Natural Selection operates. The generation of novel ideas and behaviors may not be entirely random, but constrained by prior successes and failures – of the current individual (such as Bohr) or of predecessors (such as Nicholson).</p>

                        <p>The time seems right for abandoning the naive notions of intelligent design and genius, and for scientifically exploring the true origins of creative behavior.</p>
                    </div>
                </div>

                {{-- Floating Annotation Toolbar --}}
                <div class="sticky bottom-6 w-full flex flex-col items-center pointer-events-none z-30 mt-4 mb-2">
                    {{-- Colour picker --}}
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
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar">
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto">

                {{-- Passage 1 divider --}}
                <div class="mt-2 mb-4">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 1</span>
                    </div>
                </div>

                {{-- Questions 1–5: Note Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-2"><strong>Questions 1–5</strong></p>
                    <p class="text-sm text-gray-800 mb-2">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-2">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-6">Write your answers in boxes 1–5 on your answer sheet.</p>

                    <div class="border-2 border-gray-400 p-6 bg-white text-[15px]">
                        <h4 class="text-[17px] font-bold text-center mb-6">The Dead Sea Scrolls</h4>

                        {{-- Discovery --}}
                        <p class="font-bold mb-3">Discovery</p>
                        <p class="mb-3">Qumran, 1946/7</p>
                        <ul class="list-disc ml-5 space-y-4 mb-8">
                            <li class="pl-2">three Bedouin shepherds in their teens were near an opening on side of cliff</li>
                            <li class="pl-2">
                                heard a noise of breaking when one teenager threw a <strong>1</strong>
                                <input type="text" name="q1" class="ans" placeholder="Answer">
                            </li>
                            <li class="pl-2">
                                teenagers went into the <strong>2</strong>
                                <input type="text" name="q2" class="ans" placeholder="Answer">
                                and found a number of containers made of <strong>3</strong>
                                <input type="text" name="q3" class="ans" placeholder="Answer">
                            </li>
                        </ul>

                        {{-- The scrolls --}}
                        <p class="font-bold mb-3">The scrolls</p>
                        <ul class="list-disc ml-5 space-y-4">
                            <li class="pl-2">date from between 150 BCE and 70 CE</li>
                            <li class="pl-2 leading-relaxed">
                                thought to have been written by group of people known as the<br>
                                <strong>4</strong>
                                <input type="text" name="q4" class="ans" placeholder="Answer">
                            </li>
                            <li class="pl-2">
                                written mainly in the <strong>5</strong>
                                <input type="text" name="q5" class="ans" placeholder="Answer">
                                language
                            </li>
                            <li class="pl-2">most are on religious topics, written using ink on parchment or papyrus</li>
                        </ul>
                    </div>
                </div>

                {{-- Questions 6-13: TRUE, FALSE, NOT GIVEN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 6–13</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 1?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 6–13 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic">TRUE</span></div><div class="italic">if the statement agrees with the information</div>
                            <div><span class="font-bold italic">FALSE</span></div><div class="italic">if the statement contradicts the information</div>
                            <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if there is no information on this</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mt-2">
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
                                    [6, 'The Bedouin teenagers who found the scrolls were disappointed by how little money they received for them.'],
                                    [7, 'There is agreement among academics about the origin of the Dead Sea Scrolls.'],
                                    [8, 'Most of the books of the Bible written on the scrolls are incomplete.'],
                                    [9, 'The information on the Copper Scroll is written in an unusual way.'],
                                    [10, 'Mar Samuel was given some of the scrolls as a gift.'],
                                    [11, 'In the early 1950s, a number of educational establishments in the US were keen to buy scrolls from Mar Samuel.'],
                                    [12, 'The scroll that was pieced together in 2017 contains information about annual occasions in the Qumran area 2,000 years ago.'],
                                    [13, 'Academics at the University of Haifa are currently researching how to decipher the final scroll.'],
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

                    <div class="flex justify-end mt-8">
                        <button onclick="document.getElementById('passage-2').scrollIntoView({behavior: 'smooth'})" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                            Next: Passage 2
                        </button>
                    </div>
                </div>

                {{-- Passage 2 divider --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Questions 14-18: Identifying Information --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-2"><strong>Questions 14–18</strong></p>
                    <p class="text-sm text-gray-800 mb-2">Reading Passage 2 has five sections, <strong>A–E</strong>.</p>
                    <p class="text-sm text-gray-800 mb-4">Which section contains the following information?</p>
                    <p class="text-sm italic text-gray-700 mb-2">Write the correct letter, <strong>A–E</strong>, in boxes 14–18 on your answer sheet.</p>
                    <p class="text-sm font-bold text-gray-800 mb-6">NB <span class="font-normal italic">You may use any letter more than once.</span></p>

                    <div class="space-y-4 text-[15px]">
                        @foreach([
                            [14, 'a reference to a type of tomato that can resist a dangerous infection'],
                            [15, 'an explanation of how problems can arise from focusing only on a certain type of tomato plant.'],
                            [16, 'a number of examples of plants that are not cultivated at present but could be useful as food sources'],
                            [17, 'a comparison between the early domestication of the tomato and more recent research'],
                            [18, 'a personal reaction to the flavour of a tomato that has been genetically edited'],
                        ] as [$num, $text])
                        <div class="flex items-start gap-4">
                            <span class="font-bold w-6 flex-none mt-1">{{ $num }}</span>
                            <div class="flex-1 mt-1">{{ $text }}</div>
                            <select name="q{{ $num }}" class="flex-none border border-gray-400 rounded px-3 py-1 bg-white focus:outline-none focus:border-green-500 cursor-pointer">
                                <option value="" disabled selected>....</option>
                                @foreach(['A','B','C','D','E'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Questions 19-23: Matching people --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-2"><strong>Questions 19–23</strong></p>
                    <p class="text-sm text-gray-800 mb-4">Look at the following statements (Questions 19–23) and the list of researchers below.</p>
                    <p class="text-sm text-gray-800 mb-4">Match each statement with the correct researcher, <strong>A–D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-2">Write the correct letter, <strong>A–D</strong>, in boxes 19–23 on your answer sheet.</p>
                    <p class="text-sm font-bold text-gray-800 mb-8">NB <span class="font-normal italic">You may use any letter more than once.</span></p>

                    <div class="space-y-4 text-[15px] mb-8">
                        @foreach([
                            [19, 'Domestication of certain plants could allow them to adapt to future environmental challenges.'],
                            [20, 'The idea of growing and eating unusual plants may not be accepted on a large scale.'],
                            [21, 'It is not advisable for the future direction of certain research to be made public.'],
                            [22, 'Present efforts to domesticate one wild fruit are limited by the costs involved.'],
                            [23, 'Humans only make use of a small proportion of the plant food available on Earth.'],
                        ] as [$num, $text])
                        <div class="flex items-start gap-4">
                            <span class="font-bold w-6 flex-none mt-1">{{ $num }}</span>
                            <div class="flex-1 mt-1">{{ $text }}</div>
                            <select name="q{{ $num }}" class="flex-none border border-gray-400 rounded px-3 py-1 bg-white focus:outline-none focus:border-green-500 cursor-pointer">
                                <option value="" disabled selected>....</option>
                                @foreach(['A','B','C','D'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                    </div>

                    <div class="border border-black p-5 max-w-sm mx-auto bg-gray-50 text-[15px]">
                        <p class="font-bold text-center mb-4">List of Researchers</p>
                        @foreach([
                            'A' => 'Jorg Kudla',
                            'B' => 'Caixia Gao',
                            'C' => 'Joyce Van Eck',
                            'D' => 'Jonathan Jones'
                        ] as $l => $name)
                        <div class="flex gap-4 mb-2 ml-4">
                            <span class="font-bold">{{ $l }}</span>
                            <span>{{ $name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Questions 24-26: Sentence Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-2"><strong>Questions 24–26</strong></p>
                    <p class="text-sm text-gray-800 mb-2">Complete the sentences below.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-6">Write your answers in boxes 24–26 on your answer sheet.</p>

                    <div class="space-y-6 text-[15px] leading-loose">
                        <div>
                            <strong>24</strong>&nbsp;&nbsp; An undesirable trait such as loss of 
                            <input type="text" name="q24" class="border-b border-gray-500 outline-none px-2 w-36 bg-transparent text-center focus:border-blue-500" placeholder="Answer">
                            may be caused by a mutation in a tomato gene.
                        </div>
                        <div>
                            <strong>25</strong>&nbsp;&nbsp; By modifying one gene in a tomato plant, researchers made the tomato three times its original 
                            <input type="text" name="q25" class="border-b border-gray-500 outline-none px-2 w-36 bg-transparent text-center focus:border-blue-500" placeholder="Answer">.
                        </div>
                        <div>
                            <strong>26</strong>&nbsp;&nbsp; A type of tomato which was not badly affected by 
                            <input type="text" name="q26" class="border-b border-gray-500 outline-none px-2 w-36 bg-transparent text-center focus:border-blue-500" placeholder="Answer">
                            , and was rich in vitamin C, was produced by a team of researchers in China.
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-8">
                    <button onclick="document.getElementById('passage-3').scrollIntoView({behavior: 'smooth'})" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                        Next: Passage 3
                    </button>
                </div>

                <hr class="my-10 border-gray-300">

                {{-- Passage 3 divider --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>

                {{-- Questions 27-31: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–31</strong></p>
                    <p class="text-sm text-gray-800 mb-4">Choose the correct letter, <strong>A, B, C</strong> or <strong>D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-6">Write the correct letter in boxes 27–31 on your answer sheet.</p>

                    <div class="space-y-6">
                        @foreach([
                            [27, 'The purpose of the first paragraph is to', ['A' => 'defend particular ideas.', 'B' => 'compare certain beliefs.', 'C' => 'disprove a widely held view.', 'D' => 'outline a common assumption.']],
                            [28, 'What are the writers doing in the second paragraph?', ['A' => 'criticising an opinion', 'B' => 'justifying a standpoint', 'C' => 'explaining an approach', 'D' => 'supporting an argument']],
                            [29, 'In the third paragraph, what do the writers suggest about Darwin and Einstein?', ['A' => 'They represent an exception to a general rule.', 'B' => 'Their way of working has been misunderstood.', 'C' => 'They are an ideal which others should aspire to.', 'D' => 'Their achievements deserve greater recognition.']],
                            [30, "John Nicholson is an example of a person whose idea", ['A' => 'established his reputation as an influential scientist.', 'B' => 'was only fully understood at a later point in history.', 'C' => "laid the foundations for someone else's breakthrough.", 'D' => 'initially met with scepticism from the scientific community.']],
                            [31, "What is the key point of interest about the 'acey-deucy' stirrup placement?", ['A' => 'the simple reason why it was invented', 'B' => 'the enthusiasm with which it was adopted', 'C' => 'the research that went into its development', 'D' => 'the cleverness of the person who first used it']],
                        ] as [$num, $question, $opts])
                        <div>
                            <p class="text-sm font-semibold text-gray-800 mb-2"><span class="text-blue-600 font-bold mr-1">{{ $num }}</span> {{ $question }}</p>
                            <div class="space-y-2 ml-4">
                                @foreach($opts as $letter => $text)
                                <label class="flex items-start gap-4 cursor-pointer group">
                                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer flex-none">
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

                {{-- Questions 32-36: YES/NO/NOT GIVEN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 32–36</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the claims of the writer in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 32–36 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic">YES</span></div><div class="italic">if the statement agrees with the claims of the writer</div>
                            <div><span class="font-bold italic">NO</span></div><div class="italic">if the statement contradicts the claims of the writer</div>
                            <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if it is impossible to say what the writer thinks about this</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mt-2">
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
                                    [32, 'Acknowledging people such as Plato or da Vinci as geniuses will help us understand the process by which great minds create new ideas.'],
                                    [33, 'The Law of Effect was discovered at a time when psychologists were seeking a scientific reason why creativity occurs.'],
                                    [34, 'The Law of Effect states that no planning is involved in the behaviour of organisms.'],
                                    [35, 'The Law of Effect sets out clear explanations about the sources of new ideas and behaviours.'],
                                    [36, 'Many scientists are now turning away from the notion of intelligent design and genius.'],
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

                {{-- Questions 37-40: Summary Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-2"><strong>Questions 37–40</strong></p>
                    <p class="text-sm text-gray-800 mb-2">Complete the summary using the list of words, <strong>A–G</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-6">Write the correct letter, <strong>A–G</strong>, in boxes 37–40 on your answer sheet.</p>

                    <div class="border-2 border-gray-400 p-6 bg-white text-[15px] mb-8">
                        <h4 class="text-[17px] font-bold text-center mb-6">The origins of creative behaviour</h4>
                        
                        <p class="leading-loose">
                            The traditional view of scientific discovery is that breakthroughs happen when a single great mind has sudden
                            <strong>37</strong>
                            <select name="q37" class="border border-gray-400 rounded px-2 py-1 mx-1 focus:outline-none focus:border-green-500 cursor-pointer text-sm">
                                <option value="" disabled selected>.....</option>
                                @foreach(['A','B','C','D','E','F','G'] as $val) <option value="{{ $val }}">{{ $val }}</option> @endforeach
                            </select>. 
                            Although this can occur, it is not often the case. Advances are more likely to be the result of a longer process. In some cases, this process involves
                            <strong>38</strong>
                            <select name="q38" class="border border-gray-400 rounded px-2 py-1 mx-1 focus:outline-none focus:border-green-500 cursor-pointer text-sm">
                                <option value="" disabled selected>.....</option>
                                @foreach(['A','B','C','D','E','F','G'] as $val) <option value="{{ $val }}">{{ $val }}</option> @endforeach
                            </select>, 
                            such as Nicholson's theory about proto-elements. In others, simple necessity may provoke innovation, as with Westrope's decision to modify the position of his riding stirrups. There is also often an element of
                            <strong>39</strong>
                            <select name="q39" class="border border-gray-400 rounded px-2 py-1 mx-1 focus:outline-none focus:border-green-500 cursor-pointer text-sm">
                                <option value="" disabled selected>.....</option>
                                @foreach(['A','B','C','D','E','F','G'] as $val) <option value="{{ $val }}">{{ $val }}</option> @endforeach
                            </select>, 
                            for example, the coincidence of ideas that led to the invention of the Post-It note. With both the Law of Natural Selection and the Law of Effect, there may be no clear
                            <strong>40</strong>
                            <select name="q40" class="border border-gray-400 rounded px-2 py-1 mx-1 focus:outline-none focus:border-green-500 cursor-pointer text-sm">
                                <option value="" disabled selected>.....</option>
                                @foreach(['A','B','C','D','E','F','G'] as $val) <option value="{{ $val }}">{{ $val }}</option> @endforeach
                            </select> 
                            involved, but merely a process of variation and selection.
                        </p>
                    </div>

                    <div class="border border-black p-5 max-w-lg mx-auto bg-gray-50 text-[15px]">
                        <div class="grid grid-cols-3 gap-y-3">
                            <div><strong>A</strong>&nbsp;&nbsp;invention</div>
                            <div><strong>B</strong>&nbsp;&nbsp;goals</div>
                            <div><strong>C</strong>&nbsp;&nbsp;compromise</div>
                            <div><strong>D</strong>&nbsp;&nbsp;mistakes</div>
                            <div><strong>E</strong>&nbsp;&nbsp;luck</div>
                            <div><strong>F</strong>&nbsp;&nbsp;inspiration</div>
                            <div><strong>G</strong>&nbsp;&nbsp;experiments</div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-center">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-12 rounded-xl shadow-lg transition-transform transform hover:-translate-y-1">
                        Submit Reading Test
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- Annotation Tool Javascript --}}
<script>
    window.initDrawingCanvas = function(canvasElement) {
        if (!canvasElement) return null;
        const ctx = canvasElement.getContext('2d');
        let isDrawing = false;
        let mode = 'draw'; // 'draw' or 'erase'

        function resize() {
            canvasElement.width = canvasElement.offsetWidth;
            canvasElement.height = canvasElement.offsetHeight;
        }
        window.addEventListener('resize', resize);
        resize();

        function startPosition(e) {
            isDrawing = true;
            draw(e);
        }
        function endPosition() {
            isDrawing = false;
            ctx.beginPath();
        }
        function draw(e) {
            if (!isDrawing) return;
            const rect = canvasElement.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            ctx.lineWidth = 3;
            ctx.lineCap = 'round';

            if (mode === 'draw') {
                ctx.strokeStyle = '#3b82f6';
                ctx.globalCompositeOperation = 'source-over';
            } else if (mode === 'erase') {
                ctx.lineWidth = 20;
                ctx.globalCompositeOperation = 'destination-out';
                ctx.strokeStyle = 'rgba(0,0,0,1)';
            }

            ctx.lineTo(x, y);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(x, y);
        }

        canvasElement.addEventListener('mousedown', startPosition);
        canvasElement.addEventListener('mouseup', endPosition);
        canvasElement.addEventListener('mousemove', draw);
        canvasElement.addEventListener('mouseleave', endPosition);

        return {
            setMode: function(newMode) { mode = newMode; },
            resize: resize
        };
    };

    window.applyAnnotation = function(type, color) {
        let selection = window.getSelection();
        if (!selection.rangeCount || selection.isCollapsed) return;
        
        // Basic naive highlighting
        try {
            document.execCommand('hiliteColor', false, color);
        } catch (e) {
            console.warn('highlight fail', e);
        }
        window.getSelection().removeAllRanges();
    };

    window.removeHighlight = function(e) {
        if (e.target.nodeName === 'SPAN' && e.target.style.backgroundColor) {
            let text = document.createTextNode(e.target.textContent);
            e.target.parentNode.replaceChild(text, e.target);
        }
    };
</script>

</body>
</html>

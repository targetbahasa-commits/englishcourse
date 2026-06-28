<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Reading Mock Test {{ $testId ?? 3 }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

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
                    <h1 class="text-xl font-bold text-gray-800">IELTS Reading – Mock Test {{ $testId ?? 3 }}</h1>
                    <p class="text-sm text-gray-500">Cambridge {{ $edition ?? 17 }} Reading Practice</p>
                </div>
            </div>
            <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition ?? 17, 'id' => $testId ?? 3]) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
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
                <div class="mb-6" id="passage-1">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 1</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong>, which are based on Reading Passage 1 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">The thylacine</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p>The extinct thylacine, also known as the Tasmanian tiger, was a marsupial* that bore a superficial resemblance to a dog. Its most distinguishing feature was the 13–19 dark brown stripes over its back, beginning at the rear of the body and extending onto the tail. The thylacine's average nose-to-tail length for adult males was 162.6 cm, compared to 153.7 cm for females.</p>

                        <p>The thylacine appeared to occupy most types of terrain except dense rainforest, with open eucalyptus forest thought to be its prime habitat. In terms of feeding, it was exclusively carnivorous, and its stomach was muscular with an ability to distend so that it could eat large amounts of food at one time, probably an adaptation to compensate for long periods when hunting was unsuccessful and food scarce. The thylacine was not a fast runner and probably caught its prey by exhausting it during a long pursuit. During long-distance chases, thylacines were likely to have relied more on scent than any other sense. They emerged to hunt during the evening, night and early morning and tended to retreat to the hills and forest for shelter during the day. Despite the common name 'tiger', the thylacine had a shy, nervous temperament. Although mainly nocturnal, it was sighted moving during the day and some individuals were even recorded basking in the sun.</p>

                        <p>The thylacine had an extended breeding season from winter to spring, with indications that some breeding took place throughout the year. The thylacine, like all marsupials, was tiny and hairless when born. Newborns crawled into the pouch on the belly of their mother, and attached themselves to one of the four teats, remaining there for up to three months. When old enough to leave the pouch, the young stayed in a lair such as a deep rocky cave, well-hidden nest or hollow log, whilst the mother hunted.</p>

                        <p>Approximately 4,000 years ago, the thylacine was widespread throughout New Guinea and most of mainland Australia, as well as the island of Tasmania. The most recent, well-dated occurrence of a thylacine on the mainland is a carbon-dated fossil from Murray Cave in Western Australia, which is around 3,100 years old. Its extinction coincided closely with the arrival of wild dogs called dingoes in Australia and a similar predator in New Guinea. Dingoes never reached Tasmania, and most scientists see this as the main reason for the thylacine's survival there.</p>

                        <p>The dramatic decline of the thylacine in Tasmania, which began in the 1830s and continued for a century, is generally attributed to the relentless efforts of sheep farmers and bounty hunters** with shotguns. While this determined campaign undoubtedly played a large part, it is likely that various other factors also contributed to the decline and eventual extinction of the species. These include competition with wild dogs introduced by European settlers, loss of habitat along with the disappearance of prey species, and a distemper-like disease which may also have affected the thylacine.</p>

                        <p>There was only one successful attempt to breed a thylacine in captivity, at Melbourne Zoo in 1899. This was despite the large numbers that went through some zoos, particularly London Zoo and Tasmania's Hobart Zoo. The famous naturalist John Gould foresaw the thylacine's demise when he published his <em>Mammals of Australia</em> between 1848 and 1863, writing, 'The numbers of this singular animal will speedily diminish, extermination will have its full sway, and it will then, like the wolf of England and Scotland, be recorded as an animal of the past.'</p>

                        <p>However, there seems to have been little public pressure to preserve the thylacine, nor was much concern expressed by scientists at the decline of this species in the decades that followed. A notable exception was T.T. Flynn, Professor of Biology at the University of Tasmania. In 1914, he was sufficiently concerned about the scarcity of the thylacine to suggest that some should be captured and placed on a small island. But it was not until 1929, with the species on the very edge of extinction, that Tasmania's Animals and Birds Protection Board passed a motion protecting thylacines only for the month of December, which was thought to be their prime breeding season. The last known wild thylacine to be killed was shot by a farmer in the north-east of Tasmania in 1930, leaving just captive specimens. Official protection of the species by the Tasmanian government was introduced in July 1936, 59 days before the last known individual died in Hobart Zoo on 7th September, 1936.</p>

                        <p>There have been numerous expeditions and searches for the thylacine over the years, none of which has produced definitive evidence that thylacines still exist. The species was declared extinct by the Tasmanian government in 1986.</p>

                        <div class="mt-8 pt-4 border-t border-gray-300 text-xs text-gray-500">
                            <p>*marsupial: a mammal, such as a kangaroo, whose young are born incompletely developed and are typically carried and suckled in a pouch on the mother's belly</p>
                            <p class="mt-1">**bounty hunters: people paid money for killing specified animals</p>
                        </div>
                    </div>
                </div>

                {{-- Passage 2: Palm oil --}}
                <div id="passage-2" class="mt-12 mb-6">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">Palm oil</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <div class="flex gap-4">
                            <span class="font-bold text-[15px] flex-none w-5">A</span>
                            <p>Palm oil is an edible oil derived from the fruit of the African oil palm tree, and is currently the most consumed vegetable oil in the world. It's almost certainly in the soap we wash with in the morning, the sandwich we have for lunch, and the biscuits we snack on during the day. Why is palm oil so attractive for manufacturers? Primarily because its unique properties – such as remaining solid at room temperature – make it an ideal ingredient for long-term preservation, allowing many packaged foods on supermarket shelves to have 'best before' dates of months, even years, into the future.</p>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold text-[15px] flex-none w-5">B</span>
                            <p>Many farmers have seized the opportunity to maximise the planting of oil palm trees. Between 1990 and 2012, the global land area devoted to growing oil palm trees grew from 6 to 17 million hectares, now accounting for around ten percent of total cropland in the entire world. From a mere two million tonnes of palm oil being produced annually globally 50 years ago, there are now around 60 million tonnes produced every single year, a figure looking likely to double or even triple by the middle of the century.</p>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold text-[15px] flex-none w-5">C</span>
                            <p>However, there are multiple reasons why conservationists cite the rapid spread of oil palm plantations as a major concern. There are countless news stories of deforestation, habitat destruction and dwindling species populations, all as a direct result of land clearing to establish oil palm tree monoculture on an industrial scale, particularly in Malaysia and Indonesia. Endangered species – most famously the Sumatran orangutan, but also rhinos, elephants, tigers, and numerous other fauna – have suffered from the unstoppable spread of oil palm plantations.</p>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold text-[15px] flex-none w-5">D</span>
                            <div class="space-y-4">
                                <p>'Palm oil is surely one of the greatest threats to global biodiversity,' declares Dr Farnon Ellwood of the University of the West of England, Bristol. 'Palm oil is replacing rainforest, and rainforest is where all the species are. That's a problem.' This has led to some radical questions among environmentalists, such as whether consumers should try to boycott palm oil entirely.</p>
                                <p>Meanwhile Bhavani Shankar, Professor at London's School of Oriental and African Studies, argues, 'It's easy to say that palm oil is the enemy and we should be against it. It makes for a more dramatic story, and it's very intuitive. But given the complexity of the argument, I think a much more nuanced story is closer to the truth.'</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold text-[15px] flex-none w-5">E</span>
                            <p>One response to the boycott movement has been the argument for the vital role palm oil plays in lifting many millions of people in the developing world out of poverty. Is it desirable to have palm oil boycotted, replaced, eliminated from the global supply chain, given how many low-income people in developing countries depend on it for their livelihoods? How best to strike a utilitarian balance between these competing factors has become a serious bone of contention.</p>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold text-[15px] flex-none w-5">F</span>
                            <div class="space-y-4">
                                <p>Even the deforestation argument isn't as straightforward as it seems. Oil palm plantations produce at least four and potentially up to ten times more oil per hectare than soybean, rapeseed, sunflower or other competing oils. That immensely high yield – which is predominantly what makes it so profitable – is potentially also an ecological benefit. If ten times more palm oil can be produced from a patch of land than any competing oil, then ten times more land would need to be cleared in order to produce the same volume of oil from that competitor.</p>
                                <p>As for the question of carbon emissions, the issue really depends on what oil palm trees are replacing. Crops vary in the degree to which they sequester carbon – in other words, the amount of carbon they capture from the atmosphere and store within the plant. The more carbon a plant sequesters, the more it reduces the effect of climate change. As Shankar explains: '[Palm oil production] actually sequesters more carbon in some ways than other alternatives. […] Of course, if you're cutting down virgin forest it's terrible – that's what's happening in Indonesia and Malaysia, it's been allowed to get out of hand. But if it's replacing rice, for example, it might actually sequester more carbon.'</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold text-[15px] flex-none w-5">G</span>
                            <p>The industry is now regulated by a group called the Roundtable on Sustainable Palm Oil (RSPO), consisting of palm growers, retailers, product manufacturers, and other interested parties. Over the past decade or so, an agreement has gradually been reached regarding standards that producers of palm oil have to meet in order for their product to be regarded as officially 'sustainable'. The RSPO insists upon no virgin forest clearing, transparency and regular assessment of carbon stocks, among other criteria. Only once these requirements are fully satisfied is the oil allowed to be sold as certified sustainable palm oil (CSPO). Recent figures show that the RSPO now certifies around 12 million tonnes of palm oil annually, equivalent to roughly 21 percent of the world's total palm oil production.</p>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold text-[15px] flex-none w-5">H</span>
                            <p>There is even hope that oil palm plantations might not need to be such sterile monocultures, or 'green deserts', as Ellwood describes them. New research at Ellwood's lab hints at one plant which might make all the difference. The bird's nest fern <em>(Asplenium nidus)</em> grows on trees in an epiphytic fashion (meaning it's dependent on the tree only for support, not for nutrients), and is native to many tropical regions, where as a keystone species it performs a vital ecological role. Ellwood believes that reintroducing the bird's nest fern into oil palm plantations could potentially allow these areas to recover their biodiversity, providing a home for all manner of species, from fungi and bacteria, to invertebrates such as insects, amphibians, reptiles and even mammals.</p>
                        </div>

                    </div>
                </div>

                {{-- Passage 3: Building the Skyline --}}
                <div id="passage-3" class="mt-12 mb-6">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-2">Building the Skyline: The Birth and Growth of Manhattan's Skyscrapers</h3>
                    <p class="text-center italic text-gray-600 text-[15px] mb-6">Katharine L. Shester reviews a book by Jason Barr about the development of New York City</p>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p>In <em>Building the Skyline</em>, Jason Barr takes the reader through a detailed history of New York City. The book combines geology, history, economics, and a lot of data to explain why business clusters developed where they did and how the early decisions of workers and firms shaped the skyline we see today. <em>Building the Skyline</em> is organized into two distinct parts. The first is primarily historical and addresses New York's settlement and growth from 1609 to 1900; the second deals primarily with the 20th century and is a compilation of chapters commenting on different aspects of New York's urban development. The tone and organization of the book changes somewhat between the first and second parts, as the latter chapters incorporate aspects of Barr's related research papers.</p>

                        <p>Barr begins chapter one by taking the reader on a 'helicopter time-machine' ride – giving a fascinating account of how the New York landscape in 1609 might have looked from the sky. He then moves on to a subterranean walking tour of the city, indicating the location of rock and water below the subsoil, before taking the reader back to the surface. His love of the city comes through as he describes various fun facts about the location of the New York residence of early 19th-century vice-president Aaron Burr as well as a number of legends about the city.</p>

                        <p>Chapters two and three take the reader up to the Civil War (1861–1865), with chapter two focusing on the early development of land and the implementation of a grid system in 1811. Chapter three focuses on land use before the Civil War. Both chapters are informative and well researched and set the stage for the economic analysis that comes later in the book. I would have liked Barr to expand upon his claim that existing tenements* prevented skyscrapers in certain neighborhoods because 'likely no skyscraper developer was interested in performing the necessary “slum clearance”'. Later in the book, Barr makes the claim that the depth of bedrock** was not a limiting factor for developers, as foundation costs were a small fraction of the cost of development. At first glance, it is not obvious why slum clearance would be limiting, while more expensive foundations would not.</p>

                        <p>Chapter four focuses on immigration and the location of neighborhoods and tenements in the late 19th century. Barr identifies four primary immigrant enclaves and analyzes their locations in terms of the amenities available in the area. Most of these enclaves were located on the least valuable land, between the industries located on the waterfront and the wealthy neighborhoods bordering Central Park.</p>

                        <p>Part two of the book begins with a discussion of the economics of skyscraper height. In chapter five, Barr distinguishes between engineering height, economic height, and developer height — where engineering height is the tallest building that can be safely made at a given time, economic height is the height that is most efficient from society's point of view, and developer height is the actual height chosen by the developer, who is attempting to maximize return on investment.</p>

                        <p>Chapter five also has an interesting discussion of the technological advances that led to the construction of skyscrapers. For example, the introduction of iron and steel skeletal frames made thick, load-bearing walls unnecessary, expanding the usable square footage of buildings and increasing the use of windows and availability of natural light. Chapter six then presents data on building height throughout the 20th century and uses regression analysis to 'predict' building construction. While less technical than the research paper on which the chapter is based, it is probably more technical than would be preferred by a general audience.</p>

                        <p>Chapter seven tackles the 'bedrock myth', the assumption that the absence of bedrock close to the surface between Downtown and Midtown New York is the reason for skyscrapers not being built between the two urban centers. Rather, Barr argues that while deeper bedrock does increase foundation costs, these costs were neither prohibitively high nor were they large compared to the overall cost of building a skyscraper. What I enjoyed the most about this chapter was Barr's discussion of how foundations are actually built. He describes the use of caissons, which enable workers to dig down for considerable distances, often below the water table, until they reach bedrock. Barr's thorough technological history discusses not only how caissons work, but also the dangers involved. While this chapter references empirical research papers, it is a relatively easy read.</p>

                        <p>Chapters eight and nine focus on the birth of Midtown and the building boom of the 1920s. Chapter eight contains lengthy discussions of urban economic theory that may serve as a distraction to readers primarily interested in New York. However, they would be well-suited for undergraduates learning about the economics of cities. In the next chapter, Barr considers two of the primary explanations for the building boom of the 1920s — the first being exuberance, and the second being financing. He uses data to assess the viability of these two explanations and finds that supply and demand factors explain much of the development of the 1920s; though it enabled the boom, cheap credit was not, he argues, the primary cause.</p>

                        <p>In the final chapter (chapter 10), Barr discusses another of his empirical papers that estimates Manhattan land values from the mid-19th century to the present day. The data work that went into these estimations is particularly impressive. Toward the end of the chapter, Barr assesses 'whether skyscrapers are a cause or an effect of high land values'. He finds that changes in land values predict future building height, but the reverse is not true. The book ends with an epilogue, in which Barr discusses the impact of climate change on the city and makes policy suggestions for New York going forward.</p>

                        <div class="mt-8 pt-4 border-t border-gray-300 text-xs text-gray-500">
                            <p>* a tenement: a multi-occupancy building of any sort, but particularly a run-down apartment building or slum building</p>
                            <p class="mt-1">** bedrock: the solid, hard rock in the ground that lies under a loose layer of soil</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Annotation toolbar --}}
            <div class="sticky bottom-0 left-0 right-0 z-30 bg-white border-t border-gray-200 px-4 py-2 flex items-center gap-2 shadow-md">
                <span class="text-xs text-gray-500 font-medium mr-1">Tools:</span>
                <button @click="highlightMode = !highlightMode; pencilMode = false; eraserMode = false;"
                        :class="highlightMode ? 'bg-yellow-200 border-yellow-400' : 'bg-white border-gray-300 hover:bg-gray-50'"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-medium text-gray-700 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zM3 15a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"></path></svg>
                    Highlight
                </button>
                <div x-show="highlightMode" class="flex items-center gap-1.5">
                    @foreach(['yellow' => 'bg-yellow-300', 'green' => 'bg-green-300', 'blue' => 'bg-blue-300', 'pink' => 'bg-pink-300'] as $color => $cls)
                    <button @click="highlightColor = '{{ $color }}'" :class="highlightColor === '{{ $color }}' ? 'ring-2 ring-offset-1 ring-gray-500' : ''" class="w-5 h-5 rounded-full {{ $cls }} border border-gray-300"></button>
                    @endforeach
                </div>
                <button @click="pencilMode = !pencilMode; highlightMode = false; eraserMode = false;"
                        :class="pencilMode ? 'bg-indigo-100 border-indigo-400' : 'bg-white border-gray-300 hover:bg-gray-50'"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-medium text-gray-700 transition-colors">
                    ✏️ Pencil
                </button>
                <button @click="eraserMode = !eraserMode; pencilMode = false; highlightMode = false;"
                        :class="eraserMode ? 'bg-red-100 border-red-400' : 'bg-white border-gray-300 hover:bg-gray-50'"
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border text-xs font-medium text-gray-700 transition-colors">
                    🧹 Eraser
                </button>
                <button @click="if(canvasObj) canvasObj.clear();" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-300 bg-white hover:bg-gray-50 text-xs font-medium text-gray-700 transition-colors">
                    🗑️ Clear
                </button>
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
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–5</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 1–5 on your answer sheet.</p>

                    <div class="border border-gray-300 rounded-lg p-5 text-[15px] bg-gray-50">
                        <h3 class="font-bold text-center text-base mb-5">The thylacine</h3>

                        <h4 class="font-bold mb-3">Appearance and behaviour</h4>
                        <ul class="list-disc ml-5 space-y-2 mb-5 text-[14px] text-gray-800">
                            <li>looked rather like a dog</li>
                            <li>had a series of stripes along its body and tail</li>
                            <li>ate an entirely <strong>1</strong> <input type="text" name="q1" class="ans" placeholder="Answer"> diet</li>
                            <li>probably depended mainly on <strong>2</strong> <input type="text" name="q2" class="ans" placeholder="Answer"> when hunting</li>
                            <li>young spent first months of life inside its mother's <strong>3</strong> <input type="text" name="q3" class="ans" placeholder="Answer"></li>
                        </ul>

                        <h4 class="font-bold mb-3">Decline and extinction</h4>
                        <ul class="list-disc ml-5 space-y-2 text-[14px] text-gray-800">
                            <li>last evidence in mainland Australia is a 3,100-year-old <strong>4</strong> <input type="text" name="q4" class="ans" placeholder="Answer"></li>
                            <li>probably went extinct in mainland Australia due to animals known as dingoes</li>
                            <li>reduction in <strong>5</strong> <input type="text" name="q5" class="ans" placeholder="Answer"> and available sources of food were partly responsible for decline in Tasmania</li>
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
                                    [6, 'Significant numbers of thylacines were killed by humans from the 1830s onwards.'],
                                    [7, 'Several thylacines were born in zoos during the late 1800s.'],
                                    [8, "John Gould's prediction about the thylacine surprised some biologists."],
                                    [9, 'In the early 1900s, many scientists became worried about the possible extinction of the thylacine.'],
                                    [10, "T. T. Flynn's proposal to rehome captive thylacines on an island proved to be impractical."],
                                    [11, 'There were still reasonable numbers of thylacines in existence when a piece of legislation protecting the species during their breeding season was passed.'],
                                    [12, 'From 1930 to 1936, the only known living thylacines were all in captivity.'],
                                    [13, 'Attempts to find living thylacines are now rarely made.'],
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

                {{-- Passage 2 divider --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Q14-20: Section Matching --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–20</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 2 has eight sections, <strong>A–H</strong>.</p>
                    <p class="text-sm text-gray-800 mb-1">Which section contains the following information?</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–H</strong>, in boxes 14–20 on your answer sheet.</p>

                    <div class="space-y-3 text-[14px]">
                        @foreach([
                            [14, 'examples of a range of potential environmental advantages of oil palm tree cultivation'],
                            [15, 'description of an organisation which controls the environmental impact of palm oil production'],
                            [16, 'examples of the widespread global use of palm oil'],
                            [17, 'reference to a particular species which could benefit the ecosystem of oil palm plantations'],
                            [18, 'figures illustrating the rapid expansion of the palm oil industry'],
                            [19, 'an economic justification for not opposing the palm oil industry'],
                            [20, 'examples of creatures badly affected by the establishment of oil palm plantations'],
                        ] as [$num, $statement])
                        <div class="flex items-start gap-3">
                            <span class="font-bold text-blue-600 w-6 flex-none text-sm">{{ $num }}</span>
                            <span class="flex-1 text-gray-800 leading-snug">{{ $statement }}</span>
                            <div class="relative flex-none w-16">
                                <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1.5 px-2 pr-6 rounded text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer">
                                    <option value="" disabled selected>–</option>
                                    @foreach(['A','B','C','D','E','F','G','H'] as $l)
                                    <option value="{{ $l }}">{{ $l }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-1 flex items-center text-gray-500">
                                    <svg class="fill-current h-3 w-3" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Q21-22: Choose TWO --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 21 and 22</strong></p>
                    <p class="text-sm italic text-gray-700 mb-3">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                    <p class="text-sm text-gray-700 mb-1">Write the correct letters in boxes 21 and 22 on your answer sheet.</p>
                    <p class="text-sm text-gray-800 mb-4">Which <strong>TWO</strong> statements are made about the Roundtable on Sustainable Palm Oil (RSPO)?</p>
                    <div class="space-y-2 text-[14px]">
                        @foreach([
                            ['A', 'Its membership has grown steadily over the course of the last decade.'],
                            ['B', 'It demands that certified producers be open and honest about their practices.'],
                            ['C', 'It took several years to establish its set of criteria for sustainable palm oil certification.'],
                            ['D', 'Its regulations regarding sustainability are stricter than those governing other industries.'],
                            ['E', 'It was formed at the request of environmentalists concerned about the loss of virgin forests.'],
                        ] as [$letter, $text])
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="q21_22[]" value="{{ $letter }}" class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none">
                            <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $letter }}</strong>&nbsp; {{ $text }}</span>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 mt-2 italic">Select exactly two options.</p>
                </div>

                {{-- Q23-26: Sentence Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 23–26</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the sentences below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>NO MORE THAN TWO WORDS</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 23–26 on your answer sheet.</p>
                    <div class="space-y-4 text-[14px] text-gray-800">
                        <div class="flex items-start gap-3">
                            <span class="font-bold text-blue-600 flex-none">23</span>
                            <span>One advantage of palm oil for manufacturers is that it stays <input type="text" name="q23" class="ans" placeholder="Answer"> even when not refrigerated.</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="font-bold text-blue-600 flex-none">24</span>
                            <span>The <input type="text" name="q24" class="ans" placeholder="Answer"> is the best known of the animals suffering habitat loss as a result of the spread of oil palm plantations.</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="font-bold text-blue-600 flex-none">25</span>
                            <span>As one of its criteria for the certification of sustainable palm oil, the RSPO insists that growers check <input type="text" name="q25" class="ans" placeholder="Answer"> on a routine basis.</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="font-bold text-blue-600 flex-none">26</span>
                            <span>Ellwood and his researchers are looking into whether the bird's nest fern could restore <input type="text" name="q26" class="ans" placeholder="Answer"> in areas where oil palm trees are grown.</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-8">
                    <button onclick="document.getElementById('passage-3').scrollIntoView({behavior: 'smooth'})" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">
                        Next: Passage 3
                    </button>
                </div>

                {{-- Passage 3 divider --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>

                {{-- Q27-31: MCQ A-D --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–31</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 27–31 on your answer sheet.</p>

                    <div class="space-y-6 text-[14px]">
                        @foreach([
                            [27, 'What point does Shester make about Barr\'s book in the first paragraph?', [
                                'A' => 'It gives a highly original explanation for urban development.',
                                'B' => "Elements of Barr's research papers are incorporated throughout the book.",
                                'C' => 'Other books that are available on the subject have taken a different approach.',
                                'D' => 'It covers a range of factors that affected the development of New York.',
                            ]],
                            [28, 'How does Shester respond to the information in the book about tenements?', [
                                'A' => "She describes the reasons for Barr's interest.",
                                'B' => "She indicates a potential problem with Barr's analysis.",
                                'C' => "She compares Barr's conclusion with that of other writers.",
                                'D' => 'She provides details about the sources Barr used for his research.',
                            ]],
                            [29, 'What does Shester say about chapter six of the book?', [
                                'A' => 'It contains conflicting data.',
                                'B' => 'It focuses too much on possible trends.',
                                'C' => 'It is too specialised for most readers.',
                                'D' => 'It draws on research that is out of date.',
                            ]],
                            [30, 'What does Shester suggest about the chapters focusing on the 1920s building boom?', [
                                'A' => 'The information should have been organised differently.',
                                'B' => 'More facts are needed about the way construction was financed.',
                                'C' => 'The explanation that is given for the building boom is unlikely.',
                                'D' => 'Some parts will have limited appeal to certain people.',
                            ]],
                            [31, 'What impresses Shester the most about the chapter on land values?', [
                                'A' => 'the broad time period that is covered',
                                'B' => 'the interesting questions that Barr asks',
                                'C' => 'the nature of the research into the topic',
                                'D' => 'the recommendations Barr makes for the future',
                            ]],
                        ] as [$num, $question, $options])
                        <div>
                            <p class="font-semibold mb-2"><span class="text-blue-600 font-bold mr-2">{{ $num }}</span>{{ $question }}</p>
                            <div class="space-y-1.5 ml-6">
                                @foreach($options as $l => $t)
                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="radio" name="q{{ $num }}" value="{{ $l }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer flex-none">
                                    <span class="group-hover:text-blue-700 transition-colors"><strong>{{ $l }}</strong>&nbsp; {{ $t }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Q32-35: YES/NO/NOT GIVEN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 32–35</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the claims of the writer in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 32–35 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-5 text-sm bg-gray-50">
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
                                    [32, 'The description in the first chapter of how New York probably looked from the air in the early 1600s lacks interest.'],
                                    [33, 'Chapters two and three prepare the reader well for material yet to come.'],
                                    [34, 'The biggest problem for many nineteenth-century New York immigrant neighbourhoods was a lack of amenities.'],
                                    [35, "In the nineteenth century, New York's immigrant neighbourhoods tended to concentrate around the harbour."],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-2 pr-7 rounded text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer">
                                                <option value="" disabled selected>–</option>
                                                <option value="YES">YES</option>
                                                <option value="NO">NO</option>
                                                <option value="NOT GIVEN">NOT GIVEN</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Q36-40: Summary completion A-J --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 36–40</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary using the list of phrases, <strong>A–J</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–J</strong>, in boxes 36–40 on your answer sheet.</p>

                    {{-- Summary box --}}
                    <div class="border border-gray-300 rounded-lg p-5 bg-gray-50 text-[14px] text-gray-800 mb-5 leading-relaxed">
                        <h4 class="font-bold text-center text-base mb-4">The bedrock myth</h4>
                        <p class="mb-4">In chapter seven, Barr indicates how the lack of bedrock close to the surface does not explain why skyscrapers are absent from <strong>36</strong>
                            <div class="relative inline-block w-16 mx-1">
                                <select name="q36" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1 px-2 pr-6 rounded text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer">
                                    <option value="" disabled selected>–</option>
                                    @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-1 flex items-center text-gray-500"><svg class="fill-current h-3 w-3" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                            </div>. He points out that although the cost of foundations increases when bedrock is deep below the surface, this cannot be regarded as <strong>37</strong>
                            <div class="relative inline-block w-16 mx-1">
                                <select name="q37" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1 px-2 pr-6 rounded text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer">
                                    <option value="" disabled selected>–</option>
                                    @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-1 flex items-center text-gray-500"><svg class="fill-current h-3 w-3" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                            </div>, especially when compared to <strong>38</strong>
                            <div class="relative inline-block w-16 mx-1">
                                <select name="q38" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1 px-2 pr-6 rounded text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer">
                                    <option value="" disabled selected>–</option>
                                    @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-1 flex items-center text-gray-500"><svg class="fill-current h-3 w-3" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                            </div>.
                        </p>
                        <p>A particularly enjoyable part of the chapter was Barr's account of how foundations are built. He describes not only how <strong>39</strong>
                            <div class="relative inline-block w-16 mx-1">
                                <select name="q39" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1 px-2 pr-6 rounded text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer">
                                    <option value="" disabled selected>–</option>
                                    @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-1 flex items-center text-gray-500"><svg class="fill-current h-3 w-3" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                            </div> are made possible by the use of caissons, but he also discusses their <strong>40</strong>
                            <div class="relative inline-block w-16 mx-1">
                                <select name="q40" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1 px-2 pr-6 rounded text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer">
                                    <option value="" disabled selected>–</option>
                                    @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-1 flex items-center text-gray-500"><svg class="fill-current h-3 w-3" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                            </div>. The chapter is well researched but relatively easy to understand.
                        </p>
                    </div>

                    {{-- Phrase options box --}}
                    <div class="border border-gray-300 rounded-lg p-4 bg-white text-[13px]">
                        <div style="display:grid; grid-template-columns: repeat(3,1fr); gap: 0.375rem 1rem;">
                            @foreach([
                                'A' => 'development plans',
                                'B' => 'deep excavations',
                                'C' => 'great distance',
                                'D' => 'excessive expense',
                                'E' => 'impossible tasks',
                                'F' => 'associated risks',
                                'G' => 'water level',
                                'H' => 'specific areas',
                                'I' => 'total expenditure',
                                'J' => 'construction guidelines',
                            ] as $l => $phrase)
                            <div><span class="font-bold">{{ $l }}</span> {{ $phrase }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>

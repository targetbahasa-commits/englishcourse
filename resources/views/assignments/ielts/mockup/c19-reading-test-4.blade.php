<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Reading Mock Test - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        html, body { height: 100%; overflow: hidden; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        .cambridge-text { font-family: "Times New Roman", Times, serif; font-size: 16px; line-height: 1.6; color: #1a1a1a; }
        .cambridge-heading { font-family: Arial, Helvetica, sans-serif; font-size: 1.5rem; font-weight: bold; margin-bottom: 1.5rem; }
        .cambridge-subheading { font-family: Arial, Helvetica, sans-serif; font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; }
        .cambridge-paragraph { margin-bottom: 1.25rem; text-align: justify; }
        [x-cloak] { display: none !important; }
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
                <div class="p-2.5 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">IELTS Reading – Mock Test {{ $testId ?? '4' }}</h1>
                    <p class="text-sm text-gray-500">Cambridge {{ $edition ?? '19' }} Reading Practice</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition ?? '19', 'id' => $testId ?? '4']) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all border border-gray-200">
                    Exit
                </a>
            </div>
        </div>
    </div>

    {{-- Split pane layout --}}
    <div class="flex-1 min-h-0 grid overflow-hidden" style="grid-template-columns: 2.5fr 2fr;">
        
        {{-- LEFT PANEL: PASSAGE TEXT --}}
        <div class="h-full overflow-y-auto bg-white border-r border-gray-200 custom-scrollbar relative"
             x-data="{ highlightMode: false, pencilMode: false, eraserMode: false, highlightColor: 'yellow', canvasObj: null }">
            
            <div class="p-10 pb-32 max-w-4xl mx-auto relative z-20">
                
                {{-- PASSAGE 1 TEXT --}}
                <div class="cambridge-text max-w-3xl mx-auto">
                    <p class="italic mb-6 text-gray-600">You should spend about 20 minutes on <span class="font-bold">Questions 1–13</span>, which are based on Reading Passage 1 below.</p>
                    
                    <h2 class="cambridge-heading text-center mb-8">The impact of climate change on butterflies in Britain</h2>

                    <p class="cambridge-paragraph">According to conservationists, populations of around two thirds of butterfly species have declined in Britain over the past 40 years. If this trend continues, it might have unpredictable knock-on effects for other species in the ecosystem. Butterfly eggs develop into caterpillars and these insects, which are the second stage in a new butterfly's lifecycle, consume vast quantities of plant material, and in turn act as prey for birds as well as bats and other small mammals. Only by arming themselves with an understanding of why butterfly numbers are down can conservationists hope to halt or reverse the decline.</p>

                    <p class="cambridge-paragraph">Butterflies prefer outdoor conditions to be 'just right', which means neither too hot nor too cold. Under the conditions of climate change, the temperature at any given time in summer is generally getting warmer, leaving butterflies with the challenge of how to deal with this. One of the main ways in which species are ensuring conditions suit them is by changing the time of year at which they are active and reproduce. Scientists refer to the timing of such lifecycle events as 'phenology', so when an animal or plant starts to do something earlier in the year than it usually does, it is said to be 'advancing its phenology'.</p>

                    <p class="cambridge-paragraph">These advances have been observed already in a wide range of butterflies – indeed, most species are advancing their phenology to some extent. In Britain, as the average spring temperature has increased by roughly 0.5 °C over the past 20 years, species have advanced by between three days and a week on average, to keep in line with cooler temperatures. Is this a sign that butterflies are well equipped to cope with climate change, and readily adjust to new temperatures? Or are these populations under stress, being dragged along unwillingly by unnaturally fast changes? The answer is still unknown, but a new study is seeking to answer these questions.</p>

                    <p class="cambridge-paragraph">First, the researchers pulled together data from millions of records that had been submitted by butterfly enthusiasts – people who spend their free time observing the activities of different species. This provided information on 130 species of butterflies in Great Britain every year for a 20-year period. They then estimated the abundance and distribution of each species across this time, along with how far north in the country they had moved. The data also, crucially, allowed researchers to estimate subtle changes in what time of the year each species was changing into an adult butterfly.</p>

                    <p class="cambridge-paragraph">Analysing the trends in each variable, the researchers discovered that species with more flexible lifecycles were more likely to be able to benefit from an earlier emergence driven by climate change. Some species are able to go from caterpillar to butterfly twice or more per year, so that the individual butterflies you see flying in the spring are the grandchildren or great-grandchildren of the individuals seen a year previously.</p>

                    <p class="cambridge-paragraph">Among these species, researchers observed that those which have been advancing their phenology the most over the 20-year study period also had the most positive trends in abundance, distribution and northwards extent. For these species, such as Britain's tiniest butterfly, the dainty Small Blue, whose colonies are up to a hundred strong, some develop into butterflies early in spring, allowing their summer generations to complete another reproductive cycle by autumn so that more population growth occurs.</p>

                    <p class="cambridge-paragraph">Other species, however, are less flexible and restricted to a single reproductive cycle per year. For these species, there was no evidence of any benefit to emerging earlier. Indeed, worryingly, it was found that the species in this group that specialise in very specific habitat types, often related to the caterpillar's preferred diet, actually tended to be most at harm from advancing phenology. The beautiful High Brown Fritillary, often described as Britain's most endangered butterfly, is in this group. It is found only in coppiced woodland and limestone pavement habitats. It is also a single-generation butterfly that has advanced its phenology. This suggests that climate change, while undoubtedly not the sole cause, might have played a part in the downfall of this species.</p>

                    <p class="cambridge-paragraph">All is not lost, however. Many of Britain's single-generation species show the capacity, in continental Europe, to add a second generation in years that are sufficiently warm. Therefore, as the climate continues to warm, species like the Silver-studded Blue might be able to switch to multiple generations in the UK as well, and so begin to extract benefits from the additional warmth, potentially leading to population increases.</p>

                    <p class="cambridge-paragraph">More immediately, conservationists can arm themselves with all this knowledge to spot the warning signs of species that may be at risk. The White Admiral of southern England, a much sought-after butterfly, experienced a significant increase in numbers from the 1920s but has shown a considerable decline in the past 20 years. This may be because the caterpillar exists solely on a diet of a plant called honeysuckle. But it is also likely to be due to climate change.</p>
                </div>

                {{-- PASSAGE 2 TEXT --}}
                <div class="mb-6 mt-16 pt-16 border-t-2 border-gray-300 cambridge-text max-w-3xl mx-auto">
                    <p class="italic mb-6 text-gray-600">You should spend about 20 minutes on <span class="font-bold">Questions 14–26</span>, which are based on Reading Passage 2 below.</p>
                    
                    <h2 class="cambridge-heading text-center mb-4">Deep-sea mining</h2>
                    <p class="text-center italic text-lg mb-8 text-gray-800">Bacteria from the ocean floor can beat superbugs and cancer. But habitats are at risk from the hunger for marine minerals</p>

                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="font-bold text-lg flex-none w-6">A</div>
                            <div class="cambridge-paragraph m-0">When Professor Mat Upton found that a microbe from a deep-sea sponge was killing pathogenic bugs in his laboratory, he realised it could be a breakthrough in the fight against antibiotic-resistant superbugs, which are responsible for thousands of deaths a year in the UK alone. Further tests confirmed that an antibiotic from the sponge bacteria, found living more than 700 metres under the sea at the Rockall trough in the north-east Atlantic, was previously unknown to science, boosting its potential as a life-saving medicine. But Upton, and other scientists who view the deep ocean and its wealth of unique and undocumented species as a prospecting ground for new medicines, fear such potential will be lost in the rush to exploit the deep sea's equally rich metal and mineral resources.</div>
                        </div>

                        <div class="flex gap-4">
                            <div class="font-bold text-lg flex-none w-6">B</div>
                            <div class="cambridge-paragraph m-0">'We're looking at the bioactive potential of marine resources, to see if there are any more medicines or drugs down there before we destroy it for ever,' says Upton, a medical microbiologist at the University of Plymouth. He is among many scientists urging a halt to deep-sea mining, asking for time to weigh up the pros and cons. 'In sustainability terms, this could be a better way of exploiting the economic potential of the deep sea,' he argues. Oceanographers using remotely operated vehicles have spotted many new species. Among them have been sea cucumbers with tails allowing them to sail along the ocean floor, and a rare 'Dumbo' octopus, found 3,000 metres under the Pacific Ocean, off the coast of California. Any one of these could offer lifesaving potential. Upton estimates it could take up to a decade for a newly discovered antibiotic to become a medicine – but the race towards commercial mining in the ocean abyss has already begun.</div>
                        </div>

                        <div class="flex gap-4">
                            <div class="font-bold text-lg flex-none w-6">C</div>
                            <div class="cambridge-paragraph m-0">The deep sea contains more nickel, cobalt and rare earth metals than all land reserves combined, according to the US Geological Survey. Mining corporations argue that deep-sea exploration could help diversify the supply of metals and point to the fact that demand for resources such as copper, aluminium, cobalt for electric car batteries and other metals to power technology and smartphones, is soaring. They say that deep-sea mining could yield far superior ore to land mining with little, if any, waste. Different methods of extraction exist, but most involve employing some form of converted machinery previously used in terrestrial mining to excavate materials from the sea floor, at depths of up to 6,000 metres, then drawing a seawater slurry, containing rock and other solid particles, from the sea floor to ships on the surface. The slurry is then 'de-watered' and transferred to another vessel for shipping. Extracted seawater is pumped back down and discharged close to the sea floor.</div>
                        </div>

                        <div class="flex gap-4">
                            <div class="font-bold text-lg flex-none w-6">D</div>
                            <div class="cambridge-paragraph m-0">But environmental and legal groups have urged caution, arguing there are potentially massive and unknown ramifications for the environment and for nearby communities, and that the global regulatory framework is not yet drafted. 'Despite arising in the last half century, the "new global gold rush" of deep-sea mining shares many features with past resource scrambles – including a general disregard for environmental and social impacts, and the marginalisation of indigenous peoples and their rights,' a paper, written by Julie Hunter and Julian Aguon, from Blue Ocean Law, and Pradeep Singh, from the Center for Marine Environmental Sciences, Bremen, argues. The authors say that knowledge of the deep seabed remains extremely limited. 'The surface of the Moon, Mars and even Venus have all been mapped and studied in much greater detail, leading marine scientists to commonly remark that, with respect to the deep sea, "We don't yet know what we need to know".'</div>
                        </div>

                        <div class="flex gap-4">
                            <div class="font-bold text-lg flex-none w-6">E</div>
                            <div class="cambridge-paragraph m-0">Scientific research – including a recent paper in Marine Policy journal – has suggested the deep seabed, and hydrothermal vents, which are created when seawater meets volcanic magma, have crucial impacts upon biodiversity and the global climate. The mineral-rich vents and their surrounds are also home to many well-known animals including crustaceans, tubeworms, clams, slugs, anemones and fish. 'It is becoming increasingly clear that deep-sea mining poses a grave threat to these vital seabed functions,' the paper says. 'Extraction methods would produce large sediment plumes and involve the discharge of waste back into the ocean, significantly disturbing seafloor environments,' the paper continues. 'On deep sea vents, scientists are clear,' says Dr Jon Copley of the National Oceanography Centre, Southampton: 'we don't want mining on them.'</div>
                        </div>

                        <div class="flex gap-4">
                            <div class="font-bold text-lg flex-none w-6">F</div>
                            <div class="cambridge-paragraph m-0">The oceans occupy around 70% of the planet and are relatively unexplored, says Mike Johnston, chief executive of Nautilus, a Canadian underwater exploration company: 'It makes sense to explore this untapped potential in an environmentally sustainable way, instead of continually looking at the fast depleting land resources of the planet to meet society's rising needs.' Those leading the global rush to place giant mining machines thousands of metres below the sea surface say the environmental impacts will be far lower than on land. But critics say exotic and little-known ecosystems in the deep oceans could be destroyed and must be protected. 'Mining will be the greatest assault on deep-sea ecosystems ever inflicted by humans,' according to hydrothermal vent expert Verena Tunnicliffe, at the University of Victoria in Canada. She argues that active vents must be off-limits for mining to protect the new knowledge and biotechnology spin-offs they can deliver, and that strict controls must be in place elsewhere.</div>
                        </div>
                    </div>
                </div>

                {{-- PASSAGE 3 TEXT --}}
                <div class="mb-6 mt-16 pt-16 border-t-2 border-gray-300 cambridge-text max-w-3xl mx-auto">
                    <p class="italic mb-6 text-gray-600">You should spend about 20 minutes on <span class="font-bold">Questions 27–40</span>, which are based on Reading Passage 3 below.</p>
                    
                    <h2 class="cambridge-heading text-center mb-4">The Unselfish Gene</h2>
                    <p class="text-center italic text-lg mb-8 text-gray-800">A psychologist gives his view on how humans became self-centred</p>

                    <p class="cambridge-paragraph">There has long been a general assumption that human beings are essentially selfish. We're apparently ruthless, with strong impulses to compete against each other for resources and to accumulate power and possessions. If we are kind to one another, it's usually because we have ulterior motives. If we are good, it's only because we have managed to control and transcend our innate selfishness and brutality.</p>

                    <p class="cambridge-paragraph">This bleak view of human nature is closely associated with the science writer Richard Dawkins, whose 1976 book <i>The Selfish Gene</i> became popular because it fitted so well with – and helped to justify – the competitive and individualistic ethos that was so prevalent in late 20th-century societies. Like many others, Dawkins justifies his views with reference to the field of evolutionary psychology. Evolutionary psychology theorises that present-day human traits developed in prehistoric times, during what is termed the 'environment of evolutionary adaptedness'.</p>

                    <p class="cambridge-paragraph">Prehistory is usually seen as a period of intense competition, when life was such a brutal battle that only those with traits such as selfishness, aggression and ruthlessness survived. And because survival depended on access to resources – such as rivers, forests and animals – there was bound to be conflict between rival groups, which led to the development of traits such as racism and warfare. This seems logical. But, in fact, the assumption on which this all rests – that prehistoric life was a desperate struggle for survival – is false.</p>

                    <p class="cambridge-paragraph">It's important to remember that in the prehistoric era, the world was very sparsely populated. According to some estimates, around 15,000 years ago, the population of Europe was only 29,000, and the population of the whole world was less than half a million. Humans at that time were hunter-gatherers: people who lived by hunting wild animals and collecting wild plants. With such small population densities, it seems unlikely that prehistoric hunter-gatherer groups had to compete against each other for resources or had any need to develop ruthlessness and competitiveness, or to go to war.</p>

                    <p class="cambridge-paragraph">There is significant evidence to back this notion from contemporary hunter-gatherer groups, who live in the same way as prehistoric humans did. As the anthropologist Bruce Knauft has remarked, hunter-gatherers are characterised by 'extreme political and sexual egalitarianism'. Knauft has observed that individuals in such groups don't accumulate property or possessions and have an ethical obligation to share everything. They also have methods of preserving egalitarianism by ensuring that disparities of status don't arise.</p>

                    <p class="cambridge-paragraph">The !Kung people of southern Africa, for example, swap arrows before going hunting and when an animal is killed, the acclaim does not go to the person who fired the arrow, but to the person the arrow belongs to. And if a person becomes too domineering, the other members of the group ostracise them, exiling the offender from society. Typically in such groups, men do not dictate what women do. Women in hunter-gatherer groups worldwide often benefit from a high level of autonomy, being able to select their own marriage partners, decide what work they do and work whenever they choose to. And if a marriage breaks down, they have custody rights over their children.</p>

                    <p class="cambridge-paragraph">Many anthropologists believe that societies such as the !Kung were normal until a few thousand years ago, when population growth led to the development of agriculture and a settled lifestyle. In view of the above, there seems little reason to assume that traits such as racism, warfare and male domination should have been selected by evolution – as they would have been of little benefit in the prehistoric era. Individuals who behaved selfishly and ruthlessly would be less likely to survive, since they would have been ostracised from their groups.</p>

                    <p class="cambridge-paragraph">It makes more sense, then, to see traits such as cooperation, egalitarianism, altruism and peacefulness as innate characteristics of human beings. These were the traits that were prevalent in human life for tens of thousands of years. So presumably these traits are still strong in us now.</p>

                    <p class="cambridge-paragraph">But if prehistoric life wasn't really as brutal as has often been assumed, why do modern humans behave so selfishly and ruthlessly? Perhaps these negative traits should be seen as a later development, the result of environmental and psychological factors. Research has shown repeatedly that when the natural habitats of primates such as apes and gorillas are disrupted, they tend to become more violent and hierarchical.</p>

                    <p class="cambridge-paragraph">So, it could well be that the same thing has happened to us. I believe that the end of the hunter-gatherer lifestyle and the advent of farming was connected to a psychological change that occurred in some groups of people. There was a new sense of individuality and separateness, which led to a new selfishness, and ultimately to hierarchical societies, patriarchy and warfare. At any rate, these negative traits appear to have developed so recently that it doesn't seem feasible to explain them in adaptive or evolutionary terms.</p>
                </div>

            </div>
        </div>

        {{-- RIGHT PANEL: QUESTIONS --}}
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar relative" x-data="{ answers: {} }">
            
            <div class="p-10 pb-32 max-w-4xl mx-auto relative z-20">
                
                {{-- PASSAGE 1 QUESTIONS --}}
                <div class="max-w-4xl mx-auto text-gray-800">
                    
                    {{-- Questions 1-6 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <p class="font-bold mb-4 text-lg">Questions 1–6</p>
                        <p class="mb-4 text-[15px]">Do the following statements agree with the information given in Reading Passage 1?</p>
                        <p class="italic mb-4 text-[15px]">In boxes 1–6 on your answer sheet, write</p>
                        
                        <div class="ml-4 mb-6 space-y-2 text-[15px] max-w-sm">
                            <div class="flex gap-4"><span class="font-bold w-24 flex-none uppercase">TRUE</span><span>if the statement agrees with the information</span></div>
                            <div class="flex gap-4"><span class="font-bold w-24 flex-none uppercase">FALSE</span><span>if the statement contradicts the information</span></div>
                            <div class="flex gap-4"><span class="font-bold w-24 flex-none uppercase">NOT GIVEN</span><span>if there is no information on this</span></div>
                        </div>

                        <div class="space-y-5 text-[15px]">
                            @foreach([
                                1 => 'Forty years ago, there were fewer butterflies in Britain than at present.',
                                2 => 'Caterpillars are eaten by a number of different predators.',
                                3 => '\'Phenology\' is a term used to describe a creature\'s ability to alter the location of a lifecycle event.',
                                4 => 'Some species of butterfly have a reduced lifespan due to spring temperature increases.',
                                5 => 'There is a clear reason for the adaptations that butterflies are making to climate change.',
                                6 => 'The data used in the study was taken from the work of amateur butterfly watchers.'
                            ] as $qNum => $qText)
                            <div class="flex gap-4 items-start">
                                <span class="font-bold w-6 flex-none mt-1">{{ $qNum }}</span>
                                <div class="flex-1">
                                    <p class="mb-2">{{ $qText }}</p>
                                    <select x-model="answers.q{{ $qNum }}" class="border border-gray-300 rounded-md px-3 py-1.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 bg-gray-50 font-sans text-sm w-40 shadow-sm">
                                        <option value="" disabled selected>Select Answer</option>
                                        <option value="TRUE">TRUE</option>
                                        <option value="FALSE">FALSE</option>
                                        <option value="NOT GIVEN">NOT GIVEN</option>
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 7-13 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <p class="font-bold mb-4 text-lg">Questions 7–13</p>
                        <p class="italic mb-4 text-[15px]">Complete the notes below.</p>
                        <p class="italic mb-6 text-[15px]">Choose <span class="font-bold text-black uppercase">ONE WORD ONLY</span> from the passage for each answer.</p>
                        <p class="italic mb-6 text-[15px]">Write your answers in boxes 7–13 on your answer sheet.</p>

                        <div class="border border-gray-400 p-8 bg-white max-w-full mx-auto">
                            <h3 class="text-xl font-bold text-center mb-6 text-gray-900 border-b border-gray-400 pb-4">Butterflies in the UK</h3>
                            
                            <div class="space-y-6 text-[15px]">
                                <div>
                                    <p class="font-bold mb-3">The Small Blue</p>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li class="pl-2">
                                            <div class="flex items-center gap-2 flex-wrap inline-flex">
                                                <span>lives in large <span class="font-bold">7</span></span>
                                                <input type="text" x-model="answers.q7" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                            </div>
                                        </li>
                                        <li class="pl-2">
                                            <div class="flex items-center gap-2 flex-wrap inline-flex">
                                                <span>first appears at the start of <span class="font-bold">8</span></span>
                                                <input type="text" x-model="answers.q8" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                            </div>
                                        </li>
                                        <li class="pl-2">completes more than one reproductive cycle per year</li>
                                    </ul>
                                </div>

                                <div>
                                    <p class="font-bold mb-3 mt-6">The High Brown Fritillary</p>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li class="pl-2">has one reproductive cycle</li>
                                        <li class="pl-2">
                                            <div class="flex items-center gap-2 flex-wrap inline-flex">
                                                <span>is considered to be more <span class="font-bold">9</span></span>
                                                <input type="text" x-model="answers.q9" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                                <span>than other species</span>
                                            </div>
                                        </li>
                                        <li class="pl-2">
                                            <div class="flex items-center gap-2 flex-wrap inline-flex">
                                                <span>its caterpillars occupy a limited range of <span class="font-bold">10</span></span>
                                                <input type="text" x-model="answers.q10" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div>
                                    <p class="font-bold mb-3 mt-6">The Silver-studded Blue</p>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li class="pl-2">
                                            <div class="flex items-center gap-2 flex-wrap inline-flex">
                                                <span>is already able to reproduce twice a year in warm areas of <span class="font-bold">11</span></span>
                                                <input type="text" x-model="answers.q11" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div>
                                    <p class="font-bold mb-3 mt-6">The White Admiral</p>
                                    <ul class="list-disc pl-5 space-y-3">
                                        <li class="pl-2">
                                            <div class="flex items-center gap-2 flex-wrap inline-flex">
                                                <span>is found in <span class="font-bold">12</span></span>
                                                <input type="text" x-model="answers.q12" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                                <span>areas of England</span>
                                            </div>
                                        </li>
                                        <li class="pl-2">
                                            <div class="flex items-center gap-2 flex-wrap inline-flex">
                                                <span>both climate change and the <span class="font-bold">13</span></span>
                                                <input type="text" x-model="answers.q13" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block">
                                                <span>of the caterpillar are possible reasons for decline</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PASSAGE 2 QUESTIONS --}}
                <div class="mt-8 mb-4 max-w-4xl mx-auto">
                    <div class="flex justify-center mb-6">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>
                <div class="max-w-4xl mx-auto text-gray-800">
                    
                    {{-- Questions 14-17 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <p class="font-bold mb-4 text-lg">Questions 14–17</p>
                        <p class="mb-4 text-[15px]">Reading Passage 2 has six paragraphs, <span class="font-bold">A–F</span>.</p>
                        <p class="mb-4 text-[15px]">Which paragraph contains the following information?</p>
                        <p class="italic mb-6 text-[15px]">Write the correct letter, <span class="font-bold text-black">A–F</span>, in boxes 14–17 on your answer sheet.</p>

                        <div class="space-y-4 text-[15px]">
                            @foreach([
                                14 => 'reference to the rapidly increasing need for one raw material in the transport industry',
                                15 => 'a rough estimate of the area of the Earth covered by the oceans',
                                16 => 'how a particular underwater habitat, where minerals and organisms co-exist, is formed',
                                17 => 'reference to the fact that the countries of the world have yet to agree on rules for the exploration of the seabed'
                            ] as $qNum => $qText)
                            <div class="flex gap-4 items-start">
                                <span class="font-bold w-6 flex-none mt-1">{{ $qNum }}</span>
                                <div class="flex-1">
                                    <p class="mb-2 leading-tight">{{ $qText }}</p>
                                    <select x-model="answers.q{{ $qNum }}" class="border border-gray-300 rounded-md px-3 py-1.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 bg-gray-50 font-sans text-sm w-24 shadow-sm">
                                        <option value="" disabled selected>-</option>
                                        @foreach(['A','B','C','D','E','F'] as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 18-23 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <p class="font-bold mb-4 text-lg">Questions 18–23</p>
                        <p class="mb-4 text-[15px]">Look at the following statements (Questions 18–23) and the list of people below.</p>
                        <p class="mb-4 text-[15px]">Match each statement with the correct person or people, <span class="font-bold">A–E</span>.</p>
                        <p class="italic mb-4 text-[15px]">Write the correct letter, <span class="font-bold text-black">A–E</span>, in boxes 18–23 on your answer sheet.</p>
                        <p class="font-bold mb-6 text-[15px]">NB <span class="italic font-normal">You may use any letter more than once.</span></p>

                        <div class="space-y-4 text-[15px] mb-8">
                            @foreach([
                                18 => 'A move away from the exploration of heavily mined reserves on land is a good idea.',
                                19 => 'The negative effects of undersea exploration on local areas and their inhabitants are being ignored.',
                                20 => 'There are more worthwhile things to extract from the sea than minerals.',
                                21 => 'No other form of human exploration will have such a destructive impact on marine life as deep-sea mining.',
                                22 => 'More is known about outer space than about what lies beneath the oceans.',
                                23 => 'There is one marine life habitat where experts agree mining should not take place.'
                            ] as $qNum => $qText)
                            <div class="flex gap-4 items-start">
                                <span class="font-bold w-6 flex-none mt-1">{{ $qNum }}</span>
                                <div class="flex-1">
                                    <p class="mb-2 leading-tight">{{ $qText }}</p>
                                    <select x-model="answers.q{{ $qNum }}" class="border border-gray-300 rounded-md px-3 py-1.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 bg-gray-50 font-sans text-sm w-24 shadow-sm">
                                        <option value="" disabled selected>-</option>
                                        @foreach(['A','B','C','D','E'] as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="border border-gray-400 p-6 bg-white w-full max-w-sm mx-auto">
                            <h3 class="font-bold text-center text-lg mb-4 text-gray-900 border-b border-gray-300 pb-2">List of People</h3>
                            <div class="space-y-3 text-[15px] max-w-[280px] mx-auto">
                                <div class="flex gap-4"><span class="font-bold w-6 flex-none">A</span><span>Professor Mat Upton</span></div>
                                <div class="flex gap-4"><span class="font-bold w-6 flex-none">B</span><span>Julie Hunter, Julian Aguon and Pradeep Singh</span></div>
                                <div class="flex gap-4"><span class="font-bold w-6 flex-none">C</span><span>Dr Jon Copley</span></div>
                                <div class="flex gap-4"><span class="font-bold w-6 flex-none">D</span><span>Mike Johnston</span></div>
                                <div class="flex gap-4"><span class="font-bold w-6 flex-none">E</span><span>Verena Tunnicliffe</span></div>
                            </div>
                        </div>
                    </div>

                    {{-- Questions 24-26 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <p class="font-bold mb-4 text-lg">Questions 24–26</p>
                        <p class="italic mb-4 text-[15px]">Complete the summary below.</p>
                        <p class="italic mb-6 text-[15px]">Choose <span class="font-bold text-black uppercase">ONE WORD ONLY</span> from the passage for each answer.</p>
                        <p class="italic mb-6 text-[15px]">Write your answers in boxes 24–26 on your answer sheet.</p>

                        <div class="border border-gray-400 p-8 bg-gray-50 text-[15px] leading-relaxed">
                            <h3 class="text-xl font-bold text-center mb-6 text-gray-900">Mining the sea floor</h3>
                            
                            <p class="mb-4">
                                Mining corporations believe that the mineral resources lying under the sea may be superior to those found in the earth. They also say that these can be removed without producing much <span class="font-bold">24</span>
                                <input type="text" x-model="answers.q24" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block mx-1">
                                .
                            </p>
                            
                            <p class="mb-4">
                                The extraction is often done by adapting the <span class="font-bold">25</span>
                                <input type="text" x-model="answers.q25" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block mx-1">
                                that has already been used to work on land. The method of excavation involves removing the seawater from the slurry that is brought up to ships and returning it to the seabed. However, concerned groups strongly believe that <span class="font-bold">26</span>
                                <input type="text" x-model="answers.q26" class="border-b border-gray-400 outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block mx-1">
                                is necessary due to the possible number of unidentified consequences.
                            </p>
                        </div>
                    </div>

                </div>

                {{-- PASSAGE 3 QUESTIONS --}}
                <div class="mt-8 mb-4 max-w-4xl mx-auto">
                    <div class="flex justify-center mb-6">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>
                <div class="max-w-4xl mx-auto text-gray-800">
                    
                    {{-- Questions 27-30 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <p class="font-bold mb-4 text-lg">Questions 27–30</p>
                        <p class="mb-4 text-[15px]">Choose the correct letter, <span class="font-bold text-black">A, B, C</span> or <span class="font-bold text-black">D</span>.</p>
                        <p class="italic mb-6 text-[15px]">Write the correct letter in boxes 27–30 on your answer sheet.</p>

                        <div class="space-y-8 text-[15px]">
                            @foreach([
                                27 => [
                                    'q' => 'What is the writer doing in the first paragraph?',
                                    'options' => [
                                        'A' => 'setting out two opposing views about human nature',
                                        'B' => 'justifying his opinion about our tendency to be greedy',
                                        'C' => 'describing a commonly held belief about people\'s behaviour',
                                        'D' => 'explaining why he thinks that humans act in a selfish manner'
                                    ]
                                ],
                                28 => [
                                    'q' => 'What point is made about Richard Dawkins\' book <i>The Selfish Gene</i>?',
                                    'options' => [
                                        'A' => 'Its appeal lay in the radical nature of its ideas.',
                                        'B' => 'Its success was due to the scientific support it offered.',
                                        'C' => 'It presented a view that was in line with the attitudes of its time.',
                                        'D' => 'It took an innovative approach to the analysis of human psychology.'
                                    ]
                                ],
                                29 => [
                                    'q' => 'What does the writer suggest about the prehistoric era in the fourth paragraph?',
                                    'options' => [
                                        'A' => 'Societies were more complex than many people believe.',
                                        'B' => 'Supplies of natural resources were probably relatively plentiful.',
                                        'C' => 'Most estimates about population sizes are likely to be inaccurate.',
                                        'D' => 'Humans moved across continents more than was previously thought.'
                                    ]
                                ],
                                30 => [
                                    'q' => 'The writer refers to Bruce Knauft\'s work as support for the idea that',
                                    'options' => [
                                        'A' => 'selfishness is a relatively recent development in human societies.',
                                        'B' => 'only people in isolated communities can live in an unselfish manner.',
                                        'C' => 'very few lifestyles have survived unchanged since prehistoric times.',
                                        'D' => 'hunter-gatherer cultures worldwide are declining in number.'
                                    ]
                                ]
                            ] as $qNum => $data)
                            <div>
                                <div class="flex gap-4 items-start mb-3">
                                    <span class="font-bold w-6 flex-none mt-1">{{ $qNum }}</span>
                                    <p class="leading-relaxed">{!! $data['q'] !!}</p>
                                </div>
                                <div class="pl-10 space-y-3">
                                    @foreach($data['options'] as $letter => $text)
                                    <label class="flex items-start gap-4 cursor-pointer group">
                                        <input type="radio" x-model="answers.q{{ $qNum }}" value="{{ $letter }}" class="mt-1 text-emerald-600 focus:ring-emerald-500">
                                        <div class="flex gap-3">
                                            <span class="font-bold text-gray-700 group-hover:text-emerald-700 transition-colors">{{ $letter }}</span>
                                            <span class="text-gray-600 group-hover:text-gray-900 transition-colors">{{ $text }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Questions 31-35 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <p class="font-bold mb-4 text-lg">Questions 31–35</p>
                        <p class="italic mb-4 text-[15px]">Complete the summary below.</p>
                        <p class="italic mb-6 text-[15px]">Choose <span class="font-bold text-black uppercase">ONE WORD ONLY</span> from the passage for each answer.</p>
                        <p class="italic mb-6 text-[15px]">Write your answers in boxes 31–35 on your answer sheet.</p>

                        <div class="border border-gray-400 p-8 bg-gray-50 text-[15px] leading-relaxed">
                            <h3 class="text-xl font-bold text-center mb-6 text-gray-900">Contemporary hunter-gatherer societies</h3>
                            
                            <p class="mb-4">
                                Bruce Knauft's research shows that contemporary hunter-gatherer societies tend to exhibit a high level of <span class="font-bold">31</span>
                                <input type="text" x-model="answers.q31" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block mx-1">
                                in all areas of life. In these cultures, distributing resources fairly among all members is a moral obligation. These societies also employ strategies to prevent differences in <span class="font-bold">32</span>
                                <input type="text" x-model="answers.q32" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block mx-1">
                                occurring: for example, the !Kung follow a custom whereby the credit for one person's success at <span class="font-bold">33</span>
                                <input type="text" x-model="answers.q33" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block mx-1">
                                is given to another member of the group. Individuals who behave in a <span class="font-bold">34</span>
                                <input type="text" x-model="answers.q34" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block mx-1">
                                manner are punished by being excluded from the group, and women have a considerable amount of <span class="font-bold">35</span>
                                <input type="text" x-model="answers.q35" class="border-b border-gray-400 outline-none px-2 w-32 bg-transparent focus:border-blue-500 placeholder-gray-300 border-dotted border-b-2 transition-colors text-center inline-block mx-1">
                                in choices regarding work and marriage.
                            </p>
                        </div>
                    </div>

                    {{-- Questions 36-40 --}}
                    <div class="mb-10 bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                        <p class="font-bold mb-4 text-lg">Questions 36–40</p>
                        <p class="mb-4 text-[15px]">Do the following statements agree with the views of the writer in Reading Passage 3?</p>
                        <p class="italic mb-4 text-[15px]">In boxes 36–40 on your answer sheet, write</p>
                        
                        <div class="ml-4 mb-6 space-y-2 text-[15px] max-w-md">
                            <div class="flex gap-4"><span class="font-bold w-24 flex-none uppercase">YES</span><span>if the statement agrees with the views of the writer</span></div>
                            <div class="flex gap-4"><span class="font-bold w-24 flex-none uppercase">NO</span><span>if the statement contradicts the views of the writer</span></div>
                            <div class="flex gap-4"><span class="font-bold w-24 flex-none uppercase">NOT GIVEN</span><span>if it is impossible to say what the writer thinks about this</span></div>
                        </div>

                        <div class="space-y-5 text-[15px]">
                            @foreach([
                                36 => 'Some anthropologists are mistaken about the point when the number of societies such as the !Kung began to decline.',
                                37 => 'Humans who developed warlike traits in prehistory would have had an advantage over those who did not.',
                                38 => 'Being peaceful and cooperative is a natural way for people to behave.',
                                39 => 'Negative traits are more apparent in some modern cultures than in others.',
                                40 => 'Animal research has failed to reveal a link between changes in the environment and the emergence of aggressive tendencies.'
                            ] as $qNum => $qText)
                            <div class="flex gap-4 items-start">
                                <span class="font-bold w-6 flex-none mt-1">{{ $qNum }}</span>
                                <div class="flex-1">
                                    <p class="mb-2">{{ $qText }}</p>
                                    <select x-model="answers.q{{ $qNum }}" class="border border-gray-300 rounded-md px-3 py-1.5 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 bg-gray-50 font-sans text-sm w-40 shadow-sm">
                                        <option value="" disabled selected>Select Answer</option>
                                        <option value="YES">YES</option>
                                        <option value="NO">NO</option>
                                        <option value="NOT GIVEN">NOT GIVEN</option>
                                    </select>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end">
                        <button class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition shadow-sm" onclick="alert('Test submitted! (Mock functionality)')">
                            Submit All Answers
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>

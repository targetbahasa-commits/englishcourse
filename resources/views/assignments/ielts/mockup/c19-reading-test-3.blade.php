<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Reading Mock Test {{ $testId ?? '3' }} - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

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
                    <h1 class="text-xl font-bold text-gray-800">IELTS Reading – Mock Test {{ $testId ?? '3' }}</h1>
                    <p class="text-sm text-gray-500">Cambridge {{ $edition ?? '19' }} Reading Practice</p>
                </div>
            </div>
            <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition ?? '19', 'id' => $testId ?? '3']) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back
            </a>
        </div>
    </div>

    {{-- Split screen --}}
    <div class="flex-1 min-h-0 grid overflow-hidden" style="grid-template-columns: 2.5fr 2fr;">

        {{-- LEFT: Reading Passage --}}
        <div class="h-full overflow-y-auto bg-white border-r border-gray-200 custom-scrollbar relative"
             x-data="{ highlightMode: false, pencilMode: false, eraserMode: false, highlightColor: 'yellow', canvasObj: null }"
        >
            <div class="px-10 py-8 pb-32 max-w-3xl mx-auto relative z-20">
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-gray-600 text-white px-6 py-1.5 uppercase tracking-widest">READING</span>
                </div>
                
                <h2 class="text-xl font-bold mb-4 tracking-wider uppercase text-gray-600">READING PASSAGE 1</h2>
                <p class="italic mb-8 text-gray-700">You should spend about 20 minutes on <span class="font-bold">Questions 1–13</span>, which are based on Reading Passage 1 below.</p>
                
                <h3 class="text-3xl font-bold text-center mb-8 text-gray-700">Archaeologists discover evidence of prehistoric island settlers</h3>
                
                <div class="space-y-6 text-gray-800 text-lg leading-relaxed text-justify font-serif">
                    <p>In early April 2019, Dr Ceri Shipton and his colleagues from Australian National University became the first archaeologists to explore Obi, one of many tropical islands in Indonesia's Maluku Utara province. The research team's discoveries suggest that the prehistoric people who lived on Obi were adept on both land and sea, hunting in the dense rainforest, foraging on the seashore, and possibly even voyaging between islands.</p>

                    <p>The excavations were part of a project to learn more about how people first dispersed from mainland Asia, through the Indonesian archipelago and into the prehistoric continent that once connected Australia and New Guinea. The team's earlier research suggested that the northernmost islands in the group, known as the Wallacean islands, including Obi, would have offered the easiest migration route. It also seemed likely that these islands were crucial 'stepping stones' on humans' island-hopping voyages through this region millennia ago. But to support this idea, they needed archaeological evidence for humans living in this remote area in the ancient past. So, they travelled to Obi to look for sites that might reveal evidence of early occupation.</p>

                    <p>Just inland from the village of Kelo on Obi's northern coast, Shipton and his colleagues found two caves containing prehistoric rock shelters that were suitable for excavation. With the permission and help of the local people of Kelo, they dug a small test excavation in each shelter. There they found numerous artefacts, including fragments of axes, some dating to about 14,000 years ago. The earliest axes at Kelo were made using clam shells. Axes made from clam shells from roughly the same time had also previously been found elsewhere in this region, including on the nearby island of Gebe to the northeast. As on Gebe, it is highly likely that Obi's axes were used in the construction of canoes, thus allowing these early peoples to maintain connections between communities on neighbouring islands.</p>

                    <p>The oldest cultural layers from the Kelo site provided the team with the earliest record for human occupation on Obi, dating back around 18,000 years. At this time the climate was drier and colder than today, and the island's dense rainforests would likely have been much less impenetrable than they are now. Sea levels were about 120 metres lower, meaning Obi was a much larger island, encompassing what is today the separate island of Bisa, as well as several other small islands nearby.</p>

                    <p>Roughly 11,700 years ago, as the most recent ice age ended, the climate became significantly warmer and wetter, no doubt making Obi's jungle much thicker. According to the researchers, it is no coincidence that around this time the first axes crafted from stone rather than sea shells appear, likely in response to their heavy-duty use for clearing and modification of the increasingly dense rainforest. While stone takes about twice as long to grind into an axe compared to shell, the harder material keeps its sharp edge for longer.</p>

                    <p>Judging by the bones which the researchers unearthed in the Kelo caves, people living there mainly hunted the Rothschild's cuscus, a possum-like creature that still lives on Obi today. As the forest grew more dense, people probably used axes to clear patches of forest and make hunting easier.</p>

                    <p>Shipton's team's excavation of the shelters at the Kelo site unearthed a volcanic glass substance called obsidian, which must have been brought over from another island, as there is no known source on Obi. It also revealed particular types of beads, similar to those previously found on islands in southern Wallacea. These finds again support the idea that Obi islanders routinely travelled to other islands.</p>

                    <p>The excavations suggest people successfully lived in the two Kelo shelters for about 10,000 years. But then, about 8,000 years ago, both were abandoned. Did the residents leave Obi completely, or move elsewhere on the island? Perhaps the jungle had grown so thick that axes were no longer a match for the dense undergrowth. Perhaps people simply moved to the coast and turned to fishing rather than hunting as a means of survival.</p>

                    <p>Whatever the reason for the departure, there is no evidence for use of the Kelo shelters after this time, until about 1,000 years ago, when they were re-occupied by people who owned pottery as well as items made out of gold and silver. It seems likely, in view of Obi's location, that this final phase of occupation also saw the Kelo shelters used by people involved in the historic trade in spices between the Maluku islands and the rest of the world.</p>
                </div>

                {{-- Passage 2 --}}
                <div class="mb-6 mt-16 pt-16 border-t-2 border-gray-300">
                    <h2 class="text-xl font-bold mb-4 tracking-wider uppercase text-gray-600">READING PASSAGE 2</h2>
                    <p class="italic mb-8 text-gray-700">You should spend about 20 minutes on <span class="font-bold">Questions 14–26</span>, which are based on Reading Passage 2 below.</p>
                    
                    <h3 class="text-3xl font-bold text-center mb-8 text-gray-700">The global importance of wetlands</h3>
                    
                    <div class="space-y-6 text-gray-800 text-lg leading-relaxed text-justify font-serif">
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">A</span>
                            <p>Wetlands are areas where water covers the soil, or is present either at or near the surface of the soil, for all or part of the year. These are complex ecosystems, rich in unique plant and animal life. But according to the World Wide Fund for Nature (WWFN), half of the world's wetlands have disappeared since 1990 &ndash; converted or destroyed for commercial development, drainage schemes and the extraction of minerals and peat*. Many of those that remain have been damaged by agricultural pesticides and fertilisers, industrial pollutants, and construction works.</p>
                        </div>

                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">B</span>
                            <p>Throughout history, humans have gathered around wetlands, and their fertile ecosystems have played an important part in human development. Consequently, they are of considerable religious, historical and archaeological value to many communities around the world. 'Wetlands directly support the livelihoods and well-being of millions of people,' says Dr Matthew McCartney, principal researcher and hydrologist at the International Water Management Institute (IWMI). 'In many developing countries, large numbers of people are dependent on wetland agriculture for their livelihoods.'</p>
                        </div>

                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">C</span>
                            <p>They also serve a crucial environmental purpose. 'Wetlands are one of the key tools in mitigating climate change across the planet,' says Pieter van Eijk, head of Climate Adaptation at Wetlands International (WI), pointing to their use as buffers that protect coastal areas from sea-level rise and extreme weather events such as hurricanes and flooding. Wetland coastal forests provide food and water, as well as shelter from storms, and WI and other agencies are working to restore those forests which have been lost. 'It can be as simple as planting a few trees per hectare to create shade and substantially change a microclimate,' he says. 'Implementing climate change projects isn't so much about money.'</p>
                        </div>

                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">D</span>
                            <p>The world's wetlands are, unfortunately, rich sources for in-demand commodities, such as palm oil and pulpwood. Peatlands &ndash; wetlands with a waterlogged organic soil layer &ndash; are particularly targeted. When peatlands are drained for cultivation, they become net carbon emitters instead of active carbon stores, and, according to Marcel Silvius, head of Climate-smart Land-use at WI, this practice causes six per cent of all global carbon emissions. The clearance of peatlands for planting also increases the risk of forest fires, which release huge amounts of CO2. 'We're seeing huge peatland forests with extremely high biodiversity value being lost for a few decades of oil palm revenues,' says Silvius.</p>
                        </div>

                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">E</span>
                            <p>The damage starts when logging companies arrive to clear the trees. They dig ditches to enter the peat swamps by boat and then float the logs out the same way. These are then used to drain water out of the peatlands to allow for the planting of corn, oil palms or pulpwood trees. Once the water has drained away, bacteria and fungi then break down the carbon in the peat and turn it into CO2 and methane. Meanwhile, the remainder of the solid matter in the peat starts to move downwards, in a process known as subsidence**. Peat comprises 90 per cent water, so this is one of the most alarming consequences of peatland clearances. 'In the tropics, peat subsides at about four centimetres a year, so within half a century, very large landscapes on Sumatra and Borneo will become flooded as the peat drops below water level,' says Silvius. 'It's a huge catastrophe that's in preparation. Some provinces will lose 40 per cent of their landmass.'</p>
                        </div>

                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">F</span>
                            <p>And while these industries affect wetlands in ways that can easily be documented, Dr Dave Tickner of the WWFN believes that more subtle impacts can be even more devastating. 'Sediment run-off and fertilisers can be pretty invisible,' says Tickner. 'Over-extraction of water is equally invisible. You do get shock stories about rivers running red, or even catching fire, but there's seldom one big impact that really hurts a wetland.' Tickner does not blame anyone for deliberate damage, however. 'I've worked on wetland issues for 20 years and have never met anybody who wanted to damage a wetland,' he says. 'It isn't something that people generally set out to do. Quite often, the effects simply come from people trying to make a living.'</p>
                        </div>

                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">G</span>
                            <p>Silvius also acknowledges the importance of income generation. 'It's not that we just want to restore the biodiversity of wetlands &ndash; which we do &ndash; but we recognise there's a need to provide an income for local people.' This approach is supported by IWMI. 'The idea is that people in a developing country will only protect wetlands if they value and profit from them,' says McCartney. 'For sustainability, it's essential that local people are involved in wetland planning and decision making and have clear rights to use wetlands.'</p>
                        </div>

                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">H</span>
                            <p>The fortunes of wetlands would be improved, Silvius suggests, if more governments recognised their long-term value. 'Different governments have different attitudes,' he says, and goes on to explain that some countries place a high priority on restoring wetlands, while others still deny the issue. McCartney is cautiously optimistic, however. 'Awareness of the importance of wetlands is growing,' he says. 'It's true that wetland degradation still continues at a rapid pace, but my impression is that things are slowly changing.'</p>
                        </div>

                        <div class="text-sm text-gray-500 mt-8 pt-4 border-t border-gray-200 space-y-2">
                            <p>* peat: a brown deposit formed by the partial decomposition of vegetation in wet acidic conditions, often cut out and dried for use as fuel</p>
                            <p>** subsidence: the gradual caving in or sinking of an area of land</p>
                        </div>
                    </div>
                </div>

                {{-- Passage 3 --}}
                <div class="mb-6 mt-16 pt-16 border-t-2 border-gray-300">
                    <h2 class="text-xl font-bold mb-4 tracking-wider uppercase text-gray-600">READING PASSAGE 3</h2>
                    <p class="italic mb-8 text-gray-700">You should spend about 20 minutes on <span class="font-bold">Questions 27–40</span>, which are based on Reading Passage 3 below.</p>
                    
                    <h3 class="text-3xl font-bold text-center mb-4 text-gray-700">Is the era of artificial speech translation upon us?</h3>
                    <p class="text-center italic text-gray-600 mb-8 text-lg">Once the stuff of science fiction, technology that enables people to talk using different languages is now here. But how effective is it?</p>
                    
                    <div class="space-y-6 text-gray-800 text-lg leading-relaxed text-justify font-serif">
                        <p>Noise, Alex Waibel tells me, is one of the major challenges that artificial speech translation has to meet. A device may be able to recognise speech in a laboratory, or a meeting room, but will struggle to cope with the kind of background noise I can hear in my office surrounding Professor Waibel as he speaks to me from Kyoto station in Japan. I'm struggling to follow him in English, on a scratchy line that reminds me we are nearly 10,000 kilometres apart &ndash; and that distance is still an obstacle to communication even if you're speaking the same language, as we are. We haven't reached the future yet. If we had, Waibel would have been able to speak more comfortably in his native German and I would have been able to hear his words in English.</p>

                        <p>At Karlsruhe Institute of Technology, where he is a professor of computer science, Waibel and his colleagues already give lectures in German that their students can follow in English via an electronic translator. The system generates text that students can read on their laptops or phones, so the process is somewhat similar to subtitling. It helps that lecturers speak clearly, don't have to compete with background chatter, and say much the same thing each year.</p>

                        <p>The idea of artificial speech translation has been around for a long time. Douglas Adams' science fiction novel, The Hitchhiker's Guide to the Galaxy, published in 1979, featured a life form called the 'Babel fish' which, when placed in the ear, enabled a listener to understand any language in the universe. It came to represent one of those devices that technology enthusiasts dream of long before they become practically realisable, like TVs flat enough to hang on walls: objects that we once could only dream of having but that are now commonplace. Now devices that look like prototype Babel fish have started to appear, riding a wave of advances in artificial translation and voice recognition.</p>

                        <p>At this stage, however, they seem to be regarded as eye-catching novelties rather than steps towards what Waibel calls 'making a language-transparent society'. They tend to be domestic devices or applications suitable for hotel check-ins, for example, providing a practical alternative to speaking traveller's English. The efficiency of the translator is less important than the social function. However, 'Professionals are less inclined to be patient in a conversation,' founder and CEO at Waverly Labs, Andrew Ochoa, observes. To redress this, Waverly is now preparing a new model for professional applications, which entails performance improvements in speech recognition, translation accuracy and the time it takes to deliver the translated speech.</p>

                        <p>For a conversation, both speakers need to have devices called Pilots (translator earpieces) in their ears. 'We find that there's a barrier with sharing one of the earphones with a stranger,' says Ochoa. That can't have been totally unexpected. The problem would be solved if earpiece translators became sufficiently prevalent that strangers would be likely to already have their own in their ears. Whether that happens, and how quickly, will probably depend not so much on the earpieces themselves, but on the prevalence of voice-controlled devices and artificial translation in general.</p>

                        <p>Waibel highlights the significance of certain Asian nations, noting that voice translation has really taken off in countries such as Japan with a range of systems. There is still a long way to go, though. A translation system needs to be simultaneous, like the translator's voice speaking over the foreign politician being interviewed on the TV, rather than in sections that oblige speakers to pause after every few remarks and wait for the translation to be delivered. It needs to work offline, for situations where internet access isn't possible, and to address apprehensions about the amount of private speech data accumulating in the cloud, having been sent to servers for processing.</p>

                        <p>Systems not only need to cope with physical challenges such as noise, they will also need to be socially aware by addressing people in the right way. Some cultural traditions demand solemn respect for academic status, for example, and it is only polite to respect this. Etiquette-sensitive artificial translators could relieve people of the need to know these differing cultural norms. At the same time, they might help to preserve local customs, slowing the spread of habits associated with international English, such as its readiness to get on first-name terms.</p>

                        <p>Professors and other professionals will not outsource language awareness to software, though. If the technology matures into seamless, ubiquitous artificial speech translation, it will actually add value to language skills. Whether it will help people conduct their family lives or relationships is open to question &ndash; though one noteworthy possibility is that it could overcome the language barriers that often arise between generations after migration, leaving children and their grandparents without a shared language.</p>

                        <p>Whatever uses it is put to, though, it will never be as good as the real thing. Even if voice-morphing technology simulates the speaker's voice, their lip movements won't match, and they will look like they are in a dubbed movie. The contrast will underline the value of shared languages, and the value of learning them. Sharing a language can promote a sense of belonging and community, as with the international scientists who use English as a lingua franca, where their predecessors used Latin. Though the practical need for a common language will diminish, the social value of sharing one will persist. And software will never be a substitute for the subtle but vital understanding that comes with knowledge of a language.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Questions --}}
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar">
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto" x-data="{ answers: {} }">

                {{-- Questions 1–7: True/False/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–7</strong></p>
                    <p class="text-sm text-gray-800 mb-2">Do the following statements agree with the information given in Reading Passage 1?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 1–7 on your answer sheet, write</p>

                    <div class="mb-6 ml-6 text-sm text-gray-800">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic uppercase tracking-wider">TRUE</span></div><div class="italic">if the statement agrees with the information</div>
                            <div><span class="font-bold italic uppercase tracking-wider">FALSE</span></div><div class="italic">if the statement contradicts the information</div>
                            <div><span class="font-bold italic uppercase tracking-wider">NOT GIVEN</span></div><div class="italic">if there is no information on this</div>
                        </div>
                    </div>

                    <div class="mt-2 space-y-4">
                        @foreach([
                            1 => 'Archaeological research had taken place on the island of Obi before the arrival of Ceri Shipton and his colleagues.',
                            2 => 'At the Kelo sites, the researchers found the first clam shell axes ever to be discovered in the region.',
                            3 => 'The size of Obi today is less than it was 18,000 years ago.',
                            4 => 'A change in the climate around 11,700 years ago had a greater impact on Obi than on the surrounding islands.',
                            5 => 'The researchers believe there is a connection between warmer, wetter weather and a change in the material used to make axes.',
                            6 => 'Shipton\'s team were surprised to find evidence of the Obi islanders\' hunting practices.',
                            7 => 'It is thought that the Kelo shelters were occupied continuously until about 1,000 years ago.'
                        ] as $qNum => $statement)
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-gray-900 w-6 mt-1 flex-none">{{ $qNum }}</span>
                            <span class="text-gray-800 text-sm flex-1 mt-1">{{ $statement }}</span>
                            <div class="relative inline-block w-32 flex-none">
                                <select x-model="answers.q{{ $qNum }}" name="q{{ $qNum }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1.5 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                    <option value="" disabled selected>-</option>
                                    <option value="TRUE">TRUE</option>
                                    <option value="FALSE">FALSE</option>
                                    <option value="NOT GIVEN">NOT GIVEN</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Questions 8–13: Note Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 8–13</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Choose <span class="font-bold uppercase">ONE WORD ONLY</span> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 8–13 on your answer sheet.</p>

                    <div class="border border-gray-400 p-6 sm:p-8 bg-white text-sm">
                        <h4 class="text-lg font-bold text-center mb-6 text-gray-700">Archaeological findings on Obi</h4>
                        
                        <p class="text-gray-800 leading-relaxed mb-4">
                            Excavations of rock shelters inside <span class="font-bold">8</span>
                            <input type="text" x-model="answers.q8" name="q8" class="border-b border-gray-400 outline-none px-1 w-24 bg-transparent text-center focus:border-blue-500 transition-colors">
                            near the village of Kelo revealed:
                        </p>
                        
                        <ul class="list-disc ml-6 space-y-4 mb-6">
                            <li class="text-gray-800 leading-relaxed pl-2">
                                axes from around 14,000 years ago, probably used to make canoes
                            </li>
                            <li class="text-gray-800 leading-relaxed pl-2">
                                axes made out of <span class="font-bold">9</span>
                                <input type="text" x-model="answers.q9" name="q9" class="border-b border-gray-400 outline-none px-1 w-24 bg-transparent text-center focus:border-blue-500 transition-colors">
                                , dating from around 11,700 years ago
                            </li>
                            <li class="text-gray-800 leading-relaxed pl-2">
                                <span class="font-bold">10</span>
                                <input type="text" x-model="answers.q10" name="q10" class="border-b border-gray-400 outline-none px-1 w-24 bg-transparent text-center focus:border-blue-500 transition-colors">
                                of an animal: evidence of what ancient islanders ate
                            </li>
                            <li class="text-gray-800 leading-relaxed pl-2">
                                evidence of travel between islands:
                                <ul class="list-[circle] ml-6 mt-3 space-y-3">
                                    <li class="pl-2">obsidian: a material that is not found naturally on Obi</li>
                                    <li class="pl-2">
                                        <span class="font-bold">11</span>
                                        <input type="text" x-model="answers.q11" name="q11" class="border-b border-gray-400 outline-none px-1 w-24 bg-transparent text-center focus:border-blue-500 transition-colors">
                                        which resembled ones found on other islands.
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        <p class="text-gray-800 leading-relaxed mb-4">
                            It is thought that from 8,000 years ago, Obi islanders:
                        </p>

                        <ul class="list-disc ml-6 space-y-4">
                            <li class="text-gray-800 leading-relaxed pl-2">
                                may have switched from hunting to fishing
                            </li>
                            <li class="text-gray-800 leading-relaxed pl-2">
                                had <span class="font-bold">12</span>
                                <input type="text" x-model="answers.q12" name="q12" class="border-b border-gray-400 outline-none px-1 w-24 bg-transparent text-center focus:border-blue-500 transition-colors">
                                as well as items made out of metal
                            </li>
                            <li class="text-gray-800 leading-relaxed pl-2">
                                probably took part in the production and sale of <span class="font-bold">13</span>
                                <input type="text" x-model="answers.q13" name="q13" class="border-b border-gray-400 outline-none px-1 w-24 bg-transparent text-center focus:border-blue-500 transition-colors">
                                .
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- ── PASSAGE 2 Questions ── --}}
                <div class="mt-8 mb-4">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-gray-600 text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Questions 14-17: Matching Headings/Paragraphs --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–17</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 2 has eight paragraphs, <strong>A–H</strong>.</p>
                    <p class="text-sm text-gray-800 mb-1">Which paragraph contains the following information?</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct letter, <strong>A–H</strong>, in boxes 14–17 on your answer sheet.</p>

                    <div class="mt-2 space-y-4">
                        @foreach([
                            14 => 'reference to the need to ensure that inhabitants of wetland regions continue to benefit from them',
                            15 => 'the proportion of wetlands which have already been lost',
                            16 => 'reference to the idea that people are beginning to appreciate the value of wetlands',
                            17 => 'mention of the cultural significance of wetlands'
                        ] as $qNum => $statement)
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-gray-900 w-6 mt-1 flex-none">{{ $qNum }}</span>
                            <span class="text-gray-800 text-sm flex-1 mt-1">{{ $statement }}</span>
                            <div class="relative inline-block w-24 flex-none">
                                <select x-model="answers.q{{ $qNum }}" name="q{{ $qNum }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1.5 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                    <option value="" disabled selected>-</option>
                                    @foreach(['A','B','C','D','E','F','G','H'] as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Questions 18-22: Sentence Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 18–22</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the sentences below.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Choose <span class="font-bold uppercase">ONE WORD ONLY</span> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 18–22 on your answer sheet.</p>

                    <div class="space-y-5">
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-gray-900 w-6 mt-1 flex-none">18</span>
                            <p class="text-gray-800 text-sm mt-1 leading-relaxed">
                                Peatlands which have been drained begin to release <input type="text" x-model="answers.q18" name="q18" class="border-b border-gray-400 outline-none px-1 w-28 bg-transparent text-center focus:border-blue-500 transition-colors"> instead of storing it.
                            </p>
                        </div>
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-gray-900 w-6 mt-1 flex-none">19</span>
                            <p class="text-gray-800 text-sm mt-1 leading-relaxed">
                                Once peatland areas have been cleared, <input type="text" x-model="answers.q19" name="q19" class="border-b border-gray-400 outline-none px-1 w-28 bg-transparent text-center focus:border-blue-500 transition-colors"> are more likely to occur.
                            </p>
                        </div>
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-gray-900 w-6 mt-1 flex-none">20</span>
                            <p class="text-gray-800 text-sm mt-1 leading-relaxed">
                                Clearing peatland forests to make way for oil palm plantations destroys the <input type="text" x-model="answers.q20" name="q20" class="border-b border-gray-400 outline-none px-1 w-28 bg-transparent text-center focus:border-blue-500 transition-colors"> of the local environment.
                            </p>
                        </div>
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-gray-900 w-6 mt-1 flex-none">21</span>
                            <p class="text-gray-800 text-sm mt-1 leading-relaxed">
                                Water is drained out of peatlands through the <input type="text" x-model="answers.q21" name="q21" class="border-b border-gray-400 outline-none px-1 w-28 bg-transparent text-center focus:border-blue-500 transition-colors"> which are created by logging companies.
                            </p>
                        </div>
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-gray-900 w-6 mt-1 flex-none">22</span>
                            <p class="text-gray-800 text-sm mt-1 leading-relaxed">
                                Draining peatlands leads to <input type="text" x-model="answers.q22" name="q22" class="border-b border-gray-400 outline-none px-1 w-28 bg-transparent text-center focus:border-blue-500 transition-colors"> : a serious problem which can eventually result in coastal flooding and land loss.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Questions 23-26: Match statements with correct expert --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 23–26</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Look at the following statements (Questions 23–26) and the list of experts below.</p>
                    <p class="text-sm text-gray-800 mb-4">Match each statement with the correct expert, <strong>A–D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–D</strong>, in boxes 23–26 on your answer sheet.</p>

                    <div class="mt-2 space-y-4 mb-6">
                        @foreach([
                            23 => 'Communities living in wetland regions must be included in discussions about the future of these areas.',
                            24 => 'Official policies towards wetlands vary from one nation to the next.',
                            25 => 'People cause harm to wetlands without having any intention to do so.',
                            26 => 'Initiatives to reverse environmental damage need not be complex.'
                        ] as $qNum => $statement)
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-gray-900 w-6 mt-1 flex-none">{{ $qNum }}</span>
                            <span class="text-gray-800 text-sm flex-1 mt-1">{{ $statement }}</span>
                            <div class="relative inline-block w-24 flex-none">
                                <select x-model="answers.q{{ $qNum }}" name="q{{ $qNum }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1.5 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                    <option value="" disabled selected>-</option>
                                    @foreach(['A','B','C','D'] as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="border border-gray-400 rounded-lg p-5 bg-white text-sm max-w-sm mx-auto shadow-sm">
                        <h4 class="text-base font-bold text-center mb-4 text-gray-900">List of Experts</h4>
                        <div class="space-y-3 max-w-[200px] mx-auto text-gray-800">
                            <div class="flex gap-4"><span class="font-bold text-gray-900">A</span> <span>Matthew McCartney</span></div>
                            <div class="flex gap-4"><span class="font-bold text-gray-900">B</span> <span>Pieter van Eijk</span></div>
                            <div class="flex gap-4"><span class="font-bold text-gray-900">C</span> <span>Marcel Silvius</span></div>
                            <div class="flex gap-4"><span class="font-bold text-gray-900">D</span> <span>Dave Tickner</span></div>
                        </div>
                    </div>
                </div>

                {{-- ── PASSAGE 3 Questions ── --}}
                <div class="mt-12 mb-4">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-gray-600 text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>

                {{-- Questions 27–30: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–30</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct letter in boxes 27–30 on your answer sheet.</p>

                    <div class="space-y-6">
                        @foreach([
                            27 => [
                                'question' => 'What does the reader learn about the conversation in the first paragraph?',
                                'options' => [
                                    'A' => 'The speakers are communicating in different languages.',
                                    'B' => 'Neither of the speakers is familiar with their environment.',
                                    'C' => 'The topic of the conversation is difficult for both speakers.',
                                    'D' => 'Aspects of the conversation are challenging for both speakers.'
                                ]
                            ],
                            28 => [
                                'question' => 'What assists the electronic translator during lectures at Karlsruhe Institute of Technology?',
                                'options' => [
                                    'A' => 'the repeated content of lectures',
                                    'B' => 'the students\' reading skills',
                                    'C' => 'the languages used',
                                    'D' => 'the lecturers\' technical ability'
                                ]
                            ],
                            29 => [
                                'question' => 'When referring to <span class="italic">The Hitchhiker\'s Guide to the Galaxy</span>, the writer suggests that',
                                'options' => [
                                    'A' => 'the Babel fish was considered undesirable at the time.',
                                    'B' => 'this book was not seriously intending to predict the future.',
                                    'C' => 'artificial speech translation was not a surprising development.',
                                    'D' => 'some speech translation techniques are better than others.'
                                ]
                            ],
                            30 => [
                                'question' => 'What does the writer say about sharing earpieces?',
                                'options' => [
                                    'A' => 'It is something people will get used to doing.',
                                    'B' => 'The reluctance to do this is understandable.',
                                    'C' => 'The equipment will be unnecessary in the future.',
                                    'D' => 'It is something few people need to worry about.'
                                ]
                            ]
                        ] as $qNum => $qData)
                        <div>
                            <div class="flex gap-4 items-start mb-3">
                                <span class="font-bold text-gray-900 w-6 flex-none mt-1">{{ $qNum }}</span>
                                <span class="text-gray-800 font-medium mt-1">{!! $qData['question'] !!}</span>
                            </div>
                            <div class="ml-10 space-y-2">
                                @foreach($qData['options'] as $letter => $optionText)
                                <label class="flex gap-3 items-start cursor-pointer hover:bg-gray-50 p-2 rounded transition">
                                    <input type="radio" x-model="answers.q{{ $qNum }}" name="q{{ $qNum }}" value="{{ $letter }}" class="mt-1 text-blue-600 focus:ring-blue-500">
                                    <span class="font-bold text-gray-700">{{ $letter }}</span>
                                    <span class="text-gray-700">{{ $optionText }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Questions 31–34: Matching Sentence Endings --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 31–34</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete each sentence with the correct ending, <strong>A–F</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–F</strong>, in boxes 31–34 on your answer sheet.</p>

                    <div class="mt-2 space-y-4 mb-6">
                        @foreach([
                            31 => 'Speech translation methods are developing fast in Japan',
                            32 => 'TV interviews that use translation voiceover methods are successful',
                            33 => 'Future translation systems should address people appropriately',
                            34 => 'Users may be able to maintain their local customs'
                        ] as $qNum => $statement)
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-gray-900 w-6 mt-1 flex-none">{{ $qNum }}</span>
                            <span class="text-gray-800 text-sm flex-1 mt-1">{{ $statement }}</span>
                            <div class="relative inline-block w-24 flex-none">
                                <select x-model="answers.q{{ $qNum }}" name="q{{ $qNum }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1.5 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                    <option value="" disabled selected>-</option>
                                    @foreach(['A','B','C','D','E','F'] as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm max-w-lg mx-auto shadow-sm">
                        <div class="space-y-3 text-gray-800">
                            <div class="flex gap-4"><span class="font-bold text-gray-900 w-4 flex-none">A</span> <span>but there are concerns about this.</span></div>
                            <div class="flex gap-4"><span class="font-bold text-gray-900 w-4 flex-none">B</span> <span>as systems do not need to conform to standard practices.</span></div>
                            <div class="flex gap-4"><span class="font-bold text-gray-900 w-4 flex-none">C</span> <span>but they are far from perfect.</span></div>
                            <div class="flex gap-4"><span class="font-bold text-gray-900 w-4 flex-none">D</span> <span>despite the noise issues.</span></div>
                            <div class="flex gap-4"><span class="font-bold text-gray-900 w-4 flex-none">E</span> <span>because translation is immediate.</span></div>
                            <div class="flex gap-4"><span class="font-bold text-gray-900 w-4 flex-none">F</span> <span>and have an awareness of good manners.</span></div>
                        </div>
                    </div>
                </div>

                {{-- Questions 35–40: Yes/No/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 35–40</strong></p>
                    <p class="text-sm text-gray-800 mb-2">Do the following statements agree with the views of the writer in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 35–40 on your answer sheet, write</p>

                    <div class="mb-6 ml-6 text-sm text-gray-800">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic uppercase tracking-wider">YES</span></div><div class="italic">if the statement agrees with the views of the writer</div>
                            <div><span class="font-bold italic uppercase tracking-wider">NO</span></div><div class="italic">if the statement contradicts the views of the writer</div>
                            <div><span class="font-bold italic uppercase tracking-wider">NOT GIVEN</span></div><div class="italic">if it is impossible to say what the writer thinks about this</div>
                        </div>
                    </div>

                    <div class="mt-2 space-y-4">
                        @foreach([
                            35 => 'Language translation systems will be seen as very useful throughout the academic and professional worlds.',
                            36 => 'The overall value of automated translation to family life is yet to be shown.',
                            37 => 'Automated translation could make life more difficult for immigrant families.',
                            38 => 'Visual aspects of language translation are being considered by scientists.',
                            39 => 'International scientists have found English easier to translate into other languages than Latin.',
                            40 => 'As far as language is concerned, there is a difference between people\'s social and practical needs.'
                        ] as $qNum => $statement)
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-gray-900 w-6 mt-1 flex-none">{{ $qNum }}</span>
                            <span class="text-gray-800 text-sm flex-1 mt-1">{{ $statement }}</span>
                            <div class="relative inline-block w-32 flex-none">
                                <select x-model="answers.q{{ $qNum }}" name="q{{ $qNum }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1.5 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                    <option value="" disabled selected>-</option>
                                    <option value="YES">YES</option>
                                    <option value="NO">NO</option>
                                    <option value="NOT GIVEN">NOT GIVEN</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Final Submit Placeholder --}}
                <div class="mt-8 flex justify-end">
                    <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                        Submit All Answers
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>

</body>
</html>

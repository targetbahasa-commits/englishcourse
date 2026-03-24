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
             x-data="{ highlightMode: false, pencilMode: false, eraserMode: false, highlightColor: 'yellow', canvasObj: null }"
        >
            <div class="px-10 py-8 pb-32 max-w-3xl mx-auto relative z-20">
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">READING</span>
                </div>
                
                <h2 class="text-xl font-bold mb-4 tracking-wider uppercase">READING PASSAGE 1</h2>
                <p class="italic mb-8">You should spend about 20 minutes on <span class="font-bold">Questions 1–13</span>, which are based on Reading Passage 1 below.</p>
                
                <h3 class="text-3xl font-bold text-center mb-8">How tennis rackets have changed</h3>
                
                <div class="space-y-6 text-gray-800 text-lg leading-relaxed text-justify font-serif">
                    <p>In 2016, the British professional tennis player Andy Murray was ranked as the world's number one. It was an incredible achievement by any standard &ndash; made even more remarkable by the fact that he did this during a period considered to be one of the strongest in the sport's history, competing against the likes of Rafael Nadal, Roger Federer and Novak Djokovic, to name just a few. Yet five years previously, he had been regarded as a talented outsider who entered but never won the major tournaments.</p>

                    <p>Of the changes that account for this transformation, one was visible and widely publicised: in 2011, Murray invited former number one player Ivan Lendl onto his coaching team &ndash; a valuable addition that had a visible impact on the player's playing style. Another change was so subtle as to pass more or less unnoticed. Like many players, Murray has long preferred a racket that consists of two types of string: one for the mains (verticals) and another for the crosses (horizontals). While he continued to use natural string in the crosses, in 2012 he switched to a synthetic string for the mains. A small change, perhaps, but its importance should not be underestimated.</p>

                    <p>The modification that Murray made is just one of a number of options available to players looking to tweak their rackets in order to improve their games. 'Touring professionals have their rackets customised to their specific needs,' says Colin Triplow, a UK-based professional racket stringer. 'It's a highly important part of performance maximisation.' Consequently, the specific rackets used by the world's elite are not actually readily available to the public; rather, each racket is individually made to suit the player who uses it. Take the US professional tennis players Mike and Bob Bryan, for example: 'We're very particular with our racket specifications,' they say. 'All our rackets are sent from our manufacturer to Tampa, Florida, where our frames go through a . . . thorough customisation process.' They explain how they have adjusted not only racket length, but even experimented with different kinds of paint. The rackets they use now weigh more than the average model and also have a denser string pattern (i.e. more crosses and mains).</p>

                    <p>The primary reason for these modifications is simple: as the line between winning and losing becomes thinner and thinner, even these slight changes become more and more important. As a result, players and their teams are becoming increasingly creative with the modifications to their rackets as they look to maximise their competitive advantage.</p>

                    <p>Racket modifications mainly date back to the 1970s, when the amateur German tennis player Werner Fischer started playing with the so-called spaghetti-strung racket. It created a string bed that generated so much topspin that it was quickly banned by the International Tennis Federation. However, within a decade or two, racket modification became a regularity. Today it is, in many ways, an aspect of the game that is equal in significance to nutrition or training.</p>

                    <p>Modifications can be divided into two categories: those to the string bed and those to the racket frame. The former is far more common than the latter: the choice of the strings and the tension with which they are installed is something that nearly all professional players experiment with. They will continually change it depending on various factors including the court surface, climatic conditions, and game styles. Some will even change it depending on how they feel at the time.</p>

                    <p>At one time, all tennis rackets were strung with natural gut made from the outer layer of sheep or cow intestines. This all changed in the early 1990s with the development of synthetic strings that were cheaper and more durable. They are made from three materials: nylon (relatively durable and affordable), Kevlar (too stiff to be used alone) or co-polyester (polyester combined with additives that enhance its performance). Even so, many professional players continue to use a 'hybrid set-up', where a combination of both synthetic and natural strings are used.</p>

                    <p>Of the synthetics, co-polyester is by far the most widely used. It's a perfect fit for the style of tennis now played, where players tend to battle it out from the back of the court rather than coming to the net. Studies indicate that the average spin from a co-polyester string is 25% greater than that from natural string or other synthetics. In a sense, the development of co-polyester strings has revolutionised the game.</p>

                    <p>However, many players go beyond these basic adjustments to the strings and make changes to the racket frame itself. For example, much of the serving power of US professional player Pete Sampras was attributed to the addition of four to five lead weights onto his rackets, and today many professionals have the weight adjusted during the manufacturing process.</p>

                    <p>Other changes to the frame involve the handle. Players have individual preferences for the shape of the handle and some will have the handle of one racket moulded onto the frame of a different racket. Other players make different changes. The professional Portuguese player Gonçalo Oliveira replaced the original grips of his rackets with something thinner because they had previously felt uncomfortable to hold.</p>

                    <p>Racket customisation and modification have pushed the standards of the game to greater levels that few could have anticipated in the days of natural strings and heavy, wooden frames, and it's exciting to see what further developments there will be in the future.</p>
                </div>

                {{-- Passage 2 --}}
                <div class="mb-6 mt-16 pt-16 border-t-2 border-gray-300">
                    <h2 class="text-xl font-bold mb-4 tracking-wider uppercase">READING PASSAGE 2</h2>
                    <p class="italic mb-8">You should spend about 20 minutes on <span class="font-bold">Questions 14–26</span>, which are based on Reading Passage 2 below.</p>
                    
                    <h3 class="text-3xl font-bold text-center mb-8">The pirates of the ancient Mediterranean</h3>
                    <p class="text-center italic text-gray-700 text-lg mb-8 max-w-2xl mx-auto">
                        In the first and second millennia BCE, pirates sailed around the Mediterranean, attacking ships and avoiding pursuers
                    </p>

                    <div class="space-y-6 text-gray-800 text-lg leading-relaxed text-justify font-serif">
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">A</span>
                            <p>When one mentions pirates, an image springs to most people’s minds of a crew of misfits, daredevils and adventurers in command of a tall sailing ship in the Caribbean Sea. Yet from the first to the third millennium BCE, thousands of years before these swashbucklers began spreading fear across the Caribbean, pirates prowled the Mediterranean, raiding merchant ships and threatening vital trade routes. However, despite all efforts and the might of various ancient states, piracy could not be stopped. The situation remained unchanged for thousands of years. Only when the pirates directly threatened the interests of ancient Rome did the Roman Republic organise a massive fleet to eliminate piracy. Under the command of the Roman general Pompey, Rome eradicated piracy, transforming the Mediterranean into <em>‘Mare Nostrum’</em> (Our Sea).</p>
                        </div>

                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">B</span>
                            <p>Although piracy in the Mediterranean is first recorded in ancient Egypt during the reign of Pharaoh Amenhotep III (c 1390-1353 BCE), it is reasonable to assume it predated this powerful civilisation. This is partly due to the great importance the Mediterranean held at this time, and partly due to its geography. While the Mediterranean region is predominantly fertile, some parts are rugged and hilly, even mountainous. In the ancient times, the inhabitants of these areas relied heavily on marine resources, including fish and salt. Most had their own boats, possessed good seafaring skills, and unsurpassed knowledge of the local coastline and sailing routes. Thus, it is not surprising that during hardships, these men turned to piracy. Geography itself further benefited the pirates, with the numerous coves along the coast providing places for them to hide their boats and strike undetected. Before the invention of ocean-going caravels* in the 15th century, ships could not easily cross long distances over open water. Thus, in the ancient world most were restricted to a few well-known navigable routes that followed the coastline. Caught in a trap, a slow merchant ship laden with goods had no other option but to surrender. In addition, knowledge of the local area helped the pirates to avoid retaliation once a state fleet arrived.</p>
                        </div>

                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">C</span>
                            <p>One should also add that it was not unknown in the first and second millennia BCE for governments to resort to pirates’ services, especially during wartime, employing their skills and numbers against their opponents. A pirate fleet would serve in the first wave of attack, preparing the way for the navy. Some of the regions were known for providing safe harbours to pirates, who, in return, boosted the local economy.</p>
                        </div>

                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">D</span>
                            <p>The first known record of a named group of Mediterranean pirates, made during the rule of ancient Egyptian Pharaoh Akhenaten (c 1353-1336 BCE), was in the Amarna Letters. These were extracts of diplomatic correspondence between the pharaoh and his allies, and covered many pressing issues, including piracy. It seems the pharaoh was troubled by two distinct pirate groups, the Lukka and the Sherden. Despite the Egyptian fleet’s best efforts, the pirates continued to cause substantial disruption to regional commerce. In the letters, the king of Alashiya (modern Cyprus) rejected Akhenaten’s claims of a connection with the Lukka (based in modern-day Turkey). The king assured Akhenaten he was prepared to punish any of his subjects involved in piracy.</p>
                        </div>

                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">E</span>
                            <p>The ancient Greek world’s experience of piracy was different from that of Egyptian rulers. While Egypt’s power was land-based, the ancient Greeks relied on the Mediterranean in almost all aspects of life, from trade to warfare. Interestingly, in his works the <em>Iliad</em> and the <em>Odyssey</em>, the ancient Greek writer Homer not only condones, but praises the lifestyle and actions of pirates. The opinion remained unchanged in the following centuries. The ancient Greek historian Thucydides, for instance, glorified pirates’ daring attacks on ships or even cities. For Greeks, piracy was a part of everyday life. Even high-ranking members of the state were not beyond engaging in such activities. According to the Greek orator Demosthenes, in 355 BCE, Athenian ambassadors made a detour from their official travel to capture a ship sailing from Egypt, taking the wealth found onboard for themselves! The Greeks’ liberal approach towards piracy does not mean they always tolerated it, but attempts to curtail piracy were hampered by the large number of pirates operating in the Mediterranean.</p>
                        </div>

                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">F</span>
                            <p>The rising power of ancient Rome required the Roman Republic to deal with piracy in the Mediterranean. While piracy was a serious issue for the Republic, Rome profited greatly from its existence. Pirate raids provided a steady source of slaves, essential for Rome’s agriculture and mining industries. But this arrangement could work only while the pirates left Roman interests alone. Pirate attacks on grain ships, which were essential to Roman citizens, led to angry voices in the Senate, demanding punishment of the culprits. Rome, however, did nothing, further encouraging piracy. By the 1st century BCE, emboldened pirates kidnapped prominent Roman dignitaries, asking for a large ransom to be paid. Their most famous hostage was none other than Julius Caesar, captured in 75 BCE.</p>
                        </div>

                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">G</span>
                            <p>By now, Rome was well aware that pirates had outlived their usefulness. The time had come for concerted action. In 67 BCE, a new law granted Pompey vast funds to combat the Mediterranean menace. Taking personal command, Pompey divided the entire Mediterranean into 13 districts, assigning a fleet and commander to each. After cleansing one district of pirates, the fleet would join another in the next district. The process continued until the entire Mediterranean was free of pirates. Although thousands of pirates died at the hands of Pompey’s troops, as a long-term solution to the problem, many more were offered land in fertile areas located far from the sea. Instead of a maritime menace, Rome got productive farmers that further boosted its economy.</p>
                        </div>

                        <p class="text-sm text-gray-500 mt-8 pt-4 border-t border-gray-200">* caravel: a small, highly manoeuvrable sailing ship developed by the Portuguese</p>
                    </div>
                </div>

                {{-- Passage 3 --}}
                <div class="mb-6 mt-16 pt-16 border-t-2 border-gray-300">
                    <h2 class="text-xl font-bold mb-4 tracking-wider uppercase">READING PASSAGE 3</h2>
                    <p class="italic mb-8">You should spend about 20 minutes on <span class="font-bold">Questions 27–40</span>, which are based on Reading Passage 3 below.</p>
                    
                    <h3 class="text-3xl font-bold text-center mb-8">The persistence and peril of misinformation</h3>
                    <p class="text-center italic text-gray-700 text-lg mb-8 max-w-2xl mx-auto">
                        Brian Southwell looks at how human brains verify information and discusses some of the challenges of battling widespread falsehoods
                    </p>

                    <div class="space-y-6 text-gray-800 text-lg leading-relaxed text-justify font-serif">
                        <p>Misinformation &ndash; both deliberately promoted and accidentally shared &ndash; is perhaps an inevitable part of the world in which we live, but it is not a new problem. People likely have lied to one another for roughly as long as verbal communication has existed. Deceiving others can offer an apparent opportunity to gain strategic advantage, to motivate others to action, or even to protect interpersonal bonds. Moreover, people inadvertently have been sharing inaccurate information with one another for thousands of years.</p>

                        <p>However, we currently live in an era in which technology enables information to reach large audiences distributed across the globe, and thus the potential for immediate and widespread effects from misinformation now looms larger than in the past. Yet the means to correct misinformation might, over time, be found in those same patterns of mass communication and of the facilitated spread of information.</p>

                        <p>The main worry regarding misinformation is its potential to unduly influence attitudes and behavior, leading people to think and act differently than they would if they were correctly informed, as suggested by the research teams of Stephan Lewandowsky of the University of Bristol and Elizabeth Marsh of Duke University, among others. In other words, we worry that misinformation might lead people to hold misperceptions (or false beliefs) and that these misperceptions, especially when they occur among large groups of people, may have detrimental, downstream consequences for health, social harmony, and the political climate.</p>

                        <p>At least three observations related to misinformation in the contemporary mass-media environment warrant the attention of researchers, policy makers, and really everyone who watches television, listens to the radio, or reads information online. First of all, people who encounter misinformation tend to believe it, at least initially. Secondly, electronic and print media often do not block many types of misinformation before it appears in content available to large audiences. Thirdly, countering misinformation once it has enjoyed wide exposure can be a resource-intensive effort.</p>

                        <p>Knowing what happens when people initially encounter misinformation holds tremendous importance for estimating the potential for subsequent problems. Although it is fairly routine for individuals to come across information that is false, the question of exactly how &ndash; and when &ndash; we mentally label information as true or false has garnered philosophical debate. The dilemma is neatly summarized by a contrast between how the 17th-century philosophers René Descartes and Baruch Spinoza described human information engagement, with conflicting predictions that only recently have been empirically tested in robust ways. Descartes argued that a person only accepts or rejects information after considering its truth or falsehood; Spinoza argued that people accept all encountered information (or misinformation) by default and then subsequently verify or reject it through a separate cognitive process. In recent decades, empirical evidence from the research teams of Erik Asp of the University of Chicago and Daniel Gilbert at Harvard University, among others, has supported Spinoza’s account: people appear to encode all new information as if it were true, even if only momentarily, and later tag the information as being either true or false, a pattern that seems consistent with the observation that mental resources for skepticism physically reside in a different part of the brain than the resources used in perceiving and encoding.</p>

                        <p>What about our second observation that misinformation often can appear in electronic or print media without being preemptively blocked? In support of this, one might consider the nature of regulatory structures in the United States: regulatory agencies here tend to focus on post hoc detection of broadcast information. Organizations such as the Food and Drug Administration (FDA) offer considerable monitoring and notification functions, but these roles typically do not involve preemptive censoring. The FDA oversees direct-to-consumer prescription drug advertising, for example, and has developed mechanisms such as the ‘Bad Ad’ program, through which people can report advertising in apparent violation of FDA guidelines on drug risks. Such programs, although laudable and useful, do not keep false advertising off the airwaves. In addition, even misinformation that is successfully corrected can continue to affect attitudes.</p>

                        <p>This leads us to our third observation: a campaign to correct misinformation, even if rhetorically compelling, requires resources and planning to accomplish necessary reach and frequency. For corrective campaigns to be persuasive, audiences need to be able to comprehend them, which requires either effort to frame messages in ways that are accessible or effort to educate and sensitize audiences to the possibility of misinformation. That some audiences might be unaware of the potential for misinformation also suggests the utility of media literacy efforts as early as elementary school. Even with journalists and scholars pointing to the phenomenon of ‘fake news’, people do not distinguish between demonstrably false stories and those based in fact when scanning and processing written information.</p>

                        <p>We live at a time when widespread misinformation is common. Yet at this time many people also are passionately developing potential solutions and remedies. The journey forward undoubtedly will be a long and arduous one. Future remedies will require not only continued theoretical consideration but also the development and maintenance of consistent monitoring tools &ndash; and a recognition among fellow members of society that claims which find prominence in the media that are insufficiently based in scientific consensus and social reality should be countered. Misinformation arises as a result of human fallibility and human information needs. To overcome the worst effects of the phenomenon, we will need coordinated efforts over time, rather than any singular one-time panacea we could hope to offer.</p>
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
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 1?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 1–7 on your answer sheet, write</p>

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
                                    1 => 'People had expected Andy Murray to become the world\'s top tennis player for at least five years before 2016.',
                                    2 => 'The change that Andy Murray made to his rackets attracted a lot of attention.',
                                    3 => 'Most of the world\'s top players take a professional racket stringer on tour with them.',
                                    4 => 'Mike and Bob Bryan use rackets that are light in comparison to the majority of rackets.',
                                    5 => 'Werner Fischer played with a spaghetti-strung racket that he designed himself.',
                                    6 => 'The weather can affect how professional players adjust the strings on their rackets.',
                                    7 => 'It was believed that the change Pete Sampras made to his rackets contributed to his strong serve.'
                                ] as $qNum => $statement)
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $qNum }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select x-model="answers.q{{ $qNum }}" name="q{{ $qNum }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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

                {{-- Questions 8–13: Note Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 8–13</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <span class="font-bold uppercase">ONE WORD ONLY</span> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 8–13 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-4">The tennis racket and how it has changed</h4>
                        <ul class="list-disc ml-5 space-y-4 mb-4">
                            <li class="text-gray-800 leading-relaxed">
                                Mike and Bob Bryan made changes to the types of <span class="font-bold">8</span>
                                <input type="text" x-model="answers.q8" name="q8" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                used on their racket frames.
                            </li>
                            <li class="text-gray-800 leading-relaxed">
                                Players were not allowed to use the spaghetti-strung racket because of the amount of <span class="font-bold">9</span>
                                <input type="text" x-model="answers.q9" name="q9" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                it created.
                            </li>
                            <li class="text-gray-800 leading-relaxed">
                                Changes to rackets can be regarded as being as important as players' diets or the <span class="font-bold">10</span>
                                <input type="text" x-model="answers.q10" name="q10" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                they do.
                            </li>
                            <li class="text-gray-800 leading-relaxed">
                                All rackets used to have natural strings made from the <span class="font-bold">11</span>
                                <input type="text" x-model="answers.q11" name="q11" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                of animals.
                            </li>
                            <li class="text-gray-800 leading-relaxed">
                                Pete Sampras had metal <span class="font-bold">12</span>
                                <input type="text" x-model="answers.q12" name="q12" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                put into the frames of his rackets.
                            </li>
                            <li class="text-gray-800 leading-relaxed">
                                Gonçalo Oliveira changed the <span class="font-bold">13</span>
                                <input type="text" x-model="answers.q13" name="q13" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                on his racket handles.
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- ── PASSAGE 2 Questions ── --}}
                <div class="mt-8 mb-4">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Questions 14-19: Matching Headings/Paragraphs --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–19</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 2 has seven paragraphs, <strong>A–G</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Which paragraph contains the following information?</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct letter, <strong>A–G</strong>, in boxes 14–19 on your answer sheet.</p>
                    <p class="mb-5 font-bold uppercase italic text-sm text-gray-700">NB You may use any letter more than once.</p>

                    <div class="overflow-x-auto mt-2">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-32 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    14 => 'a reference to a denial of involvement in piracy',
                                    15 => 'details of how a campaign to eradicate piracy was carried out',
                                    16 => 'a mention of the circumstances in which states in the ancient world would make use of pirates',
                                    17 => 'a reference to how people today commonly view pirates',
                                    18 => 'an explanation of how some people were encouraged not to return to piracy',
                                    19 => 'a mention of the need for many sailing vessels to stay relatively close to land'
                                ] as $qNum => $statement)
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $qNum }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select x-model="answers.q{{ $qNum }}" name="q{{ $qNum }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                @foreach(['A','B','C','D','E','F','G'] as $opt)
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

                {{-- Questions 20 and 21: Choose TWO --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6" x-init="answers.q20_21 = answers.q20_21 || []">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 20 and 21</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct letters in boxes 20 and 21 on your answer sheet.</p>
                    <p class="text-sm text-gray-800 mb-4">Which <strong>TWO</strong> of the following statements does the writer make about inhabitants of the Mediterranean region in the ancient world?</p>

                    <div class="space-y-3">
                        @foreach([
                            'A' => 'They often used stolen vessels to carry out pirate attacks.',
                            'B' => 'They managed to escape capture by the authorities because they knew the area so well.',
                            'C' => 'They paid for information about the routes merchant ships would take.',
                            'D' => 'They depended more on the sea for their livelihood than on farming.',
                            'E' => 'They stored many of the goods taken in pirate attacks in coves along the coastline.'
                        ] as $letter => $optionText)
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="answers.q20_21" value="{{ $letter }}" 
                                   class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none"
                                   @change="if (answers.q20_21.length > 2) answers.q20_21.shift()">
                            <span class="text-sm text-gray-800 group-hover:text-blue-700 transition-colors">
                                <strong>{{ $letter }}</strong>&nbsp; {{ $optionText }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Questions 22 and 23: Choose TWO --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6" x-init="answers.q22_23 = answers.q22_23 || []">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 22 and 23</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct letters in boxes 22 and 23 on your answer sheet.</p>
                    <p class="text-sm text-gray-800 mb-4">Which <strong>TWO</strong> of the following statements does the writer make about piracy and ancient Greece?</p>

                    <div class="space-y-3">
                        @foreach([
                            'A' => 'The state estimated that very few people were involved in piracy.',
                            'B' => 'Attitudes towards piracy changed shortly after the Iliad and the Odyssey were written.',
                            'C' => 'Important officials were known to occasionally take part in piracy.',
                            'D' => 'Every citizen regarded pirate attacks on cities as unacceptable.',
                            'E' => 'A favourable view of piracy is evident in certain ancient Greek texts.'
                        ] as $letter => $optionText)
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="answers.q22_23" value="{{ $letter }}" 
                                   class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none"
                                   @change="if (answers.q22_23.length > 2) answers.q22_23.shift()">
                            <span class="text-sm text-gray-800 group-hover:text-blue-700 transition-colors">
                                <strong>{{ $letter }}</strong>&nbsp; {{ $optionText }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Questions 24–26: Summary completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 24–26</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 24–26 on your answer sheet.</p>

                    <div class="border border-gray-300 p-5 rounded-lg bg-gray-50 text-sm mb-5">
                        <h4 class="text-base font-bold text-center mb-4">Ancient Rome and piracy</h4>
                        <p class="text-gray-800 leading-loose mb-2">
                            Piracy was an issue ancient Rome had to deal with, but it also brought some benefits for Rome. For example, pirates supplied slaves that were important for Rome's industries. However, attacks on vessels transporting 
                            <span class="font-bold">24</span>
                            <input type="text" x-model="answers.q24" name="q24" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            to Rome resulted in calls for 
                            <span class="font-bold">25</span>
                            <input type="text" x-model="answers.q25" name="q25" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            for the pirates responsible. Nevertheless, piracy continued, with some pirates demanding a 
                            <span class="font-bold">26</span>
                            <input type="text" x-model="answers.q26" name="q26" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            for the return of the Roman officials they captured.
                        </p>
                    </div>
                </div>

                {{-- ── PASSAGE 3 Questions ── --}}
                <div class="mt-8 mb-4">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>

                {{-- Questions 27-30: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–30</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 27–30 on your answer sheet.</p>

                    <div class="space-y-6">
                        @foreach([
                            [27, 'What point does the writer make about misinformation in the first paragraph?', [
                                'A' => 'Misinformation is a relatively recent phenomenon.',
                                'B' => 'Some people find it easy to identify misinformation.',
                                'C' => 'Misinformation changes as it is passed from one person to another.',
                                'D' => 'There may be a number of reasons for the spread of misinformation.',
                            ]],
                            [28, 'What does the writer say about the role of technology?', [
                                'A' => 'It may at some point provide us with a solution to misinformation.',
                                'B' => 'It could fundamentally alter the way in which people regard information.',
                                'C' => 'It has changed the way in which organisations use misinformation.',
                                'D' => 'It has made it easier for people to check whether information is accurate.',
                            ]],
                            [29, 'What is the writer doing in the fourth paragraph?', [
                                'A' => 'comparing the different opinions people have of misinformation',
                                'B' => 'explaining how the effects of misinformation have changed over time',
                                'C' => 'outlining which issues connected with misinformation are significant today',
                                'D' => 'describing the attitude of policy makers towards misinformation in the media',
                            ]],
                            [30, 'What point does the writer make about regulation in the USA?', [
                                'A' => 'The guidelines issued by the FDA need to be simplified.',
                                'B' => 'Regulation does not affect people\'s opinions of new prescription drugs.',
                                'C' => 'The USA has more regulatory bodies than most other countries.',
                                'D' => 'Regulation fails to prevent misinformation from appearing in the media.',
                            ]],
                        ] as [$num, $question, $opts])
                        <div>
                            <p class="text-sm font-semibold text-gray-800 mb-2"><span class="text-blue-600 font-bold mr-1">{{ $num }}</span> {{ $question }}</p>
                            <div class="space-y-2 ml-4">
                                @foreach($opts as $letter => $text)
                                <label class="flex items-start gap-4 cursor-pointer group">
                                    <input type="radio" x-model="answers.q{{ $num }}" name="q{{ $num }}" value="{{ $letter }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer flex-none">
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

                {{-- Questions 31-36: Summary completion with options --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 31–36</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Complete the summary using the list of phrases, <strong>A–J</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–J</strong>, in boxes 31–36 on your answer sheet.</p>

                    <div class="border border-gray-300 p-5 rounded-lg bg-gray-50 text-sm mb-5">
                        <h4 class="text-base font-bold text-center mb-4">What happens when people encounter misinformation?</h4>
                        <p class="text-gray-800 leading-loose mb-2">
                            Although people have 
                            <strong>31</strong>
                            <select x-model="answers.q31" name="q31" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            to misinformation, there is debate about precisely how and when we label something as true or untrue. The philosophers Descartes and Spinoza had 
                            <strong>32</strong>
                            <select x-model="answers.q32" name="q32" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            about how people engage with information. While Descartes believed that people accept or reject information after considering whether it is true or not, Spinoza argued that people accepted <em>all</em> information they encountered (and by default misinformation) and did not verify or reject it until afterwards. Moreover, Spinoza believed that a distinct 
                            <strong>33</strong>
                            <select x-model="answers.q33" name="q33" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            is involved in these stages. Recent research has provided
                            <strong>34</strong>
                            <select x-model="answers.q34" name="q34" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            for Spinoza's theory and it would appear that people accept all encountered information as if it were true, even if this is for an extremely 
                            <strong>35</strong>
                            <select x-model="answers.q35" name="q35" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            , and do not label the information as true or false until later. This is consistent with the fact that the resources for scepticism and the resources for perceiving and encoding are in 
                            <strong>36</strong>
                            <select x-model="answers.q36" name="q36" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            in the brain.
                        </p>
                    </div>

                    {{-- Word bank --}}
                    <div class="border border-gray-400 p-5 bg-white text-sm mx-auto w-full mb-2">
                        <div class="grid gap-x-6 gap-y-3" style="grid-template-columns: repeat(3, minmax(0, 1fr));">
                            @foreach([
                                'A' => 'constant conflict', 'B' => 'additional evidence', 'C' => 'different locations',
                                'D' => 'experimental subjects', 'E' => 'short period', 'F' => 'extreme distrust',
                                'G' => 'frequent exposure', 'H' => 'mental operation', 'I' => 'dubious reason',
                                'J' => 'different ideas'
                            ] as $l => $w)
                            <div class="flex gap-4"><span class="font-bold text-gray-900 w-4">{{ $l }}</span> <span class="text-gray-800">{{ $w }}</span></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Questions 37-40: YES/NO/NOT GIVEN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 37–40</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the claims of the writer in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 37–40 on your answer sheet, write</p>

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
                                    37 => 'Campaigns designed to correct misinformation will fail to achieve their purpose if people are unable to understand them.',
                                    38 => 'Attempts to teach elementary school students about misinformation have been opposed.',
                                    39 => 'It may be possible to overcome the problem of misinformation in a relatively short period.',
                                    40 => 'The need to keep up with new information is hugely exaggerated in today\'s world.'
                                ] as $qNum => $statement)
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $qNum }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select x-model="answers.q{{ $qNum }}" name="q{{ $qNum }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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

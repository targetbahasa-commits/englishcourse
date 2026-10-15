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

        @media (min-width: 768px) {
            body.has-admin-sidebar .reading-fixed-shell {
                left: 16rem;
            }
            body.has-admin-sidebar.sidebar-collapsed .reading-fixed-shell {
                left: 3.5rem;
            }
            body.has-student-sidebar .reading-fixed-shell,
            body.has-teacher-sidebar .reading-fixed-shell {
                left: 16rem;
            }
            body.has-student-sidebar.sidebar-collapsed .reading-fixed-shell,
            body.has-teacher-sidebar.sidebar-collapsed .reading-fixed-shell {
                left: 4rem;
            }
            .reading-fixed-shell {
                left: var(--admin-sidebar-offset, var(--teacher-sidebar-offset, var(--student-sidebar-offset, var(--guest-sidebar-offset, 0px))));
                transition: left .2s ease;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-white">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')


<div class="fixed inset-0 z-0 flex flex-col reading-fixed-shell">

    
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

    
    <div class="flex-1 min-h-0 grid overflow-hidden" style="grid-template-columns: 2.5fr 2fr;">

        
        {{-- LEFT: Reading Passage --}}
        <div class="h-full overflow-y-auto bg-gray-50 border-r border-gray-200 custom-scrollbar relative" id="passage-pane">

            <div class="px-4 sm:px-6 md:px-8 py-8 pb-32 w-full relative">

                {{-- READING header --}}
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest shadow-sm">READING</span>
                </div>

                {{-- Passage 1 --}}
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
                    {{-- Drawing canvas for Passage 1 --}}
                    <canvas x-ref="drawingCanvas"
                            class="absolute inset-0 w-full h-full z-10 rounded-2xl"
                            :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'">
                    </canvas>

                    <div class="relative z-20" :class="pencilMode ? 'pointer-events-none' : ''">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                            <span class="bg-pink-50 text-pink-600 font-bold px-3 py-1 rounded-lg text-sm tracking-wide uppercase">READING PASSAGE 1</span>
                        </div>
                        <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong>, which are based on Reading Passage 1 below.</p>

                        <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">The White Horse of Uffington</h3>

                        <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif] pb-6"
                             @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                             @click="if(eraserMode) window.removeHighlight($event);">

                            <div class="flex justify-center mb-8">
                                <img src="{{ asset('images/tests/uffington_white_horse.png') }}" alt="The Uffington White Horse" class="w-full max-w-sm rounded-xl shadow-md border border-gray-200 object-cover">
                            </div>
                            <p>The cutting of huge figures or ‘geoglyphs’ into the earth of English hillsides has taken place for more than 3,000 years. There are 56 hill figures scattered around England, with the vast majority on the chalk downlands of the country’s southern counties. The figures include giants, horses, crosses and regimental badges. Although the majority of these geoglyphs date within the last 300 years or so, there are one or two that are much older.</p>
                            <p>The most famous of these figures is perhaps also the most mysterious – the Uffington White Horse in Oxfordshire. The White Horse has recently been re-dated and shown to be even older than its previously assigned ancient pre-Roman Iron Age* date. More controversial is the date of the enigmatic Long Man of Wilmington in Sussex. While many historians are convinced the figure is prehistoric, others believe that it was the work of an artistic monk from a nearby priory and was created between the 11th and 15th centuries.</p>
                            <p>The method of cutting these huge figures was simply to remove the overlying grass to reveal the gleaming white chalk below. However, the grass would soon grow over the geoglyph again unless it was regularly cleaned or scoured by a fairly large team of people. One reason that the vast majority of hill figures have disappeared is that when the traditions associated with the figures faded, people no longer bothered or remembered to clear away the grass to expose the chalk outline. Furthermore, over hundreds of years the outlines would sometimes change due to people not always cutting in exactly the same place, thus creating a different shape to the original geoglyph. The fact that any ancient hill figures survive at all in England today is testament to the strength and continuity of local customs and beliefs which, in one case at least, must stretch back over millennia.</p>
                            <p class="text-xs text-gray-500 mt-2 border-t pt-2">*Iron Age: a period (in Britain 800 BCE – 43 CE) that is characterised by the use of iron tools</p>
                            <p>The Uffington White Horse is a unique, stylised representation of a horse consisting of a long, sleek back, thin disjointed legs, a streaming tail, and a bird-like beaked head. The elegant creature almost melts into the landscape. The horse is situated 2.5 km from Uffington village on a steep slope close to the Late Bronze Age* (c. 7th century BCE) hillfort of Uffington Castle and below the Ridgeway, a long-distance Neolithic** track.</p>
                            <p>The Uffington Horse is also surrounded by Bronze Age burial mounds. It is not far from the Bronze Age cemetery of Lambourn Seven Barrows, which consists of more than 30 well-preserved burial mounds. The carving has been placed in such a way as to make it extremely difficult to see from close quarters, and like many geoglyphs is best appreciated from the air. Nevertheless, there are certain areas of the Vale of the White Horse, the valley containing and named after the enigmatic creature, from which an adequate impression may be gained. Indeed on a clear day the carving can be seen from up to 30 km away.</p>
                            <p>The earliest evidence of a horse at Uffington is from the 1070s CE when ‘White Horse Hill’ is mentioned in documents from the nearby Abbey of Abingdon, and the first reference to the horse itself is soon after, in 1190 CE. However, the carving is believed to date back much further than that. Due to the similarity of the Uffington White Horse to the stylised depictions of horses on 1st century BCE coins, it had been thought that the creature must also date to that period.</p>
                            <p>However, in 1995 Optically Stimulated Luminescence (OSL) testing was carried out by the Oxford Archaeological Unit on soil from two of the lower layers of the horse’s body, and from another cut near the base. The result was a date for the horse’s construction somewhere between 1400 and 600 BCE – in other words, it had a Late Bronze Age or Early Iron Age origin.</p>
                            <p>The latter end of this date range would tie the carving of the horse in with occupation of the nearby Uffington hillfort, indicating that it may represent a tribal emblem marking the land of the inhabitants of the hillfort. Alternatively, the carving may have been carried out during a Bronze or Iron Age ritual. Some researchers see the horse as representing the Celtic*** horse goddess Epona, who was worshipped as a protector of horses, and for her associations with fertility. However, the cult of Epona was not imported from Gaul (France) until around the first century CE. This date is at least six centuries after the Uffington Horse was probably carved. Nevertheless, the horse had great ritual and economic significance during the Bronze and Iron Ages, as attested by its depictions on jewellery and other metal objects. It is possible that the carving represents a goddess in native mythology, such as Rhiannon, described in later Welsh mythology as a beautiful woman dressed in gold and riding a white horse.</p>
                            <p>The fact that geoglyphs can disappear easily, along with their associated rituals and meaning, indicates that they were never intended to be anything more than temporary gestures. But this does not lessen their importance. These giant carvings are a fascinating glimpse into the minds of their creators and how they viewed the landscape in which they lived.</p>
                        </div>

                        {{-- Floating Toolbar for Passage 1 --}}
                        @include('assignments.ielts.mockup.partials.reading-toolbar')
                    </div>
                </div>

                {{-- Passage 2 --}}
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
                    {{-- Drawing canvas for Passage 2 --}}
                    <canvas x-ref="drawingCanvas"
                            class="absolute inset-0 w-full h-full z-10 rounded-2xl"
                            :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'">
                    </canvas>

                    <div class="relative z-20" :class="pencilMode ? 'pointer-events-none' : ''">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                            <span class="bg-pink-50 text-pink-600 font-bold px-3 py-1 rounded-lg text-sm tracking-wide uppercase">READING PASSAGE 2</span>
                        </div>
                        <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 below.</p>

                        <h3 class="text-2xl font-bold text-center text-gray-900 mb-2">I contain multitudes</h3>
                        <p class="text-center italic text-gray-700 mb-8">Wendy Moore reviews Ed Yong's book about microbes</p>

                        <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif] pb-6"
                             @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                             @click="if(eraserMode) window.removeHighlight($event);">
                            <p>Microbes, most of them bacteria, have populated this planet since long before animal life developed and they will outlive us. Invisible to the naked eye, they are ubiquitous. They inhabit the soil, air, rocks and water and are present within every form of life, from seaweed and coral to dogs and humans. And, as Yong explains in his utterly absorbing and hugely important book, we mess with them at our peril.</p>
                            <p>Every species has its own colony of microbes, called a 'microbiome', and these microbes vary not only between species but also between individuals and within different parts of each individual. What is amazing is that while the number of human cells in the average person is about 30 trillion, the number of microbial ones is higher &ndash; about 39 trillion. At best, Yong informs us, we are only 50 per cent human. Indeed, some scientists even suggest we should think of each species and its microbes as a single unit, dubbed a 'holobiont'.</p>
                            <p>In each human there are microbes that live only in the stomach, the mouth or the armpit and by and large they do so peacefully. So 'bad' microbes are just microbes out of context. Microbes that sit contentedly in the human gut (where there are more microbes than there are stars in the galaxy) can become deadly if they find their way into the bloodstream. These communities are constantly changing too. The right hand shares just one sixth of its microbes with the left hand. And, of course, we are surrounded by microbes. Every time we eat, we swallow a million microbes in each gram of food; we are continually swapping microbes with other humans, pets and the world at large.</p>
                            <p>It's a fascinating topic and Yong, a young British science journalist, is an extraordinarily adept guide. Writing with lightness and panache, he has a knack of explaining complex science in terms that are both easy to understand and totally enthralling. Yong is on a mission. Leading us gently by the hand, he takes us into the world of microbes &ndash; a bizarre, alien planet &ndash; in a bid to persuade us to love them as much as he does. By the end, we do.</p>
                            <p>For most of human history we had no idea that microbes existed. The first man to see these extraordinarily potent creatures was a Dutch lens-maker called Antony van Leeuwenhoek in the 1670s. Using microscopes of his own design that could magnify up to 270 times, he examined a drop of water from a nearby lake and found it teeming with tiny creatures he called 'animalcules'. It wasn't until nearly two hundred years later that the research of French biologist Louis Pasteur indicated that some microbes caused disease. It was Pasteur's 'germ theory' that gave bacteria the poor image that endures today.</p>
                            <p>Yong's book is in many ways a plea for microbial tolerance, pointing out that while fewer than one hundred species of bacteria bring disease, many thousands more play a vital role in maintaining our health. The book also acknowledges that our attitude towards bacteria is not a simple one. We tend to see the dangers posed by bacteria, yet at the same time we are sold yoghurts and drinks that supposedly nurture 'friendly' bacteria. In reality, says Yong, bacteria should not be viewed as either friends or foes, villains or heroes. Instead we should realise we have a symbiotic relationship, that can be mutually beneficial or mutually destructive.</p>
                            <p>What then do these millions of organisms do? The answer is pretty much everything. New research is now unravelling the ways in which bacteria aid digestion, regulate our immune systems, eliminate toxins, produce vitamins, affect our behaviour and even combat obesity. 'They actually help us become who we are,' says Yong. But we are facing a growing problem. Our obsession with hygiene, our overuse of antibiotics and our unhealthy, low-fibre diets are disrupting the bacterial balance and may be responsible for soaring rates of allergies and immune problems, such as inflammatory bowel disease (IBD).</p>
                            <p>The most recent research actually turns accepted norms upside down. For example, there are studies indicating that the excessive use of household detergents and antibacterial products actually destroys the microbes that normally keep the more dangerous germs at bay. Other studies show that keeping a dog as a pet gives children early exposure to a diverse range of bacteria, which may help protect them against allergies later.</p>
                            <p>The readers of Yong's book must be prepared for a decidedly unglamorous world. Among the less appealing case studies is one about a fungus that is wiping out entire populations of frogs and that can be halted by a rare microbial bacterium. Another is about squid that carry luminescent bacteria that protect them against predators. However, if you can overcome your distaste for some of the investigations, the reasons for Yong's enthusiasm become clear. The microbial world is a place of wonder. Already, in an attempt to stop mosquitoes spreading dengue fever &ndash; a disease that infects 400 million people a year &ndash; mosquitoes are being loaded with a bacterium to block the disease. In the future, our ability to manipulate microbes means we could construct buildings with useful microbes built into their walls to fight off infections. Just imagine a neonatal hospital ward coated in a specially mixed cocktail of microbes so that babies get the best start in life.</p>
                        </div>

                        {{-- Floating Toolbar for Passage 2 --}}
                        @include('assignments.ielts.mockup.partials.reading-toolbar')
                    </div>
                </div>

                {{-- Passage 3 --}}
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
                    {{-- Drawing canvas for Passage 3 --}}
                    <canvas x-ref="drawingCanvas"
                            class="absolute inset-0 w-full h-full z-10 rounded-2xl"
                            :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'">
                    </canvas>

                    <div class="relative z-20" :class="pencilMode ? 'pointer-events-none' : ''">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                            <span class="bg-pink-50 text-pink-600 font-bold px-3 py-1 rounded-lg text-sm tracking-wide uppercase">READING PASSAGE 3</span>
                        </div>
                        <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                        <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">How to make wise decisions</h3>

                        <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif] pb-6"
                             @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                             @click="if(eraserMode) window.removeHighlight($event);">
                            <p>Across cultures, wisdom has been considered one of the most revered human qualities. Although the truly wise may seem few and far between, empirical research examining wisdom suggests that it isn’t an exceptional trait possessed by a small handful of bearded philosophers after all – in fact, the latest studies suggest that most of us have the ability to make wise decisions, given the right context.</p>
                            <p>‘It appears that experiential, situational, and cultural factors are even more powerful in shaping wisdom than previously imagined,’ says Associate Professor Igor Grossmann of the University of Waterloo in Ontario, Canada. ‘Recent empirical findings from cognitive, developmental, social, and personality psychology cumulatively suggest that people’s ability to reason wisely varies dramatically across experiential and situational contexts. Understanding the role of such contextual factors offers unique insights into understanding wisdom in daily life, as well as how it can be enhanced and taught.’</p>
                            <p>It seems that it’s not so much that some people simply possess wisdom and others lack it, but that our ability to reason wisely depends on a variety of external factors. ‘It is impossible to characterize thought processes attributed to wisdom without considering the role of contextual factors,’ explains Grossmann. ‘In other words, wisdom is not solely an “inner quality” but rather unfolds as a function of situations people happen to be in. Some situations are more likely to promote wisdom than others.’</p>
                            <p>Coming up with a definition of wisdom is challenging, but Grossmann and his colleagues have identified four key characteristics as part of a framework of wise reasoning. One is intellectual humility or recognition of the limits of our own knowledge, and another is appreciation of perspectives wider than the issue at hand. Sensitivity to the possibility of change in social relations is also key, along with compromise or integration of different attitudes and beliefs.</p>
                            <p>Grossmann and his colleagues have also found that one of the most reliable ways to support wisdom in our own day-to-day decisions is to look at scenarios from a third-party perspective, as though giving advice to a friend. Research suggests that when adopting a first-person viewpoint we focus on ‘the focal features of the environment’ and when we adopt a third-person, ‘observer’ viewpoint we reason more broadly and focus more on interpersonal and moral ideals such as justice and impartiality. Looking at problems from this more expansive viewpoint appears to foster cognitive processes related to wise decisions.</p>
                            <p>What are we to do, then, when confronted with situations like a disagreement with a spouse or negotiating a contract at work, that require us to take a personal stake? Grossmann argues that even when we aren’t able to change the situation, we can still evaluate these experiences from different perspectives.</p>
                            <p>For example, in one experiment that took place during the peak of a recent economic recession, graduating college seniors were asked to reflect on their job prospects. The students were instructed to imagine their career either ‘as if you were a distant observer’ or ‘before your own eyes as if you were right there’. Participants in the group assigned to the ‘distant observer’ role displayed more wisdom-related reasoning (intellectual humility and recognition of change) than did participants in the control group.</p>
                            <p>In another study, couples in long-term romantic relationships were instructed to visualize an unresolved relationship conflict either through the eyes of an outsider or from their own perspective. Participants then discussed the incident with their partner for 10 minutes, after which they wrote down their thoughts about it. Couples in the ‘other’s eyes’ condition were significantly more likely to rely on wise reasoning – recognizing others’ perspectives and searching for a compromise – compared to the couples in the egocentric condition.</p>
                            <p>‘Ego-decentering promotes greater focus on others and enables a bigger picture, conceptual view of the experience, affording recognition of intellectual humility and change,’ says Grossmann.</p>
                            <p>We might associate wisdom with intelligence or particular personality traits, but research shows only a small positive relationship between wise thinking and crystallized intelligence and the personality traits of openness and agreeableness. ‘It is remarkable how much people can vary in their wisdom from one situation to the next, and how much stronger such contextual effects are for understanding the relationship between wise judgment and its social and affective outcomes as compared to the generalized “traits”,’ Grossmann explains. ‘That is, knowing how wisely a person behaves in a given situation is more informative for understanding their emotions or likelihood to forgive [or] retaliate as compared to knowing whether the person may be wise “in general”.’</p>
                        </div>

                        {{-- Floating Toolbar for Passage 3 --}}
                        @include('assignments.ielts.mockup.partials.reading-toolbar')
                    </div>
                </div>

            </div>
        </div>

        {{-- RIGHT: Questions --}}
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar" id="questions-panel">
            <div class="px-4 sm:px-6 md:px-8 py-8 pb-24 w-full relative">

                {{-- ── SOAL UNTUK PASSAGE 1 ── --}}
                <div id="questions-passage-1" data-passage="1" class="mb-10">
                    <div onclick="document.getElementById('passage-1')?.scrollIntoView({behavior: 'smooth', block: 'start'})"
                         class="mb-6 flex items-center justify-between p-4 bg-gradient-to-r from-pink-50 via-rose-50/40 to-white rounded-2xl border border-pink-200/80 shadow-sm cursor-pointer hover:border-pink-300 hover:shadow-md transition select-none group"
                         title="Klik untuk melompat ke Reading Passage 1">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-pink-600 text-white flex items-center justify-center font-bold text-sm shadow-sm group-hover:scale-105 transition-transform">P1</span>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 leading-tight flex items-center gap-2">
                                    <span>Soal untuk Passage 1</span>
                                    <span class="text-xs font-normal text-gray-400 group-hover:text-pink-600 transition flex items-center gap-0.5">
                                        <svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        <span class="hidden sm:inline">Lihat Bacaan</span>
                                    </span>
                                </h3>
                                <p class="text-xs text-gray-500">Pertanyaan 1–13 berdasarkan Reading Passage 1</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-pink-100 text-pink-700 text-xs font-bold rounded-full border border-pink-200">Questions 1–13</span>
                    </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–8</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 1?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 1–8 on your answer sheet, write</p>

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
                                    [1, "Most geoglyphs in England are located in a particular area of the country."],
                                    [2, "There are more geoglyphs in the shape of a horse than any other creature."],
                                    [3, "A recent dating of the Uffington White Horse indicates that people were mistaken about its age."],
                                    [4, "Historians have come to an agreement about the origins of the Long Man of Wilmington."],
                                    [5, "Geoglyphs were created by people placing white chalk on the hillside."],
                                    [6, "Many geoglyphs in England are no longer visible."],
                                    [7, "The shape of some geoglyphs has been altered over time."],
                                    [8, "The fame of the Uffington White Horse is due to its size."],
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

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 9–13</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 9–13 on your answer sheet.</p>

                    <div class="border-2 border-gray-400 rounded-lg p-6 bg-white text-sm font-sans relative shadow-sm">
                        <h4 class="text-xl font-bold text-center mb-6">The Uffington White Horse</h4>
                        
                        <p class="font-bold text-gray-900 mb-3 text-base">The location of the Uffington White Horse:</p>
                        <ul class="list-disc ml-6 space-y-3 mb-6 text-gray-800 text-[15px]">
                            <li class="pl-2">a distance of 2.5 km from Uffington village</li>
                            <li class="pl-2">
                                near an ancient road known as the <span class="font-bold">9</span>
                                <input type="text" name="q9" class="border-b border-gray-500 outline-none px-2 w-48 bg-transparent text-[15px] placeholder-gray-400 focus:border-blue-500 transition-colors" placeholder="Answer">
                            </li>
                            <li class="pl-2">close to an ancient cemetery that has a number of burial mounds</li>
                        </ul>

                        <p class="font-bold text-gray-900 mb-3 text-base">Dating the Uffington White Horse:</p>
                        <ul class="list-disc ml-6 space-y-3 mb-6 text-gray-800 text-[15px]">
                            <li class="pl-2">
                                first reference to White Horse Hill appears in <span class="font-bold">10</span>
                                <input type="text" name="q10" class="border-b border-gray-500 outline-none px-2 w-48 bg-transparent text-[15px] placeholder-gray-400 focus:border-blue-500 transition-colors" placeholder="Answer"> from the 1070s
                            </li>
                            <li class="pl-2">horses shown on coins from the period 100 BCE – 1 BCE are similar in appearance</li>
                            <li class="pl-2">
                                according to analysis of the surrounding <span class="font-bold">11</span>
                                <input type="text" name="q11" class="border-b border-gray-500 outline-none px-2 w-48 bg-transparent text-[15px] placeholder-gray-400 focus:border-blue-500 transition-colors" placeholder="Answer"> , the Horse is Late Bronze Age / Early Iron Age
                            </li>
                        </ul>

                        <p class="font-bold text-gray-900 mb-3 text-base">Possible reasons for creation of the Uffington White Horse:</p>
                        <ul class="list-disc ml-6 space-y-4 text-gray-800 text-[15px]">
                            <li class="pl-2">an emblem to indicate land ownership</li>
                            <li class="pl-2">formed part of an ancient ritual</li>
                            <li class="pl-2 leading-relaxed">
                                was a representation of goddess Epona – associated with protection of horses and <span class="font-bold">12</span>
                                <input type="text" name="q12" class="border-b border-gray-500 outline-none px-2 w-48 bg-transparent text-[15px] placeholder-gray-400 focus:border-blue-500 transition-colors" placeholder="Answer">
                            </li>
                            <li class="pl-2 leading-relaxed">
                                was a representation of a Welsh goddess called <span class="font-bold">13</span>
                                <input type="text" name="q13" class="border-b border-gray-500 outline-none px-2 w-48 bg-transparent text-[15px] placeholder-gray-400 focus:border-blue-500 transition-colors" placeholder="Answer">
                            </li>
                        </ul>
                    </div>
                </div>
                </div>

                {{-- ── SOAL UNTUK PASSAGE 2 ── --}}
                <div id="questions-passage-2" data-passage="2" class="mb-10">
                    <div onclick="document.getElementById('passage-2')?.scrollIntoView({behavior: 'smooth', block: 'start'})"
                         class="mb-6 flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 via-indigo-50/40 to-white rounded-2xl border border-blue-200/80 shadow-sm cursor-pointer hover:border-blue-300 hover:shadow-md transition select-none group"
                         title="Klik untuk melompat ke Reading Passage 2">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-sm group-hover:scale-105 transition-transform">P2</span>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 leading-tight flex items-center gap-2">
                                    <span>Soal untuk Passage 2</span>
                                    <span class="text-xs font-normal text-gray-400 group-hover:text-blue-600 transition flex items-center gap-0.5">
                                        <svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        <span class="hidden sm:inline">Lihat Bacaan</span>
                                    </span>
                                </h3>
                                <p class="text-xs text-gray-500">Pertanyaan 14–26 berdasarkan Reading Passage 2</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full border border-blue-200">Questions 14–26</span>
                    </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–16</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 14–16 on your answer sheet.</p>

                    <div class="space-y-6">
                        @foreach([
                            [14, 'What point does the writer make about microbes in the first paragraph?', [
                                'A' => 'They adapt quickly to their environment.',
                                'B' => 'The risk they pose has been exaggerated.',
                                'C' => 'They are more plentiful in animal life than plant life.',
                                'D' => 'They will continue to exist for longer than the human race.',
                            ]],
                            [15, 'In the second paragraph, the writer is impressed by the fact that', [
                                'A' => 'each species tends to have vastly different microbes.',
                                'B' => 'some parts of the body contain relatively few microbes.',
                                'C' => 'the average individual has more microbial cells than human ones.',
                                'D' => 'scientists have limited understanding of how microbial cells behave.',
                            ]],
                            [16, 'What is the writer doing in the fifth paragraph?', [
                                'A' => 'explaining how a discovery was made',
                                'B' => 'comparing scientists\' theories about microbes',
                                'C' => 'describing confusion among scientists',
                                'D' => 'giving details of how microbes cause disease',
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

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 17–20</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Complete the summary using the list of words, <strong>A–H</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–H</strong>, in boxes 17–20 on your answer sheet.</p>

                    <div class="border border-gray-300 rounded-lg p-5 bg-white text-sm mb-5">
                        <h4 class="text-lg font-bold text-center mb-6">We should be more tolerant of microbes</h4>

                        <p class="text-gray-800 leading-[2.5] mb-4">
                            Yong's book argues that we should be more tolerant of microbes. Many have a beneficial effect, and only a relatively small number lead to
                            <strong>17</strong>
                            <select name="q17" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            . And although it is misleading to think of microbes as 'friendly', we should also stop thinking of them as the enemy. In fact, we should accept that our relationship with microbes is one based on
                            <strong>18</strong>
                            <select name="q18" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            .
                        </p>
                        <p class="text-gray-800 leading-[2.5] mb-4">
                            New research shows that microbes have numerous benefits for humans. Amongst other things, they aid digestion, remove poisons, produce vitamins and may even help reduce obesity. However, there is a growing problem. Our poor
                            <strong>19</strong>
                            <select name="q19" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            , our overuse of antibiotics, and our excessive focus on
                            <strong>20</strong>
                            <select name="q20" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            are upsetting the bacterial balance and may be contributing to the huge increase in allergies and immune system problems.
                        </p>
                    </div>

                    
                    <div class="border border-gray-400 p-5 bg-white text-[15px] mx-auto w-full mb-2">
                        <div class="grid gap-x-6 gap-y-4 font-sans" style="grid-template-columns: repeat(3, minmax(0, 1fr));">
                            @foreach([
                                'A' => 'solution', 'B' => 'partnership', 'C' => 'destruction',
                                'D' => 'exaggeration', 'E' => 'cleanliness', 'F' => 'regulations',
                                'G' => 'illness', 'H' => 'nutrition'
                            ] as $l => $w)
                            <div class="flex gap-4"><span class="font-bold text-gray-900 w-4">{{ $l }}</span> <span class="text-gray-800">{{ $w }}</span></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 21–26</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the claims of the writer in Reading Passage 2?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 21–26 on your answer sheet, write</p>

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
                                    [21, "It is possible that using antibacterial products in the home fails to have the desired effect."],
                                    [22, "It is a good idea to ensure that children come into contact with as few bacteria as possible."],
                                    [23, "Yong's book contains more case studies than are necessary."],
                                    [24, "The case study about bacteria that prevent squid from being attacked may have limited appeal."],
                                    [25, "Efforts to control dengue fever have been surprisingly successful."],
                                    [26, "Microbes that reduce the risk of infection have already been put inside the walls of some hospital wards."],
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
                </div>

                {{-- ── SOAL UNTUK PASSAGE 3 ── --}}
                <div id="questions-passage-3" data-passage="3" class="mb-10">
                    <div onclick="document.getElementById('passage-3')?.scrollIntoView({behavior: 'smooth', block: 'start'})"
                         class="mb-6 flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 via-violet-50/40 to-white rounded-2xl border border-purple-200/80 shadow-sm cursor-pointer hover:border-purple-300 hover:shadow-md transition select-none group"
                         title="Klik untuk melompat ke Reading Passage 3">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-xl bg-purple-600 text-white flex items-center justify-center font-bold text-sm shadow-sm group-hover:scale-105 transition-transform">P3</span>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 leading-tight flex items-center gap-2">
                                    <span>Soal untuk Passage 3</span>
                                    <span class="text-xs font-normal text-gray-400 group-hover:text-purple-600 transition flex items-center gap-0.5">
                                        <svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        <span class="hidden sm:inline">Lihat Bacaan</span>
                                    </span>
                                </h3>
                                <p class="text-xs text-gray-500">Pertanyaan 27–40 berdasarkan Reading Passage 3</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold rounded-full border border-purple-200">Questions 27–40</span>
                    </div>

                {{-- Q27-30: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–30</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 27–30 on your answer sheet.</p>

                    <div class="space-y-6">
                        @foreach([
                            [27, 'What point does the writer make in the first paragraph?', [
                                'A' => 'Wisdom appears to be unique to the human race.',
                                'B' => 'A basic assumption about wisdom may be wrong.',
                                'C' => 'Concepts of wisdom may depend on the society we belong to.',
                                'D' => 'There is still much to be discovered about the nature of wisdom.',
                            ]],
                            [28, 'What does Igor Grossmann suggest about the ability to make wise decisions?', [
                                'A' => 'It can vary greatly from one person to another.',
                                'B' => 'Earlier research into it was based on unreliable data.',
                                'C' => 'The importance of certain influences on it was underestimated.',
                                'D' => 'Various branches of psychology define it according to their own criteria.',
                            ]],
                            [29, 'According to the third paragraph, Grossmann claims that the level of wisdom an individual shows', [
                                'A' => 'can be greater than they think it is.',
                                'B' => 'will be different in different circumstances.',
                                'C' => 'may be determined by particular aspects of their personality.',
                                'D' => 'should develop over time as a result of their life experiences.',
                            ]],
                            [30, 'What is described in the fifth paragraph?', [
                                'A' => 'a difficulty encountered when attempting to reason wisely',
                                'B' => 'an example of the type of person who is likely to reason wisely',
                                'C' => 'a controversial view about the benefits of reasoning wisely',
                                'D' => 'a recommended strategy that can help people to reason wisely',
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

                {{-- Q31-35: Summary Completion (Word Bank) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 31–35</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Complete the summary using the list of words, <strong>A–J</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–J</strong>, in boxes 31–35 on your answer sheet.</p>

                    <div class="border border-gray-300 rounded-lg p-5 bg-white text-sm mb-5">
                        <h4 class="text-lg font-bold text-center mb-6">The characteristics of wise reasoning</h4>

                        <p class="text-gray-800 leading-[2.5] mb-4">
                            Igor Grossmann and colleagues have established four characteristics which enable us to make wise decisions. It is important to have a certain degree of
                            <strong>31</strong>
                            <select name="q31" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            regarding the extent of our knowledge, and to take into account
                            <strong>32</strong>
                            <select name="q32" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            which may not be the same as our own. We should also be able to take a broad
                            <strong>33</strong>
                            <select name="q33" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            of any situation. Another key characteristic is being aware of the likelihood of alterations in the way that people relate to each other.
                        </p>
                        <p class="text-gray-800 leading-[2.5] mb-4">
                            Grossmann also believes that it is better to regard scenarios with
                            <strong>34</strong>
                            <select name="q34" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            . By avoiding the first-person perspective, we focus more on
                            <strong>35</strong>
                            <select name="q35" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            and on other moral ideals, which in turn leads to wiser decision-making.
                        </p>
                    </div>

                    {{-- Word bank --}}
                    <div class="border border-gray-400 p-5 bg-white text-[15px] mx-auto w-full mb-2">
                        <div class="grid gap-x-6 gap-y-4 font-sans" style="grid-template-columns: repeat(3, minmax(0, 1fr));">
                            @foreach([
                                'A' => 'opinions', 'B' => 'confidence', 'C' => 'view',
                                'D' => 'modesty', 'E' => 'problems', 'F' => 'objectivity',
                                'G' => 'fairness', 'H' => 'experiences', 'I' => 'range', 'J' => 'reasons'
                            ] as $l => $w)
                            <div class="flex gap-4"><span class="font-bold text-gray-900 w-4">{{ $l }}</span> <span class="text-gray-800">{{ $w }}</span></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Questions 36–40: True/False/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 36–40</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 36–40 on your answer sheet, write</p>

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
                                    [36, "Students participating in the job prospects experiment could choose one of two perspectives to take."],
                                    [37, "Participants in the couples experiment were aware that they were taking part in a study about wise reasoning."],
                                    [38, "In the couples experiments, the length of the couples’ relationships had an impact on the results."],
                                    [39, "In both experiments, the participants who looked at the situation from a more detached viewpoint tended to make wiser decisions."],
                                    [40, "Grossmann believes that a person’s wisdom is determined by their intelligence to only a very limited extent."],
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
</body>
</html>

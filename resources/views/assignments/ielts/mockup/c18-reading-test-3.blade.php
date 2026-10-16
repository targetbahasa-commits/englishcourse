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
                <div id="headerScoreBadge" class="hidden items-center gap-2 px-3 py-1.5 bg-emerald-50 border border-emerald-300 rounded-xl shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-emerald-800" id="headerScoreText">Band -</span>
                    <button type="button" onclick="openEvalResultModal()" class="text-xs font-bold text-emerald-700 underline hover:text-emerald-900 transition">Lihat Rapor</button>
                </div>
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

                {{-- Passage 1 Card --}}
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

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-2">Materials to take us beyond concrete</h3>
                    <p class="text-center italic text-gray-600 mb-6 text-[15px]">Concrete is everywhere, but it's bad for the planet, generating large amounts of carbon dioxide – alternatives are being developed</p>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p><strong>A</strong> Concrete is the second most used substance in the global economy, after water – and one of the world's biggest single sources of greenhouse gas emissions. The chemical process by which cement, the key ingredient of concrete, is created results in large quantities of carbon dioxide. The UN estimates that there will be 9.8 billion people living on the planet by mid-century. They will need somewhere to live. If concrete is the only answer to the construction of new cities, then carbon emissions will soar, aggravating global warming. And so scientists have started innovating with other materials, in a scramble for alternatives to a universal commodity that has underpinned our modern life for many years.</p>

                        <p><strong>B</strong> The problem with replacing concrete is that it is so very good at what it does. Chris Cheeseman, an engineering professor at Imperial College London, says the key thing to consider is the extent to which concrete is used around the world, and is likely to continue to be used. 'Concrete is not a high-carbon product. Cement is high carbon, but concrete is not. But it is the scale on which it is used that makes it high carbon. The sheer scale of manufacture is so huge, that is the issue.'</p>

                        <p><strong>C</strong> Not only are the ingredients of concrete relatively cheap and found in abundance in most places around the globe, the stuff itself has marvellous properties: Portland cement, the vital component of concrete, is mouldable and pourable, but quickly sets hard. Cheeseman also notes another advantage: concrete and steel have similar thermal expansion properties, so steel can be used to reinforce concrete, making it far stronger and more flexible as a building material than it could be on its own. According to Cheeseman, all these factors together make concrete hard to beat. 'Concrete is amazing stuff. Making anything with similar properties is going to be very difficult.'</p>

                        <p><strong>D</strong> A possible alternative to concrete is wood. Making buildings from wood may seem like a rather medieval idea, but climate change is driving architects to turn to treated timber as a possible resource. Recent years have seen the emergence of tall buildings constructed almost entirely from timber. Vancouver, Vienna and Brumunddal in Norway are all home to constructed tall, wooden buildings.</p>

                        <p><strong>E</strong> Using wood to construct buildings, however, is not straightforward. Wood expands as it absorbs moisture from the air and is susceptible to pests, not to mention fire. But treating wood and combining it with other materials can improve its properties. Cross-laminated timber is engineered wood. An adhesive is used to stick layers of solid-sawn timber together, crosswise, to form building blocks. This material is light but has the strength of concrete and steel. Construction experts say that wooden buildings can be constructed at a greater speed than ones of concrete and steel and the process, it seems, is quieter.</p>

                        <p><strong>F</strong> Stora Enso is Europe's biggest supplier of cross-laminated timber, and its vice-president Markus Mannström reports that the company is seeing increasing demand globally for building in wood, with climate change concerns the key driver. Finland, with its large forests, where Stora Enso is based, has been leading the way, but the company is seeing a rise in demand for its timber products across the world, including in Asia. Of course, using timber in a building also locks away the carbon that it absorbed as it grew. But even treated wood has its limitations and only when a wider range of construction projects has been proven in practice will it be possible to see wood as a real alternative to concrete in constructing tall buildings.</p>

                        <p><strong>G</strong> Fly ash and slag from iron ore are possible alternatives to cement in a concrete mix. Fly ash, a byproduct of coal-burning power plants, can be incorporated into concrete mixes to make up as much as 15 to 30% of the cement, without harming the strength or durability of the resulting mix. Iron-ore slag, a byproduct of the iron-ore smelting process, can be used in a similar way. Their incorporation into concrete mixes has the potential to reduce greenhouse gas emissions.</p>

                        <p>But Anna Surgenor, of the UK's Green Building Council, notes that although these waste products can save carbon in the concrete mix, their use is not always straightforward. 'It's possible to replace the cement content in concrete with waste products to lower the overall carbon impact. But there are several calculations that need to be considered across the entire life cycle of the building – these include factoring in where these materials are being shipped from. If they are transported over long distances, using fossil fuels, the use of alternative materials might not make sense from an overall carbon reduction perspective.'</p>

                        <p><strong>H</strong> While these technologies are all promising ideas, they are either unproven or based on materials that are not abundant. In their overview of innovation in the concrete industry, Felix Preston and Johanna Lehne of the UK's Royal Institute of International Affairs reached the conclusion that, 'Some novel cements have been discussed for more than a decade within the research community, without breaking through. At present, these alternatives are rarely as cost-effective as conventional cement, and they face raw-material shortages and resistance from customers.'</p>

                        </div>

                        {{-- Floating Toolbar for Passage 1 --}}
                        @include('assignments.ielts.mockup.partials.reading-toolbar')
                    </div>
                </div>

                {{-- Passage 2 Card --}}
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

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-2">The steam car</h3>
                    <p class="text-center italic text-gray-600 mb-6 text-[15px]">The successes and failures of the Doble brothers and their steam cars</p>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p><strong>A</strong> When primitive automobiles first began to appear in the 1800s, their engines were based on steam power. Steam had already enjoyed a long and successful career in the railways, so it was only natural that the technology evolved into a miniaturized version which was separate from the trains. But these early cars inherited steam's weaknesses along with its strengths. The boilers had to be lit by hand, and they required about twenty minutes to build up pressure before they could be driven. Furthermore, their water reservoirs only lasted for about thirty miles before needing replenishment. Despite such shortcomings, these newly designed self-propelled carriages offered quick transportation, and by the early 1900s it was not uncommon to see such machines shuttling wealthy citizens around town.</p>

                        <p><strong>B</strong> But the glory days of steam cars were few. A new technology called the Internal Combustion Engine soon appeared, which offered the ability to drive down the road just moments after starting up. At first, these noisy gasoline cars were unpopular because they were more complicated to operate and they had difficult hand-crank starters, which were known to break arms when the engines backfired. But in 1912 General Motors introduced the electric starter, and over the following few years steam power was gradually phased out.</p>

                        <p><strong>C</strong> Even as the market was declining, four brothers made one last effort to rekindle the technology. Between 1906 and 1909, while still attending high school, Abner Doble and his three brothers built their first steam car in their parents' basement. It comprised parts taken from a wrecked early steam car but reconfigured to drive an engine of their own design. Though it did not run well, the Doble brothers went on to build a second and third prototype in the following years. Though the Doble boys' third prototype, nicknamed the Model B, still lacked the convenience of an internal combustion engine, it drew the attention of automobile trade magazines due to its numerous improvements over previous steam cars. The Model B proved to be superior to gasoline automobiles in many ways. Its high-pressure steam drove the engine pistons in virtual silence, in contrast to clattering gas engines which emitted the aroma of burned hydrocarbons. Perhaps most impressively, the Model B was amazingly swift. It could accelerate from zero to sixty miles per hour in just fifteen seconds, a feat described as 'remarkable acceleration' by <em>Automobile</em> magazine in 1914.</p>

                        <p><strong>D</strong> The following year Abner Doble drove the Model B from Massachusetts to Detroit in order to seek investment in his automobile design, which he used to open the General Engineering Company. He and his brothers immediately began working on the Model C, which was intended to expand upon the innovations of the Model B. The brothers added features such as a key-based ignition in the cabin, eliminating the need for the operator to manually ignite the boiler. With these enhancements, the Dobles' new car company promised a steam vehicle which would provide all of the convenience of a gasoline car, but with much greater speed, much simpler driving controls, and a virtually silent powerplant. By the following April, the General Engineering Company had received 5,390 deposits for Doble Detroits, which were scheduled for delivery in early 1918.</p>

                        <p><strong>E</strong> Later that year Abner Doble delivered unhappy news to those eagerly awaiting the delivery of their modern new cars. Those buyers who received the handful of completed cars complained that the vehicles were sluggish and erratic, sometimes going in reverse when they should go forward. The new engine design, though innovative, was still plagued with serious glitches.</p>

                        <p><strong>F</strong> The brothers made one final attempt to produce a viable steam automobile. In early 1924, the Doble brothers shipped a Model E to New York City to be road-tested by the Automobile Club of America. After sitting overnight in freezing temperatures, the car was pushed out into the road and left to sit for over an hour in the frosty morning air. At the turn of the key, the boiler lit and reached its operating pressure inside of forty seconds. As they drove the test vehicle further, they found that its evenly distributed weight lent it surprisingly good handling, even though it was so heavy. As the new Doble steamer was further developed and tested, its maximum speed was pushed to over a hundred miles per hour, and it achieved about fifteen miles per gallon of kerosene with negligible emissions.</p>

                        <p><strong>G</strong> Sadly, the Dobles' brilliant steam car never was a financial success. Priced at around $18,000 in 1924, it was popular only among the very wealthy. Plus, it is said that no two Model Es were quite the same, because Abner Doble tinkered endlessly with the design. By the time the company folded in 1931, fewer than fifty of the amazing Model E steam cars had been produced. For his whole career, until his death in 1961, Abner Doble remained adamant that steam-powered automobiles were at least equal to gasoline cars, if not superior. Given the evidence, he may have been right. Many of the Model E Dobles which have survived are still in good working condition, some having been driven over half a million miles with only normal maintenance. Astonishingly, an unmodified Doble Model E runs clean enough to pass the emissions laws in California today, and they are pretty strict. It is true that the technology poses some difficult problems, but you cannot help but wonder how efficient a steam car might be with the benefit of modern materials and computers. Under the current pressure to improve automotive performance and reduce emissions, it is not unthinkable that the steam car may rise again.</p>

                        </div>

                        {{-- Floating Toolbar for Passage 2 --}}
                        @include('assignments.ielts.mockup.partials.reading-toolbar')
                    </div>
                </div>

                {{-- Passage 3 Card --}}
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

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">The case for mixed-ability classes</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p>Picture this scene. It's an English literature lesson in a UK school, and the teacher has just read an extract from Shakespeare's <em>Romeo and Juliet</em> with a class of 15-year-olds. He's given some of the students copies of <em>No Fear Shakespeare</em>, a kid-friendly translation of the original. For three students, even these literacy demands are beyond them. Another girl simply can't focus and he gives her pens and paper to draw with. The teacher can ask the <em>No Fear</em> group to identify the key characters and maybe provide a tentative plot summary. He can ask most of the class about character development, and five of them might be able to support their statements with textual evidence. Now two curious students are wondering whether Shakespeare advocates living a life of moderation or one of passionate engagement.</p>

                        <p>As a teacher myself, I'd think my lesson would be going rather well if the discussion went as described above. But wouldn't this kind of class work better if there weren't such a huge gap between the top and the bottom? If we put all the kids who needed literacy support into one class, and all the students who want to discuss the virtue of moderation into another?</p>

                        <p>The practice of 'streaming', or 'tracking', involves separating students into classes depending on their diagnosed levels of attainment. At a macro level, it requires the establishment of academically selective schools for the brightest students, and comprehensive schools for the rest. Within schools, it means selecting students into a 'stream' of general ability, or 'sets' of subject-specific ability. The practice is intuitively appealing to almost every stakeholder.</p>

                        <p>I have heard the mixed-ability model attacked by way of analogy: a group hike. The fittest in the group take the lead and set a brisk pace, only to have to stop and wait every 20 minutes. This is frustrating, and their enthusiasm wanes. Meanwhile, the slowest ones are not only embarrassed but physically struggling to keep up. What's worse, they never get a long enough break. They honestly just want to quit. Hiking, they feel, is not for them.</p>

                        <p>Mixed-ability classes bore students, frustrate parents and burn out teachers. The brightest ones will never summit Mount Qomolangma, and the stragglers won't enjoy the lovely stroll in the park they are perhaps more suited to. Individuals suffer at the demands of the collective, mediocrity prevails. So: is learning like hiking?</p>

                        <p>The current pedagogical paradigm is arguably that of constructivism, which emerged out of the work of psychologist Lev Vygotsky. In the 1930s, Vygotsky emphasised the importance of targeting a student's specific 'zone of proximal development' (ZPD). This is the gap between what they can achieve only with support – teachers, textbooks, worked examples, parents and so on – and what they can achieve independently. The purpose of teaching is to provide and then gradually remove this 'scaffolding' until they are autonomous. If we accept this model, it follows that streaming students with similar ZPDs would be an efficient and effective solution. And that forcing everyone on the same hike – regardless of aptitude – would be madness.</p>

                        <p>Despite all this, there is limited empirical evidence to suggest that streaming results in better outcomes for students. Professor John Hattie, director of the Melbourne Education Research Institute, notes that 'tracking has minimal effects on learning outcomes'. What is more, streaming appears to significantly – and negatively – affect those students assigned to the lowest sets. These students tend to have much higher representation of low socioeconomic class. Less significant is the small benefit for those lucky clever students in the higher sets. The overall result is that the smart stay smart and the dumb get dumber, further entrenching the social divide.</p>

                        <p>In the latest update of Hattie's influential meta-analysis of factors influencing student achievement, one of the most significant factors is the teachers' estimate of achievement. Streaming students by diagnosed achievement automatically limits what the teacher feels the student is capable of. Meanwhile, in a mixed environment, teachers' estimates need to be more diverse and flexible.</p>

                        <p>While streaming might seem to help teachers effectively target a student's ZPD, it can underestimate the importance of peer-to-peer learning. A crucial aspect of constructivist theory is the role of the MKO – 'more-knowledgeable other' – in knowledge construction. While teachers are traditionally the MKOs in classrooms, the value of knowledgeable student peers must not go unrecognised either.</p>

                        <p>I find it amazing to watch students get over an idea to their peers in ways that I would never think of. They operate with different language tools and different social tools from teachers and, having just learnt it themselves, they possess similar cognitive structures to their struggling classmates. There is also something exciting about passing on skills and knowledge that you yourself have just mastered – a certain pride and zeal, a certain freshness to the interaction between 'teacher' and 'learner' that is often lost by the expert for whom the steps are obvious and the joy of discovery forgotten.</p>

                        <p>Having a variety of different abilities in a collaborative learning environment provides valuable resources for helping students meet their learning needs, not to mention improving their communication and social skills. And today, more than ever, we need the many to flourish – not suffer at the expense of a few bright stars. Once a year, I go on a hike with my class, a mixed bunch of students. It <em>is</em> challenging. The fittest students realise they need to encourage the reluctant. There are lookouts who report back, and extra items to carry for others. We make it – together.</p>

                        </div>

                        {{-- Floating Toolbar for Passage 3 --}}
                        @include('assignments.ielts.mockup.partials.reading-toolbar')
                    </div>
                </div>

            </div>
        </div>

        {{-- RIGHT: Questions --}}
        <div class="relative h-full min-h-0 overflow-hidden" id="questions-column-wrapper">
            <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar" id="questions-panel">
            <div class="px-4 sm:px-6 md:px-8 py-8 pb-24 w-full relative">

{{-- PASSAGE 1 QUESTIONS header --}}
                <div class="flex justify-center mb-6">
                    <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 1</span>
                </div>

                {{-- Questions 1–4: Section matching A-H --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–4</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 1 has eight sections, <strong>A–H</strong>.</p>
                    <p class="text-sm text-gray-800 mb-3">Which section contains the following information?</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–H</strong>, in boxes 1–4 on your answer sheet.</p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Information</th>
                                    <th class="p-3 font-bold text-gray-600 w-24 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [1, 'an explanation of the industrial processes that create potential raw materials for concrete'],
                                    [2, 'a reference to the various locations where high-rise wooden buildings can be found'],
                                    [3, 'an indication of how widely available the raw materials of concrete are'],
                                    [4, 'the belief that more high-rise wooden buildings are needed before wood can be regarded as a viable construction material'],
                                ] as [$num, $info])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $info }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                            <option value="" disabled selected>–</option>
                                            @foreach(range('A','H') as $l)
                                            <option value="{{ $l }}">{{ $l }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Questions 5–8: Summary completion ONE WORD ONLY --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 5–8</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 5–8 on your answer sheet.</p>

                    <div class="border-2 border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-5">Making buildings with wood</h4>

                        <p class="leading-loose mb-3">
                            Wood is a traditional building material, but current environmental concerns are encouraging
                            <strong>5</strong>
                            <input type="text" name="q5" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            to use wood in modern construction projects.
                        </p>
                        <p class="leading-loose mb-3">
                            Using wood, however, has its challenges. For example, as
                            <strong>6</strong>
                            <input type="text" name="q6" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            in the atmosphere enters wood, it increases in size. In addition, wood is prone to pests and the risk of fire is greater. However, wood can be turned into a better construction material if it is treated and combined with other materials. In one process,
                            <strong>7</strong>
                            <input type="text" name="q7" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            of solid wood are glued together to create building blocks. These blocks are lighter than concrete and steel but equal them in strength. Experts say that wooden buildings are an improvement on those made of concrete and steel in terms of the
                            <strong>8</strong>
                            <input type="text" name="q8" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            with which they can be constructed and how much noise is generated by the process.
                        </p>
                    </div>
                </div>

                {{-- Questions 9–13: Matching people A-D --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 9–13</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Look at the following statements (Questions 9–13) and the list of people below.</p>
                    <p class="text-sm text-gray-800 mb-1">Match each statement with the correct person, <strong>A, B, C or D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Write the correct letter, <strong>A, B, C or D</strong>, in boxes 9–13 on your answer sheet.</p>
                    <p class="text-sm italic text-gray-700 mb-5"><strong>NB</strong> You may use any letter more than once.</p>

                    {{-- People list box --}}
                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <p class="font-bold text-center mb-3">List of People</p>
                        <div class="space-y-1 ml-4">
                            <div><strong>A</strong> Chris Cheeseman</div>
                            <div><strong>B</strong> Markus Mannström</div>
                            <div><strong>C</strong> Anna Surgenor</div>
                            <div><strong>D</strong> Felix Preston and Johanna Lehne</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-24 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [9, 'The environmental advantage of cement alternatives may not be as great as initially assumed.'],
                                    [10, 'It would be hard to create a construction alternative to concrete that offers so many comparable benefits.'],
                                    [11, 'Worries about the environment have led to increased interest in wood as a construction material.'],
                                    [12, 'Expense has been a factor in the negative response to the development of new cements.'],
                                    [13, 'The environmental damage caused by concrete is due to it being produced in large quantities.'],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                            <option value="" disabled selected>–</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- PASSAGE 2 QUESTIONS --}}
                <div class="flex justify-center mb-6 mt-10">
                    <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                </div>

                {{-- Questions 14–20: Heading matching --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–20</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 2 has seven paragraphs, <strong>A–G</strong>.</p>
                    <p class="text-sm text-gray-800 mb-1">Choose the correct heading for each paragraph from the list of headings below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct number, <strong>i–viii</strong>, in boxes 14–20 on your answer sheet.</p>

                    {{-- Headings list --}}
                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <p class="font-bold text-center mb-3">List of Headings</p>
                        <div class="space-y-1 ml-4">
                            <div><strong>i</strong>&nbsp;&nbsp;&nbsp;A period in cold conditions before the technology is assessed</div>
                            <div><strong>ii</strong>&nbsp;&nbsp;Marketing issues lead to failure</div>
                            <div><strong>iii</strong>&nbsp;Good and bad aspects of steam technology are passed on</div>
                            <div><strong>iv</strong>&nbsp;&nbsp;A possible solution to the issues of today</div>
                            <div><strong>v</strong>&nbsp;&nbsp;&nbsp;Further improvements lead to commercial orders</div>
                            <div><strong>vi</strong>&nbsp;&nbsp;Positive publicity at last for this quiet, clean, fast vehicle</div>
                            <div><strong>vii</strong>&nbsp;A disappointing outcome for customers</div>
                            <div><strong>viii</strong> A better option than the steam car arises</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Paragraph</th>
                                    <th class="p-3 font-bold text-gray-600 w-24 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [14, 'Paragraph A'],
                                    [15, 'Paragraph B'],
                                    [16, 'Paragraph C'],
                                    [17, 'Paragraph D'],
                                    [18, 'Paragraph E'],
                                    [19, 'Paragraph F'],
                                    [20, 'Paragraph G'],
                                ] as [$num, $para])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm">{{ $para }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                            <option value="" disabled selected>–</option>
                                            @foreach(['i','ii','iii','iv','v','vi','vii','viii'] as $h)
                                            <option value="{{ $h }}">{{ $h }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Questions 21–23: MCQ --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 21–23</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Choose the correct letter, <strong>A, B, C or D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 21–23 on your answer sheet.</p>

                    @foreach([
                        [21, 'What point does the writer make about the steam car in Paragraph B?', ['A' => 'Its success was short-lived.', 'B' => 'Not enough cars were made.', 'C' => 'Car companies found them hard to sell.', 'D' => 'People found them hard to drive.']],
                        [22, 'When building their first steam car, the Doble brothers', ['A' => 'constructed all the parts themselves.', 'B' => 'made written notes at each stage of the construction.', 'C' => 'needed several attempts to achieve a competitive model.', 'D' => 'sought the advice of experienced people in the car industry.']],
                        [23, 'In order to produce the Model C, the Doble brothers', ['A' => 'moved production to a different city.', 'B' => 'raised financial capital.', 'C' => 'employed an additional worker.', 'D' => 'abandoned their earlier designs.']],
                    ] as [$num, $question, $options])
                    <div class="mb-6 p-4 {{ $loop->even ? 'bg-gray-50' : '' }} rounded-lg">
                        <p class="mb-3 text-sm"><strong>{{ $num }}</strong> {{ $question }}</p>
                        <div class="space-y-2 ml-6">
                            @foreach($options as $letter => $text)
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-100 p-1.5 rounded text-sm">
                                <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span><strong>{{ $letter }}</strong> {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Questions 24–26: Summary completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 24–26</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD AND/OR A NUMBER</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 24–26 on your answer sheet.</p>

                    <div class="border-2 border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-5">The Model E</h4>

                        <p class="leading-loose mb-3">
                            The Model E was road-tested in 1924 by the Automobile Club of America. They found it easy to drive, despite its weight, and it impressed the spectators. A later version of the Model E raised its
                            <strong>24</strong>
                            <input type="text" name="q24" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            , while keeping its emissions extremely low.
                        </p>
                        <p class="leading-loose mb-3">
                            The steam car was too expensive for many people and its design was constantly being altered. Under
                            <strong>25</strong>
                            <input type="text" name="q25" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            cars were produced before the company went out of business. However, even today, there are Model Es on the road in the US. They are straightforward to maintain, and they satisfy California's
                            <strong>26</strong>
                            <input type="text" name="q26" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            emissions laws. Perhaps today's technology and materials would help us revive the steam car.
                        </p>
                    </div>
                </div>

                {{-- PASSAGE 3 QUESTIONS --}}
                <div class="flex justify-center mb-6 mt-10">
                    <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                </div>

                {{-- Questions 27–30: MCQ --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–30</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Choose the correct letter, <strong>A, B, C or D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 27–30 on your answer sheet.</p>

                    @foreach([
                        [27, 'The writer describes the <em>Romeo and Juliet</em> lesson in order to demonstrate', ['A' => 'how few students are interested in literature.', 'B' => 'how a teacher handles a range of learning needs.', 'C' => 'how unsuitable Shakespeare is for most teenagers.', 'D' => 'how weaker students can disrupt their classmates\' learning.']],
                        [28, 'What does the writer say about streaming in the third paragraph?', ['A' => 'It has a very broad appeal.', 'B' => 'It favours cleverer students.', 'C' => 'It is relatively simple to implement.', 'D' => 'It works better in some schools than others.']],
                        [29, 'What idea is suggested by the reference to Mount Qomolangma in the fifth paragraph?', ['A' => 'students following unsuitable paths', 'B' => 'students attempting interesting tasks', 'C' => 'students not achieving their full potential', 'D' => 'students not being aware of their limitations']],
                        [30, "What does the word 'scaffolding' in the sixth paragraph refer to?", ['A' => 'the factors which prevent a student from learning effectively', 'B' => 'the environment where most of a student\'s learning takes place', 'C' => 'the assistance given to a student in their initial stages of learning', 'D' => 'the setting of appropriate learning targets for a student\'s aptitude']],
                    ] as [$num, $question, $options])
                    <div class="mb-6 p-4 {{ $loop->even ? 'bg-gray-50' : '' }} rounded-lg">
                        <p class="mb-3 text-sm"><strong>{{ $num }}</strong> {!! $question !!}</p>
                        <div class="space-y-2 ml-6">
                            @foreach($options as $letter => $text)
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-100 p-1.5 rounded text-sm">
                                <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span><strong>{{ $letter }}</strong> {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Questions 31–35: Summary completion with phrases A–I --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 31–35</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary using the list of phrases, <strong>A–I</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–I</strong>, in boxes 31–35 on your answer sheet.</p>

                    <div class="border-2 border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-5">Is streaming effective?</h4>

                        <p class="leading-loose mb-3">
                            According to Professor John Hattie of the Melbourne Education Research Institute, there is very little indication that streaming leads to
                            <strong>31</strong>
                            <select name="q31" class="appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 cursor-pointer w-14 mx-1">
                                <option value="" disabled selected>–</option>
                                @foreach(range('A','I') as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                            </select>
                            . He points out that, in schools which use streaming, the most significant impact is on those students placed in the
                            <strong>32</strong>
                            <select name="q32" class="appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 cursor-pointer w-14 mx-1">
                                <option value="" disabled selected>–</option>
                                @foreach(range('A','I') as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                            </select>
                            , especially where a large proportion of them have
                            <strong>33</strong>
                            <select name="q33" class="appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 cursor-pointer w-14 mx-1">
                                <option value="" disabled selected>–</option>
                                @foreach(range('A','I') as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                            </select>
                            . Meanwhile, for the
                            <strong>34</strong>
                            <select name="q34" class="appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 cursor-pointer w-14 mx-1">
                                <option value="" disabled selected>–</option>
                                @foreach(range('A','I') as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                            </select>
                            , there appears to be only minimal advantage. A further issue is that teachers tend to have
                            <strong>35</strong>
                            <select name="q35" class="appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 cursor-pointer w-14 mx-1">
                                <option value="" disabled selected>–</option>
                                @foreach(range('A','I') as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                            </select>
                            of students in streamed groups.
                        </p>
                    </div>

                    {{-- Phrases box --}}
                    <div class="border border-gray-300 p-4 rounded-lg mt-4 text-sm bg-gray-50">
                        <div class="grid grid-cols-3 gap-x-4 gap-y-2">
                            <div><strong>A</strong> wrong classes</div>
                            <div><strong>B</strong> lower expectations</div>
                            <div><strong>C</strong> average learners</div>
                            <div><strong>D</strong> bottom sets</div>
                            <div><strong>E</strong> brightest pupils</div>
                            <div><strong>F</strong> disadvantaged backgrounds</div>
                            <div><strong>G</strong> weaker students</div>
                            <div><strong>H</strong> higher achievements</div>
                            <div><strong>I</strong> positive impressions</div>
                        </div>
                    </div>
                </div>

                {{-- Questions 36–40: Yes/No/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 36–40</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the views of the writer in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 36–40 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic">YES</span></div><div class="italic">if the statement agrees with the views of the writer</div>
                            <div><span class="font-bold italic">NO</span></div><div class="italic">if the statement contradicts the views of the writer</div>
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
                                    [36, 'The Vygotsky model of education supports the concept of a mixed-ability class.'],
                                    [37, 'Some teachers are uncertain about allowing students to take on MKO roles in the classroom.'],
                                    [38, 'It can be rewarding to teach knowledge which you have only recently acquired.'],
                                    [39, 'The priority should be to ensure that the highest-achieving students attain their goals.'],
                                    [40, 'Taking part in collaborative outdoor activities with teachers and classmates can improve student outcomes in the classroom.'],
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

                {{-- Final Submit --}}
                @if($submitEnabled ?? true)
                <div class="mt-6 flex justify-end" id="submitReadingBtnContainer">
                    <button type="button" id="submitReadingAnswersBtn" onclick="evaluateReadingAnswers()" class="px-8 py-3.5 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 active:scale-95 text-white font-bold text-sm sm:text-base rounded-xl transition shadow-lg flex items-center gap-2 cursor-pointer border border-emerald-500/20">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Submit All Answers</span>
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
</div>

@include('assignments.ielts.mockup.partials.reading-annotations')

@include('assignments.ielts.mockup.partials.reading-dictionary')
@include('assignments.ielts.mockup.partials.c18-reading-test-3-evaluator')
</body>
</html>

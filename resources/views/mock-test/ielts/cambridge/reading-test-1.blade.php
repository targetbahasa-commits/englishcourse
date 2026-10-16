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
    @include('components.cambridge-guest-signup-modal')

{{-- Fixed full-screen layout --}}
<div class="fixed inset-0 z-0 flex flex-col reading-fixed-shell">

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
                <div id="headerScoreBadge" class="hidden items-center gap-2 px-3 py-1.5 bg-emerald-50 border border-emerald-300 rounded-xl shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-xs font-bold text-emerald-800" id="headerScoreText">Band -</span>
                    <button type="button" onclick="openEvalResultModal()" class="text-xs font-bold text-emerald-700 underline hover:text-emerald-900 transition">Lihat Rapor</button>
                </div>
                <a href="{{ $backUrl ?? route('mock-test.ielts-academic.cambridge.skills', ['edition' => $edition, 'id' => $testId]) }}" class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    {{ $backLabel ?? 'Back' }}
                </a>
            </div>
        </div>
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
                         new ResizeObserver(() => { if (canvasObj) canvasObj.resize(); }).observe($el);
                     "
                >
                    {{-- Drawing canvas for Passage 1 --}}
                    <canvas x-ref="drawingCanvas"
                            class="absolute inset-0 w-full h-full z-10 rounded-2xl"
                            :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'">
                    </canvas>

                    <div class="relative z-20">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                            <span class="bg-pink-50 text-pink-600 font-bold px-3 py-1 rounded-lg text-sm tracking-wide uppercase">READING PASSAGE 1</span>
                        </div>
                        <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong>, which are based on Reading Passage 1 below.</p>

                        <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">Why we need to protect polar bears</h3>

                        {{-- Passage text --}}
                        <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif] pb-6"
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

                        {{-- Floating Toolbar for Passage 1 --}}
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
                         new ResizeObserver(() => { if (canvasObj) canvasObj.resize(); }).observe($el);
                     "
                >
                    {{-- Drawing canvas for Passage 2 --}}
                    <canvas x-ref="drawingCanvas"
                            class="absolute inset-0 w-full h-full z-10 rounded-2xl"
                            :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'">
                    </canvas>

                    <div class="relative z-20">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                            <span class="bg-pink-50 text-pink-600 font-bold px-3 py-1 rounded-lg text-sm tracking-wide uppercase">READING PASSAGE 2</span>
                        </div>
                        <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 on pages 21 and 22.</p>

                        <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">The Step Pyramid of Djoser</h3>

                        <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif] pb-6"
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

                        {{-- Floating Toolbar for Passage 2 --}}
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
                         new ResizeObserver(() => { if (canvasObj) canvasObj.resize(); }).observe($el);
                     "
                >
                    {{-- Drawing canvas for Passage 3 --}}
                    <canvas x-ref="drawingCanvas"
                            class="absolute inset-0 w-full h-full z-10 rounded-2xl"
                            :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'">
                    </canvas>

                    <div class="relative z-20">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                            <span class="bg-pink-50 text-pink-600 font-bold px-3 py-1 rounded-lg text-sm tracking-wide uppercase">READING PASSAGE 3</span>
                        </div>
                        <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                        <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">The future of work</h3>

                        <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif] pb-6"
                             @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                             @click="if(eraserMode) window.removeHighlight($event);">
                            <p>According to a leading business consultancy, 3–14% of the global workforce will need to switch to a different occupation within the next 10–15 years, and all workers will need to adapt as their occupations evolve alongside increasingly capable machines. Automation – or 'embodied artificial intelligence' (AI) – is one aspect of the disruptive effects of technology on the labour market. 'Disembodied AI', like the algorithms running in our smartphones, is another.</p>

                            <p>Dr Stella Pachidi from Cambridge Judge Business School believes that some of the most fundamental changes are happening as a result of the 'algorithmication' of jobs that are dependent on data rather than on production – the so-called knowledge economy. Algorithms are capable of learning from data to undertake tasks that previously needed human judgement, such as reading legal contracts, analysing medical scans and gathering market intelligence.</p>

                            <p>'In many cases, they can outperform humans,' says Pachidi. 'Organisations are attracted to using algorithms because they want to make choices based on what they consider is "perfect information", as well as to reduce costs and enhance productivity.'</p>

                            <p>'But these enhancements are not without consequences,' says Pachidi. 'If routine cognitive tasks are taken over by AI, how do professions develop their future experts?' she asks. 'One way of learning about a job is "legitimate peripheral participation" – a novice stands next to experts and learns by observation. If this isn't happening, then you need to find new ways to learn.'</p>

                            <p>Another issue is the extent to which the technology influences or even controls the workforce. For over two years, Pachidi monitored a telecommunications company. 'The way telecoms salespeople work is through personal and frequent contact with clients, using the benefit of experience to assess a situation and reach a decision. However, the company had started using a[n] … algorithm that defined when account managers should contact certain customers about which kinds of campaigns and what to offer them.'</p>

                            <p>The algorithm – usually built by external designers – often becomes the keeper of knowledge, she explains. In cases like this, Pachidi believes, a short-sighted view begins to creep into working practices whereby workers learn through the 'algorithm's eyes' and become dependent on its instructions. Alternative explorations – where experimentation and human instinct lead to progress and new ideas – are effectively discouraged.</p>

                            <p>Pachidi and colleagues even observed people developing strategies to make the algorithm work to their own advantage. 'We are seeing cases where workers feed the algorithm with false data to reach their targets,' she reports.</p>

                            <p>It's scenarios like these that many researchers in Cambridge and beyond are working to avoid by increasing the trustworthiness and transparency of AI technologies, so that organisations and individuals understand how AI decisions are made. In the meantime, says Pachidi, in our race to reap the undoubted benefits of new technology, it's important to avoid taking a laissez-faire approach to algorithmication: 'We need to make sure we fully understand the dilemmas that this new world raises regarding expertise, occupational boundaries and control.'</p>

                            <p>While Pachidi sees changes ahead in the nature of work, economist Professor Hamish Low believes that the future of work will involve major transitions across the whole life course for everyone: 'The traditional trajectory of full-time education followed by full-time work followed by a pensioned retirement is a thing of the past.'</p>

                            <p>'Disruptive technologies, the rise of the ad hoc "gig economy", living longer and the fragile economics of pension provision will mean a multistage employment life: one where retraining happens across the life course, and where multiple jobs and no job happen by choice at different stages.'</p>

                            <p>His research examines the role of risk and the welfare system in relation to work at these various life stages. 'When we are talking about the future of work,' he says, 'we should have in mind these new frameworks for what people's lives will look like, and prepare new generations for a different perspective on employment.'</p>

                            <p>On the subject of future job losses, Low believes the predictions are founded on a fallacy: 'It assumes that the number of jobs is fixed. If in 30 years, half of 100 jobs are being carried out by robots, that doesn't mean we are left with just 50 jobs for humans. The number of jobs will increase: we would expect there to be 150 jobs.'</p>

                            <p>Dr Ewan McGaughey, at Cambridge's Centre for Business Research and King's College London, agrees that 'apocalyptic' views about the future of work are misguided. 'It's the laws that restrict the supply of capital to the job market, not the advent of new technologies that causes unemployment.'</p>

                            <p>His recently published research answers the question of whether automation, AI and robotics will mean a 'jobless future' by looking at the causes of unemployment. 'History is clear that change can mean redundancies – after World War II, 42% of UK jobs were redundant, but social policy maintained full employment. Yes, technology can displace people. But social policies can tackle this through retraining and redeployment.'</p>

                            <p>He adds: 'The big problem won't be unemployment, it will be underemployment – people who want to work but can't because they have zero-hours contracts. If there is going to be change to jobs as a result of AI and robotics, then I'd like to see governments seizing the opportunity to improve policy to enforce good job security. We can "reprogramme" the law to prepare for a fairer future of work and leisure.'</p>
                        </div>

                        {{-- Floating Toolbar for Passage 3 --}}
                    </div>
                </div>

            </div>
        </div>

        {{-- RIGHT: Questions --}}
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar" id="questions-panel">
            <div class="px-4 sm:px-6 md:px-8 py-8 pb-24 w-full relative">

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
                @if($submitEnabled ?? true)
                <div class="mt-6 flex justify-end">
                    <button type="button" id="submitReadingAnswersBtn" onclick="evaluateReadingAnswers()" class="px-7 py-3.5 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 active:scale-95 text-white font-bold text-sm sm:text-base rounded-xl transition shadow-lg flex items-center gap-2 cursor-pointer border border-emerald-500/20">
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



@include('assignments.ielts.mockup.partials.reading-test-1-evaluator')
</body>
</html>

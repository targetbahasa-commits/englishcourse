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

                {{-- Passage 1: Green roofs --}}
                <div class="mb-6">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 1</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong>, which are based on Reading Passage 1 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">Green roofs</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p><strong>A</strong> Rooftops covered with grass, vegetable gardens and lush foliage are now a common sight in many cities around the world. More and more private companies and city authorities are investing in green roofs, drawn to their wide-ranging benefits. Among the benefits are saving on energy costs, mitigating the risk of floods, making habitats for urban wildlife, tackling air pollution and even growing food. These increasingly radical urban designs can help cities adapt to the monumental problems they face, such as access to resources and a lack of green space due to development. But the involvement of city authorities, businesses and other institutions is crucial to ensuring their success – as is research investigating different options to suit the variety of rooftop spaces found in cities. The UK is relatively new to developing green roofs, and local governments and institutions are playing a major role in spreading the practice. London is home to much of the UK's green roof market, mainly due to forward-thinking policies such as the London Plan, which has paved the way to more than doubling the area of green roofs in the capital.</p>

                        <p><strong>B</strong> Ongoing research is showcasing how green roofs in cities can integrate with 'living walls': environmentally friendly walls which are partially or completely covered with greenery, including a growing medium, such as soil or water. Research also indicates that green roofs can be integrated with drainage systems on the ground, such as street trees, so that the water is managed better and the built environment is made more sustainable. There is also evidence to demonstrate the social value of green roofs. Doctors are increasingly prescribing time spent gardening outdoors for patients dealing with anxiety and depression. And research has found that access to even the most basic green spaces can provide a better quality of life for dementia sufferers and help people avoid obesity.</p>

                        <p><strong>C</strong> In North America, green roofs have become mainstream, with a wide array of expansive, accessible and food-producing roofs installed in buildings. Again, city leaders and authorities have helped push the movement forward – only recently, San Francisco, USA, created a policy requiring new buildings to have green roofs. Toronto, Canada, has policies dating from the 1990s, encouraging the development of urban farms on rooftops. These countries also benefit from having newer buildings than in many parts of the world, which makes it easier to install green roofs. Being able to keep enough water at roof height and distribute it right across the rooftop is crucial to maintaining the plants on any green roof – especially on 'edible roofs' where fruit and vegetables are farmed. And it's much easier to do this in newer buildings, which can typically hold greater weight, than to retro-fit old ones. Having a stronger roof also makes it easier to grow a greater variety of plants, since the soil can be deeper.</p>

                        <p><strong>D</strong> For green roofs to become the norm for new developments, there needs to be support from public authorities and private investors. Those responsible for maintaining buildings may have to acquire new skills, such as landscaping, and in some cases, volunteers may be needed to help out. Other considerations include installing drainage paths, meeting health and safety requirements and perhaps allowing access for the public, as well as planning restrictions and disruption from regular activities in and around the buildings during installation. To convince investors and developers that installing green roofs is worthwhile, economic arguments are still the most important. The term 'natural capital' has been developed to explain the economic value of nature; for example, measuring the money saved by installing natural solutions to protect against flood damage, adapt to climate change or help people lead healthier and happier lives.</p>

                        <p><strong>E</strong> As the expertise about green roofs grows, official standards have been developed to ensure that they are designed, constructed and maintained properly, and function well. Improvements in the science and technology underpinning green roof development have also led to new variations in the concept. For example, 'blue roofs' enable buildings to hold water over longer periods of time, rather than draining it away quickly – crucial in times of heavier rainfall. There are also combinations of green roofs with solar panels, and 'brown roofs' which are wilder in nature and maximise biodiversity. If the trend continues, it could create new jobs and a more vibrant and sustainable local food economy – alongside many other benefits. There are still barriers to overcome, but the evidence so far indicates that green roofs have the potential to transform cities and help them function sustainably long into the future. The success stories need to be studied and replicated elsewhere, to make green, blue, brown and food-producing roofs the norm in cities around the world.</p>
                    </div>
                </div>

                {{-- Passage 2: The growth mindset --}}
                <div class="mb-6 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">The growth mindset</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p>Over the past century, a powerful idea has taken root in the educational landscape. The concept of intelligence as something innate has been supplanted by the idea that intelligence is not fixed, and that, with the right training, we can be the authors of our own cognitive capabilities. Psychologist Alfred Binet, the developer of the first intelligence tests, was one of many 19th-century scientists who held that earlier view and sought to quantify cognitive ability. Then, in the early 20th century, progressive thinkers revolted against the notion that inherent ability is destiny. Instead, educators such as John Dewey argued that every child's intelligence could be developed, given the right environment.</p>

                        <p>'Growth mindset theory' is a relatively new – and extremely popular – version of this idea. In many schools today you will see hallways covered in motivational posters and hear speeches on the mindset of great sporting heroes who simply <em>believed</em> their way to the top. A major focus of the growth mindset in schools is coaxing students away from seeing failure as an indication of their ability, and towards seeing it as a chance to improve that ability. As educationalist Jeff Howard noted several decades ago: 'Smart is not something that you just are, smart is something that you can get.'</p>

                        <p>The idea of the growth mindset is based on the work of psychologist Carol Dweck in California in the 1990s. In one key experiment, Dweck divided a group of 10- to 12-year-olds into two groups. All were told that they had achieved a high score on a test but the first group were praised for their intelligence in achieving this, while the others were praised for their effort. The second group – those who had been instilled with a 'growth mindset' – were subsequently far more likely to put effort into future tasks. Meanwhile, the former took on only those tasks that would not risk their sense of worth. This group had inferred that success or failure is due to innate ability, and this 'fixed mindset' had led them to fear of failure and lack of effort. Praising ability actually made the students perform worse, while praising effort emphasised that change was possible.</p>

                        <p>One of the greatest impediments to successfully implementing a growth mindset, however, is the education system itself: in many parts of the world, the school climate is obsessed with performance in the form of constant testing, analysing and ranking of students – a key characteristic of the fixed mindset. Nor is it unusual for schools to create a certain cognitive dissonance, when they applaud the benefits of a growth mindset but then hand out fixed target grades in lessons based on performance.</p>

                        <p>Aside from the implementation problem, the original growth mindset research has also received harsh criticism. The statistician Andrew Gelman claims that 'their research designs have enough degrees of freedom that they could take their data to support just about any theory at all'. Professor of Psychology Timothy Bates, who has been trying to replicate Dweck's work, is finding that the results are repeatedly null. He notes that: 'People with a growth mindset don't cope any better with failure … Kids with the growth mindset aren't getting better grades, either before or after our intervention study.'</p>

                        <p>Much of this criticism is not lost on Dweck, and she deserves great credit for responding to it and adapting her work accordingly. In fact, she argues that her work has been misunderstood and misapplied in a range of ways. She has also expressed concerns that her theories are being misappropriated in schools by being conflated with the self-esteem movement: 'For me the growth mindset is a tool for learning and improvement. It's not just a vehicle for making children feel good.'</p>

                        <p>But there is another factor at work here. The failure to translate the growth mindset into the classroom might reflect a misunderstanding of the nature of teaching and learning itself. Growth mindset supporters David Yeager and Gregory Walton claim that interventions should be delivered in a subtle way to maximise their effectiveness. They say that if adolescents perceive a teacher's intervention as conveying that they are in need of help, this could undo its intended effects.</p>

                        <p>A lot of what drives students is their innate beliefs and how they perceive themselves. There is a strong correlation between self-perception and achievement, but there is evidence to suggest that the actual effect of achievement on self-perception is stronger than the other way round. To stand up in a classroom and successfully deliver a good speech is a genuine achievement, and that is likely to be more powerfully motivating than vague notions of 'motivation' itself.</p>

                        <p>Recent evidence would suggest that growth mindset interventions are not the elixir of student learning that its proponents claim it to be. The growth mindset appears to be a viable construct in the lab, which, when administered in the classroom via targeted interventions, doesn't seem to work. It is hard to dispute that having faith in the capacity to change is a good attribute for students. Paradoxically, however, that aspiration is not well served by direct interventions that try to instil it.</p>

                        <p>Motivational posters and talks are often a waste of time, and might well give students a deluded notion of what success actually means. Teaching concrete skills such as how to write an effective introduction to an essay then praising students' effort in getting there is probably a far better way of improving confidence than telling them how unique they are, or indeed how capable they are of changing their own brains. Perhaps growth mindset works best as a philosophy and not an intervention.</p>
                    </div>
                </div>

                {{-- Passage 3: Alfred Wegener --}}
                <div class="mb-6 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-1">Alfred Wegener: science, exploration and the theory of continental drift</h3>
                    <p class="text-center italic text-gray-600 mb-6 text-[15px]">by Mott T Greene</p>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p class="font-bold">Introduction</p>

                        <p>This is a book about the life and scientific work of Alfred Wegener, whose reputation today rests with his theory of continental displacements, better known as 'continental drift'. Wegener proposed this theory in 1912 and developed it extensively for nearly 20 years. His book on the subject, <em>The Origin of Continents and Oceans</em>, went through four editions and was the focus of an international controversy in his lifetime and for some years after his death.</p>

                        <p>Wegener's basic idea was that many mysteries about the Earth's history could be solved if one supposed that the continents moved laterally, rather than supposing that they remained fixed in place. Wegener showed in great detail how such continental movements were plausible and how they worked, using evidence from a large number of sciences including geology, geophysics, paleontology, and climatology. Wegener's idea – that the continents move – is at the heart of the theory that guides Earth sciences today: namely plate tectonics. Plate tectonics is in many respects quite different from Wegener's proposal, in the same way that modern evolutionary theory is very different from the ideas Charles Darwin proposed in the 1850s about biological evolution. Yet plate tectonics is a descendant of Alfred Wegener's theory of continental drift, in quite the same way that modern evolutionary theory is a descendant of Darwin's theory of natural selection.</p>

                        <p>When I started writing about Wegener's life and work, one of the most intriguing things about him for me was that, although he came up with a theory on continental drift, he was not a geologist. He trained as an astronomer and pursued a career in atmospheric physics. When he proposed the theory of continental displacements in 1912, he was a lecturer in physics and astronomy at the University of Marburg, in southern Germany. However, he was not an 'unknown'. In 1906 he had set a world record (with his brother Kurt) for time aloft in a hot-air balloon: 52 hours. Between 1906 and 1908 he had taken part in a highly publicized and extremely dangerous expedition to the coast of northeast Greenland. He had also made a name for himself amongst a small circle of meteorologists and atmospheric physicists in Germany as the author of a textbook, <em>Thermodynamics of the Atmosphere</em> (1911), and of a number of interesting scientific papers.</p>

                        <p>As important as Wegener's work on continental drift has turned out to be, it was largely a sideline to his interest in atmospheric physics, geophysics, and paleoclimatology*, and thus I have been at great pains to put Wegener's work on continental drift in the larger context of his other scientific work, and in the even larger context of atmospheric sciences in his lifetime. This is a 'continental drift book' only to the extent that Wegener was interested in that topic and later became famous for it. My treatment of his other scientific work is no less detailed, though I certainly have devoted more attention to the reception of his ideas on continental displacement, as they were much more controversial than his other work.</p>

                        <p>Readers interested in the specific detail of Wegener's career will see that he often stopped pursuing a given line of investigation (sometimes for years on end), only to pick it up later. I have tried to provide guideposts to his rapidly shifting interests by characterizing different phases of his life as careers in different sciences, which is reflected in the titles of the chapters. Thus, the index should be a sufficient guide for those interested in a particular aspect of Wegener's life but perhaps not all of it. My own feeling, however, is that the parts do not make as much sense on their own as do all of his activities taken together. In this respect I urge readers to try to experience Wegener's life as he lived it, with all the interruptions, changes of mind, and renewed efforts this entailed.</p>

                        <p>Wegener left behind a few published works but, as was standard practice, these reported the results of his work – not the journey he took to reach that point. Only a few hundred of the many thousands of letters he wrote and received in his lifetime have survived and he didn't keep notebooks or diaries that recorded his life and activities. He was not active (with a few exceptions) in scientific societies, and did not seek to find influence or advance his ideas through professional contacts and politics, spending most of his time at home in his study reading and writing, or in the field collecting observations.</p>

                        <p>Some famous scientists, such as Newton, Darwin, and Einstein, left mountains of written material behind, hundreds of notebooks and letters numbering in the tens of thousands. Others, like Michael Faraday, left extensive journals of their thoughts and speculations, parallel to their scientific notebooks. The more such material a scientist leaves behind, the better chance a biographer has of forming an accurate picture of how a scientist's ideas took shape and evolved.</p>

                        <p>I am firmly of the opinion that most of us, Wegener included, are not in any real sense the authors of our own lives. We plan, think, and act, often with apparent freedom, but most of the time our lives 'happen to us', and we only retrospectively turn this happenstance into a coherent narrative of fulfilled intentions. This book, therefore, is a story both of the life and scientific work that Alfred Wegener planned and intended and of the life and scientific work that actually 'happened to him'. These are, as I think you will soon see, not always the same thing.</p>

                        <p class="text-xs text-gray-500 border-t border-gray-300 pt-3 mt-3">* Paleoclimatology – The study of past climates</p>
                    </div>
                </div>

            </div>

            {{-- Annotation toolbar --}}
            <div class="sticky bottom-6 flex flex-col items-center z-30 pointer-events-none gap-3">
                <div x-show="highlightMode" x-transition class="flex items-center gap-2 pointer-events-auto bg-white/80 p-1.5 rounded-full backdrop-blur-md shadow-lg border border-gray-200/50">
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

        {{-- RIGHT: Questions --}}
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar">
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto">

                {{-- PASSAGE 1 QUESTIONS header --}}
                <div class="flex justify-center mb-6">
                    <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 1</span>
                </div>

                {{-- Questions 1–5: Paragraph matching A-E --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–5</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 1 has five paragraphs, <strong>A–E</strong>.</p>
                    <p class="text-sm text-gray-800 mb-3">Which paragraph contains the following information?</p>
                    <p class="text-sm italic text-gray-700 mb-2">Write the correct letter, <strong>A–E</strong>, in boxes 1–5 on your answer sheet.</p>
                    <p class="text-sm text-gray-700 mb-5"><strong>NB</strong> You may use any letter more than once.</p>

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
                                    [1, 'mention of several challenges to be overcome before a green roof can be installed'],
                                    [2, 'reference to a city where green roofs have been promoted for many years'],
                                    [3, 'a belief that existing green roofs should be used as a model for new ones'],
                                    [4, 'examples of how green roofs can work in combination with other green urban initiatives'],
                                    [5, 'the need to make a persuasive argument for the financial benefits of green roofs'],
                                ] as [$num, $info])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $info }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                            <option value="" disabled selected>–</option>
                                            @foreach(range('A','E') as $l)
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

                {{-- Questions 6–9: Summary completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 6–9</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary below.</p>
                    <p class="text-sm text-gray-800 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 6–9 on your answer sheet.</p>

                    <div class="border border-gray-300 rounded-xl p-5 bg-gray-50">
                        <h4 class="text-lg font-bold text-center text-gray-900 mb-4">Advantages of green roofs</h4>

                        <div class="text-sm text-gray-800 leading-relaxed space-y-4">
                            <p>City rooftops covered with greenery have many advantages. These include lessening the likelihood that floods will occur, reducing how much money is spent on
                                <span class="font-bold">6</span>
                                <input type="text" class="border-b-2 border-gray-400 outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400 mx-1" placeholder="Answer">
                                and creating environments that are suitable for wildlife. In many cases, they can also be used for producing
                                <span class="font-bold">7</span>
                                <input type="text" class="border-b-2 border-gray-400 outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400 mx-1" placeholder="Answer">
                                .
                            </p>

                            <p>There are also social benefits of green roofs. For example, the medical profession recommends
                                <span class="font-bold">8</span>
                                <input type="text" class="border-b-2 border-gray-400 outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400 mx-1" placeholder="Answer">
                                as an activity to help people cope with mental health issues. Studies have also shown that the availability of green spaces can prevent physical problems such as
                                <span class="font-bold">9</span>
                                <input type="text" class="border-b-2 border-gray-400 outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400 mx-1" placeholder="Answer">
                                .
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Questions 10–11: Choose TWO --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 10 and 11</strong></p>
                    <p class="text-sm italic text-gray-800 mb-1">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-3">Write the correct letters in boxes 10 and 11 on your answer sheet.</p>
                    <p class="text-sm text-gray-800 mb-5">Which <strong>TWO</strong> advantages of using newer buildings for green roofs are mentioned in Paragraph C of the passage?</p>

                    <div class="space-y-3 ml-2" data-max-checks="2">
                        @foreach([
                            ['A', 'a longer growing season for edible produce'],
                            ['B', 'more economical use of water'],
                            ['C', 'greater water-storage capacity'],
                            ['D', 'ability to cultivate more plant types'],
                            ['E', 'a large surface area for growing plants'],
                        ] as [$letter, $text])
                        <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="checkbox" name="q10_11[]" value="{{ $letter }}" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm"><strong>{{ $letter }}</strong> {{ $text }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Questions 12–13: Choose TWO --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 12 and 13</strong></p>
                    <p class="text-sm italic text-gray-800 mb-1">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-3">Write the correct letters in boxes 12 and 13 on your answer sheet.</p>
                    <p class="text-sm text-gray-800 mb-5">Which <strong>TWO</strong> aims of new variations on the concept of green roofs are mentioned in Paragraph E of the passage?</p>

                    <div class="space-y-3 ml-2" data-max-checks="2">
                        @foreach([
                            ['A', 'to provide habitats for a wide range of species'],
                            ['B', 'to grow plants successfully even in the wettest climates'],
                            ['C', 'to regulate the temperature of the immediate environment'],
                            ['D', 'to generate power from a sustainable source'],
                            ['E', 'to collect water to supply other buildings'],
                        ] as [$letter, $text])
                        <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                            <input type="checkbox" name="q12_13[]" value="{{ $letter }}" class="mt-1 w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm"><strong>{{ $letter }}</strong> {{ $text }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- PASSAGE 2 QUESTIONS header --}}
                <div class="flex justify-center mb-6 mt-10">
                    <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                </div>

                {{-- Questions 14–16: MCQ A-D --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–16</strong></p>
                    <p class="text-sm italic text-gray-800 mb-1">Choose the correct letter, <strong>A, B, C or D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 14–16 on your answer sheet.</p>

                    @foreach([
                        [14, 'What can we learn from the first paragraph?', ['A' => 'where the notion of innate intelligence first began', 'B' => 'when ideas about the nature of intelligence began to shift', 'C' => 'how scientists have responded to changing views of intelligence', 'D' => 'why thinkers turned away from the idea of intelligence being fixed']],
                        [15, 'The second paragraph describes how schools encourage students to', ['A' => 'identify their personal ambitions.', 'B' => 'help each other to realise their goals.', 'C' => 'have confidence in their potential to succeed.', 'D' => 'concentrate on where their particular strengths lie.']],
                        [16, 'In the third paragraph, the writer suggests that students with a fixed mindset', ['A' => 'tend to be less competitive.', 'B' => 'generally have a low sense of self-esteem.', 'C' => 'will only work hard if they are given constant encouragement.', 'D' => 'are afraid to push themselves beyond what they see as their limitations.']],
                    ] as [$num, $question, $options])
                    <div class="mb-6 p-4 {{ $loop->even ? 'bg-gray-50' : '' }} rounded-lg">
                        <p class="mb-3 text-sm"><strong>{{ $num }}</strong> {{ $question }}</p>
                        <div class="space-y-2 ml-6">
                            @foreach($options as $letter => $text)
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-100 p-1.5 rounded">
                                <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="text-sm"><strong>{{ $letter }}</strong> {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Questions 17–22: Matching people --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 17–22</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Look at the following statements (Questions 17–22) and the list of people below.</p>
                    <p class="text-sm text-gray-800 mb-1">Match each statement with the correct person or people, <strong>A–E</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-2">Write the correct letter, <strong>A–E</strong>, in boxes 17–22 on your answer sheet.</p>
                    <p class="text-sm text-gray-700 mb-5"><strong>NB</strong> You may use any letter more than once.</p>

                    {{-- List of People box --}}
                    <div class="border border-gray-400 rounded-xl p-5 mb-6 bg-gray-50">
                        <p class="text-center font-bold mb-3 text-sm">List of People</p>
                        <div class="space-y-2 text-sm">
                            <div><strong>A</strong> Alfred Binet</div>
                            <div><strong>B</strong> Carol Dweck</div>
                            <div><strong>C</strong> Andrew Gelman</div>
                            <div><strong>D</strong> Timothy Bates</div>
                            <div><strong>E</strong> David Yeager and Gregory Walton</div>
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
                                    [17, 'The methodology behind the growth mindset studies was not strict enough.'],
                                    [18, 'The idea of the growth mindset has been incorrectly interpreted.'],
                                    [19, 'Intellectual ability is an unchangeable feature of each individual.'],
                                    [20, 'The growth mindset should be promoted without students being aware of it.'],
                                    [21, 'The growth mindset is not simply about boosting students\' morale.'],
                                    [22, 'Research shows that the growth mindset has no effect on academic achievement.'],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                            <option value="" disabled selected>–</option>
                                            @foreach(range('A','E') as $l)
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

                {{-- Questions 23–26: Yes/No/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 23–26</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the views of the writer in Reading Passage 2?</p>
                    <p class="text-sm italic text-gray-700 mb-2">In boxes 23–26 on your answer sheet, write</p>
                    <div class="text-sm text-gray-700 mb-5 ml-4 space-y-1">
                        <p><strong class="italic">YES</strong> <span class="ml-4 italic">if the statement agrees with the views of the writer</span></p>
                        <p><strong class="italic">NO</strong> <span class="ml-4 italic">if the statement contradicts the views of the writer</span></p>
                        <p><strong class="italic">NOT GIVEN</strong> <span class="ml-4 italic">if it is impossible to say what the writer thinks about this</span></p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-28 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [23, 'Dweck has handled criticisms of her work in an admirable way.'],
                                    [24, 'Students\' self-perception is a more effective driver of self-confidence than actual achievement is.'],
                                    [25, 'Recent evidence about growth mindset interventions has attracted unfair coverage in the media.'],
                                    [26, 'Deliberate attempts to encourage students to strive for high achievement may have a negative effect.'],
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

                {{-- PASSAGE 3 QUESTIONS header --}}
                <div class="flex justify-center mb-6 mt-10">
                    <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                </div>

                {{-- Questions 27–30: Yes/No/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–30</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the claims of the writer in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-2">In boxes 27–30 on your answer sheet, write</p>
                    <div class="text-sm text-gray-700 mb-5 ml-4 space-y-1">
                        <p><strong class="italic">YES</strong> <span class="ml-4 italic">if the statement agrees with the claims of the writer</span></p>
                        <p><strong class="italic">NO</strong> <span class="ml-4 italic">if the statement contradicts the claims of the writer</span></p>
                        <p><strong class="italic">NOT GIVEN</strong> <span class="ml-4 italic">if it is impossible to say what the writer thinks about this</span></p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-28 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [27, 'Wegener\'s ideas about continental drift were widely disputed while he was alive.'],
                                    [28, 'The idea that the continents remained fixed in place was defended in a number of respected scientific publications.'],
                                    [29, 'Wegener relied on a limited range of scientific fields to support his theory of continental drift.'],
                                    [30, 'The similarities between Wegener\'s theory of continental drift and modern-day plate tectonics are enormous.'],
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

                {{-- Questions 31–36: Summary completion with phrases A-J --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 31–36</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary using the list of phrases, <strong>A–J</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–J</strong>, in boxes 31–36 on your answer sheet.</p>

                    <div class="border border-gray-300 rounded-xl p-5 bg-gray-50 mb-6">
                        <h4 class="text-lg font-bold text-center text-gray-900 mb-4">Wegener's life and work</h4>

                        <div class="text-sm text-gray-800 leading-relaxed space-y-3">
                            <p>One of the remarkable things about Wegener from a
                                <span class="font-bold">31</span>
                                <select name="q31" class="appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer w-14 mx-1">
                                    <option value="" disabled selected>–</option>
                                    @foreach(range('A','J') as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                                </select>
                                is that although he proposed a theory of continental drift, he was not a geologist. His
                                <span class="font-bold">32</span>
                                <select name="q32" class="appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer w-14 mx-1">
                                    <option value="" disabled selected>–</option>
                                    @foreach(range('A','J') as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                                </select>
                                were limited to atmospheric physics. However, at the time he proposed his theory of continental drift in 1912, he was already a person of
                                <span class="font-bold">33</span>
                                <select name="q33" class="appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer w-14 mx-1">
                                    <option value="" disabled selected>–</option>
                                    @foreach(range('A','J') as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                                </select>
                                . Six years previously, there had been his
                                <span class="font-bold">34</span>
                                <select name="q34" class="appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer w-14 mx-1">
                                    <option value="" disabled selected>–</option>
                                    @foreach(range('A','J') as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                                </select>
                                of 52 hours in a hot-air balloon, followed by his well-publicised but
                                <span class="font-bold">35</span>
                                <select name="q35" class="appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer w-14 mx-1">
                                    <option value="" disabled selected>–</option>
                                    @foreach(range('A','J') as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                                </select>
                                of Greenland's coast. With the publication of his textbook on thermodynamics, he had also come to the attention of a
                                <span class="font-bold">36</span>
                                <select name="q36" class="appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-2 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer w-14 mx-1">
                                    <option value="" disabled selected>–</option>
                                    @foreach(range('A','J') as $l)<option value="{{ $l }}">{{ $l }}</option>@endforeach
                                </select>
                                of German scientists.
                            </p>
                        </div>
                    </div>

                    {{-- Phrase options box --}}
                    <div class="border border-gray-400 rounded-xl p-5 bg-gray-50">
                        <div class="grid grid-cols-3 gap-3 text-sm">
                            <div><strong>A</strong> modest fame</div>
                            <div><strong>B</strong> vast range</div>
                            <div><strong>C</strong> record-breaking achievement</div>
                            <div><strong>D</strong> research methods</div>
                            <div><strong>E</strong> select group</div>
                            <div><strong>F</strong> professional interests</div>
                            <div><strong>G</strong> scientific debate</div>
                            <div><strong>H</strong> hazardous exploration</div>
                            <div><strong>I</strong> biographer's perspective</div>
                            <div><strong>J</strong> narrow investigation</div>
                        </div>
                    </div>
                </div>

                {{-- Questions 37–40: MCQ A-D --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 37–40</strong></p>
                    <p class="text-sm italic text-gray-800 mb-1">Choose the correct letter, <strong>A, B, C or D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 37–40 on your answer sheet.</p>

                    @foreach([
                        [37, 'What is Mott T Greene doing in the fifth paragraph?', ['A' => 'describing what motivated him to write the book', 'B' => 'explaining why it is desirable to read the whole book', 'C' => 'suggesting why Wegener pursued so many different careers', 'D' => 'indicating what aspects of Wegener\'s life interested him most']],
                        [38, 'What is said about Wegener in the sixth paragraph?', ['A' => 'He was not a particularly ambitious person.', 'B' => 'He kept a record of all his scientific observations.', 'C' => 'He did not adopt many of the scientific practices of the time.', 'D' => 'He enjoyed discussing new discoveries with other scientists.']],
                        [39, 'What does Greene say about some other famous scientists?', ['A' => 'Their published works had a greater impact than Wegener\'s did.', 'B' => 'They had fewer doubts about their scientific ideas than Wegener did.', 'C' => 'Their scientific ideas were more controversial than Wegener\'s.', 'D' => 'They are easier subjects to write about than Wegener.']],
                        [40, 'What is Greene\'s main point in the final paragraph?', ['A' => 'It is not enough in life to have good intentions.', 'B' => 'People need to plan carefully if they want to succeed.', 'C' => 'People have little control over many aspects of their lives.', 'D' => 'It is important that people ensure they have the freedom to act.']],
                    ] as [$num, $question, $options])
                    <div class="mb-6 p-4 {{ $loop->even ? 'bg-gray-50' : '' }} rounded-lg">
                        <p class="mb-3 text-sm"><strong>{{ $num }}</strong> {{ $question }}</p>
                        <div class="space-y-2 ml-6">
                            @foreach($options as $letter => $text)
                            <label class="flex items-start gap-3 cursor-pointer hover:bg-gray-100 p-1.5 rounded">
                                <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <span class="text-sm"><strong>{{ $letter }}</strong> {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Submit --}}
                <div class="flex justify-center mt-8">
                    <button class="px-10 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl shadow-lg transition-all hover:-translate-y-0.5">
                        Submit Answers
                    </button>
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

/* ── Choose TWO checkbox limiter ── */
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-max-checks]').forEach(group => {
        const max = parseInt(group.dataset.maxChecks);
        const checkboxes = group.querySelectorAll('input[type="checkbox"]');
        let checkedOrder = [];
        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                if (this.checked) {
                    checkedOrder.push(this);
                    if (checkedOrder.length > max) {
                        const oldest = checkedOrder.shift();
                        oldest.checked = false;
                    }
                } else {
                    checkedOrder = checkedOrder.filter(item => item !== this);
                }
            });
        });
    });
});
</script>

</body>
</html>

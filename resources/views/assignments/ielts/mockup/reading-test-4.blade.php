<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mock Test {{ $testId }} – IELTS Reading | {{ config('app.name', 'Target Bahasa') }}</title>
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
                    <h1 class="text-3xl font-bold text-gray-800">Reading Mock Test 4</h1>
                    <p class="text-sm text-gray-500">Cambridge IELTS Reading Practice</p>
                </div>
            </div>
            <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId]) }}" class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
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

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">Roman tunnels</h3>
                    <p class="text-[15px] italic text-gray-700 mb-8 text-center max-w-3xl mx-auto">The Romans, who once controlled areas of Europe, North Africa and Asia Minor, adopted the construction techniques of other civilizations to build tunnels in their territories</p>

                        {{-- Passage text --}}
                        <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                             @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                             @click="if(eraserMode) window.removeHighlight($event);">

                            <p>The Persians, who lived in present-day Iran, were one of the first civilizations to build tunnels that provided a reliable supply of water to human settlements in dry areas. In the early first millennium BCE, they introduced the <em>qanat</em> method of tunnel construction, which consisted of placing posts over a hill in a straight line, to ensure that the tunnel kept to its route, and then digging vertical shafts down into the ground at regular intervals. Underground, workers removed the earth from between the ends of the shafts, creating a tunnel. The excavated soil was taken up to the surface using the shafts, which also provided ventilation during the work. Once the tunnel was completed, it allowed water to flow from the top of a hillside down towards a canal, which supplied water for human use. Remarkably, some <em>qanats</em> built by the Persians 2,700 years ago are still in use today.</p>

                            <p>They later passed on their knowledge to the Romans, who also used the <em>qanat</em> method to construct water-supply tunnels for agriculture. Roman <em>qanat</em> tunnels were constructed with vertical shafts dug at intervals of between 30 and 60 meters. The shafts were equipped with handholds and footholds to help those climbing in and out of them and were covered with a wooden or stone lid. To ensure that the shafts were vertical, Romans hung a plumb line from a rod placed across the top of each shaft and made sure that the weight at the end of it hung in the center of the shaft. Plumb lines were also used to measure the depth of the shaft and to determine the slope of the tunnel. The 5.6-kilometer-long Claudius tunnel, built in 41 CE to drain the Fucine Lake in central Italy, had shafts that were up to 122 meters deep, took 11 years to build and involved approximately 30,000 workers.</p>

                            <p>By the 6th century BCE, a second method of tunnel construction appeared called the <em>counter-excavation</em> method, in which the tunnel was constructed from both ends. It was used to cut through high mountains when the <em>qanat</em> method was not a practical alternative. This method required greater planning and advanced knowledge of surveying, mathematics and geometry as both ends of a tunnel had to meet correctly at the center of the mountain. Adjustments to the direction of the tunnel also had to be made whenever builders encountered geological problems or when it deviated from its set path. They constantly checked the tunnel's advancing direction, for example, by looking back at the light that penetrated through the tunnel mouth, and made corrections whenever necessary. Large deviations could happen, and they could result in one end of the tunnel not being usable. An inscription written on the side of a 428-meter tunnel, built by the Romans as part of the Saldae aqueduct system in modern-day Algeria, describes how the two teams of builders missed each other in the mountain and how the later construction of a lateral link between both corridors corrected the initial error.</p>

                            <p>The Romans dug tunnels for their roads using the counter-excavation method, whenever they encountered obstacles such as hills or mountains that were too high for roads to pass over. An example is the 37-meter-long, 6-meter-high, Furlo Pass Tunnel built in Italy in 69–79 CE. Remarkably, a modern road still uses this tunnel today. Tunnels were also built for mineral extraction. Miners would locate a mineral vein and then pursue it with shafts and tunnels underground. Traces of such tunnels used to mine gold can still be found at the Dolaucothi mines in Wales. When the sole purpose of a tunnel was mineral extraction, construction required less planning, as the tunnel route was determined by the mineral vein.</p>

                            <p>Roman tunnel projects were carefully planned and carried out. The length of time it took to construct a tunnel depended on the method being used and the type of rock being excavated. The <em>qanat</em> construction method was usually faster than the counter-excavation method as it was more straightforward. This was because the mountain could be excavated not only from the tunnel mouths but also from shafts. The type of rock could also influence construction times. When the rock was hard, the Romans employed a technique called fire quenching which consisted of heating the rock with fire, and then suddenly cooling it with cold water so that it would crack. Progress through hard rock could be very slow, and it was not uncommon for tunnels to take years, if not decades, to be built. Construction marks left on a Roman tunnel in Bologna show that the rate of advance through solid rock was 30 centimeters per day. In contrast, the rate of advance of the Claudius tunnel can be calculated at 1.4 meters per day. Most tunnels had inscriptions showing the names of patrons who ordered construction and sometimes the name of the architect. For example, the 1.4-kilometer Çevlik tunnel in Turkey, built to divert the floodwater threatening the harbor of the ancient city of Seleuceia Pieria, had inscriptions on the entrance, still visible today, that also indicate that the tunnel was started in 69 CE and was completed in 81 CE.</p>
                        </div>

                        {{-- Floating Annotation Toolbar --}}


                </div>

                {{-- Passage 2 --}}
                <div class="mb-6 pt-10 border-t border-gray-200 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-4">Changes in reading habits</h3>
                    <p class="text-[15px] italic text-gray-700 mb-8 text-center max-w-3xl mx-auto block">What are the implications of the way we read today?</p>

                    {{-- Passage text --}}
                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p>Look around on your next plane trip. The iPad is the new pacifier for babies and toddlers. Younger school-aged children read stories on smartphones; older kids don't read at all, but hunch over video games. Parents and other passengers read on tablets or skim a flotilla of email and news feeds. Unbeknown to most of us, an invisible, game-changing transformation links everyone in this picture: the neuronal circuit that underlies the brain's ability to read is subtly, rapidly changing and this has implications for everyone from the pre-reading toddler to the expert adult.</p>

                        <p>As work in neurosciences indicates, the acquisition of literacy necessitated a new circuit in our species' brain more than 6,000 years ago. That circuit evolved from a very simple mechanism for decoding basic information, like the number of goats in one's herd, to the present, highly elaborated reading brain. My research depicts how the present reading brain enables the development of some of our most important intellectual and affective processes: internalized knowledge, analogical reasoning, and inference; perspective-taking and empathy; critical analysis and the generation of insight. Research surfacing in many parts of the world now cautions that each of these essential 'deep reading' processes may be under threat as we move into digital-based modes of reading.</p>
                        
                        <p>This is not a simple, binary issue of print versus digital reading and technological innovation. As MIT scholar Sherry Turkle has written, we do not err as a society when we innovate but when we ignore what we disrupt or diminish while innovating. In this hinge moment between print and digital cultures, society needs to confront what is diminishing in the expert reading circuit, what our children and older students are not developing, and what we can do about it.</p>

                        <p>We know from research that the reading circuit is not given to human beings through a genetic blueprint like vision or language; it needs an environment to develop. Further, it will adapt to that environment's requirements – from different writing systems to the characteristics of whatever medium is used. If the dominant medium advantages processes that are fast, multi-task oriented and well-suited for large volumes of information, like the current digital medium, so will the reading circuit. As UCLA psychologist Patricia Greenfield writes, the result is that less attention and time will be allocated to slower, time-demanding deep reading processes.</p>

                        <p>Increasing reports from educators and from researchers in psychology and the humanities bear this out. English literature scholar and teacher Mark Edmundson describes how many college students actively avoid the classic literature of the 19th and 20th centuries in favour of something simpler as they no longer have the patience to read longer, denser, more difficult texts. We should be less concerned with students' 'cognitive impatience', however, than by what may underlie it: the potential inability of large numbers of students to read with a level of critical analysis sufficient to comprehend the complexity of thought and argument found in more demanding texts.</p>

                        <p>Multiple studies show that digital screen use may be causing a variety of troubling downstream effects on reading comprehension in older high school and college students. In Stavanger, Norway, psychologist Anne Mangen and her colleagues studied how high school students comprehend the same material in different mediums. Mangen's group asked subjects questions about a short story whose plot had universal student appeal; half of the students read the story on a tablet, the other half in paperback. Results indicated that students who read on print were superior in their comprehension to screen-reading peers, particularly in their ability to sequence detail and reconstruct the plot in chronological order.</p>

                        <p>Ziming Liu from San Jose State University has conducted a series of studies which indicate that the 'new norm' in reading is skimming, involving word-spotting and browsing through the text. Many readers now use a pattern when reading in which they sample the first line and then word-spot through the rest of the text. When the reading brain skims like this, it reduces time allocated to deep reading processes. In other words, we don't have time to grasp complexity, to understand another's feelings, to perceive beauty, and to create thoughts of the reader's own.</p>

                        <p>The possibility that critical analysis, empathy and other deep reading processes could become the unintended 'collateral damage' of our digital culture is not a straightforward binary issue about print versus digital reading. It is about how we all have begun to read on various mediums and how that changes not only what we read, but also the purposes for which we read. Nor is it only about the young. The subtle atrophy of critical analysis and empathy affects us all equally. It affects our ability to navigate a constant bombardment of information. It incentivizes a retreat to the most familiar stores of unchecked information, which require and receive no analysis, leaving us susceptible to false information and irrational ideas.</p>

                        <p>There's an old rule in neuroscience that does not alter with age: use it or lose it. It is a very hopeful principle when applied to critical thought in the reading brain because it implies choice. The story of the changing reading brain is hardly finished. We possess both the science and the technology to identify and redress the changes in how we read before they become entrenched. If we work to understand exactly what we will lose, alongside the extraordinary new capacities that the digital world has brought us, there is as much reason for excitement as caution.</p>
                    </div>
                </div>

                {{-- Passage 3 --}}
                <div class="mb-6 pt-10 border-t border-gray-200 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-4">Attitudes towards Artificial Intelligence</h3>

                    {{-- Passage text --}}
                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p><span class="font-bold mr-2 text-lg">A</span>Artificial intelligence (AI) can already predict the future. Police forces are using it to map when and where crime is likely to occur. Doctors can use it to predict when a patient is most likely to have a heart attack or stroke. Researchers are even trying to give AI imagination so it can plan for unexpected consequences.</p>
                        <p>Many decisions in our lives require a good forecast, and AI is almost always better at forecasting than we are. Yet for all these technological advances, we still seem to deeply lack confidence in AI predictions. Recent cases show that people don't like relying on AI and prefer to trust human experts, even if these experts are wrong.</p>
                        <p>If we want AI to really benefit people, we need to find a way to get people to trust it. To do that, we need to understand why people are so reluctant to trust AI in the first place.</p>

                        <p><span class="font-bold mr-2 text-lg">B</span>Take the case of Watson for Oncology, one of technology giant IBM's supercomputer programs. Their attempt to promote this program to cancer doctors was a PR disaster. The AI promised to deliver top-quality recommendations on the treatment of 12 cancers that accounted for 80% of the world's cases. But when doctors first interacted with Watson, they found themselves in a rather difficult situation. On the one hand, if Watson provided guidance about a treatment that coincided with their own opinions, physicians did not see much point in Watson's recommendations. The supercomputer was simply telling them what they already knew, and these recommendations did not change the actual treatment.</p>
                        <p>On the other hand, if Watson generated a recommendation that contradicted the experts' opinion, doctors would typically conclude that Watson wasn't competent. And the machine wouldn't be able to explain why its treatment was plausible because its machine-learning algorithms were simply too complex to be fully understood by humans. Consequently, this has caused even more suspicion and disbelief, leading many doctors to ignore the seemingly outlandish AI recommendations and stick to their own expertise.</p>

                        <p><span class="font-bold mr-2 text-lg">C</span>This is just one example of people's lack of confidence in AI and their reluctance to accept what AI has to offer. Trust in other people is often based on our understanding of how others think and having experience of their reliability. This helps create a psychological feeling of safety. AI, on the other hand, is still fairly new and unfamiliar to most people. Even if it can be technically explained (and that's not always the case), AI's decision-making process is usually too difficult for most people to comprehend. And interacting with something we don't understand can cause anxiety and give us a sense that we're losing control.</p>
                        <p>Many people are also simply not familiar with many instances of AI actually working, because it often happens in the background. Instead, they are acutely aware of instances where AI goes wrong. Embarrassing AI failures receive a disproportionate amount of media attention, emphasising the message that we cannot rely on technology. Machine learning is not foolproof, in part because the humans who design it aren't.</p>

                        <p><span class="font-bold mr-2 text-lg">D</span>Feelings about AI run deep. In a recent experiment, people from a range of backgrounds were given various sci-fi films about AI to watch and then asked questions about automation in everyday life. It was found that, regardless of whether the film they watched depicted AI in a positive or negative light, simply watching a cinematic vision of our technological future polarised the participants' attitudes. Optimists became more extreme in their enthusiasm for AI and sceptics became even more guarded.</p>
                        <p>This suggests people use relevant evidence about AI in a biased manner to support their existing attitudes, a deep-rooted human tendency known as "confirmation bias". As AI is represented more and more in media and entertainment, it could lead to a society split between those who benefit from AI and those who reject it. More pertinently, refusing to accept the advantages offered by AI could place a large group of people at a serious disadvantage.</p>

                        <p><span class="font-bold mr-2 text-lg">E</span>Fortunately, we already have some ideas about how to improve trust in AI. Simply having previous experience with AI can significantly improve people's opinions about the technology, as was found in the study mentioned above. Evidence also suggests the more you use other technologies such as the internet, the more you trust them.</p>
                        <p>Another solution may be to reveal more about the algorithms which AI uses and the purposes they serve. Several high-profile social media companies and online marketplaces already release transparency reports about government requests and surveillance disclosures. A similar practice for AI could help people have a better understanding of the way algorithmic decisions are made.</p>

                        <p><span class="font-bold mr-2 text-lg">F</span>Research suggests that allowing people some control over AI decision-making could also improve trust and enable AI to learn from human experience. For example, one study showed that when people were allowed the freedom to slightly modify an algorithm, they felt more satisfied with its decisions, more likely to believe it was superior and more likely to use it in the future.</p>
                        <p>We don't need to understand the intricate inner workings of AI systems, but if people are given a degree of responsibility for how they are implemented, they will be more willing to accept AI into their lives.</p>
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

                {{-- Questions 1–6: Diagram Labelling --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–6</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Label the diagrams below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 1–6 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-white text-sm">
                        <h4 class="text-base font-bold text-center mb-6 text-gray-900">The Persian Qanat Method</h4>
                        
                        <!-- Diagram Image Placeholder -->
                        <div class="mb-6 flex justify-center">
                            <img src="{{ asset('assets/images/mockups/persian_qanat.png') }}" class="max-w-full h-auto border border-gray-200 shadow-sm bg-white" alt="Diagram: The Persian Qanat Method (Please upload persian_qanat.png to public/assets/images/mockups/)">
                        </div>

                        <div class="space-y-4 max-w-lg mx-auto mb-10 text-gray-800 leading-loose">
                            <div class="flex items-center gap-3">
                                <span class="font-bold text-blue-600">1</span>
                                <input type="text" name="q1" class="border-b border-gray-500 outline-none px-2 py-1 w-32 bg-white text-sm placeholder-gray-400 focus:border-blue-500 shadow-sm rounded-t-sm" placeholder="Answer">
                                <span>to direct the tunnelling</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span>water runs into a</span>
                                <span class="font-bold text-blue-600">2</span>
                                <input type="text" name="q2" class="border-b border-gray-500 outline-none px-2 py-1 w-32 bg-white text-sm placeholder-gray-400 focus:border-blue-500 shadow-sm rounded-t-sm" placeholder="Answer">
                                <span>used by local people</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span>vertical shafts to remove earth and for</span>
                                <span class="font-bold text-blue-600">3</span>
                                <input type="text" name="q3" class="border-b border-gray-500 outline-none px-2 py-1 w-32 bg-white text-sm placeholder-gray-400 focus:border-blue-500 shadow-sm rounded-t-sm" placeholder="Answer">
                            </div>
                        </div>

                        <h4 class="text-base font-bold text-center mb-6 text-gray-900 pt-6 border-t border-gray-300">Cross-section of a Roman Qanat Shaft</h4>
                        
                        <!-- Diagram Image Placeholder -->
                        <div class="mb-6 flex justify-center">
                            <img src="{{ asset('assets/images/mockups/roman_qanat.png') }}" class="max-w-full h-auto border border-gray-200 shadow-sm bg-white" alt="Diagram: Cross-section of a Roman Qanat Shaft (Please upload roman_qanat.png to public/assets/images/mockups/)">
                        </div>

                        <div class="space-y-4 max-w-lg mx-auto text-gray-800 leading-loose">
                            <div class="flex items-center gap-3">
                                <span class="font-bold text-blue-600">4</span>
                                <input type="text" name="q4" class="border-b border-gray-500 outline-none px-2 py-1 w-32 bg-white text-sm placeholder-gray-400 focus:border-blue-500 shadow-sm rounded-t-sm" placeholder="Answer">
                                <span>made of wood or stone</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="font-bold text-blue-600">5</span>
                                <input type="text" name="q5" class="border-b border-gray-500 outline-none px-2 py-1 w-32 bg-white text-sm placeholder-gray-400 focus:border-blue-500 shadow-sm rounded-t-sm" placeholder="Answer">
                                <span>attached to the plumb line</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span>handholds and footholds used for</span>
                                <span class="font-bold text-blue-600">6</span>
                                <input type="text" name="q6" class="border-b border-gray-500 outline-none px-2 py-1 w-32 bg-white text-sm placeholder-gray-400 focus:border-blue-500 shadow-sm rounded-t-sm" placeholder="Answer">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Questions 7–10: True/False/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 7–10</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 1?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 7–10 on your answer sheet, write</p>

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
                                    [7, "The counter-excavation method completely replaced the qanat method in the 6th century BCE."],
                                    [8, "Only experienced builders were employed to construct a tunnel using the counter-excavation method."],
                                    [9, "The information about a problem that occurred during the construction of the Saldae aqueduct system was found in an ancient book."],
                                    [10, "The mistake made by the builders of the Saldae aqueduct system was that the two parts of the tunnel failed to meet."],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{!! $statement !!}</td>
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

                {{-- Questions 11–13: Short Answer --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 11–13</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Answer the questions below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>NO MORE THAN TWO WORDS</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 11–13 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-white text-sm">
                        <div class="space-y-6">
                            <div class="flex flex-col gap-2">
                                <div class="flex gap-2">
                                    <span class="font-bold text-blue-600">11</span>
                                    <span class="text-gray-800">What type of mineral were the Dolaucothi mines in Wales built to extract?</span>
                                </div>
                                <input type="text" name="q11" class="border-b border-gray-500 outline-none px-2 py-1 w-64 bg-white text-sm placeholder-gray-400 focus:border-blue-500 shadow-sm rounded-t-sm" placeholder="Answer">
                            </div>
                            
                            <div class="flex flex-col gap-2">
                                <div class="flex gap-2">
                                    <span class="font-bold text-blue-600">12</span>
                                    <span class="text-gray-800">In addition to the patron, whose name might be carved onto a tunnel?</span>
                                </div>
                                <input type="text" name="q12" class="border-b border-gray-500 outline-none px-2 py-1 w-64 bg-white text-sm placeholder-gray-400 focus:border-blue-500 shadow-sm rounded-t-sm" placeholder="Answer">
                            </div>
                            
                            <div class="flex flex-col gap-2">
                                <div class="flex gap-2">
                                    <span class="font-bold text-blue-600">13</span>
                                    <span class="text-gray-800">What part of Seleuceia Pieria was the Çevlik tunnel built to protect?</span>
                                </div>
                                <input type="text" name="q13" class="border-b border-gray-500 outline-none px-2 py-1 w-64 bg-white text-sm placeholder-gray-400 focus:border-blue-500 shadow-sm rounded-t-sm" placeholder="Answer">
                            </div>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="mt-6 flex justify-end">
                        <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                            Submit Answers
                        </button>
                    </div>
                </div>

                {{-- ── PASSAGE 2 Questions ── --}}
                <div class="mt-10 mb-6 px-2">
                    <h2 class="text-lg font-bold text-gray-900 uppercase tracking-wide">PASSAGE 2 QUESTIONS</h2>
                </div>

                {{-- Questions 14–17: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–17</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 14–17 on your answer sheet.</p>

                    <div class="space-y-6">
                        @foreach([
                            [14, "What is the writer's main point in the first paragraph?", [
                                "A" => "Our use of technology is having a hidden effect on us.",
                                "B" => "Technology can be used to help youngsters to read.",
                                "C" => "Travellers should be encouraged to use technology on planes.",
                                "D" => "Playing games is a more popular use of technology than reading."
                            ]],
                            [15, "What main point does Sherry Turkle make about innovation?", [
                                "A" => "Technological innovation has led to a reduction in print reading.",
                                "B" => "We should pay attention to what might be lost when innovation occurs.",
                                "C" => "We should encourage more young people to become involved in innovation.",
                                "D" => "There is a difference between developing products and developing ideas."
                            ]],
                            [16, "What point is the writer making in the fourth paragraph?", [
                                "A" => "Humans have an inborn ability to read and write.",
                                "B" => "Reading can be done using many different mediums.",
                                "C" => "Writing systems make unexpected demands on the brain.",
                                "D" => "Some brain circuits adjust to whatever is required of them."
                            ]],
                            [17, "According to Mark Edmundson, the attitude of college students", [
                                "A" => "has changed the way he teaches.",
                                "B" => "has influenced what they select to read.",
                                "C" => "does not worry him as much as it does others.",
                                "D" => "does not match the views of the general public."
                            ]],
                        ] as [$num, $question, $options])
                        <div class="mb-4">
                            <div class="flex gap-2 mb-2">
                                <span class="font-bold text-blue-600">{{ $num }}</span>
                                <span class="text-gray-800 font-semibold">{{ $question }}</span>
                            </div>
                            <div class="space-y-2 pl-6">
                                @foreach($options as $letter => $text)
                                <label class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 hover:bg-white cursor-pointer transition-colors">
                                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="mt-0.5 w-4 h-4 text-blue-600 bg-white border-gray-300 focus:ring-blue-500">
                                    <div class="flex-1 text-sm text-gray-800"><span class="font-bold mr-2">{{ $letter }}</span> {{ $text }}</div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Questions 18–22: Summary Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 18–22</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary using the list of words, <strong>A–H</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–H</strong>, in boxes 18–22 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-white text-sm">
                        <h4 class="text-lg font-bold text-center mb-4 text-gray-900">Studies on digital screen use</h4>

                        <p class="mb-4 text-gray-800 leading-loose">
                            There have been many studies on digital screen use, showing some <span class="font-bold text-blue-600">18</span>
                            <div class="relative inline-block align-middle mx-1.5 w-24">
                                <select name="q18" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1 px-2 pr-6 rounded text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                    <option value="" disabled selected>-</option>
                                    @foreach(range('A', 'H') as $letter)
                                        <option value="{{ $letter }}">{{ $letter }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-600">
                                    <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                            trends. Psychologist Anne Mangen gave high-school students a short story to read, half using digital and half using print mediums. Her team then used a question-and-answer technique to find out how <span class="font-bold text-blue-600">19</span>
                            <div class="relative inline-block align-middle mx-1.5 w-24">
                                <select name="q19" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1 px-2 pr-6 rounded text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                    <option value="" disabled selected>-</option>
                                    @foreach(range('A', 'H') as $letter)
                                        <option value="{{ $letter }}">{{ $letter }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-600">
                                    <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                            each group's understanding of the plot was. The findings showed a clear pattern in the responses, with those who read screens finding the order of information <span class="font-bold text-blue-600">20</span>
                            <div class="relative inline-block align-middle mx-1.5 w-24">
                                <select name="q20" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1 px-2 pr-6 rounded text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                    <option value="" disabled selected>-</option>
                                    @foreach(range('A', 'H') as $letter)
                                        <option value="{{ $letter }}">{{ $letter }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-600">
                                    <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                            to recall.
                        </p>

                        <p class="mb-6 text-gray-800 leading-loose">
                            Studies by Ziming Liu show that students are tending to read <span class="font-bold text-blue-600">21</span>
                            <div class="relative inline-block align-middle mx-1.5 w-24">
                                <select name="q21" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1 px-2 pr-6 rounded text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                    <option value="" disabled selected>-</option>
                                    @foreach(range('A', 'H') as $letter)
                                        <option value="{{ $letter }}">{{ $letter }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-600">
                                    <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                            words and phrases in a text to save time. This approach, she says, gives the reader a superficial understanding of the <span class="font-bold text-blue-600">22</span>
                            <div class="relative inline-block align-middle mx-1.5 w-24">
                                <select name="q22" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1 px-2 pr-6 rounded text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                    <option value="" disabled selected>-</option>
                                    @foreach(range('A', 'H') as $letter)
                                        <option value="{{ $letter }}">{{ $letter }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-1 text-gray-600">
                                    <svg class="fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                            content of material, leaving no time for thought.
                        </p>

                        <div class="border border-gray-300 bg-white p-4 rounded-lg flex flex-wrap gap-x-6 gap-y-3 justify-center text-sm font-semibold max-w-xl mx-auto shadow-sm">
                            <div class="w-32"><span class="font-bold mr-2 text-blue-600">A</span> fast</div>
                            <div class="w-32"><span class="font-bold mr-2 text-blue-600">B</span> isolated</div>
                            <div class="w-32"><span class="font-bold mr-2 text-blue-600">C</span> emotional</div>
                            <div class="w-32"><span class="font-bold mr-2 text-blue-600">D</span> worrying</div>
                            <div class="w-32"><span class="font-bold mr-2 text-blue-600">E</span> many</div>
                            <div class="w-32"><span class="font-bold mr-2 text-blue-600">F</span> hard</div>
                            <div class="w-32"><span class="font-bold mr-2 text-blue-600">G</span> combined</div>
                            <div class="w-32"><span class="font-bold mr-2 text-blue-600">H</span> thorough</div>
                        </div>

                    </div>
                </div>

                {{-- Questions 23–26: YES/NO/NOT GIVEN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 23–26</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the views of the writer in Reading Passage 2?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 23–26 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-white">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic uppercase">YES</span></div><div class="italic">if the statement agrees with the views of the writer</div>
                            <div><span class="font-bold italic uppercase">NO</span></div><div class="italic">if the statement contradicts the views of the writer</div>
                            <div><span class="font-bold italic uppercase">NOT GIVEN</span></div><div class="italic">if it is impossible to say what the writer thinks about this</div>
                        </div>
                     </div>
                    
                    <div class="space-y-4">
                        @foreach([
                            [23, "The medium we use to read can affect our choice of reading content."],
                            [24, "Some age groups are more likely to lose their complex reading skills than others."],
                            [25, "False information has become more widespread in today's digital era."],
                            [26, "We still have opportunities to rectify the problems that technology is presenting."],
                        ] as [$num, $statement])
                        <div class="flex items-start gap-4">
                            <span class="font-bold text-blue-600 w-6 text-right shrink-0">{{ $num }}</span>
                            <div class="flex-1 text-sm text-gray-800 leading-relaxed">{{ $statement }}</div>
                            <div class="w-36 shrink-0">
                                <div class="relative w-full">
                                    <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1.5 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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
                        </div>
                        <div class="border-b border-gray-100 last:hidden"></div>
                        @endforeach
                    </div>
                </div>

                {{-- ── PASSAGE 3 Questions ── --}}
                <div class="mt-10 mb-6 px-2">
                    <h2 class="text-lg font-bold text-gray-900 uppercase tracking-wide">PASSAGE 3 QUESTIONS</h2>
                </div>

                {{-- Questions 27–32: List of Headings --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–32</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Reading Passage 3 has six sections, <strong>A–F</strong>.</p>
                    <p class="text-sm text-gray-800 mb-3">Choose the correct heading for each section from the list of headings below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct number, <strong><em>i–viii</em></strong>, in boxes 27–32 on your answer sheet.</p>

                    <div class="border border-gray-300 bg-white p-5 rounded-lg mb-6">
                        <p class="font-bold text-center text-gray-900 mb-3">List of Headings</p>
                        <div class="space-y-1.5 text-sm text-gray-800">
                            @foreach([
                                ['i',    'An increasing divergence of attitudes towards AI'],
                                ['ii',   'Reasons why we have more faith in human judgement than in AI'],
                                ['iii',  'The superiority of AI projections over those made by humans'],
                                ['iv',   'The process by which AI can help us make good decisions'],
                                ['v',    'The advantages of involving users in AI processes'],
                                ['vi',   'Widespread distrust of an AI innovation'],
                                ['vii',  'Encouraging openness about how AI functions'],
                                ['viii', 'A surprisingly successful AI application'],
                            ] as [$roman, $heading])
                            <div class="flex gap-3">
                                <span class="font-bold italic w-8 text-right shrink-0">{{ $roman }}</span>
                                <span>{{ $heading }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach([
                            [27, 'Section A'],
                            [28, 'Section B'],
                            [29, 'Section C'],
                            [30, 'Section D'],
                            [31, 'Section E'],
                            [32, 'Section F'],
                        ] as [$num, $label])
                        <div class="flex items-center gap-4">
                            <span class="font-bold text-blue-600 w-6 text-right shrink-0">{{ $num }}</span>
                            <div class="flex-1 text-sm text-gray-800 font-semibold">{{ $label }}</div>
                            <div class="w-28 shrink-0">
                                <div class="relative w-full">
                                    <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1.5 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(['i','ii','iii','iv','v','vi','vii','viii'] as $roman)
                                            <option value="{{ $roman }}">{{ $roman }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-b border-gray-100 last:hidden"></div>
                        @endforeach
                    </div>
                </div>

                {{-- Questions 33–35: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 33–35</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 33–35 on your answer sheet.</p>

                    <div class="space-y-6">
                        @foreach([
                            [33, "What is the writer doing in Section A?", [
                                "A" => "providing a solution to a concern",
                                "B" => "justifying an opinion about an issue",
                                "C" => "highlighting the existence of a problem",
                                "D" => "explaining the reasons for a phenomenon"
                            ]],
                            [34, "According to Section C, why might some people be reluctant to accept AI?", [
                                "A" => "They are afraid it will replace humans in decision-making jobs.",
                                "B" => "Its complexity makes them feel that they are at a disadvantage.",
                                "C" => "They would rather wait for the technology to be tested over a period of time.",
                                "D" => "Misunderstandings about how it works make it seem more challenging than it is."
                            ]],
                            [35, "What does the writer say about the media in Section C of the text?", [
                                "A" => "It leads the public to be mistrustful of AI.",
                                "B" => "It devotes an excessive amount of attention to AI.",
                                "C" => "Its reports of incidents involving AI are often inaccurate.",
                                "D" => "It gives the impression that AI failures are due to designer error."
                            ]],
                        ] as [$num, $question, $options])
                        <div class="mb-4">
                            <div class="flex gap-2 mb-2">
                                <span class="font-bold text-blue-600">{{ $num }}</span>
                                <span class="text-gray-800 font-semibold">{{ $question }}</span>
                            </div>
                            <div class="space-y-2 pl-6">
                                @foreach($options as $letter => $text)
                                <label class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 hover:bg-white cursor-pointer transition-colors">
                                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="mt-0.5 w-4 h-4 text-blue-600 bg-white border-gray-300 focus:ring-blue-500">
                                    <div class="flex-1 text-sm text-gray-800"><span class="font-bold mr-2">{{ $letter }}</span> {{ $text }}</div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Questions 36–40: YES/NO/NOT GIVEN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 36–40</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the claims of the writer in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 36–40 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-white">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic uppercase">YES</span></div><div class="italic">if the statement agrees with the claims of the writer</div>
                            <div><span class="font-bold italic uppercase">NO</span></div><div class="italic">if the statement contradicts the claims of the writer</div>
                            <div><span class="font-bold italic uppercase">NOT GIVEN</span></div><div class="italic">if it is impossible to say what the writer thinks about this</div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach([
                            [36, "Subjective depictions of AI in sci-fi films make people change their opinions about automation."],
                            [37, "Portrayals of AI in media and entertainment are likely to become more positive."],
                            [38, "Rejection of the possibilities of AI may have a negative effect on many people's lives."],
                            [39, "Familiarity with AI has very little impact on people's attitudes to the technology."],
                            [40, "AI applications which users are able to modify are more likely to gain consumer approval."],
                        ] as [$num, $statement])
                        <div class="flex items-start gap-4">
                            <span class="font-bold text-blue-600 w-6 text-right shrink-0">{{ $num }}</span>
                            <div class="flex-1 text-sm text-gray-800 leading-relaxed">{{ $statement }}</div>
                            <div class="w-36 shrink-0">
                                <div class="relative w-full">
                                    <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1.5 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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
                        </div>
                        <div class="border-b border-gray-100 last:hidden"></div>
                        @endforeach
                    </div>

                    {{-- Submit --}}
                    <div class="mt-6 flex justify-end">
                        <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                            Submit Answers
                        </button>
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

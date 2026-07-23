<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $test['label'] ?? 'IELTS Academic' }} Reading Paket {{ $test['package_number'] ?? 1 }} - {{ config('app.name', 'Target Bahasa') }}</title>
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
<body class="font-sans antialiased bg-gray-50">
    @include('components.impersonation-banner')
    @include('components.cambridge-guest-signup-modal')
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
                    <h1 class="text-xl font-bold text-gray-800">{{ $test['label'] ?? 'IELTS Academic' }} Reading - Paket {{ $test['package_number'] ?? 1 }}</h1>
                    <p class="text-sm text-gray-500">Internal package reading practice</p>
                </div>
            </div>
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

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">The natural of Yawning</h3>



                        {{-- Passage text --}}
                        <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-6 font-['Georgia',serif]"
                             @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                             @click="if(eraserMode) window.removeHighlight($event);">

                            <p><span class="font-bold mr-2">A.</span>While fatigue, drowsiness or boredom easily bring on yawns, scientists are discovering there is more to yawning than most people think. Not much is known about why we yawn or if it serves any useful function. People have already learned that yawning can be infectious. "Contagious yawning" is the increase in likelihood that you will yawn after watching or hearing someone else yawn, but not much is known about the under-lying causes, and very little research has been done on the subject. However, scientists at the University of Albany, as well as the University of Leeds and the University of London have done some exploration.</p>

                            <p><span class="font-bold mr-2">B.</span>It is commonly believed that people yawn as a result of being sleepy or tired because they need oxygen. However, the latest research shows that a yawn can help cool the brain and help it work more effectively, which is quite different from the popular belief that yawning promotes sleep and is a sign of tiredness. Dr. Andrew Gallup and his colleagues at the University of Albany in New York State said their experiments on 44 students showed that raising or lowering oxygen and carbon dioxide levels in the blood did not produce that reaction. In the study participants were shown videos of people laughing and yawning, and researchers counted how many times the volunteers responded to the "contagious yawns". The researchers found that those who breathed through the nose rather than the mouth were less likely to yawn when watching a video of other people yawning. The same effect was found among those who held a cool pack to their forehead, whereas those who held a warm pack yawned while watching the video. Since yawning occurs when brain temperature rises, sending cool blood to the brain serves to maintain the best levels of mental efficiency.</p>

                            <p><span class="font-bold mr-2">C.</span>Yawning is universal to humans and many animals. Cats, dogs and fish yawn just like humans do, but they yawn spontaneously. Only humans and chimpanzees, our closest relatives in the animal kingdom, have shown definite contagious yawning. Though much of yawning is due to suggestibility, sometimes people do not need to actually see a person yawn to involuntarily yawn themselves: hearing someone yawning or even reading about yawning can cause the same reaction.</p>

                            <p><span class="font-bold mr-2">D.</span>However, contagious yawning goes beyond mere suggestibility. Recent studies show that contagious yawning is also related to our predisposition toward empathy - the ability to understand and connect with others' emotional states. So empathy is important, sure, but how could it possibly be related to contagious yawning? Leave it up to psychologists at Leeds University in England to answer that. In their study, researchers selected 40 psychology students and 40 engineering students. Generally, psychology students are more likely to feel empathy for others, while engineering students are thought to be concerned with objects and science. Each student was made to wait individually in a waiting room, along with an undercover assistant who yawned 10 times in as many minutes. The students were then administered an emotional quotient test: students were shown 40 images of eyes and asked what emotion each one displayed. The results of the test support the idea that contagious yawning is linked to empathy. The psychology students - whose future profession requires them to focus on others - yawned contagiously an average of 5.5 times in the waiting room and scored 28 out of 40 on the emotional test. The engineering students - who tend to focus on things like numbers and systems - yawned an average of 1.5 times and scored 25.5 out of 40 on the subsequent test. The difference does not sound like much, but researchers consider it significant. Strangely enough, women, who are generally considered more emotionally attuned, did not score any higher than men.</p>

                            <p><span class="font-bold mr-2">E.</span>Another study, led by Atsushi Senju, a cognitive researcher at the University of London, also sought to answer that question. People with autism disorder are considered to be developmentally impaired emotionally. Autistics have trouble connecting with others and find it difficult to feel empathy. Since autistics have difficulty feeling empathy, then they should not be susceptible to contagious yawning. To find out, Senju and his colleagues placed 49 kids aged 7 to 15 in a room with a television. 24 of the test subjects had been diagnosed with autism spectrum disorder, the other 25 were non-autistic kids. The test subjects were shown short clips of people yawning as well as clips of people opening their mouths but not yawning. While the kids with autism had the same lack of reaction to both kinds of clips, the non-autistic kids yawned more after the clips of people yawning.</p>

                            <p><span class="font-bold mr-2">F.</span>There also have been studies that suggest yawning, especially psychological "contagious" yawning, may have developed as a way of keeping a group of animals alert and bonding members of a group into a more unit one. If an animal is drowsy or bored, it may not be as alert as it should to be prepared to spring into action and its yawning is practically saying, "Hey, I need some rest, you stay awake". Therefore, a contagious yawn could be an instinctual reaction to a signal from one member of the herd reminding the others to stay alert when danger comes. So the theory suggests evidence that yawning comes from the evolution of early humans to be ready to physically exert themselves at any given moment.</p>
                        </div>

                        {{-- Floating Annotation Toolbar --}}


                </div>

                {{-- Passage 2 --}}
                <div class="mb-6 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 on pages 21 and 22.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">WATER TREATMENT 2 : REED BED</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">
                        <p>In recent years, it has been shown that plants, more accurately roots, play a crucial part in purifying dirty water before it enters seas and rivers. In 15th-century Britain, dirty water was purified by passing through the wetlands. People began to realize that the "natural" way of water purification was effective. Nowadays subsurface flow wetlands (SSFW) are a common alternative in Europe for the treatment of wastewater in rural areas, Mainly in the last 10 to 12 years there has been a significant growth in the number and size of the systems in use. The conventional mechanism of water purification used in big cities where there are large volumes of water to be purified is inappropriate in rural areas.</p>

                        <p>The common reed has the ability to transfer oxygen from its leaves, down through its stem and rhizomes, and out via its root system. As a result of this action, a very high population of microorganisms occurs in the root system, in zones of aerobic, anoxic, and anaerobic conditions. As the waste water moves very slowly through the mass of reed roots, this liquid can be successfully treated. The reason why they are so effective is often because within the bed's root sector, natural biological, physical and chemical processes interact with one another to degrade or remove a good range of pollutants.</p>

                        <p>Dirty water from households, farms and factories consume a lot of oxygen in the water, which will lead to the death of aquatic creatures. Several aquatic plants are important in purifying water. They not only absorb carbon dioxide and release oxygen into the water, improving the environment for fish, but absorb nutrients from the welter as well. Britain and the G.S. differ in their preference of plants to purify water. Bulrushes (Scirpus spp.) and rushes (Juncus spp.) are excellent water purifiers. They remove excess nutrients from the water as well as oil and bacteria such as Escherichia coli and Salmonella. However, algae grow freely in summer and die off in winter. Their remains foul the bottom of the pool.</p>

                        <p>Artificial reed beds purify water in both horizontal and downflow ways. The reeds succeed best when a dense layer of root hairs has formed. It takes three years for the roots to fully develop. Which type of wetland a certain country applies varies widely depending on the country in Europe and its main lines of development. Besides the development of horizontal or vertical flow wetlands for wastewater treatment, the use of wetlands for sludge treatment has been very successful in Europe. Some special design lines offer the retention of microbiological organisms in constructed wetlands, the treatment of agricultural wastewater, treatment of some kinds of industrial wastewater, and the control of diffuse pollution.</p>

                        <p>If the water is slightly polluted, a horizontal system is used. Horizontal-flow wetlands may be of two types: free-water surface-flow (FWF) or sub-surface water-flow (SSF). In the former the effluent flows freely above the sand/gravel bed in which the reeds etc. are planted; in the latter effluent passes through the sand/gravel bed. In FWF-type wetlands, effluent is treated by plant stems, leaves and rhizomes. Such FWF wetlands are densely planted and typically have water-depths of less than 0.4M. However, dense planting can limit the diffusion of oxygen into the water. These systems work particularly well for low strength effluents or effluents that have undergone some forms of pretreatment and play an invaluable role in tertiary treatment and the polishing of effluents. The horizontal reed flow system uses a long reed bed, where the liquid slowly flows horizontally through. The length of the reed bed is about 100 meters. The downside of horizontal reed beds is that they use up lots of land space and they do take quite a long time to produce clean water.</p>

                        <p>A vertical flow (downflow) reed bed is a sealed, gravel filled trench with reeds growing in it. The reeds in a downflow system are planted in a bed 60cm deep. In vertical flow reed beds, the wastewater is applied to the top of the reed bed, flows down through a rhizome zone with sludge as a substrate, then through a root zone with sand as a substrate, followed by a layer of gravel for drainage, and is collected in an under drainage system of large stones. The effluent flows onto the surface of the bed and percolates slowly through the different layers into an outlet pipe, which leads to a horizontal flow bed where it is cleaned by millions of bacteria, algae, fungi, and microorganisms that digest the waste, including sewage. There is no standing water so there should be no unpleasant smells.</p>

                        <p>Vertical flow reed bed systems are much more effective than horizontal flow reed-beds not only in reducing biochemical oxygen demanded (BOD) and suspended solids (SS) levels but also in reducing ammonia levels and eliminating smells. Usually considerably smaller than horizontal flow beds, they are capable of handling much stronger effluents which contain heavily polluted matters and have a longer lifetime value. A vertical reed bed system works more efficiently than a horizontal reed bed system, but it requires more management, and its reed beds are often operated for a few days then rested, so several beds and a distribution system are needed.</p>

                        <p>The natural way of water purification has many advantages over the conventional mechanism. The natural way requires less expenditure for installation, operation and maintenance. Besides, it looks attractive and can improve the surrounding landscape. Reed beds are natural habitats found in floodplains, waterlogged depressions and estuaries. The natural bed systems are a biologically proved, an environmentally friendly and visually unobtrusive way of treating wastewater, and have the extra virtue of frequently being better than mechanical wastewater treatment systems. Over the medium to long term reed bed systems are, in most cases, more cost effective to install than any other wastewater treatment. They are naturally environmentally sound protecting groundwater, dams, creeks, rivers and estuaries.</p>
                    </div>
                </div>

                {{-- Passage 3 --}}
                <div class="mb-6 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">History of telegraph in communication</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">
                        <p>Jean-Antoine Nollet was a French clergyman and physicist. In 1746 he gathered about two hundred monks into a circle about a mile (1.6 km) in circumference, with pieces iron wire connecting them. He then discharged a battery of Leyden jars through the human chain and observed that each man reacted at substantially the same time to the electric shock, showing that the speed of electricity's propagation was very high. Given a more humane detection system, this could be a way of signaling over long distances. In 1748, Nollet invented one of the first electrometers, the electroscope, which detected the presence of an electric charge by using electrostatic attraction and repulsion.</p>

                        <p>After the introduction of the European semaphore lines in 1792, the world's desire to further its ability to communicate from a distance only grew. People wanted a way to send and receive news from remote locations so that they could better understand what was happening in the world around them - not just what was going on in their immediate town or city. This type of communication not only appealed to the media industry, but also to private individuals and companies who wished to stay in touch with contacts. In 1840 Charles Wheatstone from Britain, with William Cooke, obtained a new patent for a telegraphic arrangement. The new apparatus required only a single pair of wires, but the telegraph was still too costly for general purposes. In 1845, however, Cooke and Wheatstone succeeded in producing the single needle apparatus, which they patented, and from that time the electric telegraph became a practical instrument, soon adopted on all the railway lines of the country.</p>

                        <p>It was the European optical telegraph, or semaphore, that was the predecessor of the electrical recording telegraph that changed the history of communication forever. Building on the success of the optical telegraph, Samuel F. B. Morse completed a working version of the electrical recording telegraph, which only required a single wire to send code of dots and dashes. At first, it was imagined that only a few highly skilled encoders would be able to use it but it soon became clear that many people could become proficient in Morse code. A system of lines strung on telegraph poles began to spread in Europe and America.</p>

                        <p>In the 1840s and 1850s several individuals proposed or advocated construction of a telegraph cable across the Atlantic Ocean, including Edward Thornton and Alonzo Jackman. At that time there was no material available for cable insulation and the first breakthrough came with the discovery of a rubber-like latex called gutta percha. Introduced to Britain in 1843, gutta percha is the gum of a tree native to the Malay Peninsula and Malaysia. After the failure of their first cable in 1850, the British brothers John and Jacob Brett laid a successful submarine cable from Dover to Calais in 1851. This used two layers of gutta percha insulation and an armoured outer layer. With thin wire and thick insulation, it floated and had to be weighed down with lead pipe.</p>

                        <p>In the case of first submarine-cable telegraphy, there was the limitation of knowledge of how its electrical properties were affected by water. The voltage which may be impressed on the cable was limited to a definite value. Moreover, for certain reasons, the cable had an impedance associated with it at the sending end which could make the voltage on the cable differ from the voltage applied to the sending-end apparatus. In fact, the cable was too big for a single boat, so two had to start in the middle of the Atlantic, join their cables and sail in opposite directions. Amazingly, the first official telegram to pass between two continents was a letter of congratulation from Queen Victoria of the United Kingdom to the President of the United States, James Buchanan, on August 16, 1858. However, signal quality declined rapidly, slowing transmission to an almost unusable speed and the cable was destroyed the following month.</p>

                        <p>To complete the link between England and Australia, John Pender formed the British-Australian Telegraph Company. The first stage was to lay a 557nm cable from Singapore to Batavia on the island of Java in 1870. It seemed likely that it would come ashore at the northern port of Darwin from where it might connect around the coast to Queensland and New South Wales. It was an undertaking more ambitious than spanning ocean. Flocks of sheep had to be driven with the 400 workers to provide food. They needed horses and bullock carts and, for the parched interior, camels. In the north, tropical rains left the teams flooded. In the centre, it seemed that they would die of thirst. One critical section in the red heart of Australia involved finding a route through the McDonnell mountain range and then finding water on the other side. The water was not only essential for the construction teams. There had to be telegraph repeater stations every few hundred miles to boost the signal and the staff obviously had to have a supply of water.</p>

                        <p>On August 22, 1872, the Northern and Southern sections of the Overland Telegraph Line were connected, uniting the Australian continent and within a few months, Australia was at last in direct contact with England via the submarine cable, too. This allowed the Australian Government to receive news from around the world almost instantaneously for the first time. It could cost several pounds to send a message and it might take several hours for it to reach its destination on the other side of the globe, but the world would never be the same again. The telegraph was the first form of communication over a great distance and was a landmark in human history.</p>
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
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar">
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto">

                {{-- Questions 1–5: Paragraph Matching --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–5</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Read paragraphs A-F. Which paragraph contains the following information?</p>
                    <p class="text-sm italic text-gray-700 mb-4"><strong>NB</strong> You may use any letter more than once.</p>

                    <div class="overflow-x-auto mt-2">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Information</th>
                                    <th class="p-3 font-bold text-gray-600 w-36 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [1, "Humans' imaginations can cause yawning."],
                                    [2, "Research shows that yawning is closely related to occupations."],
                                    [3, "An overview of the latest research in yawning."],
                                    [4, "Yawning is used to regulate brain temperature."],
                                    [5, "Scientists discovered some evidence disproving the early understanding of yawning."],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                @foreach(['A','B','C','D','E','F'] as $opt)
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

                {{-- Questions 6–9: Match with University --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 6–9</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Match each of the following research results with the university which it comes from.</p>
                    <p class="text-sm italic text-gray-700 mb-4"><strong>NB</strong> You may use any letter more than once.</p>

                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50 text-sm mb-5">
                        <div class="space-y-1">
                            <div><span class="font-bold">A.</span> University of Albany</div>
                            <div><span class="font-bold">B.</span> University of Leeds</div>
                            <div><span class="font-bold">C.</span> University of London</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Research Result</th>
                                    <th class="p-3 font-bold text-gray-600 w-36 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [6, 'There is no gender difference in the cause of yawning.'],
                                    [7, 'People with certain disorders are less likely to be affected by other people yawning.'],
                                    [8, 'Yawning is associated with the way people breathe.'],
                                    [9, 'People who are trained to feel empathy for others are more likely to yawn than those who are untrained.'],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
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

                {{-- Questions 10–13: Summary Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mt-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 10–13</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD</strong> from the passage for each answer.</p>
                    <p class="text-sm text-gray-800 mb-5">Write your answers in boxes 10-13 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <p class="text-gray-800 leading-loose">
                            Another theory shows that yawning is used for <span class="font-bold">10</span>
                            <input type="text" name="q10" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            individuals into a tighter social unit. Alternatively, yawning can help increase alertness of group members in case <span class="font-bold">11</span>
                            <input type="text" name="q11" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            is close. For example, yawning signals that a member of the group needs some <span class="font-bold">12</span>
                            <input type="text" name="q12" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            and requires the others to stay aware of the surrounding situation. This theory proves that yawning is only a spontaneous behaviour resulting from some part of a simple <span class="font-bold">13</span>
                            <input type="text" name="q13" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            system in early humans.
                        </p>
                    </div>

                </div>

                {{-- ── PASSAGE 2 Questions ── --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Q14-16: True / False / Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–16</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Do the following statements agree with the information given in Reading Passage 2?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 14-16 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold">TRUE</span></div><div>if the statement agrees with the information</div>
                            <div><span class="font-bold">FALSE</span></div><div>if the statement contradicts the information</div>
                            <div><span class="font-bold">NOT GIVEN</span></div><div>if there is no information on this</div>
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
                                    [14, 'The reed bed system is a conventional method for water treatment in urban areas.'],
                                    [15, 'In the reed roots, there is a series of processes that help break down the pollutants.'],
                                    [16, 'Escherichia coli is the most difficult bacteria to eliminate.'],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                @foreach(['TRUE','FALSE','NOT GIVEN'] as $opt)
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

                {{-- Q17-19: Diagram Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 17–19</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the diagram below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Choose <strong>NO MORE THAN THREE WORDS</strong> from the passage for each answer.</p>

                    @php
                        $reedBedDiagramPath = 'images/ielts/test/paket1/reading/downflow-reed-bed-system.png';
                    @endphp

                    <div class="border-2 border-gray-300 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-2xl font-bold text-center mb-4">Downflow Reed Bed System</h4>

                        <div class="grid md:grid-cols-2 gap-6 items-start">
                            <div class="border border-gray-300 rounded-lg p-3 bg-white">
                                <img
                                    src="{{ asset($reedBedDiagramPath) }}"
                                    alt="Downflow Reed Bed System Diagram"
                                    class="w-full h-auto rounded"
                                    onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');"
                                >
                                <div class="hidden text-xs text-gray-500 text-center py-12 px-4">
                                    Diagram belum ditemukan di <strong>public/{{ $reedBedDiagramPath }}</strong>
                                </div>
                            </div>

                            <div class="space-y-5 pt-3">
                                <p class="text-gray-800 leading-loose"><strong>17</strong> <input type="text" name="q17" class="border-b border-gray-500 outline-none px-1 w-44 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> as a substrate</p>
                                <p class="text-gray-800 leading-loose"><strong>18</strong> <input type="text" name="q18" class="border-b border-gray-500 outline-none px-1 w-44 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"></p>
                                <p class="text-gray-800 leading-loose"><strong>19</strong> <input type="text" name="q19" class="border-b border-gray-500 outline-none px-1 w-44 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> for drainage</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Q20-24: Matching Advantages/Disadvantages --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 20–24</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Use the information in the passage to match the advantages and disadvantages of the two systems: horizontal flow system and down-flow system (listed A-H) below.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the appropriate letters A-H in boxes 20-24 on your answer sheet.</p>

                    <div class="border border-gray-300 rounded-lg p-5 bg-gray-50 text-sm mb-5">
                        <p class="text-gray-800 leading-loose mb-4">
                            The advantage of the downflow system is <strong>20</strong>
                            <select name="q20" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1">
                                <option value="" disabled selected>-</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>;
                            however, <strong>21</strong>
                            <select name="q21" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1">
                                <option value="" disabled selected>-</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            and <strong>22</strong>
                            <select name="q22" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1">
                                <option value="" disabled selected>-</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>.
                            The two advantages of the horizontal system are <strong>23</strong>
                            <select name="q23" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1">
                                <option value="" disabled selected>-</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            and <strong>24</strong>
                            <select name="q24" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1">
                                <option value="" disabled selected>-</option>
                                @foreach(['A','B','C','D','E','F','G','H'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>.
                            In comparison with the downflow system, the horizontal system is less effective.
                        </p>

                        <div class="grid gap-y-2">
                            @foreach([
                                ['A', 'it requires several beds'],
                                ['B', 'it is easier to construct'],
                                ['C', 'it builds on a gradient'],
                                ['D', 'it does not need much attention'],
                                ['E', 'it produces less sludges'],
                                ['F', 'it is not always working'],
                                ['G', 'it needs deeper bed'],
                                ['H', 'it can deal with more heavily polluted water'],
                            ] as [$letter, $desc])
                            <div><strong>{{ $letter }}.</strong> {{ $desc }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Q25-26: Choose TWO --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 25–26</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose two correct letters, from the following A, B, C, D or E.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write your answers in boxes 25-26 on your answer sheet.</p>
                    <p class="text-sm text-gray-800 mb-4">What are the TWO advantages of the natural water purification system mentioned in the passage:</p>

                    <div class="space-y-3">
                        @foreach([
                            ['A', 'It uses micro-organisms'],
                            ['B', 'It involves a low operating cost'],
                            ['C', 'It prevents flooding.'],
                            ['D', 'It is visually good-looking'],
                            ['E', 'It can function in all climates'],
                        ] as [$letter, $text])
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="q25_26[]" value="{{ $letter }}"
                                   class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none">
                            <span class="text-sm text-gray-800 group-hover:text-blue-700 transition-colors">
                                <strong>{{ $letter }}.</strong> {{ $text }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- ── PASSAGE 3 Questions --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>

                {{-- Q27-32: True / False / Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–32</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Do the following statements agree with the information given in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 27-32 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold">TRUE</span></div><div>if the statement agrees with the information</div>
                            <div><span class="font-bold">FALSE</span></div><div>if the statement contradicts the information</div>
                            <div><span class="font-bold">NOT GIVEN</span></div><div>if there is no information on this</div>
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
                                    [27, 'In the research of the French scientist, metal lines were used to send messages.'],
                                    [28, 'People increasingly hoped to explore ways of long-distance communication in the late eighteenth century.'],
                                    [29, 'Using Morse Code to send message needed special personnel to first simplify the message.'],
                                    [30, 'Morse was a famous inventor before he invented the code.'],
                                    [31, 'Water was significant to early telegraph repeater stations on the continent.'],
                                    [32, 'The Australian Government offered funds for the first overland line across the continent.'],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                @foreach(['TRUE','FALSE','NOT GIVEN'] as $opt)
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

                {{-- Q33-40: Short Answer Questions --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 33–40</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Answer the questions below. Choose <strong>NO MORE THAN TWO WORDS</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 33-40 on your answer sheet.</p>

                    <div class="space-y-5">
                        @foreach([
                            [33, 'Why did Charles Wheatstone\'s telegraph system fail to come into common use in the beginning?'],
                            [34, 'What material was used for insulating cable across the sea?'],
                            [35, 'What was used by British pioneers to increase the weight of the cable in the sea?'],
                            [36, 'What would occur in the submarine cable when the voltage was applied?'],
                            [37, 'Who was a message first sent to across the Atlantic by the Queen?'],
                            [38, 'What animals were used to carry the cable through desert?'],
                            [39, 'What weather condition delayed construction in north Australia?'],
                            [40, 'How long did it take to send a telegraph message from Australia to England in 1872?'],
                        ] as [$num, $question])
                        <div>
                            <p class="text-sm font-semibold text-gray-800 mb-2"><span class="text-blue-600 font-bold mr-1">{{ $num }}</span> {{ $question }}</p>
                            <input type="text" name="q{{ $num }}" class="w-full max-w-md border-b border-gray-500 outline-none px-1 py-1 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                        </div>
                        @endforeach
                    </div>
                </div>


                {{-- Final Submit --}}
                <div class="mt-6 flex justify-end">
                    <button id="submitReadingAnswersBtn" type="button" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                        Submit All Answers
                    </button>
                </div>

                <div id="readingResultPanel" class="hidden mt-4 rounded-xl border p-4 text-sm"></div>

                @php
                    $latestEval = is_array($latestPackageSectionResult->evaluation_data ?? null) ? $latestPackageSectionResult->evaluation_data : [];
                    $latestCorrect = $latestEval['score_correct'] ?? null;
                    $latestTotal = $latestEval['score_total'] ?? null;
                    $latestPercent = $latestEval['score_percent'] ?? ($latestPackageSectionResult->score ?? null);
                @endphp
                <div id="latestAttemptPanel" class="mt-4 rounded-xl border border-gray-200 bg-white p-4 text-sm text-gray-700">
                    @if($latestPackageSectionResult)
                        <p class="font-semibold text-gray-900">Hasil Tersimpan Terakhir</p>
                        <p class="mt-1">Skor: <span class="font-bold">{{ $latestPercent }}%</span>
                            @if($latestCorrect !== null && $latestTotal !== null)
                                ({{ $latestCorrect }}/{{ $latestTotal }})
                            @endif
                        </p>
                        <p class="mt-1 text-xs text-gray-500">Disimpan: {{ optional($latestPackageSectionResult->completed_at)->format('d M Y H:i') ?? '-' }}</p>
                    @else
                        <p class="font-semibold text-gray-900">Belum Ada Hasil Tersimpan</p>
                        <p class="mt-1 text-xs text-gray-500">Submit jawaban untuk menyimpan attempt pertama section ini.</p>
                    @endif
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

/* ── Reading answer key scoring (paket 1) ── */
window.readingPaket1AnswerKey = {
    q1: 'C', q2: 'D', q3: 'A', q4: 'B', q5: 'B', q6: 'B', q7: 'C', q8: 'A', q9: 'B',
    q10: 'bonding', q11: 'danger', q12: 'rest', q13: 'evolution',
    q14: 'FALSE', q15: 'TRUE', q16: 'NOT GIVEN', q17: 'sludge', q18: 'sand', q19: 'gravel',
    q20: 'H', q21: 'A', q22: 'F', q23: 'B', q24: 'D', q25_26: ['B', 'D'],
    q27: 'TRUE', q28: 'TRUE', q29: 'FALSE', q30: 'NOT GIVEN', q31: 'TRUE', q32: 'NOT GIVEN',
    q33: 'costly', q34: ['latex', 'gutta percha', 'latex/gutta percha'], q35: 'lead pipe',
    q36: 'impedance', q37: 'james buchanan', q38: 'camels', q39: 'tropical rains', q40: 'several hours'
};

const customReadingAnswerKey = @json($packageAnswerKey ?? []);
if (customReadingAnswerKey && typeof customReadingAnswerKey === 'object' && Object.keys(customReadingAnswerKey).length > 0) {
    window.readingPaket1AnswerKey = customReadingAnswerKey;
}

window.normalizeReadingAnswer = function(value) {
    return String(value || '')
        .trim()
        .toLowerCase()
        .replace(/[.,;:!?]/g, '')
        .replace(/\s+/g, ' ');
};

window.readReadingAnswer = function(questionNumber) {
    const field = document.querySelector(`[name="q${questionNumber}"]`);
    if (!field) return '';
    return field.value ?? '';
};

window.readReadingAnswerDisplay = function(questionNumber) {
    if (questionNumber === 25 || questionNumber === 26) {
        const checked = Array.from(document.querySelectorAll('input[name="q25_26[]"]:checked'))
            .map(el => String(el.value).toUpperCase())
            .sort();
        return checked.length ? checked.join(', ') : '-';
    }

    const raw = window.readReadingAnswer(questionNumber);
    return String(raw || '').trim() || '-';
};

window.getReadingExpectedAnswerDisplay = function(questionNumber) {
    const key = window.readingPaket1AnswerKey;

    if (questionNumber === 25 || questionNumber === 26) {
        return key.q25_26.join(', ');
    }

    const expected = key[`q${questionNumber}`];
    if (Array.isArray(expected)) {
        return expected.join(' / ');
    }

    return String(expected ?? '');
};

window.collectReadingAnswersPayload = function() {
    const payload = {};

    for (let q = 1; q <= 40; q++) {
        if (q === 25 || q === 26) {
            continue;
        }
        payload[`q${q}`] = window.readReadingAnswerDisplay(q);
    }

    payload.q25_26 = Array.from(document.querySelectorAll('input[name="q25_26[]"]:checked'))
        .map(el => String(el.value).toUpperCase())
        .sort();

    return payload;
};

window.isReadingAnswerCorrect = function(questionNumber) {
    const key = window.readingPaket1AnswerKey;
    const keyName = `q${questionNumber}`;

    if (questionNumber === 25 || questionNumber === 26) {
        const checked = Array.from(document.querySelectorAll('input[name="q25_26[]"]:checked')).map(el => String(el.value).toUpperCase()).sort();
        const answer = [...key.q25_26].sort();
        return checked.length === 2 && checked[0] === answer[0] && checked[1] === answer[1];
    }

    const userRaw = window.readReadingAnswer(questionNumber);
    const user = window.normalizeReadingAnswer(userRaw);
    const expected = key[keyName];

    if (Array.isArray(expected)) {
        return expected.some(item => window.normalizeReadingAnswer(item) === user);
    }

    // Preserve exact token checks for option-based answers.
    if (questionNumber <= 9 || (questionNumber >= 14 && questionNumber <= 16) || (questionNumber >= 20 && questionNumber <= 24) || (questionNumber >= 27 && questionNumber <= 32)) {
        return String(userRaw || '').trim().toUpperCase() === String(expected).toUpperCase();
    }

    return user === window.normalizeReadingAnswer(expected);
};

window.getReadingQuestionElements = function(questionNumber) {
    if (questionNumber === 25 || questionNumber === 26) {
        return Array.from(document.querySelectorAll('input[name="q25_26[]"]'));
    }

    const selectOrInput = document.querySelector(`[name="q${questionNumber}"]`);
    return selectOrInput ? [selectOrInput] : [];
};

window.resetReadingAnswerHighlights = function() {
    const fields = document.querySelectorAll('input[name^="q"], select[name^="q"]');
    fields.forEach((el) => {
        el.classList.remove('ring-2', 'ring-red-400', 'border-red-400', 'bg-red-50');
        el.classList.remove('ring-2', 'ring-green-400', 'border-green-400', 'bg-green-50');
    });
};

window.paintReadingQuestionResult = function(questionNumber, isCorrect) {
    const targets = window.getReadingQuestionElements(questionNumber);
    targets.forEach((el) => {
        el.classList.remove('ring-2', 'ring-red-400', 'border-red-400', 'bg-red-50', 'ring-green-400', 'border-green-400', 'bg-green-50');

        if (isCorrect) {
            el.classList.add('ring-2', 'ring-green-400', 'border-green-400', 'bg-green-50');
        } else {
            el.classList.add('ring-2', 'ring-red-400', 'border-red-400', 'bg-red-50');
        }
    });
};

document.addEventListener('DOMContentLoaded', function() {
    const submitBtn = document.getElementById('submitReadingAnswersBtn');
    const resultPanel = document.getElementById('readingResultPanel');
    const latestAttemptPanel = document.getElementById('latestAttemptPanel');
    if (!submitBtn || !resultPanel) return;

    const submitUrl = @json($packageSectionSubmitUrl ?? null);
    const redirectUrl = @json(route('online-test.show', ['slug' => 'ielts_academic']));
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    submitBtn.addEventListener('click', async function() {
        let correct = 0;
        const wrong = [];

        window.resetReadingAnswerHighlights();

        for (let q = 1; q <= 40; q++) {
            const ok = window.isReadingAnswerCorrect(q);
            if (ok) {
                correct += 1;
            } else {
                wrong.push(q);
            }

            window.paintReadingQuestionResult(q, ok);
        }

        resultPanel.classList.remove('hidden', 'border-red-200', 'bg-red-50', 'text-red-800', 'border-green-200', 'bg-green-50', 'text-green-800');

        if (wrong.length === 0) {
            resultPanel.classList.add('border-green-200', 'bg-green-50', 'text-green-800');
            resultPanel.innerHTML = `<p class="font-bold">Skor: ${correct}/40</p><p class="mt-1">Semua jawaban benar.</p>`;
        } else {
            resultPanel.classList.add('border-red-200', 'bg-red-50', 'text-red-800');
            const details = wrong.map((q) => {
                const userAnswer = window.readReadingAnswerDisplay(q);
                const expectedAnswer = window.getReadingExpectedAnswerDisplay(q);
                return `<li><span class="font-semibold">${q}</span>: jawaban Anda <span class="font-medium">${userAnswer}</span>, kunci <span class="font-medium">${expectedAnswer}</span></li>`;
            }).join('');

            resultPanel.innerHTML = `
                <p class="font-bold">Skor: ${correct}/40</p>
                <p class="mt-1">Salah di nomor: ${wrong.join(', ')}</p>
                <ul class="mt-3 list-disc pl-5 space-y-1 text-sm">${details}</ul>
            `;
        }

        if (!submitUrl) {
            resultPanel.innerHTML += `<p class="mt-3 text-xs">Status simpan: endpoint tidak tersedia.</p>`;
            resultPanel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            return;
        }

        try {
            const response = await fetch(submitUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    score: correct,
                    total_questions: 40,
                    wrong_numbers: wrong,
                    answers: window.collectReadingAnswersPayload(),
                }),
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const data = await response.json();
            resultPanel.innerHTML += `<p class="mt-3 text-xs">Status simpan: ${data.message || 'Berhasil'} (ID: ${data.result_id ?? '-'})</p>`;
            resultPanel.innerHTML += `<p class="mt-2 text-xs">Mengalihkan ke halaman IELTS Academic...</p>`;

            if (latestAttemptPanel) {
                latestAttemptPanel.innerHTML = `
                    <p class="font-semibold text-gray-900">Hasil Tersimpan Terakhir</p>
                    <p class="mt-1">Skor: <span class="font-bold">${data.score_percent ?? '-'}%</span> (${correct}/40)</p>
                    <p class="mt-1 text-xs text-gray-500">Disimpan: baru saja</p>
                `;
            }

            setTimeout(() => {
                window.location.href = redirectUrl;
            }, 1200);
        } catch (error) {
            resultPanel.innerHTML += `<p class="mt-3 text-xs">Status simpan: gagal (${error?.message || 'unknown error'})</p>`;
        }

        resultPanel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });
});
</script>

</body>
</html>

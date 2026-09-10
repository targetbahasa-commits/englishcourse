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
    </style>
</head>
<body class="font-sans antialiased bg-white">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')

{{-- Fixed full-screen layout --}}
<div class="fixed inset-0 z-0 flex flex-col">

    {{-- Top header --}}
    <div class="flex-none bg-white border-b border-gray-200 shadow-sm z-10">
        <div class="px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-center w-11 h-11 bg-white rounded-[10px] shadow-[0_2px_8px_rgba(0,0,0,0.06)] border border-gray-100 overflow-hidden flex-none relative">
                    <div class="absolute top-0 inset-x-0 h-1.5 bg-green-500"></div>
                    <svg class="w-5 h-5 text-gray-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-800 leading-tight">IELTS Reading – Mock Test {{ $testId ?? 2 }}</h1>
                    <p class="text-[13px] text-gray-500 mt-0.5">Cambridge {{ $edition ?? 19 }} Reading Practice</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition ?? 20, 'id' => $testId ?? 2]) }}" class="flex items-center gap-1.5 px-4 py-2 bg-[#f3f4f6] hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back
            </a>
        </div>
    </div>

    {{-- Split screen --}}
    <div class="flex-1 min-h-[0] grid overflow-hidden" style="grid-template-columns: 2.5fr 2fr;">

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

                    <h3 class="text-3xl font-bold text-center text-gray-900 mb-8 mt-4">Manatees</h3>


                    {{-- Passage text --}}
                    <div class="passage-content text-[16px] leading-[1.8] text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p>Manatees, also known as sea cows, are aquatic mammals that belong to a group of animals called Sirenia. This group also contains dugongs. Dugongs and manatees look quite alike – they are similar in size, colour and shape, and both have flexible flippers for forelimbs. However, the manatee has a broad, rounded tail, whereas the dugong's is fluked, like that of a whale. There are three species of manatees: the West Indian manatee (Trichechus manatus), the African manatee (Trichechus senegalensis) and the Amazonian manatee (Trichechus inunguis).</p>
                        
                        <p>Unlike most mammals, manatees have only six bones in their neck – most others, including humans and giraffes, have seven. This short neck allows a manatee to move its head up and down, but not side to side. To see something on its left or its right, a manatee must turn its entire body, steering with its flippers. Manatees have pectoral flippers but no back limbs, only a tail for propulsion. They do have pelvic bones, however – a leftover from their evolution from a four-legged to a fully aquatic animal. Manatees share some visual similarities to elephants. Like elephants, manatees have thick, wrinkled skin. They also have some hairs covering their bodies which help them sense vibrations in the water around them.</p>

                        <p>Seagrasses and other marine plants make up most of a manatee’s diet. Manatees spend about eight hours each day grazing and uprooting plants. They eat up to 15% of their weight in food each day. African manatees are omnivorous – studies have shown that molluscs and fish make up a small part of their diets. West Indian and Amazonian manatees are both herbivores.</p>

                        <p>Manatees’ teeth are all molars – flat, rounded teeth for grinding food. Due to manatees’ abrasive aquatic plant diet, these teeth get worn down and they eventually fall out, so they continually grow new teeth that get pushed forward to replace the ones they lose. Instead of having incisors to grasp their food, manatees have lips which function like a pair of hands to help tear food away from the seafloor.</p>
                        
                        <p>Manatees are fully aquatic, but as mammals, they need to come up to the surface to breathe. When awake, they typically surface every two to four minutes, but they can hold their breath for much longer. Adult manatees sleep underwater for 10–12 hours a day, but they come up for air every 15–20 minutes. Active manatees need to breathe more frequently. It’s thought that manatees use their muscular diaphragm and breathing to adjust their buoyancy. They may use diaphragm contractions to compress and store gas in folds in their large intestine to help them float.</p>
                        
                        <p>The West Indian manatee reaches about 3.5 metres long and weighs on average around 500 kilogrammes. It moves between fresh water and salt water, taking advantage of coastal mangroves and coral reefs, rivers, lakes and inland lagoons. There are two subspecies of West Indian manatee: the Antillean manatee is found in waters from the Bahamas to Brazil, whereas the Florida manatee is found in US waters, although some individuals have been recorded in the Bahamas. In winter, the Florida manatee is typically restricted to Florida. When the ambient water temperature drops below 20°C, it takes refuge in naturally and artificially warmed water, such as at the warm-water outfalls from powerplants.</p>
                        
                        <p>The African manatee is also about 3.5 metres long and found in the sea along the west coast of Africa, from Mauritania down to Angola. The species also makes use of rivers, with the mammals seen in landlocked countries such as Mali and Niger.</p>
                        
                        <p>The Amazonian manatee is the smallest species, though it is still a big animal. It grows to about 2.5 metres long and 350 kilogrammes. Amazonian manatees favour calm, shallow waters that are above 23°C. This species is found in fresh water in the Amazon Basin in Brazil, as well as in Colombia, Ecuador and Peru.</p>
                        
                        <p>All three manatee species are endangered or at a heightened risk of extinction. The African manatee and Amazonian manatee are both listed as Vulnerable by the International Union for Conservation of Nature (IUCN). It is estimated that 140,000 Amazonian manatees were killed between 1935 and 1954 for their meat, fat and skin, with the latter used to make leather. In more recent years, African manatee decline has been tied to incidental capture in fishing nets and hunting. Manatee hunting is now illegal in every country the African species is found in.</p>
                        
                        <p>The two subspecies of West Indian manatee are listed as Endangered by the IUCN. Both are also expected to undergo a decline of 20% over the next 40 years. A review of almost 1,800 cases of entanglement in fishing nets and of plastic consumption among marine mammals in US waters from 2009 to 2020 found that at least 700 cases involved manatees. The chief cause of death in Florida manatees is boat strikes. However, laws in certain parts of Florida now limit boat speeds during winter, allowing slow-moving manatees more time to respond.</p>

                    </div>
                </div>

                {{-- Passage 2 --}}
                <div class="mb-6 mt-16 pt-8 border-t border-gray-200">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 below.</p>

                    <h3 class="text-3xl font-bold text-center text-gray-900 mb-2 mt-4">Procrastination</h3>
                    <p class="text-center text-gray-700 italic mb-8 text-lg">A psychologist explains why we put off important tasks and how we can break this habit</p>

                    <div class="passage-content text-[16px] leading-[1.8] text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">
                        <p><strong class="mr-2 font-sans text-gray-900">A</strong>Procrastination is the habit of delaying a necessary task, usually by focusing on less urgent, more enjoyable, and easier activities instead. We all do it from time to time. We might be composing a message to a friend who we have to let down, or putting together an important report for college or work; we're doing our best to avoid doing the job at hand, but deep down we know that we should just be getting on with it. Unfortunately, berating ourselves won't stop us procrastinating again. In fact, it's one of the worst things we can do. This matters because, as my research shows, procrastination doesn't just waste time, but is actually linked to other problems, too.</p>

                        <p><strong class="mr-2 font-sans text-gray-900">B</strong>Contrary to popular belief, procrastination is not due to laziness or poor time management. Scientific studies suggest procrastination is, in fact, caused by poor mood management. This makes sense if we consider that people are more likely to put off starting or completing tasks that they are really not keen to do. If just thinking about the task threatens our sense of self-worth or makes us anxious, we will be more likely to put it off. Research involving brain imaging has found that areas of the brain linked to detection of threats and emotion regulation are actually different in people who chronically procrastinate compared to those who don't procrastinate frequently.</p>

                        <p><strong class="mr-2 font-sans text-gray-900">C</strong>Tasks that are emotionally loaded or difficult, such as preparing for exams, are prime candidates for procrastination. People with low self-esteem are more likely to procrastinate. Another group of people who tend to procrastinate are perfectionists, who worry their work will be judged harshly by others. We know that if we don't finish that report or complete those home repairs, then what we did can't be evaluated. When we avoid such tasks, we also avoid the negative emotions associated with them. This is rewarding, and it conditions us to use procrastination to repair our mood. If we engage in more enjoyable tasks instead, we get another mood boost. In the long run, however, procrastination isn't an effective way of managing emotions. The 'mood repair' we experience is temporary. Afterwards, people tend to be left with a sense of guilt that not only increases their negative mood, but also reinforces their tendency to procrastinate.</p>

                        <p><strong class="mr-2 font-sans text-gray-900">D</strong>So why is this such a problem? When most people think of the costs of procrastination, they think of the toll on productivity. For example, studies have shown that procrastination negatively impacts on student performance. But putting off reading textbooks and writing essays may affect other areas of students' lives. In one study of over 3,000 German students over a six-month period, those who reported procrastinating over their university work were also more likely to engage in study-related misconduct, such as cheating and plagiarism. But the behaviour that procrastination was most closely linked with was using fraudulent excuses to get deadline extensions. Other research shows that employees on average spend almost a quarter of their workday procrastinating, and again this is linked with negative outcomes. In fact, in one US survey of over 22,000 employees, participants who said they regularly procrastinated had less annual income and less employment stability. For every one-point increase on a measure of chronic procrastination, annual income decreased by US$15,000.</p>

                        <p><strong class="mr-2 font-sans text-gray-900">E</strong>Procrastination also correlates with serious health and well-being problems. A tendency to procrastinate is linked to poor mental health, including higher levels of depression and anxiety. Across numerous studies, I've found people who regularly procrastinate report a greater number of health issues, such as headaches, flu and colds, and digestive issues. They also experience higher levels of stress and poor sleep quality. They are less likely to practise healthy behaviours, such as eating a healthy diet and regularly exercising, and use destructive coping strategies to manage their stress. In one study of over 700 people, I found people prone to procrastination had a 63% greater risk of poor heart health after accounting for other personality traits and demographics.</p>

                        <p><strong class="mr-2 font-sans text-gray-900">F</strong>Finding better ways of managing our emotions is one route out of the vicious cycle of procrastination. An important first step is to manage our environment and how we view the task. There are a number of evidence-based strategies that can help us fend off distractions that can occupy our minds when we should be focusing on the thing we should be getting on with. For example, reminding ourselves about why the task is important and valuable can increase positive feelings towards it. Forgiving ourselves and feeling compassion when we procrastinate can help break the procrastination cycle. We should admit that we feel bad, but not be overly critical of ourselves. We should remind ourselves that we're not the first person to procrastinate, nor the last. Doing this can take the edge off the negative feelings we have about ourselves when we procrastinate. This can all make it easier to get back on track.</p>
                    </div>
                </div>

                {{-- Passage 3 --}}
                <div class="mb-6 mt-16 pt-8 border-t border-gray-200">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                    <h3 class="text-3xl font-bold text-center text-gray-900 mb-8 mt-4">Invasion of the Robot Umpires</h3>

                    <div class="passage-content text-[16px] leading-[1.8] text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p>A few years ago, Fred DeJesus from Brooklyn, New York became the first umpire in a minor league baseball game to use something called the Automated Ball-Strike System (ABS), often referred to as the 'robo-umpire'. Instead of making any judgments himself about a strike*, DeJesus had decisions fed to him through an earpiece, connected to a modified missile-tracking system. The contraption looked like a large black pizza box with one glowing green eye; it was mounted above the press stand.</p>

                        <p>Major League Baseball (MLB), who had commissioned the system, wanted human umpires to announce the calls, just as they would have done in the past. When the first pitch came in, a recorded voice told DeJesus it was a strike. Previously, calling a strike was a judgment call on the part of the umpire. Even if the batter does not hit the ball, a pitch that passes through the 'strike zone' (an imaginary zone about seventeen inches wide, stretching from the batter's knees to the middle of his chest) is considered a strike. During that first game, when DeJesus announced calls, there was no heckling and no shouted disagreement. Nobody said a word.</p>

                        <p>For a hundred and fifty years or so, the strike zone has been the game's animating force—countless arguments between a team's manager and the umpire have taken place over its boundaries and whether a ball had crossed through it. The rules of play have evolved in various stages. Today, everyone knows that you may scream your disagreement in an umpire's face, but you must never shout personal abuse at them or touch them. That's a no-no. When the robo-umpires came, however, the arguments stopped.</p>

                        <p>During the first robo-umpire season, players complained about some strange calls. In response, MLB decided to tweak the dimensions of the zone, and the following year the consensus was that ABS is profoundly consistent. MLB says the device is near-perfect, precise to within fractions of an inch. "It'll reduce controversy in the game, and be good for the game," says Rob Manfred, who is Commissioner for MLB. But the question is whether controversy is worth reducing, or whether it is the sign of a human hand.</p>

                        <p>A human, at least, yells back. When I spoke with Frank Viola, a coach for a North Carolina team, he said that ABS works as designed, but that it was also unforgiving and pedantic, almost legalistic. "Manfred is a lawyer," Viola noted. Some pitchers have complained that, compared with a human's, the robot's strike zone seems too precise. Viola was once a major-league player himself. When he was pitching, he explained, umpires rewarded skill. "Throw it where you aimed, and it would be a strike, even if it was an inch or two outside. There was a dialogue between pitcher and umpire."</p>

                        <p>The executive tasked with running the experiment for MLB is Morgan Sword, who's in charge of baseball operations. According to Sword, ABS was part of a larger project to make baseball more exciting since executives are terrified of losing younger fans, as has been the case with horse racing and boxing. He explains how they began the process by asking fans what version of baseball they found most exciting. The results showed that everyone wanted more action: more hits, more defense, more baserunning. This type of baseball essentially hasn't existed since the 1960s, when the hundred-mile-an-hour fastball, which is difficult to hit and control, entered the game. It flattened the game into strikeouts, walks, and home runs—a type of play lacking much action.</p>

                        <p>Sword's team brainstormed potential fixes. Any rule that existed, they talked about changing—from changing the bats to changing the geometry of the field. But while all of these were ruled out as potential fixes, ABS was seen as a perfect vehicle for change. According to Sword, once you get the technology right, you can load any strike zone you want into the system. "It might be a triangle, or a blob, or something shaped like Texas. Over time, as baseball evolves, ABS can allow the zone to change with it."</p>

                        <p>"In the past twenty years, sports have moved away from judgment calls. Soccer has Video Assistant Referees (for offside decisions, for example). Tennis has Hawk-Eye (for line calls, for example). For almost a decade, baseball has used instant replay on the base paths. This is widely liked, even if the precision can sometimes cause problems. But these applications deal with something physical: bases, lines, goals. The boundaries of action are precise, delineated like the keys of a piano. This is not the case with ABS and the strike zone. Historically, a certain discretion has been appreciated."</p>

                        <p>I decided to email Alva Noë, a professor at Berkeley University and a baseball fan, for his opinion. "Hardly a day goes by that I don't wake up and run through the reasons that this [robo-umpires] is such a terrible idea," he replied. He later told me, "This is part of a movement to use algorithms to take the hard choices of living out of life." Perhaps he's right. We watch baseball to kill time, not to maximize it. Some players I have met take a dissenting stance toward the robots too, believing that accuracy is not the answer. According to Joe Russo, who plays for a New Jersey team, "With technology, people just want everything to be perfect. That's not reality. I think perfect would be weird. Your teams are always winning, work is always just great, there's always money in your pocket, your car never breaks down. What is there to talk about?"</p>

                        <p class="text-sm italic text-gray-600 mt-4 border-t border-gray-100 pt-4">* <em>strike: a strike is when the batter swings at a ball and misses or when the batter does not swing at a ball that passes through the strike zone.</em></p>
                    </div>
                </div>

                {{-- Floating Annotation Toolbar --}}
                <div class="relative w-full flex flex-col items-center pointer-events-none z-30 mt-4 mb-2">
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
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto border-l border-gray-200 min-h-full">

                {{-- Questions 1–6: Note Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–6</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Choose <strong>ONE WORD AND/OR A NUMBER</strong> from the passage for each answer.</p>

                    <div class="border border-blue-200 bg-[#eef4fc] rounded-lg p-6 text-sm">
                        <h4 class="text-lg font-bold text-center mb-6 text-gray-900 border-b border-gray-300 pb-3">Manatees</h4>

                        <p class="font-bold text-gray-900 mb-3 text-base">Appearance</p>
                        <ul class="list-disc ml-5 space-y-4 mb-6">
                            <li class="text-gray-800 leading-loose">
                                look similar to dugongs, but with a differently shaped <span class="font-bold text-blue-700">1</span>
                                <input type="text" name="q1" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1">
                            </li>
                        </ul>

                        <p class="font-bold text-gray-900 mb-3 text-base">Movement</p>
                        <ul class="list-disc ml-5 space-y-4 mb-6">
                            <li class="text-gray-800 leading-relaxed">have fewer neck bones than most mammals</li>
                            <li class="text-gray-800 leading-loose">
                                need to use their <span class="font-bold text-blue-700">2</span>
                                <input type="text" name="q2" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1"> to help to turn their bodies around in order to look sideways
                            </li>
                            <li class="text-gray-800 leading-loose">
                                sense vibrations in the water by means of <span class="font-bold text-blue-700">3</span>
                                <input type="text" name="q3" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1"> on their skin
                            </li>
                        </ul>

                        <p class="font-bold text-gray-900 mb-3 text-base">Feeding</p>
                        <ul class="list-disc ml-5 space-y-4 mb-6">
                            <li class="text-gray-800 leading-loose">
                                eat mainly aquatic vegetation, such as <span class="font-bold text-blue-700">4</span>
                                <input type="text" name="q4" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1">
                            </li>
                            <li class="text-gray-800 leading-loose">
                                grasp and pull up plants with their <span class="font-bold text-blue-700">5</span>
                                <input type="text" name="q5" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1">
                            </li>
                        </ul>

                        <p class="font-bold text-gray-900 mb-3 text-base">Breathing</p>
                        <ul class="list-disc ml-5 space-y-4">
                            <li class="text-gray-800 leading-relaxed">come to the surface for air every 2-4 minutes when awake and every 15-20 while sleeping</li>
                            <li class="text-gray-800 leading-loose">
                                may regulate the <span class="font-bold text-blue-700">6</span>
                                <input type="text" name="q6" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1"> of their bodies by using muscles of diaphragm to store air internally
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Questions 7–13: True/False/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 7–13</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 1?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 7–13 on your answer sheet, write</p>

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
                                    [7, "West Indian manatees can be found in a variety of different aquatic habitats."],
                                    [8, "The Florida manatee lives in warmer waters than the Antillean manatee."],
                                    [9, "The African manatee's range is limited to coastal waters between the West African countries of Mauritania and Angola."],
                                    [10, "The extent of the loss of Amazonian manatees in the mid-twentieth century was only revealed many years later."],
                                    [11, "It is predicted that West Indian manatee populations will fall in the coming decades."],
                                    [12, "The risk to manatees from entanglement and plastic consumption increased significantly in the period 2009-2020."],
                                    [13, "There is some legislation in place which aims to reduce the likelihood of boat strikes on manatees in Florida."],
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


                {{-- ── PASSAGE 2 Questions ── --}}
                <div class="mt-12 mb-6">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Q14-16: Matching Information --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–16</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 2 has six paragraphs, <strong>A–F</strong>.</p>
                    <p class="text-sm text-gray-800 mb-1">Which paragraph contains the following information?</p>
                    <p class="text-sm font-bold text-gray-800 mb-4 mt-2">NB <span class="font-normal italic">You may use any letter more than once.</span></p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-white border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-700 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-800 text-center">Column 1</th>
                                    <th class="p-3 font-bold text-gray-800 w-28 text-center bg-white border-l border-white">Paragraph</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [14, 'mention of false assumptions about why people procrastinate'],
                                    [15, 'reference to the realisation that others also procrastinate'],
                                    [16, 'neurological evidence of a link between procrastination and emotion'],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center bg-white">{{ $num }}.</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed bg-white">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center bg-white border-l border-gray-100">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                @foreach(['A','B','C','D','E','F'] as $p)
                                                    <option value="{{ $p }}">{{ $p }}</option>
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

                {{-- Q17-22: Summary Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 17–22</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>

                    <div class="border border-blue-200 bg-[#f8fafc] rounded-lg p-6 text-sm">
                        <h4 class="text-lg font-bold text-center mb-5 text-gray-900 border-b border-gray-200 pb-3">What makes us procrastinate?</h4>
                        <div class="text-gray-800 leading-[2.5] space-y-4">
                            <p>
                                Many people think that procrastination is the result of 
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">17</span>
                                <input type="text" name="q17" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1 uppercase font-semibold text-center text-blue-800">.
                                Others believe it to be the result of an inability to organise time efficiently. 
                                But scientific studies suggest that procrastination is actually due to poor mood management. 
                                The tasks we are most likely to put off are those that could damage our self-esteem or cause us to feel 
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">18</span>
                                <input type="text" name="q18" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1 uppercase font-semibold text-center text-blue-800"> 
                                when we think about them. Research comparing chronic procrastinators with other people even found differences in the brain regions associated with regulating emotions and identifying 
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">19</span>
                                <input type="text" name="q19" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1 uppercase font-semibold text-center text-blue-800">.
                            </p>
                            <p class="pt-2 border-t border-gray-200">
                                Emotionally loaded and difficult tasks often cause us to procrastinate. Getting ready to take 
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">20</span>
                                <input type="text" name="q20" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1 uppercase font-semibold text-center text-blue-800"> 
                                might be a typical example of one such task. People who are likely to procrastinate tend to be either 
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">21</span>
                                <input type="text" name="q21" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1 uppercase font-semibold text-center text-blue-800"> 
                                or those with low self-esteem.
                            </p>
                            <p>
                                Procrastination is only a short-term measure for managing emotions. It's often followed by a feeling of 
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">22</span>
                                <input type="text" name="q22" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1 uppercase font-semibold text-center text-blue-800">, 
                                which worsens our mood and leads to more procrastination.
                            </p>
                        </div>
                    </div>
                </div>



                {{-- Q23-24: Choose TWO letters --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 23 and 24</strong></p>
                    <p class="text-sm text-gray-800 mb-4">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>

                    <p class="text-sm font-semibold text-gray-900 mb-4">Which <strong>TWO</strong> comparisons between employees who often procrastinate and those who do not are mentioned in the text?</p>

                    <div class="space-y-3 mb-8" id="q23-24-group">
                        @foreach([
                            'A' => "Their salaries are lower.",
                            'B' => "The quality of their work is inferior.",
                            'C' => "They don't keep their jobs for as long.",
                            'D' => "They don't enjoy their working lives as much.",
                            'E' => "They have poorer relationships with colleagues.",
                        ] as $letter => $text)
                        <label class="flex items-center gap-3 cursor-pointer group p-3 rounded-xl hover:bg-white border border-transparent hover:border-gray-200 transition-all">
                            <input type="checkbox" name="q23_24[]" value="{{ $letter }}"
                                   class="multi-select-2 w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none"
                                   data-group="q23-24-group">
                            <span class="text-sm text-gray-800"><strong class="mr-2">{{ $letter }}</strong>{{ $text }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Q25-26: Choose TWO letters --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 25 and 26</strong></p>
                    <p class="text-sm text-gray-800 mb-4">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>

                    <p class="text-sm font-semibold text-gray-900 mb-4">Which <strong>TWO</strong> recommendations for getting out of a cycle of procrastination does the writer give?</p>

                    <div class="space-y-3" id="q25-26-group">
                        @foreach([
                            'A' => 'not judging ourselves harshly',
                            'B' => 'setting ourselves manageable aims',
                            'C' => 'rewarding ourselves for tasks achieved',
                            'D' => 'prioritising tasks according to their importance',
                            'E' => 'avoiding things that stop us concentrating on our tasks',
                        ] as $letter => $text)
                        <label class="flex items-center gap-3 cursor-pointer group p-3 rounded-xl hover:bg-white border border-transparent hover:border-gray-200 transition-all">
                            <input type="checkbox" name="q25_26[]" value="{{ $letter }}"
                                   class="multi-select-2 w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none"
                                   data-group="q25-26-group">
                            <span class="text-sm text-gray-800"><strong class="mr-2">{{ $letter }}</strong>{{ $text }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>



                {{-- ── PASSAGE 3 Questions ── --}}
                <div class="mt-12 mb-6">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>

                {{-- Q27-32: YES/NO/NOT GIVEN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–32</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the claims of the writer in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 27–32 on your answer sheet, write</p>

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
                                    [27, 'When DeJesus first used ABS, he shared decision-making about strikes with it.'],
                                    [28, 'MLB considered it necessary to amend the size of the strike zone when criticisms were received from players.'],
                                    [29, "MLB is keen to justify the money spent on improving the accuracy of ABS's calculations."],
                                    [30, 'The hundred-mile-an-hour fastball led to a more exciting style of play.'],
                                    [31, "The differing proposals for alterations to the baseball bat led to fierce debate on Sword's team."],
                                    [32, 'ABS makes changes to the shape of the strike zone feasible.'],
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

                {{-- Q33-37: Summary Completion from list A-H --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 33–37</strong></p>
                    <p class="text-sm text-gray-800 mb-5">Complete the summary using the list of phrases, <strong>A–H</strong>, below.</p>

                    {{-- Phrase list --}}
                    <div class="border border-gray-200 rounded-xl bg-white p-5 mb-6 text-sm">
                        <div class="grid grid-cols-2 gap-x-6 gap-y-2">
                            @foreach(['A' => 'pitch boundary', 'B' => 'numerous disputes', 'C' => 'team tactics', 'D' => 'subjective assessment', 'E' => 'widespread approval', 'F' => 'former roles', 'G' => 'total silence', 'H' => 'perceived area'] as $letter => $phrase)
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-gray-700 w-5 flex-none">{{ $letter }}.</span>
                                <span class="bg-white border border-blue-200 text-blue-800 rounded-lg px-3 py-1.5 font-medium text-sm">{{ $phrase }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="border border-blue-200 bg-[#f8fafc] rounded-lg p-6 text-sm">
                        <h4 class="text-lg font-bold text-center mb-6 text-gray-900 border-b border-gray-200 pb-3">Calls by the umpire</h4>
                        <div class="text-gray-800 leading-[2.8] space-y-2">
                            <p>
                                Even after ABS was developed, MLB still wanted human umpires to shout out decisions as they had in their
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">33</span>
                                <div class="relative inline-block w-40 align-middle">
                                    <select name="q33" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(['A'=>'pitch boundary','B'=>'numerous disputes','C'=>'team tactics','D'=>'subjective assessment','E'=>'widespread approval','F'=>'former roles','G'=>'total silence','H'=>'perceived area'] as $l=>$p)
                                        <option value="{{ $l }}">{{ $l }}. {{ $p }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                                </div>.
                                The umpire's job had, at one time, required a
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">34</span>
                                <div class="relative inline-block w-44 align-middle">
                                    <select name="q34" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(['A'=>'pitch boundary','B'=>'numerous disputes','C'=>'team tactics','D'=>'subjective assessment','E'=>'widespread approval','F'=>'former roles','G'=>'total silence','H'=>'perceived area'] as $l=>$p)
                                        <option value="{{ $l }}">{{ $l }}. {{ $p }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                                </div>
                                about whether a ball was a strike.
                            </p>
                            <p>
                                A ball is considered a strike when the batter does not hit it and it crosses through a
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">35</span>
                                <div class="relative inline-block w-36 align-middle">
                                    <select name="q35" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(['A'=>'pitch boundary','B'=>'numerous disputes','C'=>'team tactics','D'=>'subjective assessment','E'=>'widespread approval','F'=>'former roles','G'=>'total silence','H'=>'perceived area'] as $l=>$p)
                                        <option value="{{ $l }}">{{ $l }}. {{ $p }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                                </div>
                                extending approximately from the batter's knee to his chest.
                            </p>
                            <p>
                                In the past,
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">36</span>
                                <div class="relative inline-block w-44 align-middle">
                                    <select name="q36" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(['A'=>'pitch boundary','B'=>'numerous disputes','C'=>'team tactics','D'=>'subjective assessment','E'=>'widespread approval','F'=>'former roles','G'=>'total silence','H'=>'perceived area'] as $l=>$p)
                                        <option value="{{ $l }}">{{ $l }}. {{ $p }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                                </div>
                                over strike calls were not uncommon, but today everyone accepts the complete ban on pushing or shoving the umpire. One difference, however, is that during the first game DeJesus used ABS, strike calls were met with
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">37</span>
                                <div class="relative inline-block w-36 align-middle">
                                    <select name="q37" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(['A'=>'pitch boundary','B'=>'numerous disputes','C'=>'team tactics','D'=>'subjective assessment','E'=>'widespread approval','F'=>'former roles','G'=>'total silence','H'=>'perceived area'] as $l=>$p)
                                        <option value="{{ $l }}">{{ $l }}. {{ $p }}</option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg></div>
                                </div>.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Q38-40: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 38–40</strong></p>
                    <p class="text-sm text-gray-800 mb-5">Choose the correct letter, <strong>A, B, C or D</strong>.</p>

                    <div class="space-y-7">
                        @foreach([
                            [38, 'What does the writer suggest about ABS in the fifth paragraph?', [
                                'A' => 'It is bound to make key decisions that are wrong.',
                                'B' => 'It may reduce some of the appeal of the game.',
                                'C' => 'It will lead to the disappearance of human umpires.',
                                'D' => 'It may increase calls for the rules of baseball to be changed.',
                            ]],
                            [39, 'Morgan Sword says that the introduction of ABS', [
                                'A' => 'was regarded as an experiment without a guaranteed outcome.',
                                'B' => 'was intended to keep up with developments in other sports.',
                                'C' => 'was a response to changing attitudes about the role of sport.',
                                'D' => 'was an attempt to ensure baseball retained a young audience.',
                            ]],
                            [40, 'Why does the writer include the views of Noë and Russo?', [
                                'A' => 'to show that attitudes to technology vary widely',
                                'B' => 'to argue that people have unrealistic expectations of sport',
                                'C' => 'to indicate that accuracy is not the same thing as enjoyment',
                                'D' => 'to suggest that the number of baseball fans needs to increase',
                            ]],
                        ] as [$num, $question, $options])
                        <div>
                            <p class="font-semibold text-gray-900 mb-3 text-sm"><span class="font-bold">{{ $num }}.</span> {{ $question }}</p>
                            <div class="space-y-2 pl-5">
                                @foreach($options as $letter => $text)
                                <label class="flex items-start gap-3 cursor-pointer group p-2 rounded-lg hover:bg-white transition-colors">
                                    <input type="radio" name="q{{ $num }}" value="{{ $letter }}" class="mt-0.5 flex-none text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer">
                                    <span class="text-sm text-gray-800 group-hover:text-black"><strong class="mr-1.5">{{ $letter }}.</strong>{{ $text }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>


                {{-- Final Submit --}}
                <div class="mt-8 flex justify-end pb-8">
                    <button class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm text-lg flex items-center gap-2">
                        Submit Answers
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
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
    
    // Timer functionality
    let timeLeft = 60 * 60;
    const timerObj = document.getElementById('time-remaining');
    if(timerObj) {
        setInterval(() => {
            if(timeLeft > 0) {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                let inner = `<svg class="w-5 h-5 flex-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                if(timerObj.innerHTML !== inner) timerObj.innerHTML = inner;
            }
        }, 1000);
    }
    
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
    while (el && el.tagName !== 'MARK') {
        if (el.classList && el.classList.contains('passage-content')) break;
        el = el.parentElement;
    }
    if (el && el.tagName === 'MARK') {
        const parent = el.parentNode;
        while (el.firstChild) {
            parent.insertBefore(el.firstChild, el);
        }
        parent.removeChild(el);
        parent.normalize(); 
    }
};
</script>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.multi-select-2').forEach(function(cb) {
            cb.addEventListener('change', function() {
                var groupId = this.dataset.group;
                var group = document.getElementById(groupId);
                if (!group) return;
                var checked = group.querySelectorAll('.multi-select-2:checked');
                if (checked.length > 2) {
                    // Uncheck the first one
                    checked[0].checked = false;
                }
            });
        });
    });
    </script>

</body>
</html>

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
<body class="font-sans antialiased bg-gray-50">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')

<div class="fixed inset-0 z-0 flex flex-col" style="padding-left: 0;">

    <div class="flex-none bg-white border-b border-gray-200 shadow-sm z-10">
        <div class="px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="p-2.5 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477-4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">IELTS Reading – Mock Test {{ $testId }}</h1>
                    <p class="text-sm text-gray-500">Cambridge IELTS 20 Reading Practice</p>
                </div>
            </div>
            <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId]) }}" class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back
            </a>
        </div>
    </div>

    <div class="flex-1 min-h-0 grid overflow-hidden" style="grid-template-columns: 2.5fr 2fr;">

        {{-- LEFT: Reading Passage --}}
        <div class="h-full overflow-y-auto bg-white border-r border-gray-200 custom-scrollbar relative"
             x-data="{ highlightMode: false, pencilMode: false, eraserMode: false, highlightColor: 'yellow', canvasObj: null }"
             x-init="
                 $watch('pencilMode', value => { if (value && !canvasObj) { canvasObj = window.initDrawingCanvas($refs.drawingCanvas); } if (value && canvasObj) canvasObj.setMode('draw'); });
                 $watch('eraserMode', value => { if (value && !canvasObj) { canvasObj = window.initDrawingCanvas($refs.drawingCanvas); } if (value && canvasObj) canvasObj.setMode('erase'); });
                 new ResizeObserver(() => { if (canvasObj) canvasObj.resize(); }).observe($el);
             ">
            <canvas x-ref="drawingCanvas" class="absolute inset-x-0 inset-y-0 w-full z-10" :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'"></canvas>
            
            <div class="px-10 py-8 pb-32 max-w-3xl mx-auto relative z-20">
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">READING</span>
                </div>

                <div class="mb-6">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 1</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong>, which are based on Reading Passage 1 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-2">Frozen Food</h3>
                    <h4 class="text-lg text-center text-gray-700 mb-6">A US perspective on the development of the frozen food industry</h4>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">
                        <p>At some point in history, humans discovered that ice preserved food. There is evidence that winter ice was stored to preserve food in the summer as far back as 10,000 years ago. Two thousand years ago, the inhabitants of South America's Andean mountains had a unique means of conserving potatoes for later consumption. They froze them overnight, then trampled them to squeeze out the moisture, then dried them in the sun. This preserved their nutritional value—if not their aesthetic appeal.</p>
                        <p>Natural ice remained the main form of refrigeration until late in the 19th century. In the early 1800s, ship owners from Boston, USA, had enormous blocks of Arctic ice towed all over the Atlantic for the purpose of food preservation. In 1851, railroads first began putting blocks of ice in insulated rail cars to send butter from Ogdensburg, New York, to Boston.</p>
                        <p>Finally, in 1870, Australian inventors found a way to make 'mechanical ice'. They used a compressor to force a gas—ammonia at first and later Freon—through a condenser. The compressed gas gave up some of its heat as it moved through the condenser. Then the gas was released quickly into a low-pressure evaporator coil where it became liquid and cold. Air was blown over the evaporator coil and then this cooled air passed into an insulated compartment, lowering its temperature to freezing point.</p>
                        <p>Initially, this process was invented to keep Australian beer cool even in hot weather. But Australian cattlemen were quick to realize that, if they could put this new invention on a ship, they could export meat across the oceans. In 1880, a shipment of Australian beef and mutton was sent, frozen, to England. While the food frozen this way was still palatable, there was some deterioration. During the freezing process, crystals formed within the cells of the food, and when the ice expanded and the cells burst, this spoilt the flavor and texture of the food.</p>
                        <p>The modern frozen food industry began with the indigenous Inuit people of Canada. In 1912, a biology student in Massachusetts, USA, named Clarence Birdseye, ran out of money and went to Labrador in Canada to trap and trade furs. While he was there, he became fascinated with how the Inuit would quickly freeze fish in the Arctic air. The fish looked and tasted fresh even months later.</p>
                        <p>Birdseye returned to the USA in 1917 and began developing mechanical freezers capable of quick-freezing food. Birdseye methodically kept inventing better freezers and gradually built a business selling frozen fish from Gloucester, Massachusetts. In 1929, his business was sold and became General Foods, but he stayed with the company as director of research, and his division continued to innovate.</p>
                        <p>Birdseye was responsible for several key innovations that made the frozen food industry possible. He developed quick-freezing techniques that reduced the damage that crystals caused, as well as the technique of freezing the product in the package it was to be sold in. He also introduced the use of cellophane, the first transparent material for food packaging, which allowed consumers to see the quality of the product. Birdseye products also came in convenient size packages that could be prepared with a minimum of effort.</p>
                        <p>But there were still obstacles. In the 1930s, few grocery stores could afford to buy freezers for a market that wasn't established yet. So, Birdseye leased inexpensive freezer cases to them. He also leased insulated railroad cars so that he could ship his products nationwide. However, few consumers had freezers large enough or efficient enough to take advantage of the products.</p>
                        <p>Sales increased in the early 1940s, when World War II gave a boost to the frozen food industry because tin was being used for munitions. Canned foods were rationed to save tin for the war effort, while frozen foods were abundant and cheap. Finally, by the 1950s, refrigerator technology had developed far enough to make these appliances affordable for the average family. By 1953, 33 million US families owned a refrigerator, and manufacturers were gradually increasing the size of the freezer compartments in them.</p>
                        <p>1950s families were also looking for convenience at mealtimes, so the moment was right for the arrival of the 'TV Dinner'. Swanson Foods was a large, nationally recognized producer of canned and frozen poultry. In 1954, the company adapted some of Birdseye's freezing techniques, and with the help of a clever name and a huge advertising budget, it launched the first 'TV Dinner'. This consisted of frozen turkey, potatoes and vegetables served in the same segmented aluminum tray that was used by airlines. The product was an instant success. Within a year, Swanson had sold 13 million TV dinners. American consumers couldn't resist the combination of a trusted brand name, a single-serving package and the convenience of a meal that could be ready after only 25 minutes in a hot oven. By 1959, Americans were spending $2.7 billion annually on frozen foods, and half a billion of that was spent on ready-prepared meals such as the TV Dinner.</p>
                        <p>Today, the US frozen food industry has a turnover of over $67 billion annually, with $26.6 billion of that sold to consumers for home consumption. The remaining $40 billion in frozen food sales come through restaurants, cafeterias, hospitals and schools, and that represents a third of the total food service sales.</p>
                    </div>

                    <div class="sticky bottom-6 w-full flex flex-col items-center pointer-events-none z-30 mt-4 mb-2">
                        <div x-show="highlightMode" class="flex gap-2 p-2 bg-white/95 backdrop-blur-md rounded-full shadow-xl border border-gray-100 mb-3 pointer-events-auto" style="display:none;">
                            <button @click.prevent.stop="highlightColor='yellow'" class="w-8 h-8 rounded-full bg-yellow-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all" :class="highlightColor==='yellow' ? 'ring-2 ring-yellow-500 scale-110' : 'hover:ring-yellow-400'"></button>
                            <button @click.prevent.stop="highlightColor='green'"  class="w-8 h-8 rounded-full bg-green-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all" :class="highlightColor==='green'  ? 'ring-2 ring-green-500 scale-110'  : 'hover:ring-green-400'"></button>
                            <button @click.prevent.stop="highlightColor='blue'"   class="w-8 h-8 rounded-full bg-blue-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all" :class="highlightColor==='blue'   ? 'ring-2 ring-blue-500 scale-110'   : 'hover:ring-blue-400'"></button>
                            <button @click.prevent.stop="highlightColor='pink'"   class="w-8 h-8 rounded-full bg-pink-300 hover:ring-2 ring-offset-2 focus:outline-none transition-all" :class="highlightColor==='pink'   ? 'ring-2 ring-pink-500 scale-110'   : 'hover:ring-pink-400'"></button>
                        </div>

                        <div class="flex justify-center items-center gap-3 pointer-events-auto bg-white/40 p-1.5 rounded-full backdrop-blur-md shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-200/50">
                            <button @click="highlightMode=!highlightMode; pencilMode=false; eraserMode=false;" class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white opacity-90 hover:opacity-100 hover:shadow-md hover:text-green-600 hover:border-green-400 hover:scale-105 transition-all" :class="{ '!bg-green-500 !text-white !border-green-600 shadow-md !opacity-100': highlightMode }" title="Highlight Tool">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                            </button>
                            <button @click="pencilMode=!pencilMode; highlightMode=false; eraserMode=false;" class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white opacity-90 hover:opacity-100 hover:shadow-md hover:text-blue-600 hover:border-blue-400 hover:scale-105 transition-all" :class="{ '!bg-blue-500 !text-white !border-blue-600 shadow-md !opacity-100': pencilMode }" title="Pencil Tool">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <button @click="eraserMode=!eraserMode; pencilMode=false; highlightMode=false;" class="w-12 h-12 flex items-center justify-center rounded-full bg-white/80 backdrop-blur-sm shadow-sm border border-gray-100 text-gray-500 hover:bg-white opacity-90 hover:opacity-100 hover:shadow-md hover:text-indigo-600 hover:border-indigo-400 hover:scale-105 transition-all" :class="{ '!bg-indigo-500 !text-white !border-indigo-600 shadow-md !opacity-100': eraserMode }" title="Eraser Tool">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 21-4.3-4.3c-1-1-1-2.5 0-3.4l9.6-9.6c1-1 2.5-1 3.4 0l5.6 5.6c1 1 1 2.5 0 3.4L13 21"/><path d="M22 21H7"/><path d="m5 11 9 9"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Passage 2 --}}
                <div class="mb-6 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2.</p>
                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">Can the planet's coral reefs be saved?</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">
                        <div class="flex gap-4">
                            <span class="font-bold text-lg w-5 flex-none" id="para-A">A</span>
                            <div>
                                <p class="mb-4">Conservationists have put the final touches to a giant artificial reef they have been assembling at the world-renowned Zoological Society of London (London Zoo). Samples of the planet's most spectacular corals – vivid green branching coral, yellow scroll, blue ridge and many more species – have been added to the giant tank along with fish that thrive in their presence: blue tang, clownfish and many others. The reef is in the zoo's new gallery, Tiny Giants, which is dedicated to the minuscule invertebrate creatures that sustain life across the planet. The coral reef tank and its seven-metre-wide window form the core of the exhibition.</p>
                                <p>'Coral reefs are the most diverse ecosystems on Earth and we want to show people how wonderful they are,' said Paul Pearce-Kelly, senior curator of invertebrates and fish at the Zoological Society of London. 'However, we also want to highlight the research and conservation efforts that are now being carried out to try to save them from the threat of global warming.' They want people to see what is being done to try to save these wonders.</p>
                            </div>
                        </div>

                        <div class="flex gap-4 mt-6">
                            <span class="font-bold text-lg w-5 flex-none" id="para-B">B</span>
                            <p>Corals are composed of tiny animals, known as polyps, with tentacles for capturing small marine creatures in the sea water. These polyps are transparent but get their brilliant tones of pink, orange, blue, green, etc. from algae that live within them, which in turn get protection, while their photosynthesising of the sun's rays provides nutrients for the polyps. This comfortable symbiotic relationship has led to the growth of coral reefs that cover 0.1% of the planet's ocean bed while providing homes for more than 25% of marine species, including fish, molluscs, sponges and shellfish.</p>
                        </div>

                        <div class="flex gap-4 mt-6">
                            <span class="font-bold text-lg w-5 flex-none" id="para-C">C</span>
                            <p>As a result, coral reefs are often described as the 'rainforests of the sea', though the comparison is dismissed by some naturalists, including David Attenborough. 'People say you cannot beat the rainforest,' Attenborough has stated. 'But that is simply not true. You go there and the first thing you think is: where ... are the birds? Where are the animals? They are hiding in the trees, of course. No, if you want beauty and wildlife, you want a coral reef. Put on a mask and stick your head under the water. The sight is mind-blowing.'</p>
                        </div>

                        <div class="flex gap-4 mt-6">
                            <span class="font-bold text-lg w-5 flex-none" id="para-D">D</span>
                            <div>
                                <p class="mb-4">Unfortunately, these majestic sights are now under very serious threat, with the most immediate problem coming in the form of thermal stress. Rising ocean temperatures are triggering bleaching events that strip reefs of their colour and eventually kill them. And that is just the start. Other menaces include ocean acidification, sea level increase, pollution by humans, deoxygenation and ocean current changes, while the climate crisis is also increasing habitat destruction. As a result, vast areas – including massive chunks of Australia's Great Barrier Reef – have already been destroyed, and scientists advise that more than 90% of reefs could be lost by 2050 unless urgent action is taken to tackle global heating and greenhouse gas emissions.</p>
                                <p>Pearce-Kelly says that coral reefs have to survive really harsh conditions – wave erosion and other factors. And 'when things start to go wrong in the oceans, then corals will be the first to react. And that is exactly what we are seeing now. Coral reefs are dying and they are telling us that all is not well with our planet.'</p>
                            </div>
                        </div>

                        <div class="flex gap-4 mt-6">
                            <span class="font-bold text-lg w-5 flex-none" id="para-E">E</span>
                            <p>However, scientists are trying to pinpoint hardy types of coral that could survive our overheated oceans, and some of this research will be carried out at London Zoo. 'Behind our ... coral reef tank we have built laboratories where scientists will be studying coral species,' said Pearce-Kelly. One aim will be to carry out research on species to find those that can survive best in warm, acidic waters. Another will be to try to increase coral breeding rates. 'Coral spawn just once a year,' he added. 'However, aquarium-based research has enabled some corals to spawn artificially, which can assist coral reef restoration efforts. And if this can be extended for all species, we could consider the launching of coral-spawning programmes several times a year. That would be a big help in restoring blighted reefs.'</p>
                        </div>

                        <div class="flex gap-4 mt-6">
                            <span class="font-bold text-lg w-5 flex-none" id="para-F">F</span>
                            <p>Research in these fields is being conducted in laboratories around the world, with the London Zoo centre linked to this global network. Studies carried out in one centre can then be tested in others. The resulting young coral can then be displayed in the tank in Tiny Giants. 'The crucial point is that the progress we make in making coral better able to survive in a warming world can be shown to the public and encourage them to believe that we can do something to save the planet's reefs,' said Pearce-Kelly. 'Saving our coral reefs is now a critically important ecological goal.'</p>
                        </div>
                    </div>
                </div>
                
                {{-- Passage 3 --}}
                <div class="mb-6 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3.</p>
                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-2">Robots and us</h3>
                    <p class="text-center text-gray-700 italic mb-6">Three leaders in their fields answer questions about our relationships with robot</p>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">
                        <p>When asked ‘Should robots be used to colonise other planets?’, cosmology and astrophysics Professor Martin Rees said he believed the solar system would be mapped by robotic craft by the end of the century. ‘The next step would be mining of asteroids, enabling fabrication of large structures in space without having to bring all the raw materials from Earth. ... I think this is more realistic and benign than the ... “terraforming”* of planets.’ He maintains that colonised planets ‘should be preserved with a status that is analogous to Antarctica here on Earth.’</p>
                        <p>On the question of using robots to colonise other planets and exploit mineral resources, engineering Professor Daniel Wolpert replied, ‘I don’t see a pressing need to colonise other planets unless we can bring [these] resources back to Earth. The vast majority of Earth is currently inaccessible to us. Using robots to gather resources nearer to home would seem to be a better use of our robotic tools.’</p>
                        <p>Meanwhile, for anthropology Professor Kathleen Richardson, the idea of ‘colonisation’ of other planets seemed morally dubious: ‘I think whether we do something on Earth or on Mars we should always do it in the spirit of a genuine interest in “the Other”, not to impose a particular model, but to meet “the Other”.’</p>
                        <p>In response to the second question, ‘How soon will machine intelligence outstrip human intelligence?’, Rees mentions robots that are advanced enough to beat humans at chess, but then goes on to say, ‘Robots are still limited in their ability to sense their environment: they can’t yet recognise and move the pieces on a real chessboard as cleverly as a child can. Later this century, however, their more advanced successors may relate to their surroundings, and to people, as adeptly as we do. Moral questions then arise. ... Should we feel guilty about exploiting [sophisticated robots]? Should we fret if they are underemployed, frustrated, or bored?’</p>
                        <p>Wolpert’s response to the question about machine intelligence outstripping human intelligence was this: ‘In a limited sense it already has. Machines can already navigate, remember and search for items with an ability that far outstrips humans. However, there is no machine that can identify visual objects or speech with the reliability and flexibility of humans. ... Expecting a machine close to the creative intelligence of a human within the next 50 years would be highly ambitious.’</p>
                        <p>Richardson believes that our fear of machines becoming too advanced has more to do with human nature than anything intrinsic to the machines themselves. In her view, it stems from humans’ tendency to personify inanimate objects: we create machines based on representations of ourselves, imagine that machines think and behave as we do, and therefore see them as an autonomous threat. ‘One of the consequences of thinking that the problem lies with machines is that ... we tend to imagine they are greater and more powerful than they really are and subsequently they become so.’</p>
                        <p>This led on to the third question, ‘Should we be scared by advances in artificial intelligence?’ To this question, Rees replied, ‘Those who should be worried are the futurologists who believe in the so-called “singularity”.** ... And another worry is that we are increasingly dependent on computer networks, and that these could behave like a single “brain” with a mind of its own, and with goals that may be contrary to human welfare. I think we should ensure that robots remain as no more than “idiot savants” lacking the capacity to outwit us, even though they may greatly surpass us in the ability to calculate and process information.’</p>
                        <p>Wolpert’s response was to say that we have already seen the damaging effects of artificial intelligence in the form of computer viruses. ‘But in this case,’ he says, ‘the real intelligence is the malicious designer. Critically, the benefits of computers outweigh the damage that computer viruses cause. Similarly, while there may be misuses of robotics in the near future, the benefits that they will bring are likely to outweigh these negative aspects.’</p>
                        <p>Richardson’s response to this question was this: ‘We need to ask why fears of artificial intelligence and robots persist; none have in fact risen up and challenged human supremacy.’ She believes that as robots have never shown themselves to be a threat to humans, it seems unlikely that they ever will. In fact, she went on, ‘Not all fear [robots]; many people welcome machine intelligence.’</p>
                        <p>In answer to the fourth question, ‘What can science fiction tell us about robotics?’, Rees replied, ‘I sometimes advise students that it’s better to read first-rate science fiction than second-rate science – more stimulating, and perhaps no more likely to be wrong.’</p>
                        <p>As his response, Wolpert commented, ‘Science fiction has often been remarkable at predicting the future. ... Science fiction has painted a vivid spectrum of possible futures, from cute and helpful robots to dystopian robotic societies. Interestingly, almost no science fiction envisages a future without robots.’</p>
                        <p>Finally, on the question of science fiction, Richardson pointed out that in modern society, people tend to think there is reality on the one hand, and fiction and fantasy on the other. She then explained that the division did not always exist, and that scientists and technologists made this separation because they wanted to carve out the sphere of their work. ‘But the divide is not so clear cut, and that is why the worlds seem to collide at times,’ she said. ‘In some cases, we need to bring these different understandings together to get a whole perspective. Perhaps then, we won’t be so frightened that something we create as a copy of ourselves will be a [threat] to us.’</p>
                        
                        <div class="mt-8 pt-4 border-t border-gray-200">
                            <p class="text-sm italic text-gray-600 mb-2">* terraforming: modifying a planet’s atmosphere to suit human needs</p>
                            <p class="text-sm italic text-gray-600">** singularity: the point when robots will be able to start creating ever more sophisticated versions of themselves</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- RIGHT: Questions --}}
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar">
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto">

                {{-- Questions 1–7: Note Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–7</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 1–7 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-4">The history of frozen food</h4>
                        
                        <p class="font-bold text-gray-800 mb-2">2,000 years ago, South America</p>
                        <ul class="list-disc ml-5 space-y-2 mb-4">
                            <li class="text-gray-800 leading-loose">
                                People conserved the nutritional value of <span class="font-bold text-blue-500">1</span>
                                <input type="text" name="q1" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">, using a method of freezing then drying.
                            </li>
                        </ul>

                        <p class="font-bold text-gray-800 mb-2">1851, USA</p>
                        <ul class="list-disc ml-5 space-y-2 mb-4">
                            <li class="text-gray-800 leading-loose">
                                <span class="font-bold text-blue-500">2</span>
                                <input type="text" name="q2" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> was kept cool by ice during transportation in specially adapted trains.
                            </li>
                        </ul>

                        <p class="font-bold text-gray-800 mb-2">1880, Australia</p>
                        <ul class="list-disc ml-5 space-y-2 mb-4">
                            <li class="text-gray-800 leading-loose">
                                Two kinds of <span class="font-bold text-blue-500">3</span>
                                <input type="text" name="q3" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> were the first frozen food shipped to England.
                            </li>
                        </ul>

                        <p class="font-bold text-gray-800 mb-2">1917 onwards, USA</p>
                        <ul class="list-disc ml-5 space-y-2 mb-4">
                            <li class="text-gray-800 leading-loose">
                                Clarence Birdseye introduced innovations including:
                                <ul class="list-disc ml-5 mt-2 space-y-2">
                                    <li class="text-gray-800">quick-freezing methods, so that <span class="font-bold text-blue-500">4</span>
                                        <input type="text" name="q4" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> did not spoil the food.</li>
                                    <li class="text-gray-800">packaging products with <span class="font-bold text-blue-500">5</span>
                                        <input type="text" name="q5" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">, so the product was visible.</li>
                                </ul>
                            </li>
                        </ul>

                        <p class="font-bold text-gray-800 mb-2">Early 1940s, USA</p>
                        <ul class="list-disc ml-5 space-y-2 mb-4">
                            <li class="text-gray-800 leading-loose">
                                Frozen food became popular because of a shortage of <span class="font-bold text-blue-500">6</span>
                                <input type="text" name="q6" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">.
                            </li>
                        </ul>

                        <p class="font-bold text-gray-800 mb-2">1950s, USA</p>
                        <ul class="list-disc ml-5 space-y-2 mb-2">
                            <li class="text-gray-800 leading-loose">
                                A large number of homes now had a <span class="font-bold text-blue-500">7</span>
                                <input type="text" name="q7" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">.
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Questions 8–13: TRUE/FALSE/NOT GIVEN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 8–13</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 1?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 8–13 on your answer sheet, write</p>

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
                                    [8, "The ice transportation business made some Boston ship owners very wealthy in the early 1800s."],
                                    [9, "A disadvantage of the freezing process invented in Australia was that it affected the taste of food."],
                                    [10, "Clarence Birdseye travelled to Labrador in order to learn how the Inuit people froze fish."],
                                    [11, "Swanson Foods invested a great deal of money in the promotion of the TV Dinner."],
                                    [12, "Swanson Foods developed a new style of container for the launch of the TV Dinner."],
                                    [13, "The US frozen food industry is currently the largest in the world."],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
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
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Q14-19: Matching Headings --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–19</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 2 has six sections, <strong>A–F</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose the correct heading for each section from the list of headings below.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct number, <strong><em>i–vii</em></strong>, in boxes 14–19 on your answer sheet.</p>

                    <div class="border border-gray-400 p-4 rounded-lg mb-6 bg-gray-50 text-sm">
                        <p class="text-center font-bold mb-3">List of Headings</p>
                        @foreach([
                            ['i',    'Tried and tested solutions'],
                            ['ii',   'Cooperation beneath the waves'],
                            ['iii',  'Working to lessen the problems'],
                            ['iv',   'Disagreement about the accuracy of a certain phrase'],
                            ['v',    'Two clear educational goals'],
                            ['vi',   'Promoting hope'],
                            ['vii',  'A warning of further trouble ahead'],
                        ] as [$roman, $text])
                        <div class="flex gap-3 py-1">
                            <span class="font-bold italic w-10 flex-none text-right">{{ $roman }}</span>
                            <span>{{ $text }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Section</th>
                                    <th class="p-3 font-bold text-gray-600 w-36 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [14, 'A'], [15, 'B'], [16, 'C'], [17, 'D'], [18, 'E'], [19, 'F']
                                ] as [$num, $para])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm font-medium">Paragraph <strong>{{ $para }}</strong></td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                @foreach(['i','ii','iii','iv','v','vi','vii'] as $opt)
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
                
                {{-- Q20-21: Choose TWO --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6" x-data="{ selected: [] }">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 20 and 21</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Write the correct letters in boxes 20 and 21 on your answer sheet.</p>
                    <p class="text-sm text-gray-800 mb-4 mt-3">Which <strong>TWO</strong> of these causes of damage to coral reefs are mentioned by the writer of the text?</p>

                    <div class="space-y-3">
                        @foreach([
                            ['A', 'a rising number of extreme storms'],
                            ['B', 'the removal of too many fish from the sea'],
                            ['C', 'the contamination of the sea from waste'],
                            ['D', 'increased disease among marine species'],
                            ['E', 'alterations in the usual flow of water in the seas'],
                        ] as [$letter, $text])
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="q20_21[]" value="{{ $letter }}"
                                   x-model="selected" @change="if(selected.length > 2) selected.shift();"
                                   class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none">
                            <span class="text-sm text-gray-800 group-hover:text-blue-700 transition-colors">
                                <strong>{{ $letter }}</strong>&nbsp; {{ $text }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 mt-3 italic">Select exactly two options.</p>
                </div>

                {{-- Q22-23: Choose TWO --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6" x-data="{ selected: [] }">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 22 and 23</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Write the correct letters in boxes 22 and 23 on your answer sheet.</p>
                    <p class="text-sm text-gray-800 mb-4 mt-3">Which <strong>TWO</strong> of the following statements are true of the researchers at London Zoo?</p>

                    <div class="space-y-3">
                        @foreach([
                            ['A', 'They are hoping to expand the numbers of different corals being bred in laboratories.'],
                            ['B', 'They want to identify corals that can cope well with the changed sea conditions.'],
                            ['C', 'They are looking at ways of creating artificial reefs that corals could grow on.'],
                            ['D', 'They are trying out methods that would speed up reproduction in some corals.'],
                            ['E', 'They are investigating materials that might protect reefs from higher temperatures.'],
                        ] as [$letter, $text])
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="q22_23[]" value="{{ $letter }}"
                                   x-model="selected" @change="if(selected.length > 2) selected.shift();"
                                   class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none">
                            <span class="text-sm text-gray-800 group-hover:text-blue-700 transition-colors">
                                <strong>{{ $letter }}</strong>&nbsp; {{ $text }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-400 mt-3 italic">Select exactly two options.</p>
                </div>

                {{-- Q24-26: Sentence Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 24–26</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the sentences below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 24–26 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm space-y-4">
                        <div class="flex items-start gap-2">
                            <span class="font-bold text-gray-800 flex-none w-5 text-right mt-1">24</span>
                            <p class="text-gray-800 leading-loose">
                                Corals have a number of
                                <input type="text" name="q24" class="border-b border-gray-500 outline-none px-2 mx-1 w-32 bg-transparent text-sm placeholder-gray-400 font-semibold" placeholder="Answer">
                                which they use to collect their food.
                            </p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="font-bold text-gray-800 flex-none w-5 text-right mt-1">25</span>
                            <p class="text-gray-800 leading-loose">
                                Algae gain
                                <input type="text" name="q25" class="border-b border-gray-500 outline-none px-2 mx-1 w-32 bg-transparent text-sm placeholder-gray-400 font-semibold" placeholder="Answer">
                                from being inside the coral.
                            </p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="font-bold text-gray-800 flex-none w-5 text-right mt-1">26</span>
                            <p class="text-gray-800 leading-loose">
                                Increases in the warmth of the sea water can remove the
                                <input type="text" name="q26" class="border-b border-gray-500 outline-none px-2 mx-1 w-32 bg-transparent text-sm placeholder-gray-400 font-semibold" placeholder="Answer">
                                from coral.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ── PASSAGE 3 Questions ── --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>

                {{-- Q27-33: Matching Statements to Experts --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–33</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Look at the following statements (Questions 27–33) and the list of experts below.</p>
                    <p class="text-sm text-gray-800 mb-1">Match each statement with the correct expert, <strong>A, B or C</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Write the correct letter, <strong>A, B or C</strong>, in boxes 27–33 on your answer sheet.</p>
                    <p class="text-sm font-bold text-gray-800 mb-4"><em>NB You may use any letter more than once.</em></p>

                    <div class="border border-gray-400 p-4 rounded-lg mb-6 bg-gray-50 text-sm">
                        <p class="text-center font-bold mb-3">List of Experts</p>
                        @foreach([
                            ['A', 'Martin Rees'],
                            ['B', 'Daniel Wolpert'],
                            ['C', 'Kathleen Richardson'],
                        ] as [$letter, $name])
                        <div class="flex gap-3 py-1 justify-center">
                            <span class="font-bold w-4 flex-none text-right">{{ $letter }}</span>
                            <span>{{ $name }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="overflow-x-auto mt-4">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-32 text-center">Expert</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [27, 'For our own safety, humans will need to restrict the abilities of robots.'],
                                    [28, 'The risk of robots harming us is less serious than humans believe it to be.'],
                                    [29, 'It will take many decades for robot intelligence to be as imaginative as human intelligence.'],
                                    [30, 'We may have to start considering whether we are treating robots fairly.'],
                                    [31, 'Robots are probably of more help to us on Earth than in space.'],
                                    [32, 'The ideas in high-quality science fiction may prove to be just as accurate as those found in the work of mediocre scientists.'],
                                    [33, 'There are those who look forward to robots developing greater intelligence.']
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center w-36">
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

                {{-- Q34-36: Matching Sentence Endings --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 34–36</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete each sentence with the correct ending, <strong>A–D</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct letter, <strong>A–D</strong>, in boxes 34–36 on your answer sheet.</p>

                    <div class="border border-gray-400 p-4 rounded-lg mb-6 bg-gray-50 text-sm">
                        @foreach([
                            ['A', 'robots to explore outer space.'],
                            ['B', 'advances made in machine intelligence so far.'],
                            ['C', 'changes made to other planets for our own benefit.'],
                            ['D', 'the harm already done by artificial intelligence.'],
                        ] as [$letter, $text])
                        <div class="flex gap-3 py-1">
                            <span class="font-bold italic w-6 flex-none text-right">{{ $letter }}</span>
                            <span>{{ $text }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-4">
                        @foreach([
                            [34, 'Richardson and Rees express similar views regarding the ethical aspect of'],
                            [35, 'Rees and Wolpert share an opinion about the extent of'],
                            [36, 'Wolpert disagrees with Richardson on the question of'],
                        ] as [$num, $sentence])
                        <div class="flex items-start gap-3 bg-gray-50 p-4 border border-gray-100 rounded-lg">
                            <span class="font-bold text-gray-800 w-5 flex-none mt-1">{{ $num }}</span>
                            <div class="flex-1 flex flex-col xl:flex-row xl:items-center gap-3">
                                <span class="text-gray-800 text-sm leading-relaxed">{{ $sentence }}</span>
                                <div class="relative inline-block w-24 flex-none xl:ml-auto">
                                    <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1.5 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Q37-40: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 37–40</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Choose the correct letter, <strong>A, B, C or D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 37–40 on your answer sheet.</p>

                    <div class="space-y-6">
                        @php
                        $mcqs = [
                            [
                                'num' => 37,
                                'q' => 'What point does Richardson make about fear of machines?',
                                'options' => [
                                    'A' => 'It has grown alongside the development of ever more advanced robots.',
                                    'B' => 'It is the result of our inclination to attribute human characteristics to non-human entities.',
                                    'C' => 'It has its origins in basic misunderstandings about how inanimate objects function.',
                                    'D' => 'It demonstrates a key difference between human intelligence and machine intelligence.'
                                ]
                            ],
                            [
                                'num' => 38,
                                'q' => 'What potential advance does Rees see as a cause for concern?',
                                'options' => [
                                    'A' => 'robots outnumbering people',
                                    'B' => 'robots having abilities which humans do not',
                                    'C' => 'artificial intelligence developing independent thought',
                                    'D' => 'artificial intelligence taking over every aspect of our lives'
                                ]
                            ],
                            [
                                'num' => 39,
                                'q' => 'What does Wolpert emphasise in his response to the question about science fiction?',
                                'options' => [
                                    'A' => 'how science fiction influences our attitudes to robots',
                                    'B' => 'how fundamental robots are to the science fiction genre',
                                    'C' => 'how the image of robots in science fiction has changed over time',
                                    'D' => 'how reactions to similar portrayals of robots in science fiction may vary'
                                ]
                            ],
                            [
                                'num' => 40,
                                'q' => 'What is Richardson doing in her comment about reality and fantasy?',
                                'options' => [
                                    'A' => 'warning people not to confuse one with the other',
                                    'B' => 'outlining ways in which one has impacted on the other',
                                    'C' => 'recommending a change of approach in how people view them',
                                    'D' => 'explaining why scientists have a different perspective on them from other people'
                                ]
                            ]
                        ];
                        @endphp

                        @foreach($mcqs as $mcq)
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-5">
                            <div class="flex items-start gap-3 mb-4">
                                <span class="font-bold text-lg text-gray-900 flex-none">{{ $mcq['num'] }}</span>
                                <p class="text-base text-gray-900 font-medium">{{ $mcq['q'] }}</p>
                            </div>
                            <div class="ml-7 space-y-2.5">
                                @foreach($mcq['options'] as $letter => $text)
                                <label class="flex items-start gap-3 cursor-pointer group p-2 hover:bg-white rounded-lg transition-colors border border-transparent hover:border-gray-200">
                                    <input type="radio" name="q{{ $mcq['num'] }}" value="{{ $letter }}" class="mt-1 w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <div class="text-sm text-gray-700">
                                        <span class="font-bold mr-1">{{ $letter }}</span>
                                        <span class="group-hover:text-blue-700 transition-colors">{{ $text }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Final Submit Button --}}
                <div class="mt-10 mb-8 flex justify-center sticky bottom-6 z-40">
                    <button class="px-10 py-3 bg-green-600 hover:bg-green-700 text-white font-bold text-lg rounded-2xl transition-all shadow-[0_8px_30px_rgb(0,0,0,0.12)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.2)] hover:-translate-y-1 w-full max-w-md">
                        Submit Reading Test
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
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
    return { setMode: m => { mode = m; }, resize };
};

window.applyAnnotation = function(type, color) {
    const sel = window.getSelection();
    if (!sel || sel.rangeCount === 0 || sel.isCollapsed) return;
    const range = sel.getRangeAt(0);
    const mark  = document.createElement('mark');
    const colors = { yellow: '#fef08a', green: '#bbf7d0', blue: '#bfdbfe', pink: '#fbcfe8' };
    mark.style.backgroundColor = colors[color] || colors.yellow;
    mark.style.borderRadius = '2px';
    try { range.surroundContents(mark); } catch(e) {}
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
</script>

</body>
</html>

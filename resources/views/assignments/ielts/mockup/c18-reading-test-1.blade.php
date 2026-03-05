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

                {{-- Passage 1 --}}
                <div class="mb-6">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 1</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong>, which are based on Reading Passage 1 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">Urban farming</h3>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p class="text-center italic">In Paris, urban farmers are trying a soil-free approach to agriculture that uses less space and fewer resources. Could it help cities face the threats to our food supplies?</p>

                        <p>On top of a striking new exhibition hall in southern Paris, the world's largest urban rooftop farm has started to bear fruit. Strawberries that are small, intensely flavoured and resplendently red sprout abundantly from large plastic tubes. Peer inside and you see the tubes are completely hollow, the roots of dozens of strawberry plants dangling down inside them. From identical vertical tubes nearby burst row upon row of lettuces; near those are aromatic herbs, such as basil, sage and peppermint. Opposite, in narrow, horizontal trays packed not with soil but with coconut fibre, grow cherry tomatoes, shiny aubergines and brightly coloured chards.</p>

                        <p>Pascal Hardy, an engineer and sustainable development consultant, began experimenting with vertical farming and aeroponic growing towers – as the soil-free plastic tubes are known – on his Paris apartment block roof five years ago. The urban rooftop space above the exhibition hall is somewhat bigger: 14,000 square metres and almost exactly the size of a couple of football pitches. Already, the team of young urban farmers who tend it have picked, in one day, 3,000 lettuces and 150 punnets of strawberries. When the remaining two thirds of the vast open area are in production, 20 staff will harvest up to 1,000 kg of perhaps 35 different varieties of fruit and vegetables, every day. 'We're not ever, obviously, going to feed the whole city this way,' cautions Hardy. 'In the urban environment you're working with very significant practical constraints, clearly, on what you can do and where. But if enough unused space can be developed like this, there's no reason why you shouldn't eventually target maybe between 5% and 10% of consumption.'</p>

                        <p>Perhaps most significantly, however, this is a real-life showcase for the work of Hardy's flourishing urban agriculture consultancy, Agripolis, which is currently fielding enquiries from around the world to design, build and equip a new breed of soil-free inner-city farm. 'The method's advantages are many,' he says. 'First, I don't much like the fact that most of the fruit and vegetables we eat have been treated with something like 17 different pesticides, or that the intensive farming techniques that produced them are such huge generators of greenhouse gases. I don't much like the fact, either, that they've travelled an average of 2,000 refrigerated kilometres to my plate, that their quality is so poor, because the varieties are selected for their capacity to withstand such substantial journeys, or that 80% of the price I pay goes to wholesalers and transport companies, not the producers.'</p>

                        <p>Produce grown using this soil-free method, on the other hand – which relies solely on a small quantity of water, enriched with organic nutrients, pumped around a closed circuit of pipes, towers and trays – is 'produced up here, and sold locally, just down there. It barely travels at all,' Hardy says. 'You can select crop varieties for their flavour, not their resistance to the transport and storage chain, and you can pick them when they're really at their best, and not before.' No soil is exhausted, and the water that gently showers the plants' roots every 12 minutes is recycled, so the method uses 90% less water than a classic intensive farm for the same yield.</p>

                        <p>Urban farming is not, of course, a new phenomenon. Inner-city agriculture is booming from Shanghai to Detroit and Tokyo to Bangkok. Strawberries are being grown in disused shipping containers, mushrooms in underground carparks. Aeroponic farming, he says, is 'virtuous'. The equipment weighs little, can be installed on almost any flat surface and is cheap to buy: roughly €100 to €150 per square metre. It is cheap to run, too, consuming a tiny fraction of the electricity used by some techniques.</p>

                        <p>Produce grown this way typically sells at prices that, while generally higher than those of classic intensive agriculture, are lower than soil-based organic growers. There are limits to what farmers can grow this way, of course, and much of the produce is suited to the summer months. 'Root vegetables we cannot do, at least not yet,' he says. 'Radishes are OK, but carrots, potatoes, that kind of thing – the roots are simply too long. Fruit trees are obviously not an option. And beans tend to take up a lot of space for not much return.' Nevertheless, urban farming of the kind being practised in Paris is one part of a bigger and fast-changing picture that is bringing food production closer to our lives.</p>
                    </div>
                </div>

                {{-- Passage 2 --}}
                <div class="mb-6 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-2">Forest management in Pennsylvania, USA</h3>
                    <p class="text-center italic text-gray-600 mb-6 text-[15px]">How managing low-quality wood (also known as low-use wood) for bioenergy can encourage sustainable forest management</p>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">A</span>
                            <p>A tree's 'value' depends on several factors including its species, size, form, condition, quality, function, and accessibility, and depends on the management goals for a given forest. The same tree can be valued very differently by each person who looks at it. A large, straight black cherry tree has high value as timber to be cut into logs or made into furniture, but for a landowner more interested in wildlife habitat, the real value of that stem (or trunk) may be the food it provides to animals. Likewise, if the tree suffers from black knot disease, its value for timber decreases, but to a woodworker interested in making bowls, it brings an opportunity for a unique and beautiful piece of art.</p>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">B</span>
                            <p>In the past, Pennsylvania landowners were solely interested in the value of their trees as high-quality timber. The norm was to remove the stems of highest quality and leave behind poorly formed trees that were not as well suited to the site where they grew. This practice, called 'high-grading', has left a legacy of 'low-use wood' in the forests. Some people even call these 'junk trees', and they are abundant in Pennsylvania. These trees have lower economic value for traditional timber markets, compete for growth with higher-value trees, shade out desirable regeneration and decrease the health of a stand<sup>*</sup> leaving it more vulnerable to poor weather and disease. Management that specifically targets low-use wood can help landowners manage these forest health issues, and wood energy markets help promote this.</p>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">C</span>
                            <p>Wood energy markets can accept less expensive wood material of lower quality than would be suitable for traditional timber markets. Most wood used for energy in Pennsylvania is used to produce heat or electricity through combustion. Many schools and hospitals use wood boiler systems to heat and power their facilities, many homes are primarily heated with wood, and some coal plants incorporate wood into their coal streams to produce electricity. Wood can also be gasified for electrical generation and can even be made into liquid fuels like ethanol and gasoline for lorries and cars. All these products are made primarily from low-use wood. Several tree- and plant-cutting approaches, which could greatly improve the long-term quality of a forest, focus strongly or solely on the use of wood for those markets.</p>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">D</span>
                            <p>One such approach is called a Timber Stand Improvement (TSI) Cut. In a TSI Cut, really poor-quality tree and plant material is cut down to allow more space, light, and other resources to the highest-valued stems that remain. Removing invasive plants might be another primary goal of a TSI Cut. The stems that are left behind might then grow in size and develop more foliage and larger crowns or tops that produce more coverage for wildlife; they have a better chance to regenerate in a less crowded environment. TSI Cuts can be tailored to one farmer's specific management goals for his or her land.</p>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">E</span>
                            <p>Another approach that might yield a high amount of low-use wood is a Salvage Cut. With the many pests and pathogens visiting forests including hemlock wooly adelgid, Asian longhorned beetle, emerald ash borer, and gypsy moth, to name just a few, it is important to remember that those working in the forests can help ease these issues through cutting procedures. These types of cut reduce the number of sick trees and seek to manage the future spread of a pest problem. They leave vigorous trees that have stayed healthy enough to survive the outbreak.</p>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">F</span>
                            <p>A Shelterwood Cut, which only takes place in a mature forest that has already been thinned several times, involves removing all the mature trees when other seedlings have become established. This then allows the forester to decide which tree species are regenerated. It leaves a young forest where all trees are at a similar point in their growth. It can also be used to develop a two-tier forest so that there are two harvests and the money that comes in is spread out over a decade or more.</p>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">G</span>
                            <p>Thinnings and dense and dead wood removal for fire prevention also center on the production of low-use wood. However, it is important to remember that some retention of what many would classify as low-use wood is very important. The tops of trees that have been cut down should be left on the site so that their nutrients cycle back into the soil. In addition, trees with many cavities are extremely important habitats for insect predators like woodpeckers, bats and small mammals. They help control problem insects and increase the health and resilience of the forest. It is also important to remember that not all small trees are low-use. For example, many species like hawthorn provide food for wildlife. Finally, rare species of trees in a forest should also stay behind as they add to its structural diversity.</p>
                        </div>

                        <p class="text-xs text-gray-500 mt-4 border-t pt-2">* stand: a group of trees</p>
                    </div>
                </div>

                {{-- Passage 3 --}}
                <div class="mb-6 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-2">Conquering Earth’s space junk problem</h3>
                    <p class="text-center italic text-gray-600 mb-6 text-[15px]">Satellites, rocket shards and collision debris are creating major traffic risks in orbit around the planet. Researchers are working to reduce these threats</p>

                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">A</span>
                            <div class="space-y-4">
                                <p>Last year, commercial companies, military and civil departments and amateurs sent more than 400 satellites into orbit, over four times the yearly average in the previous decade. Numbers could rise even more sharply if leading space companies follow through on plans to deploy hundreds to thousands of large constellations of satellites to space in the next few years.</p>
                                <p>All that traffic can lead to disaster. Ten years ago, a US commercial Iridium satellite smashed into an inactive Russian communications satellite called Cosmos-2251, creating thousands of new pieces of space shrapnel that now threaten other satellites in low Earth orbit – the zone stretching up to 2,000 kilometres in altitude. Altogether, there are roughly 20,000 human-made objects in orbit, from working satellites to small rocket pieces. And satellite operators can’t steer away from every potential crash, because each move consumes time and fuel that could otherwise be used for the spacecraft’s main job.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">B</span>
                            <div class="space-y-4">
                                <p>Concern about space junk goes back to the beginning of the satellite era, but the number of objects in orbit is rising so rapidly that researchers are investigating new ways of attacking the problem. Several teams are trying to improve methods for assessing what is in orbit, so that satellite operators can work more efficiently in ever-more-crowded space. Some researchers are now starting to compile a massive data set that includes the best possible information on where everything is in orbit. Others are developing taxonomies of space debris – working on measuring properties such as the shape and size of an object, so that satellite operators know how much to worry about what’s coming their way.</p>
                                <p>The alternative, many say, is unthinkable. Just a few uncontrolled space crashes could generate enough debris to set off a runaway cascade of fragments, rendering near-Earth space unusable. ‘If we go on like this, we will reach a point of no return,’ says Carolin Frueh, an astrodynamical researcher at Purdue University in West Lafayette, Indiana.</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">C</span>
                            <p>Even as our ability to monitor space objects increases, so too does the total number of items in orbit. That means companies, governments and other players in space are collaborating in new ways to avoid a shared threat. International groups such as the Inter-Agency Space Debris Coordination Committee have developed guidelines on space sustainability. Those include inactivating satellites at the end of their useful life by venting pressurised materials or leftover fuel that might lead to explosions. The intergovernmental groups also advise lowering satellites deep enough into the atmosphere that they will burn up or disintegrate within 25 years. But so far, only about half of all missions have abided by this 25-year goal, says Holger Krag, head of the European Space Agency’s space-debris office in Darmstadt, Germany. Operators of the planned large constellations of satellites say they will be responsible stewards in their enterprises in space, but Krag worries that problems could increase, despite their best intentions. ‘What happens to those that fail or go bankrupt?’ he asks. ‘They are probably not going to spend money to remove their satellites from space.’</p>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">D</span>
                            <p>In theory, given the vastness of space, satellite operators should have plenty of room for all these missions to fly safely without ever nearing another object. So some scientists are tackling the problem of space junk by trying to find out where all the debris is to a high degree of precision. That would alleviate the need for many of the unnecessary manoeuvres that are carried out to avoid potential collisions. ‘If you knew precisely where everything was, you would almost never have a problem,’ says Marlon Sorge, a space-debris specialist at the Aerospace Corporation in El Segundo, California.</p>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">E</span>
                            <p>The field is called space traffic management, because it’s similar to managing traffic on the roads or in the air. Think about a busy day at an airport, says Moriba Jah, an astrodynamicist at the University of Texas at Austin: planes line up in the sky, landing and taking off close to one another in a carefully choreographed routine. Air-traffic controllers know the location of the planes down to one metre in accuracy. The same can’t be said for space debris. Not all objects in orbit are known, and even those included in databases are not tracked consistently.</p>
                        </div>

                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">F</span>
                            <div class="space-y-4">
                                <p>An additional problem is that there is no authoritative catalogue that accurately lists the orbits of all known space debris. Jah illustrates this with a web-based database that he has developed. It draws on several sources, such as catalogues maintained by the US and Russian governments, to visualise where objects are in space. When he types in an identifier for a particular space object, the database draws a purple line to designate its orbit. Only this doesn’t quite work for a number of objects, such as a Russian rocket body designated in the database as object number 32280. When Jah enters that number, the database draws two purple lines: the US and Russian sources contain two completely different orbits for the same object. Jah says that it is almost impossible to tell which is correct, unless a third source of information made it possible to cross-correlate.</p>
                                <p>Jah describes himself as a space environmentalist: ‘I want to make space a place that is safe to operate, that is free and useful for generations to come.’ Until that happens, he argues, the space community will continue devolving into a tragedy in which all spaceflight operators are polluting a common resource.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Floating Annotation Toolbar --}}
                <div class="sticky bottom-6 w-full flex flex-col items-center pointer-events-none z-30 mt-4 mb-2">
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
        </div>

        {{-- RIGHT: Questions --}}
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar">
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto">

                {{-- PASSAGE 1 QUESTIONS header --}}
                <div class="flex justify-center mb-6">
                    <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 1</span>
                </div>

                {{-- Questions 1–3: Sentence Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–3</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the sentences below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>NO MORE THAN TWO WORDS AND/OR A NUMBER</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 1–3 on your answer sheet.</p>

                    <div class="border-2 border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-5">Urban farming in Paris</h4>
                        <div class="space-y-4">
                            <div class="flex items-baseline gap-2 flex-wrap leading-loose">
                                <span class="font-bold w-5 flex-none">1</span>
                                <span>Vertical tubes are used to grow strawberries,</span>
                                <input type="text" name="q1" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                <span>and herbs.</span>
                            </div>
                            <div class="flex items-baseline gap-2 flex-wrap leading-loose">
                                <span class="font-bold w-5 flex-none">2</span>
                                <span>There will eventually be a daily harvest of as much as</span>
                                <input type="text" name="q2" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                <span>in weight of fruit and vegetables.</span>
                            </div>
                            <div class="flex items-baseline gap-2 flex-wrap leading-loose">
                                <span class="font-bold w-5 flex-none">3</span>
                                <span>It may be possible that the farm's produce will account for as much as 10% of the city's</span>
                                <input type="text" name="q3" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                <span>overall.</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Questions 4–7: Table Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 4–7</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the table below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 4–7 on your answer sheet.</p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm border-collapse border border-gray-400">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border border-gray-400 p-2 font-bold text-center" colspan="4">Intensive farming versus aeroponic urban farming</th>
                                </tr>
                                <tr class="bg-gray-50">
                                    <th class="border border-gray-400 p-2 font-bold w-32"></th>
                                    <th class="border border-gray-400 p-2 font-bold text-center">Growth</th>
                                    <th class="border border-gray-400 p-2 font-bold text-center">Selection</th>
                                    <th class="border border-gray-400 p-2 font-bold text-center">Sale</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border border-gray-400 p-2 font-bold align-top">Intensive farming</td>
                                    <td class="border border-gray-400 p-2 align-top">
                                        <ul class="list-disc ml-4 space-y-2">
                                            <li class="leading-loose">wide range of <strong>4</strong> <input type="text" name="q4" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> used</li>
                                            <li>techniques pollute air</li>
                                        </ul>
                                    </td>
                                    <td class="border border-gray-400 p-2 align-top">
                                        <ul class="list-disc ml-4 space-y-2">
                                            <li>quality not good</li>
                                            <li class="leading-loose">varieties of fruit and vegetables chosen that can survive long <strong>5</strong> <input type="text" name="q5" class="border-b border-gray-500 outline-none px-1 w-20 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"></li>
                                        </ul>
                                    </td>
                                    <td class="border border-gray-400 p-2 align-top">
                                        <ul class="list-disc ml-4 space-y-2">
                                            <li class="leading-loose"><strong>6</strong> <input type="text" name="q6" class="border-b border-gray-500 outline-none px-1 w-20 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> receive very little of overall income</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border border-gray-400 p-2 font-bold align-top">Aeroponic urban farming</td>
                                    <td class="border border-gray-400 p-2 align-top">
                                        <ul class="list-disc ml-4 space-y-2">
                                            <li>no soil used</li>
                                            <li>nutrients added to water, which is recycled</li>
                                        </ul>
                                    </td>
                                    <td class="border border-gray-400 p-2 align-top">
                                        <ul class="list-disc ml-4 space-y-2">
                                            <li class="leading-loose">produce chosen because of its <strong>7</strong> <input type="text" name="q7" class="border-b border-gray-500 outline-none px-1 w-20 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"></li>
                                        </ul>
                                    </td>
                                    <td class="border border-gray-400 p-2 align-top"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Questions 8–13: True/False/Not Given --}}
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
                                    [8,  'Urban farming can take place above or below ground.'],
                                    [9,  'Some of the equipment used in aeroponic farming can be made by hand.'],
                                    [10, 'Urban farming relies more on electricity than some other types of farming.'],
                                    [11, 'Fruit and vegetables grown on an aeroponic urban farm are cheaper than traditionally grown organic produce.'],
                                    [12, 'Most produce can be grown on an aeroponic urban farm at any time of the year.'],
                                    [13, 'Beans take longer to grow on an urban farm than other vegetables.'],
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

                    <div class="mt-6 flex justify-end">
                        <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                            Submit Answers
                        </button>
                    </div>
                </div>

                {{-- PASSAGE 2 QUESTIONS --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Questions 14–18: Paragraph matching --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–18</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 2 has seven paragraphs, <strong>A–G</strong>.</p>
                    <p class="text-sm text-gray-800 mb-1">Which paragraph contains the following information?</p>
                    <p class="text-sm italic text-gray-700 mb-1">Write the correct letter, <strong>A–G</strong>, in boxes 14–18 on your answer sheet.</p>
                    <p class="text-sm italic text-gray-700 mb-4"><strong>NB</strong> You may use any letter more than once.</p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Information</th>
                                    <th class="p-3 font-bold text-gray-600 w-28 text-center">Paragraph</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [14, 'bad outcomes for a forest when people focus only on its financial reward'],
                                    [15, 'reference to the aspects of any tree that contribute to its worth'],
                                    [16, 'mention of the potential use of wood to help run vehicles'],
                                    [17, 'examples of insects that attack trees'],
                                    [18, 'an alternative name for trees that produce low-use wood'],
                                ] as [$num, $info])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $info }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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

                {{-- Questions 19–21: Matching timber cuts --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 19–21</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Look at the following purposes (Questions 19–21) and the list of timber cuts below.</p>
                    <p class="text-sm text-gray-800 mb-1">Match each purpose with the correct timber cut, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Write the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>, in boxes 19–21 on your answer sheet.</p>
                    <p class="text-sm italic text-gray-700 mb-4"><strong>NB</strong> You may use any letter more than once.</p>

                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50 mb-5 inline-block">
                        <p class="font-bold text-sm text-center mb-2">List of Timber Cuts</p>
                        <div class="space-y-1 text-sm">
                            <div class="flex gap-3"><span class="font-bold">A</span><span>a TSI Cut</span></div>
                            <div class="flex gap-3"><span class="font-bold">B</span><span>a Salvage Cut</span></div>
                            <div class="flex gap-3"><span class="font-bold">C</span><span>a Shelterwood Cut</span></div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Purpose</th>
                                    <th class="p-3 font-bold text-gray-600 w-28 text-center">Cut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [19, 'to remove trees that are diseased'],
                                    [20, 'to generate income across a number of years'],
                                    [21, 'to create a forest whose trees are close in age'],
                                ] as [$num, $purpose])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $purpose }}</td>
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

                {{-- Questions 22–26: Sentence completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 22–26</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the sentences below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 22–26 on your answer sheet.</p>

                    <div class="space-y-4 text-sm">
                        <div class="flex items-baseline gap-2 flex-wrap leading-loose">
                            <span class="font-bold w-5 flex-none">22</span>
                            <span>Some dead wood is removed to avoid the possibility of</span>
                            <input type="text" name="q22" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            <span>.</span>
                        </div>
                        <div class="flex items-baseline gap-2 flex-wrap leading-loose">
                            <span class="font-bold w-5 flex-none">23</span>
                            <span>The</span>
                            <input type="text" name="q23" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            <span>from the tops of cut trees can help improve soil quality.</span>
                        </div>
                        <div class="flex items-baseline gap-2 flex-wrap leading-loose">
                            <span class="font-bold w-5 flex-none">24</span>
                            <span>Some damaged trees should be left, as their</span>
                            <input type="text" name="q24" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            <span>provide habitats for a range of creatures.</span>
                        </div>
                        <div class="flex items-baseline gap-2 flex-wrap leading-loose">
                            <span class="font-bold w-5 flex-none">25</span>
                            <span>Some trees that are small, such as</span>
                            <input type="text" name="q25" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            <span>, are a source of food for animals and insects.</span>
                        </div>
                        <div class="flex items-baseline gap-2 flex-wrap leading-loose">
                            <span class="font-bold w-5 flex-none">26</span>
                            <span>Any trees that are</span>
                            <input type="text" name="q26" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            <span>should be left to grow, as they add to the variety of species in the forest.</span>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                            Submit Answers
                        </button>
                    </div>
                </div>

                {{-- PASSAGE 3 QUESTIONS --}}
                <div class="mt-8 mb-2">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                    </div>
                </div>

                {{-- Questions 27–31: Section matching A–F --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–31</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 3 has six sections, <strong>A–F</strong>.</p>
                    <p class="text-sm text-gray-800 mb-1">Which section contains the following information?</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct letter, <strong>A–F</strong>, in boxes 27–31 on your answer sheet.</p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Information</th>
                                    <th class="p-3 font-bold text-gray-600 w-28 text-center">Section</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [27, 'a reference to the cooperation that takes place to try and minimise risk'],
                                    [28, 'an explanation of a person\'s aims'],
                                    [29, 'a description of a major collision that occurred in space'],
                                    [30, 'a comparison between tracking objects in space and the efficiency of a transportation system'],
                                    [31, 'a reference to efforts to classify space junk'],
                                ] as [$num, $info])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $info }}</td>
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

                {{-- Questions 32–35: Summary completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 32–35</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 32–35 on your answer sheet.</p>

                    <div class="border-2 border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-4">The Inter-Agency Space Debris Coordination Committee</h4>
                        <p class="text-gray-800 leading-loose">
                            The committee gives advice on how the <strong>32</strong>
                            <input type="text" name="q32" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            of space can be achieved. The committee advises that when satellites are no longer active, any unused <strong>33</strong>
                            <input type="text" name="q33" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            or pressurised material that could cause <strong>34</strong>
                            <input type="text" name="q34" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            should be removed.
                        </p>
                        <p class="text-gray-800 leading-loose mt-4">
                            Although operators of large satellite constellations accept that they have obligations as stewards of space, Holger Krag points out that the operators that become <strong>35</strong>
                            <input type="text" name="q35" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                            are unlikely to prioritise removing their satellites from space.
                        </p>
                    </div>
                </div>

                {{-- Questions 36–40: People matching --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 36–40</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Look at the following statements (Questions 36–40) and the list of people below.</p>
                    <p class="text-sm text-gray-800 mb-1">Match each statement with the correct person, <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Write the correct letter, <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong>, in boxes 36–40 on your answer sheet.</p>
                    <p class="text-sm italic text-gray-700 mb-4"><strong>NB</strong> You may use any letter more than once.</p>

                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50 mb-5 inline-block">
                        <p class="font-bold text-sm text-center mb-2">List of People</p>
                        <div class="space-y-1 text-sm">
                            <div class="flex gap-3"><span class="font-bold">A</span><span>Carolin Frueh</span></div>
                            <div class="flex gap-3"><span class="font-bold">B</span><span>Holger Krag</span></div>
                            <div class="flex gap-3"><span class="font-bold">C</span><span>Marlon Sorge</span></div>
                            <div class="flex gap-3"><span class="font-bold">D</span><span>Moriba Jah</span></div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-28 text-center">Person</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [36, 'Knowing the exact location of space junk would help prevent any possible danger.'],
                                    [37, 'Space should be available to everyone and should be preserved for the future.'],
                                    [38, 'A recommendation regarding satellites is widely ignored.'],
                                    [39, 'There is conflicting information about where some satellites are in space.'],
                                    [40, 'There is a risk we will not be able to undo the damage that occurs in space.'],
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
                                                <option value="D">D</option>
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

                    <div class="mt-6 flex justify-end">
                        <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                            Submit All Answers
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
/* ── Choose TWO enforcement (FIFO) ── */
(function () {
    const queues = {};
    document.addEventListener('change', function (e) {
        const cb = e.target;
        if (cb.type !== 'checkbox') return;
        const name = cb.name;
        if (!name) return;
        if (!queues[name]) queues[name] = [];
        const q = queues[name];
        if (cb.checked) {
            q.push(cb);
            if (q.length > 2) { const oldest = q.shift(); oldest.checked = false; }
        } else {
            const idx = q.indexOf(cb);
            if (idx !== -1) q.splice(idx, 1);
        }
    });
})();

/* ── Drawing canvas ── */
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
</script>

</body>
</html>

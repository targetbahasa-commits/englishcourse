<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Reading Mock Test {{ $testId }} - {{ config('app.name', 'Target Bahasa') }}</title>
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
                    <h1 class="text-xl font-bold text-gray-800">IELTS Reading – Mock Test {{ $testId }}</h1>
                    <p class="text-sm text-gray-500">Cambridge IELTS Reading Practice</p>
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

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">Climate change reveals ancient artefacts in Norway's glaciers</h3>

                    {{-- Passage text --}}
                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p><span class="font-bold mr-2 text-lg">A</span>Well above the treeline in Norway's highest mountains, ancient fields of ice are shrinking as Earth's climate warms. As the ice has vanished, it has been giving up the treasures it has preserved in cold storage for the last 6,000 years – items such as ancient arrows and skis from Viking Age* traders. And those artefacts have provided archaeologists with some surprising insights into how ancient Norwegians made their livings.</p>

                        <p><span class="font-bold mr-2 text-lg">B</span>Organic materials like textiles and hides are relatively rare finds at archaeological sites. This is because unless they're protected from the microorganisms that cause decay, they tend not to last long. Extreme cold is one reliable way to keep artefacts relatively fresh for a few thousand years, but once thawed out, these materials experience degradation relatively swiftly.</p>
                        <p>With climate change shrinking ice cover around the world, glacial archaeologists need to race the clock to find newly revealed artefacts, preserve them, and study them. If something fragile dries and is windblown it might very soon be lost to science, or an arrow might be exposed and then covered again by the next snow and remain well-preserved. The unpredictability means that glacial archaeologists have to be systematic in their approach to fieldwork.</p>

                        <p><span class="font-bold mr-2 text-lg">C</span>Over a nine-year period, a team of archaeologists, which included Lars Pilø of Oppland County Council, Norway, and James Barrett of the McDonald Institute for Archaeological Research, surveyed patches of ice in Oppland, an area of south-central Norway that is home to some of the country's highest mountains. Reindeer once congregated on these icy patches in the later summer months to escape biting insects, and from the late Stone Age**, hunters followed. In addition, trade routes threaded through the mountain passes of Oppland, linking settlements in Norway to the rest of Europe.</p>
                        <p>The slow but steady movement of glaciers tends to destroy anything at their bases, so the team focused on stationary patches of ice, mostly above 1,400 metres. That ice is found amid fields of frost-weathered boulders, fallen rocks, and exposed bedrock that for nine months of the year is buried beneath snow.</p>
                        <p>'Fieldwork is hard work – hiking with all our equipment, often camping on permafrost – but very rewarding. You're rescuing the archaeology, bringing the melting ice to wider attention, discovering a unique environmental history and really connecting with the natural environment,' says Barrett.</p>

                        <p><span class="font-bold mr-2 text-lg">D</span>At the edges of the contracting ice patches, archaeologists found more than 2,000 artefacts, which formed a material record that ran from 4,000 BCE to the beginnings of the Renaissance in the 14th century. Many of the artefacts are associated with hunting. Hunters would have easily misplaced arrows and they often discarded broken bows rather than take them all the way home. Other items could have been used by hunters traversing the high mountain passes of Oppland: all-purpose items like tools, skis, and horse tack.</p>

                        <p><span class="font-bold mr-2 text-lg">E</span>Barrett's team radiocarbon-dated 153 of the artefacts and compared those dates to the timing of major environmental changes in the region – such as periods of cooling or warming – and major social and economic shifts – such as the growth of farming settlements and the spread of international trade networks leading up to the Viking Age. They found that some periods had produced lots of artefacts, which indicates that people had been pretty active in the mountains during those times. But there were few or no signs of activity during other periods.</p>

                        <p><span class="font-bold mr-2 text-lg">F</span>What was surprising, according to Barrett, was the timing of these periods. Oppland's mountains present daunting terrain and in periods of extreme cold, glaciers could block the higher mountain passes and make travel in the upper reaches of the mountains extremely difficult. Archaeologists assumed people would stick to lower elevations during a time like the Late Antique Little Ice Age, a short period of deeper-than-usual cold from about 536–600 CE. But it turned out that hunters kept regularly venturing into the mountains even when the climate turned cold, based on the amount of stuff they had apparently dropped there.</p>
                        <p>'Remarkably, though, the finds from the ice may have continued through this period, perhaps suggesting that the importance of mountain hunting increased to supplement failing agricultural harvests in times of low temperatures,' says Barrett. A colder turn in the Scandinavian climate would likely have meant widespread crop failures, so more people would have depended on hunting to make up for those losses.</p>

                        <p><span class="font-bold mr-2 text-lg">G</span>Many of the artefacts Barrett's team recovered date from the beginning of the Viking Age, the 700s through to the 900s CE. Trade networks connecting Scandinavia with Europe and the Middle East were expanding around this time. Although we usually think of ships when we think of Scandinavian expansion, these recent discoveries show that plenty of goods travelled on overland routes, like the mountain passes of Oppland. And growing Norwegian towns, along with export markets, would have created a booming demand for hides to fight off the cold, as well as antlers to make useful things like combs. Business must have been good for hunters.</p>

                        <p><span class="font-bold mr-2 text-lg">H</span>Norway's mountains are probably still hiding a lot of history – and prehistory – in remote ice patches. When Barrett's team looked at the dates for their sample of 153 artefacts, they noticed a gap with almost no artefacts from about 3,800 to 2,200 BCE. In fact, archaeological finds from that period are rare all over Norway. The researchers say that could be because many of those artefacts have already disintegrated or are still frozen in the ice. That means archaeologists could be extracting some of those artefacts from retreating ice in years to come.</p>

                        <div class="mt-8 border-t border-gray-300 pt-4 text-[13px] text-gray-600 space-y-2">
                            <p>* Viking Age: a period of European history from around 700 CE to around 1050 CE when Scandinavian Vikings migrated throughout Europe by means of trade and warfare</p>
                            <p>** The Stone Age: a period in early history that began about 3.4 million years ago</p>
                        </div>
                    </div>
                </div>

                {{-- Passage 3 --}}
                <div class="mb-6 pt-10 border-t border-gray-200 mt-10">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>

                    <h3 class="text-2xl font-bold text-center text-gray-900 mb-4">Plant 'thermometer' triggers springtime growth by measuring night-time heat</h3>
                    <p class="text-[15px] italic text-gray-700 mb-8 text-center max-w-3xl mx-auto">A photoreceptor molecule in plant cells has been found to have a second job as a thermometer after dark – allowing plants to read seasonal temperature changes. Scientists say the discovery could help breed crops that are more resilient to the temperatures expected to result from climate change.</p>

                    {{-- Passage text --}}
                    <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">

                        <p><span class="font-bold mr-2 text-lg">A</span>An international team of scientists led by the University of Cambridge has discovered that the 'thermometer' molecule in plants enables them to develop according to seasonal temperature changes. Researchers have revealed that molecules called phytochromes – used by plants to detect light during the day – actually change their function in darkness to become cellular temperature gauges that measure the heat of the night.</p>
                        <p>The new findings, published in the journal <em>Science</em>, show that phytochromes control genetic switches in response to temperature as well as light to dictate plant development.</p>

                        <p><span class="font-bold mr-2 text-lg">B</span>At night, these molecules change states, and the pace at which they change is 'directly proportional to temperature', say scientists, who compare phytochromes to mercury in a thermometer. The warmer it is, the faster the molecular change – stimulating plant growth.</p>

                        <p><span class="font-bold mr-2 text-lg">C</span>Farmers and gardeners have known for hundreds of years how responsive plants are to temperature: warm winters cause many trees and flowers to bud early, something humans have long used to predict weather and harvest times for the coming year. The latest research pinpoints for the first time a molecular mechanism in plants that reacts to temperature – often triggering the buds of spring we long to see at the end of winter.</p>

                        <p><span class="font-bold mr-2 text-lg">D</span>With weather and temperatures set to become ever more unpredictable due to climate change, researchers say the discovery that this light-sensing molecule also functions as the internal thermometer in plant cells could help us breed tougher crops. 'It is estimated that agricultural yields will need to double by 2050, but climate change is a major threat to achieving this. Key crops such as wheat and rice are sensitive to high temperatures. Thermal stress reduces crop yields by around 10% for every one degree increase in temperature,' says lead researcher Dr Philip Wigge from Cambridge's Sainsbury Laboratory. 'Discovering the molecules that allow plants to sense temperature has the potential to accelerate the breeding of crops resilient to thermal stress and climate change.'</p>

                        <p><span class="font-bold mr-2 text-lg">E</span>In their active state, phytochrome molecules bind themselves to DNA to restrict plant growth. During the day, sunlight activates the molecules, slowing down growth. If a plant finds itself in shade, phytochromes are quickly inactivated – enabling it to grow faster to find sunlight again. This is how plants compete to escape each other's shade. 'Light-driven changes to phytochrome activity occur very fast, in less than a second,' says Wigge.</p>
                        <p>At night, however, it's a different story. Instead of a rapid deactivation following sundown, the molecules gradually change from their active to inactive state. This is called 'dark reversion'. 'Just as mercury rises in a thermometer, the rate at which phytochromes revert to their inactive state during the night is a direct measure of temperature,' says Wigge.</p>

                        <p><span class="font-bold mr-2 text-lg">F</span>'The lower the temperature, the slower the rate at which phytochromes revert to inactivity, so the molecules spend more time in their active, growth-suppressing state. This is why plants are slower to grow in winter. Warm temperatures accelerate dark reversion, so that phytochromes rapidly reach an inactive state and detach themselves from the plant's DNA – allowing genes to be expressed and plant growth to resume.' Wigge believes phytochrome thermo-sensing evolved at a later stage, and co-opted the biological network already used for light-based growth during the downtime of night.</p>

                        <p><span class="font-bold mr-2 text-lg">G</span>Some plants mainly use day length as an indicator of the season. Other species, such as daffodils, have considerable temperature sensitivity, and can flower months in advance during a warm winter. In fact, the discovery of the dual role of phytochromes provides the science behind a well-known rhyme long used to predict the coming season: oak before ash we'll have a splash, ash before oak we're in for a soak.</p>
                        <p>Wigge explains: 'Oak trees rely much more on temperature, likely using phytochromes as thermometers to dictate development, whereas ash trees rely on measuring day length to determine their seasonal timing. A warmer spring, and consequently a higher likeliness of a hot summer, will result in oak leafing before ash. A cold spring will see the opposite. As the British know only too well, a colder summer is likely to be a rain-soaked one.'</p>

                        <p><span class="font-bold mr-2 text-lg">H</span>The new findings are the culmination of twelve years of research involving scientists from Germany, Argentina and the US, as well as the Cambridge team. The work was done in a model system, using a mustard plant called <em>Arabidopsis</em>, but Wigge says the phytochrome genes necessary for temperature sensing are found in crop plants as well. 'Recent advances in plant genetics now mean that scientists are able to rapidly identify the genes controlling these processes in crop plants, and even alter their activity using precise molecular "scalpels",' adds Wigge. 'Cambridge is uniquely well-positioned to do this kind of research as we have outstanding collaborators nearby who work on more applied aspects of plant biology, and can help us transfer this new knowledge into the field.'</p>
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

                {{-- Questions 1–6: Diagram Labelling --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–6</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Label the diagrams below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 1–6 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-6 text-gray-900">The Persian Qanat Method</h4>
                        
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
                                    [7, "The counter-excavation method completely replaced the qanat method in the 6th century BCE."],
                                    [8, "Only experienced builders were employed to construct a tunnel using the counter-excavation method."],
                                    [9, "The information about a problem that occurred during the construction of the Saldae aqueduct system was found in an ancient book."],
                                    [10, "The mistake made by the builders of the Saldae aqueduct system was that the two parts of the tunnel failed to meet."],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
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

                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
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

                {{-- Questions 14–19: Matching Paragraph Information --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–19</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Reading Passage 2 has eight sections, <strong>A–H</strong>.</p>
                    <p class="text-sm text-gray-800 mb-3">Which section contains the following information?</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct letter, <strong>A–H</strong>, in boxes 14–19 on your answer sheet.</p>

                    <div class="space-y-4">
                        @foreach([
                            [14, "an explanation for weapons being left behind in the mountains"],
                            [15, "a reference to the physical difficulties involved in an archaeological expedition"],
                            [16, "an explanation of why less food may have been available"],
                            [17, "a reference to the possibility of future archaeological discoveries"],
                            [18, "examples of items that would have been traded"],
                            [19, "a reference to the pressure archaeologists are under to work quickly"],
                        ] as [$num, $statement])
                        <div class="flex items-start gap-4">
                            <span class="font-bold text-blue-600 w-6 text-right shrink-0">{{ $num }}</span>
                            <div class="flex-1 text-sm text-gray-800 leading-relaxed">{{ $statement }}</div>
                            <div class="w-24 shrink-0">
                                <div class="relative w-full">
                                    <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1.5 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(range('A', 'H') as $letter)
                                            <option value="{{ $letter }}">{{ $letter }}</option>
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

                {{-- Questions 20–22: Summary Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 20–22</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 20–22 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-4 text-gray-900">Interesting finds at an archaeological site</h4>

                        <p class="mb-4 text-gray-800 leading-loose">
                            Organic materials such as animal skins and textiles are not discovered very often at archaeological sites. They have little protection against <span class="font-bold">20</span>
                            <input type="text" name="q20" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400 focus:border-blue-500" placeholder="Answer">, which means that they decay relatively quickly. But this is not always the case. If temperatures are low enough, fragile artefacts can be preserved for thousands of years.
                        </p>

                        <p class="mb-2 text-gray-800 leading-loose">
                            A team of archaeologists have been working in the mountains in Oppland in Norway to recover artefacts revealed by shrinking ice cover. In the past, there were trade routes through these mountains and <span class="font-bold">21</span>
                            <input type="text" name="q21" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400 focus:border-blue-500" placeholder="Answer"> gathered there in the summer months to avoid being attacked by <span class="font-bold">22</span>
                            <input type="text" name="q22" class="border-b border-gray-500 outline-none px-1 w-32 bg-transparent text-sm placeholder-gray-400 focus:border-blue-500" placeholder="Answer"> on lower ground. The people who used these mountains left things behind and it is those objects that are of interest to archaeologists.
                        </p>
                    </div>

                    {{-- Submit --}}
                    <div class="mt-6 flex justify-end">
                        <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                            Submit Answers
                        </button>
                    </div>
                </div>

                {{-- Questions 23 and 24: Multiple Choice (Choose TWO) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 23 and 24</strong></p>
                    <p class="text-sm text-gray-800 mb-4">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letters in boxes 23 and 24 on your answer sheet.</p>

                    <div class="mb-5 text-sm text-gray-800 font-medium">
                        Which TWO of the following statements does the writer make about the discoveries of Barrett's team?
                    </div>

                    <div class="space-y-3 pl-2">
                        @foreach([
                            ['A', "Artefacts found in the higher mountain passes were limited to skiing equipment."],
                            ['B', "Hunters went into the mountains even during periods of extreme cold."],
                            ['C', "The number of artefacts from certain time periods was relatively low."],
                            ['D', "Radiocarbon dating of artefacts produced some unreliable results."],
                            ['E', "More artefacts were found in Oppland than at any other mountain site."],
                        ] as [$letter, $option])
                        <label class="flex items-start gap-4 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="q23_24[]" value="{{ $letter }}" class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 mt-0.5">
                            <div class="flex-1 text-sm text-gray-800"><span class="font-bold mr-2">{{ $letter }}</span> {{ $option }}</div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Questions 25 and 26: Multiple Choice (Choose TWO) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 25 and 26</strong></p>
                    <p class="text-sm text-gray-800 mb-4">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letters in boxes 25 and 26 on your answer sheet.</p>

                    <div class="mb-5 text-sm text-gray-800 font-medium">
                        Which TWO of the following statements does the writer make about the Viking Age?
                    </div>

                    <div class="space-y-3 pl-2">
                        @foreach([
                            ['A', "Hunters at this time benefited from an increased demand for goods."],
                            ['B', "The beginning of the period saw the greatest growth in the wealth of Vikings."],
                            ['C', "Vikings did not rely on ships alone to transport goods."],
                            ['D', "Norwegian towns at this time attracted traders from around the world."],
                            ['E', "Vikings were primarily interested in their trading links with the Middle East."],
                        ] as [$letter, $option])
                        <label class="flex items-start gap-4 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer transition-colors">
                            <input type="checkbox" name="q25_26[]" value="{{ $letter }}" class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 mt-0.5">
                            <div class="flex-1 text-sm text-gray-800"><span class="font-bold mr-2">{{ $letter }}</span> {{ $option }}</div>
                        </label>
                        @endforeach
                    </div>

                    {{-- Submit --}}
                    <div class="mt-6 flex justify-end">
                        <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                            Submit Answers
                        </button>
                    </div>
                </div>

                {{-- ── PASSAGE 3 Questions ── --}}
                <div class="mt-10 mb-6 px-2">
                    <h2 class="text-lg font-bold text-gray-900 uppercase tracking-wide">PASSAGE 3 QUESTIONS</h2>
                </div>

                {{-- Questions 27–32: True/False/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–32</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 27–32 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic">TRUE</span></div><div class="italic">if the statement agrees with the information</div>
                            <div><span class="font-bold italic">FALSE</span></div><div class="italic">if the statement contradicts the information</div>
                            <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if there is no information on this</div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach([
                            [27, "The Cambridge scientists' discovery of the 'thermometer molecule' caused surprise among other scientists."],
                            [28, "The target for agricultural production by 2050 could be missed."],
                            [29, "Wheat and rice suffer from a rise in temperatures."],
                            [30, "It may be possible to develop crops that require less water."],
                            [31, "Plants grow faster in sunlight than in shade."],
                            [32, "Phytochromes change their state at the same speed day and night."],
                        ] as [$num, $statement])
                        <div class="flex items-start gap-4">
                            <span class="font-bold text-blue-600 w-6 text-right shrink-0">{{ $num }}</span>
                            <div class="flex-1 text-sm text-gray-800 leading-relaxed">{{ $statement }}</div>
                            <div class="w-32 shrink-0">
                                <div class="relative w-full">
                                    <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1.5 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        <option value="TRUE">TRUE</option>
                                        <option value="FALSE">FALSE</option>
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

                {{-- Questions 33–37: Matching Paragraph Information --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 33–37</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Reading Passage 3 has eight sections, <strong>A–H</strong>.</p>
                    <p class="text-sm text-gray-800 mb-3">Which section contains the following information?</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct letter, <strong>A–H</strong>, in boxes 33–37 on your answer sheet.</p>

                    <div class="space-y-4">
                        @foreach([
                            [33, "mention of specialists who can make use of the research findings"],
                            [34, "a reference to a potential benefit of the research findings"],
                            [35, "scientific support for a traditional saying"],
                            [36, "a reference to people traditionally making plans based on plant behaviour"],
                            [37, "a reference to where the research has been reported"],
                        ] as [$num, $statement])
                        <div class="flex items-start gap-4">
                            <span class="font-bold text-blue-600 w-6 text-right shrink-0">{{ $num }}</span>
                            <div class="flex-1 text-sm text-gray-800 leading-relaxed">{{ $statement }}</div>
                            <div class="w-24 shrink-0">
                                <div class="relative w-full">
                                    <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-1.5 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                        <option value="" disabled selected>-</option>
                                        @foreach(range('A', 'H') as $letter)
                                            <option value="{{ $letter }}">{{ $letter }}</option>
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

                {{-- Questions 38–40: Sentence Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 38–40</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the sentences below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>NO MORE THAN TWO WORDS</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 38–40 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <div class="space-y-4">
                            <p class="text-gray-800 leading-loose">
                                <span class="font-bold mr-2 text-blue-600">38</span>
                                Daffodils are likely to flower early in response to 
                                <input type="text" name="q38" class="border-b border-gray-500 outline-none px-1 w-48 bg-transparent text-sm placeholder-gray-400 focus:border-blue-500" placeholder="Answer"> weather.
                            </p>
                            <p class="text-gray-800 leading-loose">
                                <span class="font-bold mr-2 text-blue-600">39</span>
                                If ash trees come into leaf before oak trees, the weather in 
                                <input type="text" name="q39" class="border-b border-gray-500 outline-none px-1 w-48 bg-transparent text-sm placeholder-gray-400 focus:border-blue-500" placeholder="Answer"> will probably be wet.
                            </p>
                            <p class="text-gray-800 leading-loose">
                                <span class="font-bold mr-2 text-blue-600">40</span>
                                The research was carried out using a particular species of 
                                <input type="text" name="q40" class="border-b border-gray-500 outline-none px-1 w-48 bg-transparent text-sm placeholder-gray-400 focus:border-blue-500" placeholder="Answer"> .
                            </p>
                        </div>
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

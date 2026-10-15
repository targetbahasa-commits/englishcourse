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
            body:has(#sidebar.w-64) .reading-fixed-shell,
            body:has(aside.w-64) .reading-fixed-shell {
                left: 16rem;
            }
            body:has(#sidebar.w-16) .reading-fixed-shell,
            body:has(#sidebar.w-14) .reading-fixed-shell,
            body:has(aside.w-16) .reading-fixed-shell,
            body:has(aside.w-14) .reading-fixed-shell {
                left: 4rem;
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

                {-- Passage 1 Card --}
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
                    {-- Drawing canvas for Passage 1 --}
                    <canvas x-ref="drawingCanvas"
                            class="absolute inset-0 w-full h-full z-10 rounded-2xl"
                            :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'">
                    </canvas>

                    <div class="relative z-20" :class="pencilMode ? 'pointer-events-none' : ''">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                            <span class="bg-pink-50 text-pink-600 font-bold px-3 py-1 rounded-lg text-sm tracking-wide uppercase">READING PASSAGE 1</span>
                        </div>

id="passage-1">
                    <p class="text-[13px] font-bold tracking-widest uppercase mb-1">READING PASSAGE 1</p>
                    <p class="text-[13px] italic mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong>, which are based on Reading Passage 1 below.</p>

                    <h2 class="text-2xl font-bold text-center mb-2">Bats to the rescue</h2>
                    <p class="text-center italic text-[15px] mb-6">How Madagascar's bats are helping to save the rainforest</p>

                    <div class="space-y-4 text-[15px] leading-relaxed text-gray-900">
                        <p>There are few places in the world where relations between agriculture and conservation are more strained. Madagascar's forests are being converted to agricultural land at a rate of one percent every year. Much of this destruction is fuelled by the cultivation of the country's main staple crop: rice. And a key reason for this destruction is that insect pests are destroying vast quantities of what is grown by local subsistence farmers, leading them to clear forest to create new paddy fields. The result is devastating habitat and biodiversity loss on the island, but not all species are suffering. In fact, some of the island's insectivorous bats are currently thriving and this has important implications for farmers and conservationists alike.</p>

                        <p>Enter University of Cambridge zoologist Ricardo Rocha. He's passionate about conservation, and bats. More specifically, he's interested in how bats are responding to human activity and deforestation in particular. Rocha's new study shows that several species of bats are giving Madagascar's rice farmers a vital pest control service by feasting on plagues of insects. And this, he believes, can ease the financial pressure on farmers to turn forest into fields.</p>

                        <p>Bats comprise roughly one-fifth of all mammal species in Madagascar and thirty-six recorded bat species are native to the island, making it one of the most important regions for conservation of this animal group anywhere in the world.</p>

                        <p>Co-leading an international team of scientists, Rocha found that several species of indigenous bats are taking advantage of habitat modification to hunt insects swarming above the country's rice fields. They include the Malagasy mouse-eared bat, Major's long-fingered bat, the Malagasy white-bellied free-tailed bat and Peters' wrinkle-lipped bat.</p>

                        <p>'These winner species are providing a valuable free service to Madagascar as biological pest suppressors,' says Rocha. 'We found that six species of bat are preying on rice pests, including the paddy swarming caterpillar and grass webworm. The damage which these insects cause puts the island's farmers under huge financial pressure and that encourages deforestation.'</p>

                        <p>The study, now published in the journal <em>Agriculture, Ecosystems and Environment</em>, set out to investigate the feeding activity of insectivorous bats in the farmland bordering the Ranomafana National Park in the southeast of the country.</p>

                        <p>Rocha and his team used state-of-the-art ultrasonic recorders to record over a thousand bat 'feeding buzzes' (echolocation sequences used by bats to target their prey) at 54 sites, in order to identify the favourite feeding spots of the bats. They next used DNA barcoding techniques to analyse droppings collected from bats at the different sites.</p>

                        <p>The recordings revealed that bat activity over rice fields was much higher than it was in continuous forest – seven times higher over rice fields which were on flat ground, and sixteen times higher over fields on the sides of hills – leaving no doubt that the animals are preferentially foraging in these man-made ecosystems. The researchers suggest that the bats favour these fields because lack of water and nutrient run-off make these crops more susceptible to insect pest infestations. DNA analysis showed that all six species of bat had fed on economically important insect pests. While the findings indicated that rice farming benefits most from the bats, the scientists also found indications that the bats were consuming pests of other crops, including the black twig borer (which infests coffee plants), the sugarcane cicada, the macadamia nut-borer, and the sober tabby (a pest of citrus fruits).</p>

                        <p>'The effectiveness of bats as pest controllers has already been proven in the USA and Catalonia,' said co-author James Kemp, from the University of Lisbon. 'But our study is the first to show this happening in Madagascar, where the stakes for both farmers and conservationists are so high.'</p>

                        <p>Local people may have a further reason to be grateful to their bats. While the animal is often associated with spreading disease, Rocha and his team found evidence that Malagasy bats feed not just on crop pests but also on mosquitoes – carriers of malaria, Rift Valley fever virus and elephantiasis – as well as blackflies, which spread river blindness.</p>

                        <p>Rocha points out that the relationship is complicated. When food is scarce, bats become a crucial source of protein for local people. Even the children will hunt them. And as well as roosting in trees, the bats sometimes roost in buildings, but are not welcomed there because they make them unclean. At the same time, however, they are associated with sacred caves and the ancestors, so they can be viewed as beings between worlds, which makes them very significant in the culture of the people. And one potential problem is that while these bats are benefiting from farming, at the same time deforestation is reducing the places where they can roost, which could have long-term effects on their numbers. Rocha says, 'With the right help, we hope that farmers can promote this mutually beneficial relationship by installing bat houses.'</p>

                        <p>Rocha and his colleagues believe that maximising bat populations can help to boost crop yields and promote sustainable livelihoods. The team is now calling for further research to quantify this contribution. 'I'm very optimistic,' says Rocha. 'If we give nature a hand, we can speed up the process of regeneration.'</p>
                    </div>
                </div>

                <div

                        {-- Floating Toolbar for Passage 1 --}
                        @include('assignments.ielts.mockup.partials.reading-toolbar')
                    </div>
                </div>

                {-- Passage 2 Card --}
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
                    {-- Drawing canvas for Passage 2 --}
                    <canvas x-ref="drawingCanvas"
                            class="absolute inset-0 w-full h-full z-10 rounded-2xl"
                            :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'">
                    </canvas>

                    <div class="relative z-20" :class="pencilMode ? 'pointer-events-none' : ''">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                            <span class="bg-pink-50 text-pink-600 font-bold px-3 py-1 rounded-lg text-sm tracking-wide uppercase">READING PASSAGE 2</span>
                        </div>

id="passage-2" class="mt-10">
                    <p class="text-[13px] font-bold tracking-widest uppercase mb-1">READING PASSAGE 2</p>
                    <p class="text-[13px] italic mb-4">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 below.</p>
                    <h2 class="text-2xl font-bold text-center mb-6">Does education fuel economic growth?</h2>

                    <div class="space-y-5 text-[15px] leading-relaxed text-gray-900">
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">A</span>
                            <p>Over the last decade, a huge database about the lives of southwest German villagers between 1600 and 1900 has been compiled by a team led by Professor Sheilagh Ogilvie at Cambridge University's Faculty of Economics. It includes court records, guild ledgers, parish registers, village censuses, tax lists and – the most recent addition – 9,000 handwritten inventories listing over a million personal possessions belonging to ordinary women and men across three centuries. Ogilvie, who discovered the inventories in the archives of two German communities 30 years ago, believes they may hold the answer to a conundrum that has long puzzled economists: the lack of evidence for a causal link between education and a country's economic growth.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">B</span>
                            <p>As Ogilvie explains, 'Education helps us to work more productively, invent better technology, and earn more … surely it must be critical for economic growth? But, if you look back through history, there's no evidence that having a high literacy rate made a country industrialise earlier.' Between 1600 and 1900, England had only mediocre literacy rates by European standards, yet its economy grew fast and it was the first country to industrialise. During this period, Germany and Scandinavia had excellent literacy rates, but their economies grew slowly and they industrialised late. 'Modern cross-country analyses have also struggled to find evidence that education causes economic growth, even though there is plenty of evidence that growth increases education,' she adds.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">C</span>
                            <div>
                                <p class="mb-3">In the handwritten inventories that Ogilvie is analysing are the belongings of women and men at marriage, remarriage and death. From badger skins to Bibles, sewing machines to scarlet bodices – the villagers' entire worldly goods are included. Inventories of agricultural equipment and craft tools reveal economic activities; ownership of books and education-related objects like pens and slates suggests how people learned. In addition, the tax lists included in the database record the value of farms, workshops, assets and debts; signatures and people's estimates of their age indicate literacy and numeracy levels; and court records reveal obstacles (such as the activities of the guilds*) that stifled industry.</p>
                                <p>Previous studies usually had just one way of linking education with economic growth – the presence of schools and printing presses, perhaps, or school enrolment, or the ability to sign names. According to Ogilvie, the database provides multiple indicators for the same individuals, making it possible to analyse links between literacy, numeracy, wealth, and industriousness, for individual women and men over the long term.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">D</span>
                            <p>Ogilvie and her team have been building the vast database of material possessions on top of their full demographic reconstruction of the people who lived in these two German communities. 'We can follow the same people – and their descendants – across 300 years of educational and economic change,' she says. Individual lives have unfolded before their eyes. Stories like that of the 24-year-olds Ana Regina and Magdalena Riethmüllerin, who were chastised in 1707 for reading books in church instead of listening to the sermon. 'This tells us they were continuing to develop their reading skills at least a decade after leaving school,' explains Ogilvie. The database also reveals the case of Juliana Schweickherdt, a 50-year-old spinster living in the small Black Forest community of Wildberg, who was reprimanded in 1752 by the local weavers' guild for 'weaving cloth and combing wool, counter to the guild ordinance'. When Juliana continued taking jobs reserved for male guild members, she was summoned before the guild court and told to pay a fine equivalent to one third of a servant's annual wage. It was a small act of defiance by today's standards, but it reflects a time when laws in Germany and elsewhere regulated people's access to labour markets. The dominance of guilds not only prevented people from using their skills, but also held back even the simplest industrial innovation.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">E</span>
                            <p>The data-gathering phase of the project has been completed and now, according to Ogilvie, it is time 'to ask the big questions'. One way to look at whether education causes economic growth is to 'hold wealth constant'. This involves following the lives of different people with the same level of wealth over a period of time. If wealth is constant, it is possible to discover whether education was, for example, linked to the cultivation of new crops, or to the adoption of industrial innovations like sewing machines. The team will also ask what aspect of education helped people engage more with productive and innovative activities. Was it, for instance, literacy, numeracy, book ownership, years of schooling? Was there a threshold level – a tipping point – that needed to be reached to affect economic performance?</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">F</span>
                            <div>
                                <p class="mb-3">Ogilvie hopes to start finding answers to these questions over the next few years. One thing is already clear, she says: the relationship between education and economic growth is far from straightforward. 'German-speaking central Europe is an excellent laboratory for testing theories of economic growth,' she explains. Between 1600 and 1900, literacy rates and book ownership were high and yet the region remained poor. It was also the case that local guilds and merchant associations were extremely powerful and legislated against anything that undermined their monopolies. In villages throughout the region, guilds blocked labour migration and resisted changes that might reduce their influence.</p>
                                <p>'Early findings suggest that the potential benefits of education for the economy can be held back by other barriers, and this has implications for today,' says Ogilvie. 'Huge amounts are spent improving education in developing countries, but this spending can fail to deliver economic growth if restrictions block people – especially women and the poor – from using their education in economically productive ways. If economic institutions are poorly set up, for instance, education can't lead to growth.'</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-6 border-t pt-3">* guild: an association of artisans or merchants which oversees the practice of their craft or trade in a particular area</p>
                </div>

                <div

                        {-- Floating Toolbar for Passage 2 --}
                        @include('assignments.ielts.mockup.partials.reading-toolbar')
                    </div>
                </div>

                {-- Passage 3 Card --}
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
                    {-- Drawing canvas for Passage 3 --}
                    <canvas x-ref="drawingCanvas"
                            class="absolute inset-0 w-full h-full z-10 rounded-2xl"
                            :class="(pencilMode || eraserMode) ? 'pointer-events-auto cursor-crosshair' : 'pointer-events-none'">
                    </canvas>

                    <div class="relative z-20" :class="pencilMode ? 'pointer-events-none' : ''">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
                            <span class="bg-pink-50 text-pink-600 font-bold px-3 py-1 rounded-lg text-sm tracking-wide uppercase">READING PASSAGE 3</span>
                        </div>

id="passage-3" class="mt-10">
                    <p class="text-[13px] font-bold tracking-widest uppercase mb-1">READING PASSAGE 3</p>
                    <p class="text-[13px] italic mb-4">You should spend about 20 minutes on <strong>Questions 27–40</strong>, which are based on Reading Passage 3 below.</p>
                    <h2 class="text-2xl font-bold text-center mb-6">Timur Gareyev – blindfold chess champion</h2>

                    <div class="space-y-5 text-[15px] leading-relaxed text-gray-900">
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">A</span>
                            <p>Next month, a chess player named Timur Gareyev will take on nearly 50 opponents at once. But that is not the hard part. While his challengers will play the games as normal, Gareyev himself will be blindfolded. Even by world record standards, it sets a high bar for human performance. The 28-year-old already stands out in the rarefied world of blindfold chess. He has a fondness for bright clothes and unusual hairstyles, and he gets his kicks from the adventure sport of BASE jumping. He has already proved himself a strong chess player, too. In a 10-hour chess marathon in 2013, Gareyev played 33 games in his head simultaneously. He won 29 and lost none. The skill has become his brand: he calls himself the Blindfold King.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">B</span>
                            <p>But Gareyev's prowess has drawn interest from beyond the chess-playing community. In the hope of understanding how he and others like him can perform such mental feats, researchers at the University of California in Los Angeles (UCLA) called him in for tests. They now have their first results. 'The ability to play a game of chess with your eyes closed is not a far reach for most accomplished players,' said Jesse Rissman, who runs a memory lab at UCLA. 'But the thing that's so remarkable about Timur and a few other individuals is the number of games they can keep active at once. To me it is simply astonishing.'</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">C</span>
                            <p>Gareyev learned to play chess in his native Uzbekistan when he was six years old. Tutored by his grandfather, he entered his first tournament aged eight and soon became obsessed with competitions. At 16, he was crowned Asia's youngest ever chess grandmaster. He moved to the US soon after, and as a student helped his university win its first national chess championship. In 2013, Gareyev was ranked the third best chess player in the US.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">D</span>
                            <p>To the uninitiated, blindfold chess seems to call for superhuman skill. But displays of the feat go back centuries. The first recorded game in Europe was played in 13th-century Florence. In 1947, the Argentinian grandmaster Miguel Najdorf played 45 simultaneous games in his mind, winning 39 in the 24-hour session.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">E</span>
                            <p>Accomplished players can develop the skill of playing blind even without realising it. The nature of the game is to run through possible moves in the mind to see how they play out. From this, regular players develop a memory for the patterns the pieces make, the defences and attacks. 'You recreate it in your mind,' said Gareyev. 'A lot of players are capable of doing what I'm doing.' The real mental challenge comes from playing multiple games at once in the head. Not only must the positions of each piece on every board be memorised, they must be recalled faithfully when needed, updated with each player's moves, and then reliably stored again, so the brain can move on to the next board. First moves can be tough to remember because they are fairly uninteresting. But the ends of games are taxing too, as exhaustion sets in. When Gareyev is tired, his recall can get patchy. He sometimes makes moves based on only a fragmented memory of the pieces' positions.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">F</span>
                            <p>The scientists first had Gareyev perform some standard memory tests. These assessed his ability to hold numbers, pictures and words in mind. One classic test measures how many numbers a person can repeat, both forwards and backwards, soon after hearing them. Most people manage about seven. 'He was not exceptional on any of these standard tests,' said Rissman. 'We didn't find anything other than playing chess that he seems to be supremely gifted at.' But next came the brain scans. With Gareyev lying down in the machine, Rissman looked at how well connected the various regions of the chess player's brain were. Though the results are tentative and as yet unpublished, the scans found much greater than average communication between parts of Gareyev's brain that make up what is called the frontoparietal control network. Of 63 people scanned alongside the chess player, only one or two scored more highly on the measure. 'You use this network in almost any complex task. It helps you to allocate attention, keep rules in mind, and work out whether you should be responding or not,' said Rissman.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">G</span>
                            <p>It was not the only hint of something special in Gareyev's brain. The scans also suggest that Gareyev's visual network is more highly connected to other brain parts than usual. Initial results suggest that the areas of his brain that process visual images – such as chess boards – may have stronger links to other brain regions, and so be more powerful than normal. While the analyses are not finalised yet, they may hold the first clues to Gareyev's extraordinary ability.</p>
                        </div>
                        <div class="flex gap-4">
                            <span class="font-bold w-5 flex-none">H</span>
                            <p>For the world record attempt, Gareyev hopes to play 47 blindfold games at once in about 16 hours. He will need to win 80% to claim the title. 'I don't worry too much about the winning percentage, that's never been an issue for me,' he said. 'The most important part of blindfold chess for me is that I have found the one thing that I can fully dedicate myself to. I miss having an obsession.'</p>
                        </div>

                        {-- Floating Toolbar for Passage 3 --}
                        @include('assignments.ielts.mockup.partials.reading-toolbar')
                    </div>
                </div>

            </div>
        </div>

        {{-- RIGHT: Questions --}}
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar" id="questions-panel">
            <div class="px-4 sm:px-6 md:px-8 py-8 pb-24 w-full relative">

<h3 class="text-xl font-bold text-gray-900 mb-6">Questions 1–13</h3>

                    {{-- Q1-6: TRUE / FALSE / NOT GIVEN --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                        <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–6</strong></p>
                        <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 1?</p>
                        <p class="text-sm italic text-gray-700 mb-4">In boxes 1–6 on your answer sheet, write</p>

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
                                        [1, 'Many Madagascan forests are being destroyed by attacks from insects.'],
                                        [2, 'Loss of habitat has badly affected insectivorous bats in Madagascar.'],
                                        [3, 'Ricardo Rocha has carried out studies of bats in different parts of the world.'],
                                        [4, 'Habitat modification has resulted in indigenous bats in Madagascar becoming useful to farmers.'],
                                        [5, 'The Malagasy mouse-eared bat is more common than other indigenous bat species in Madagascar.'],
                                        [6, 'Bats may feed on paddy swarming caterpillars and grass webworms.'],
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

                    {{-- Q7-13: Table completion --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                        <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 7–13</strong></p>
                        <p class="text-sm text-gray-800 mb-2">Complete the table below.</p>
                        <p class="text-sm text-gray-800 mb-2">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                        <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 7–13 on your answer sheet.</p>

                        <div class="border border-gray-400 rounded-lg text-sm bg-gray-50 overflow-hidden">
                            {{-- Table title --}}
                            <div class="bg-gray-200/50 border-b border-gray-400 text-center py-3 font-bold text-base text-gray-800">
                                The study carried out by Rocha's team
                            </div>
                            {{-- Aim row --}}
                            <div class="flex border-b border-gray-400">
                                <div class="font-bold border-r border-gray-400 px-4 py-3 bg-gray-100" style="width:170px; flex-shrink:0;">Aim</div>
                                <div class="px-4 py-3">
                                    <ul class="list-disc ml-5 space-y-1 text-gray-800">
                                        <li>to investigate the feeding habits of bats in farmland near the Ranomafana National Park</li>
                                    </ul>
                                </div>
                            </div>
                            {{-- Method row --}}
                            <div class="flex border-b border-gray-400">
                                <div class="font-bold border-r border-gray-400 px-4 py-3 bg-gray-100" style="width:170px; flex-shrink:0;">Method</div>
                                <div class="px-4 py-3">
                                    <ul class="list-disc ml-5 space-y-2 text-gray-800">
                                        <li>ultrasonic recording to identify favourite feeding spots</li>
                                        <li>DNA analysis of bat <strong>7</strong> <input type="text" name="q7" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"></li>
                                    </ul>
                                </div>
                            </div>
                            {{-- Findings row --}}
                            <div class="flex border-b border-gray-400">
                                <div class="font-bold border-r border-gray-400 px-4 py-3 bg-gray-100" style="width:170px; flex-shrink:0;">Findings</div>
                                <div class="px-4 py-3">
                                    <ul class="list-disc ml-5 space-y-2 mb-2 text-gray-800">
                                        <li>
                                            the bats
                                            <ul class="list-none ml-2 mt-2 space-y-2">
                                                <li>– were most active in rice fields located on hills</li>
                                                <li>– ate pests of rice, <strong>8</strong> <input type="text" name="q8" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">, sugarcane, nuts and fruit</li>
                                                <li>– prevent the spread of disease by eating <strong>9</strong> <input type="text" name="q9" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> and blackflies</li>
                                            </ul>
                                        </li>
                                        <li class="mt-4">
                                            local attitudes to bats are mixed:
                                            <ul class="list-none ml-2 mt-2 space-y-2">
                                                <li>– they provide food rich in <strong>10</strong> <input type="text" name="q10" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"></li>
                                                <li>– the buildings where they roost become <strong>11</strong> <input type="text" name="q11" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"></li>
                                                <li>– they play an important role in local <strong>12</strong> <input type="text" name="q12" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            {{-- Recommendation row --}}
                            <div class="flex">
                                <div class="font-bold border-r border-gray-400 px-4 py-3 bg-gray-100" style="width:170px; flex-shrink:0;">Recommendation</div>
                                <div class="px-4 py-3">
                                    <ul class="list-disc ml-5 space-y-1 text-gray-800">
                                        <li>farmers should provide special <strong>13</strong> <input type="text" name="q13" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> to support the bat population</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- PASSAGE 2 QUESTIONS --}}
                    <div class="mt-12 mb-6 border-t border-gray-200 pt-8">
                        <div class="flex justify-center mb-6">
                            <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                        </div>
                    </div>

                    {{-- Q14-18: Section matching A-F --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                        <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–18</strong></p>
                        <p class="text-sm text-gray-800 mb-1">Reading Passage 2 has six sections, <strong>A–F</strong>.</p>
                        <p class="text-sm text-gray-800 mb-1">Which section contains the following information?</p>
                        <p class="text-sm italic text-gray-700 mb-4">Write the correct letter, <strong>A–F</strong>, in boxes 14–18 on your answer sheet.</p>

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
                                        [14, 'an explanation of the need for research to focus on individuals with a fairly consistent income'],
                                        [15, 'examples of the sources the database has been compiled from'],
                                        [16, "an account of one individual's refusal to obey an order"],
                                        [17, 'a reference to a region being particularly suited to research into the link between education and economic growth'],
                                        [18, 'examples of the items included in a list of personal possessions'],
                                    ] as [$num, $statement])
                                    <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                        <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="relative inline-block w-full">
                                                <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                    <option value="" disabled selected>-</option>
                                                    @foreach(['A','B','C','D','E','F'] as $l)
                                                    <option value="{{ $l }}">{{ $l }}</option>
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

                    {{-- Q19-22: Summary completion --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                        <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 19–22</strong></p>
                        <p class="text-sm text-gray-800 mb-1">Complete the summary below.</p>
                        <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD</strong> from the passage for each answer.</p>
                        <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 19–22 on your answer sheet.</p>

                        <div class="border-2 border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                            <h4 class="text-base font-bold text-center mb-4">Demographic reconstruction of two German communities</h4>
                            <p class="mb-4 text-gray-800 leading-loose">
                                The database that Ogilvie and her team has compiled sheds light on the lives of a range of individuals, as well as those of their
                                <strong>19</strong> <input type="text" name="q19" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">,
                                over a 300-year period. For example, Ana Regina and Magdalena Riethmüllerin were reprimanded for reading while they should have been paying attention to a
                                <strong>20</strong> <input type="text" name="q20" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">.
                            </p>
                            <p class="text-gray-800 leading-loose">
                                There was also Juliana Schweickherdt, who came to the notice of the weavers' guild in the year 1752 for breaking guild rules. As a punishment, she was later given a
                                <strong>21</strong> <input type="text" name="q21" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">.
                                Cases like this illustrate how the guilds could prevent
                                <strong>22</strong> <input type="text" name="q22" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                and stop skilled people from working.
                            </p>
                        </div>
                    </div>

                    {{-- Q23-24: Choose TWO A-E (literacy rates, Section B) --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                        <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 23 and 24</strong></p>
                        <p class="text-sm italic text-gray-700 mb-1">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                        <p class="text-sm italic text-gray-700 mb-1">Write the correct letters in boxes 23 and 24 on your answer sheet.</p>
                        <p class="text-sm text-gray-800 mb-4">Which <strong>TWO</strong> of the following statements does the writer make about literacy rates in Section B?</p>

                        <div class="space-y-3">
                            @foreach([
                                ['A', 'Very little research has been done into the link between high literacy rates and improved earnings.'],
                                ['B', 'Literacy rates in Germany between 1600 and 1900 were very good.'],
                                ['C', 'There is strong evidence that high literacy rates in the modern world result in economic growth.'],
                                ['D', 'England is a good example of how high literacy rates helped a country industrialise.'],
                                ['E', 'Economic growth can help to improve literacy rates.'],
                            ] as [$letter, $text])
                            <label class="flex items-start gap-3 cursor-pointer group p-3 rounded-lg border border-gray-200 hover:border-blue-400 hover:bg-blue-50 transition-colors">
                                <div class="relative flex items-center justify-center mt-0.5">
                                    <input type="checkbox" name="q23_24[]" value="{{ $letter }}" class="peer appearance-none w-5 h-5 border-2 border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 checked:bg-blue-600 checked:border-blue-600 cursor-pointer transition-all">
                                    <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-gray-800 text-sm leading-relaxed group-hover:text-blue-900"><strong class="mr-2">{{ $letter }}</strong> {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400 mt-2 italic ml-2">Select exactly two options.</p>
                    </div>

                    {{-- Q25-26: Choose TWO A-E (guilds, Section F) --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                        <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 25 and 26</strong></p>
                        <p class="text-sm italic text-gray-700 mb-1">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                        <p class="text-sm italic text-gray-700 mb-1">Write the correct letters in boxes 25 and 26 on your answer sheet.</p>
                        <p class="text-sm text-gray-800 mb-4">Which <strong>TWO</strong> of the following statements does the writer make in Section F about guilds in German-speaking Central Europe between 1600 and 1900?</p>

                        <div class="space-y-3">
                            @foreach([
                                ['A', 'They helped young people to learn a skill.'],
                                ['B', 'They were opposed to people moving to an area for work.'],
                                ['C', 'They kept better records than guilds in other parts of the world.'],
                                ['D', 'They opposed practices that threatened their control over a trade.'],
                                ['E', 'They predominantly consisted of wealthy merchants.'],
                            ] as [$letter, $text])
                            <label class="flex items-start gap-3 cursor-pointer group p-3 rounded-lg border border-gray-200 hover:border-blue-400 hover:bg-blue-50 transition-colors">
                                <div class="relative flex items-center justify-center mt-0.5">
                                    <input type="checkbox" name="q25_26[]" value="{{ $letter }}" class="peer appearance-none w-5 h-5 border-2 border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 checked:bg-blue-600 checked:border-blue-600 cursor-pointer transition-all">
                                    <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-gray-800 text-sm leading-relaxed group-hover:text-blue-900"><strong class="mr-2">{{ $letter }}</strong> {{ $text }}</span>
                            </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400 mt-2 italic ml-2">Select exactly two options.</p>
                    </div>
                    {{-- PASSAGE 3 QUESTIONS --}}
                    <div class="mt-12 mb-6 border-t border-gray-200 pt-8">
                        <div class="flex justify-center mb-6">
                            <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 3</span>
                        </div>
                    </div>

                    {{-- Q27-32: Paragraph matching A-H --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                        <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–32</strong></p>
                        <p class="text-sm text-gray-800 mb-1">Reading Passage 3 has eight paragraphs, <strong>A–H</strong>.</p>
                        <p class="text-sm text-gray-800 mb-1">Which paragraph contains the following information?</p>
                        <p class="text-sm italic text-gray-700 mb-2">Write the correct letter, <strong>A–H</strong>, in boxes 27–32 on your answer sheet.</p>
                        <p class="text-sm text-gray-800 mb-4"><strong><em>NB</em></strong> <em>You may use any letter more than once.</em></p>

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
                                        [27, 'a reference to earlier examples of blindfold chess'],
                                        [28, 'an outline of what blindfold chess involves'],
                                        [29, "a claim that Gareyev's skill is limited to chess"],
                                        [30, "why Gareyev's skill is of interest to scientists"],
                                        [31, "an outline of Gareyev's priorities"],
                                        [32, 'a reason why the last part of a game may be difficult'],
                                    ] as [$num, $statement])
                                    <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                        <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                        <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                        <td class="py-3 px-3 text-center">
                                            <div class="relative inline-block w-full">
                                                <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                    <option value="" disabled selected>-</option>
                                                    @foreach(['A','B','C','D','E','F','G','H'] as $l)
                                                    <option value="{{ $l }}">{{ $l }}</option>
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

                    {{-- Q33-36: TRUE / FALSE / NOT GIVEN --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                        <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 33–36</strong></p>
                        <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 3?</p>
                        <p class="text-sm italic text-gray-700 mb-4">In boxes 33–36 on your answer sheet, write</p>

                        <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                            <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                                <div><span class="font-bold italic">TRUE</span></div><div class="italic">if the statement agrees with the information</div>
                                <div><span class="font-bold italic">FALSE</span></div><div class="italic">if the statement contradicts the information</div>
                                <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if there is no information about this</div>
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
                                        [33, 'In the forthcoming games, all the participants will be blindfolded.'],
                                        [34, 'Gareyev has won competitions in BASE jumping.'],
                                        [35, 'UCLA is the first university to carry out research into blindfold chess players.'],
                                        [36, 'Good chess players are likely to be able to play blindfold chess.'],
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

                    {{-- Q37-40: Summary completion --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                        <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 37–40</strong></p>
                        <p class="text-sm text-gray-800 mb-1">Complete the summary below.</p>
                        <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                        <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 37–40 on your answer sheet.</p>

                        <div class="border-2 border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                            <h4 class="text-base font-bold text-center mb-4">How the research was carried out</h4>
                            <p class="mb-4 text-gray-800 leading-loose">
                                The researchers started by testing Gareyev's
                                <strong>37</strong> <input type="text" name="q37" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">;
                                for example, he was required to recall a string of
                                <strong>38</strong> <input type="text" name="q38" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                in order and also in reverse order. Although his performance was normal, scans showed an unusual amount of
                                <strong>39</strong> <input type="text" name="q39" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                within the areas of Gareyev's brain that are concerned with directing attention. In addition, the scans raised the possibility of unusual strength in the parts of his brain that deal with
                                <strong>40</strong> <input type="text" name="q40" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> input.
                            </p>
                        </div>
                    </div>
                    </div>
            </div>

        </div>
    </div>

</div>
@include('assignments.ielts.mockup.partials.reading-dictionary')
</body>
</html>

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

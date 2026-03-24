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
        <div class="h-full overflow-y-auto bg-white border-r border-gray-200 custom-scrollbar relative">
            <div class="px-10 py-8 pb-32 max-w-3xl mx-auto relative z-20">
                <div class="flex justify-center mb-8">
                    <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest">READING</span>
                </div>
                
                <h2 class="text-xl font-bold mb-4 tracking-wider uppercase">READING PASSAGE 1</h2>
                <p class="italic mb-8">You should spend about 20 minutes on <span class="font-bold">Questions 1–13</span>, which are based on Reading Passage 1 below.</p>
                
                <h3 class="text-3xl font-bold text-center mb-8">The Industrial Revolution in Britain</h3>
                
                <div class="space-y-6 text-gray-800 text-lg leading-relaxed text-justify font-serif">
                    <p>The Industrial Revolution began in Britain in the mid-1700s and by the 1830s and 1840s had spread to many other parts of the world, including the United States. In Britain, it was a period when a largely rural, agrarian* society was transformed into an industrialised, urban one. Goods that had once been crafted by hand started to be produced in mass quantities by machines in factories, thanks to the invention of steam power and the introduction of new machines and manufacturing techniques in textiles, iron-making and other industries.</p>

                    <p>The foundations of the Industrial Revolution date back to the early 1700s, when the English inventor Thomas Newcomen designed the first modern steam engine. Called the 'atmospheric steam engine', Newcomen's invention was originally used to power machines that pumped water out of mines. In the 1760s, the Scottish engineer James Watt started to adapt one of Newcomen's models, and succeeded in making it far more efficient. Watt later worked with the English manufacturer Matthew Boulton to invent a new steam engine driven by both the forward and backward strokes of the piston, while the gear mechanism it was connected to produced rotary motion. It was a key innovation that would allow steam power to spread across British industries.</p>

                    <p>The demand for coal, which was a relatively cheap energy source, grew rapidly during the Industrial Revolution, as it was needed to run not only the factories used to produce manufactured goods, but also steam-powered transportation. In the early 1800s, the English engineer Richard Trevithick built a steam-powered locomotive, and by 1830 goods and passengers were being transported between the industrial centres of Manchester and Liverpool. In addition, steam-powered boats and ships were widely used to carry goods along Britain's canals as well as across the Atlantic.</p>

                    <p>Britain had produced textiles like wool, linen and cotton, for hundreds of years, but prior to the Industrial Revolution, the British textile business was a true 'cottage industry', with the work performed in small workshops or even homes by individual spinners, weavers and dyers. Starting in the mid-1700s, innovations like the spinning jenny and the power loom made weaving cloth and spinning yarn and thread much easier. With these machines, relatively little labour was required to produce cloth, and the new, mechanised textile factories that opened around the country were quickly able to meet customer demand for cloth both at home and abroad.</p>

                    <p>The British iron industry also underwent major change as it adopted new innovations. Chief among the new techniques was the smelting of iron ore with coke (a material made by heating coal) instead of the traditional charcoal. This method was cheaper and produced metals that were of a higher quality, enabling Britain's iron and steel production to expand in response to demand created by the Napoleonic Wars (1803–15) and the expansion of the railways from the 1830s.</p>

                    <p>The latter part of the Industrial Revolution also saw key advances in communication methods, as people increasingly saw the need to communicate efficiently over long distances. In 1837, British inventors William Cooke and Charles Wheatstone patented the first commercial telegraphy system. In the 1830s and 1840s, Samuel Morse and other inventors worked on their own versions in the United States. Cooke and Wheatstone's system was soon used for railway signalling in the UK. As the speed of the new locomotives increased, it was essential to have a fast and effective means of avoiding collisions.</p>

                    <p>The impact of the Industrial Revolution on people's lives was immense. Although many people in Britain had begun moving to the cities from rural areas before the Industrial Revolution, this accelerated dramatically with industrialisation, as the rise of large factories turned smaller towns into major cities in just a few decades. This rapid urbanisation brought significant challenges, as overcrowded cities suffered from pollution and inadequate sanitation.</p>

                    <p>Although industrialisation increased the country's economic output overall and improved the standard of living for the middle and upper classes, many poor people continued to struggle. Factory workers had to work long hours in dangerous conditions for extremely low wages. These conditions along with the rapid pace of change fuelled opposition to industrialisation. A group of British workers who became known as 'Luddites' were British weavers and textile workers who objected to the increased use of mechanised looms and knitting frames. Many had spent years learning their craft, and they feared that unskilled machine operators were robbing them of their livelihood. A few desperate weavers began breaking into factories and smashing textile machines. They called themselves Luddites after Ned Ludd, a young apprentice who was rumoured to have wrecked a textile machine in 1779.</p>

                    <p>The first major instances of machine breaking took place in 1811 in the city of Nottingham, and the practice soon spread across the country. Machine-breaking Luddites attacked and burned factories, and in some cases they even exchanged gunfire with company guards and soldiers. The workers wanted employers to stop installing new machinery, but the British government responded to the uprisings by making machine-breaking punishable by death. The unrest finally reached its peak in April 1812, when a few Luddites were shot during an attack on a mill near Huddersfield. In the days that followed, other Luddites were arrested, and dozens were hanged or transported to Australia. By 1813, the Luddite resistance had all but vanished.</p>

                    <p class="text-sm text-gray-500 mt-8 pt-4 border-t border-gray-200">* agrarian: relating to the land, especially the use of land for farming</p>
                </div>

                {{-- Passage 2 --}}
                <div class="mb-6 mt-16 pt-16 border-t-2 border-gray-300">
                    <h2 class="text-xl font-bold mb-4 tracking-wider uppercase">READING PASSAGE 2</h2>
                    <p class="italic mb-8">You should spend about 20 minutes on <span class="font-bold">Questions 14–26</span>, which are based on Reading Passage 2 below.</p>
                    
                    <h3 class="text-3xl font-bold text-center mb-8">Athletes and stress</h3>

                    <div class="space-y-6 text-gray-800 text-lg leading-relaxed text-justify font-serif">
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">A</span>
                            <p>It isn't easy being a professional athlete. Not only are the physical demands greater than most people could handle, athletes also face intense psychological pressure during competition. This is something that British tennis player Emma Raducanu wrote about on social media following her withdrawal from the 2021 Wimbledon tournament. Though the young player had been doing well in the tournament, she began having difficulty regulating her breathing and heart rate during a match, which she later attributed to 'the accumulation of the excitement and the buzz'.</p>
                        </div>
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">B</span>
                            <p>For athletes, some level of performance stress is almost unavoidable. But there are many different factors that dictate just how people's minds and bodies respond to stressful events. Typically, stress is the result of an exchange between two factors: demands and resources. An athlete may feel stressed about an event if they feel the demands on them are greater than they can handle. These demands include the high level of physical and mental effort required to succeed, and also the athlete's concerns about the difficulty of the event, their chance of succeeding, and any potential dangers such as injury. Resources, on the other hand, are a person's ability to cope with these demands. These include factors such as the competitor's degree of confidence, how much they believe they can control the situation's outcome, and whether they're looking forward to the event or not.</p>
                        </div>
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">C</span>
                            <p>Each new demand or change in circumstances affects whether a person responds positively or negatively to stress. Typically, the more resources a person feels they have in handling the situation, the more positive their stress response. This positive stress response is called a challenge state. But should the person feel there are too many demands placed on them, the more likely they are to experience a negative stress response – known as a threat state. Research shows that the challenge states lead to good performance, while threat states lead to poorer performance. So, in Emma Raducanu's case, a much larger audience, higher expectations and facing a more skilful opponent, may all have led her to feel there were greater demands being placed on her at Wimbledon – but she didn't have the resources to tackle them. This led to her experiencing a threat response.</p>
                        </div>
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">D</span>
                            <p>Our challenge and threat responses essentially influence how our body responds to stressful situations, as both affect the production of adrenaline and cortisol – also known as 'stress hormones'. During a challenge state, adrenaline increases the amount of blood pumped from the heart and expands the blood vessels, which allows more energy to be delivered to the muscles and brain. This increase of blood and decrease of pressure in the blood vessels has been consistently related to superior sport performance in everything from cricket batting, to golf putting and football penalty taking. But during a threat state, cortisol inhibits the positive effect of adrenaline, resulting in tighter blood vessels, higher blood pressure, slower psychological responses, and a faster heart rate. In short, a threat state makes people more anxious – they make worse decisions and perform more poorly. In tennis players, cortisol has been associated with more unsuccessful serves and greater anxiety.</p>
                        </div>
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">E</span>
                            <p>That said, anxiety is also a common experience for athletes when they're under pressure. Anxiety can increase heart rate and perspiration, cause heart palpitations, muscle tremors and shortness of breath, as well as headaches, nausea, stomach pain, weakness and a desire to escape in more extreme cases. Anxiety can also reduce concentration and self-control and cause overthinking. The intensity with which a person experiences anxiety depends on the demands and resources they have. Anxiety may also manifest itself in the form of excitement or nervousness depending on the stress response. Negative stress responses can be damaging to both physical and mental health – and repeated episodes of anxiety coupled with negative responses can increase risk of heart disease and depression.</p>
                        </div>
                        <div class="flex gap-4 items-start">
                            <span class="font-bold text-xl w-6 flex-none mt-1">F</span>
                            <p>But there are many ways athletes can ensure they respond positively under pressure. Positive stress responses can be promoted through the language that they and others – such as coaches or parents – use. Psychologists can also help athletes change how they see their physiological responses – such as helping them see a higher heart rate as excitement, rather than nerves. Developing psychological skills, such as visualisation, can also help decrease physiological responses to threat. Visualisation may involve the athlete recreating a mental picture of a time when they performed well, or picturing themselves doing well in the future. This can help create a feeling of control over the stressful event. Recreating competitive pressure during training can also help athletes learn how to deal with stress. An example of this might be scoring athletes against their peers to create a sense of competition. This would increase the demands which players experience compared to a normal training session, while still allowing them to practise coping with stress.</p>
                        </div>
                    </div>
                </div>

                {{-- Passage 3 --}}
                <div class="mb-6 mt-16 pt-16 border-t-2 border-gray-300">
                    <h2 class="text-xl font-bold mb-4 tracking-wider uppercase">READING PASSAGE 3</h2>
                    <p class="italic mb-8">You should spend about 20 minutes on <span class="font-bold">Questions 27–40</span>, which are based on Reading Passage 3 below.</p>
                    
                    <h3 class="text-3xl font-bold text-center mb-8">An inquiry into the existence of the gifted child</h3>

                    <div class="space-y-6 text-gray-800 text-lg leading-relaxed text-justify font-serif">
                        <p>Let us start by looking at a modern 'genius', Maryam Mirzakhani, who died at the early age of 40. She was the only woman to win the Fields Medal – the mathematical equivalent of a Nobel prize. It would be easy to assume that someone as special as Mirzakhani must have been one of those 'gifted' children, those who have an extraordinary ability in a specific sphere of activity or knowledge. But look closer and a different story emerges. Mirzakhani was born in Tehran, Iran. She went to a highly selective girls' school but maths wasn't her interest – reading was. She loved novels and would read anything she could lay her hands on. As for maths, she did rather poorly at it for the first couple of years in her middle school, but became interested when her elder brother told her about what he'd learned. He shared a famous maths problem from a magazine that fascinated her – and she was hooked.</p>

                        <p>In adult life it is clear that she was curious, excited by what she did and also resolute in the face of setbacks. One of her comments sums it up. 'Of course, the most rewarding part is the "Aha" moment, the excitement of discovery and enjoyment of understanding something new … But most of the time, doing mathematics for me is like being on a long hike with no trail and no end in sight.' That trail took her to the heights of original research into mathematics.</p>

                        <p>Is her background unusual? Apparently not. Most Nobel prize winners were unexceptional in childhood. Einstein was slow to talk as a baby. He failed the general part of the entry test to Zurich Polytechnic – though they let him in because of high physics and maths scores. He struggled at work initially, but he kept plugging away and eventually rewrote the laws of Newtonian mechanics with his theory of relativity.</p>

                        <p>There has been a considerable amount of research on high performance over the last century that suggests it goes way beyond tested intelligence. On top of that, research is clear that brains are flexible, new neural pathways can be created, and IQ isn't fixed. For example, just because you can read stories with hundreds of pages at the age of five doesn't mean you will still be ahead of your contemporaries in your teens.</p>

                        <p>While the jury is out on giftedness being innate and other factors potentially making the difference, what is certain is that the behaviours associated with high levels of performance are replicable and most can be taught – even traits such as curiosity.</p>

                        <p>According to my colleague Prof Deborah Eyre, with whom I've collaborated on the book <em>Great Minds and How to Grow Them</em>, the latest neuroscience and psychological research suggests most individuals can reach levels of performance associated in school with the gifted and talented. However, they must be taught the right attitudes and approaches to their learning and develop the attributes of high performers – curiosity, persistence and hard work, for example – an approach Eyre calls 'high performance learning'. Critically, they need the right support in developing those approaches at home as well as at school.</p>

                        <p>Prof Anders Ericsson, an eminent education psychologist at Florida State University, US, is the co-author of <em>Peak: Secrets from the New Science of Expertise</em>. After research going back to 1980 into diverse achievements, from music to memory to sport, he doesn't think unique and innate talents are at the heart of performance. Deliberate practice, that stretches you every step of the way, and around 10,000 hours of it, is what produces the goods. It's not a magic number – the highest performers move on to doing a whole lot more, of course. Ericsson's memory research is particularly interesting because random students, trained in memory techniques for the study, went on to outperform others thought to have innately superior memories – those who you might call gifted.</p>

                        <p>But it is perhaps the work of Benjamin Bloom, another distinguished American educationist working in the 1980s, that gives the most pause for thought. Bloom's team looked at a group of extraordinarily high achieving people in disciplines as varied as ballet, swimming, piano, tennis, maths, sculpture and neurology. He found a pattern of parents encouraging and supporting their children, often in areas they enjoyed themselves. Bloom's outstanding people had worked very hard and consistently at something they had become hooked on when at a young age, and their parents all emerged as having strong work ethics themselves.</p>

                        <p>Eyre says we know how high performers learn. From that she has developed a high performing learning approach. She is working on this with a group of schools, both in Britain and abroad. Some spin-off research, which looked in detail at 24 of the 3,000 children being studied who were succeeding despite difficult circumstances, found something remarkable. Half were getting free school meals because of poverty, more than half were living with a single parent, and four in five were living in disadvantaged areas. Interviews uncovered strong evidence of an adult or adults in the child's life who valued and supported education, either in the immediate or extended family or in the child's wider community. Children talked about the need to work hard at school, to listen in class and keep trying.</p>

                        <p>Let us end with Einstein, the epitome of a genius. He clearly had curiosity, character and determination. He struggled against rejection in early life but was undeterred. Did he think he was a genius or even gifted? He once wrote: 'It's not that I'm so smart, it's just that I stay with problems longer. Most people say it is the intellect which makes a great scientist. They are wrong: it is character.'</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Questions --}}
        <div class="h-full overflow-y-auto bg-gray-50 custom-scrollbar">
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto" x-data="{ answers: {} }">

                {{-- Questions 1–7: Notes completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–7</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <span class="font-bold uppercase">ONE WORD ONLY</span> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 1–7 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-4">Britain's Industrial Revolution</h4>
                        
                        <div class="mb-4">
                            <h5 class="font-bold text-base mb-2">Steam power</h5>
                            <ul class="list-disc ml-5 space-y-4 mb-4">
                                <li class="text-gray-800 leading-relaxed">Newcomen's steam engine was used in mines to remove water.</li>
                                <li class="text-gray-800 leading-relaxed">
                                    In Watt and Boulton's steam engine, the movement of the <span class="font-bold">1</span>
                                    <input type="text" x-model="answers.q1" name="q1" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                    was linked to a gear system.
                                </li>
                                <li class="text-gray-800 leading-relaxed">
                                    A greater supply of <span class="font-bold">2</span>
                                    <input type="text" x-model="answers.q2" name="q2" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                    was required to power steam engines.
                                </li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-bold text-base mb-2">Textile industry</h5>
                            <ul class="list-disc ml-5 space-y-4 mb-4">
                                <li class="text-gray-800 leading-relaxed">
                                    Before the Industrial Revolution, spinners and weavers worked at home and in <span class="font-bold">3</span>
                                    <input type="text" x-model="answers.q3" name="q3" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                    .
                                </li>
                                <li class="text-gray-800 leading-relaxed">
                                    Not as much <span class="font-bold">4</span>
                                    <input type="text" x-model="answers.q4" name="q4" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                    was needed to produce cloth once the spinning jenny and power loom were invented.
                                </li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-bold text-base mb-2">Iron industry</h5>
                            <ul class="list-disc ml-5 space-y-4 mb-4">
                                <li class="text-gray-800 leading-relaxed">
                                    Smelting of iron ore with coke resulted in material that was better <span class="font-bold">5</span>
                                    <input type="text" x-model="answers.q5" name="q5" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                    .
                                </li>
                                <li class="text-gray-800 leading-relaxed">
                                    Demand for iron increased with the growth of the <span class="font-bold">6</span>
                                    <input type="text" x-model="answers.q6" name="q6" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                    .
                                </li>
                            </ul>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-bold text-base mb-2">Communications</h5>
                            <ul class="list-disc ml-5 space-y-4 mb-4">
                                <li class="text-gray-800 leading-relaxed">Cooke and Wheatstone patented the first telegraphy system.</li>
                                <li class="text-gray-800 leading-relaxed">The telegraphy system was used to prevent locomotives colliding.</li>
                            </ul>
                        </div>

                        <div>
                            <h5 class="font-bold text-base mb-2">Urbanisation</h5>
                            <ul class="list-disc ml-5 space-y-4 mb-4">
                                <li class="text-gray-800 leading-relaxed">Small towns turned into cities very quickly.</li>
                                <li class="text-gray-800 leading-relaxed">
                                    The new cities were dirty, crowded and lacked sufficient <span class="font-bold">7</span>
                                    <input type="text" x-model="answers.q7" name="q7" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                    .
                                </li>
                            </ul>
                        </div>

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
                                    8 => 'Britain\'s canal network grew rapidly so that more goods could be transported around the country.',
                                    9 => 'Costs in the iron industry rose when the technique of smelting iron ore with coke was introduced.',
                                    10 => 'Samuel Morse\'s communication system was more reliable than that developed by William Cooke and Charles Wheatstone.',
                                    11 => 'The economic benefits of industrialisation were limited to certain sectors of society.',
                                    12 => 'Some skilled weavers believed that the introduction of the new textile machines would lead to job losses.',
                                    13 => 'There was some sympathy among local people for the Luddites who were arrested near Huddersfield.'
                                ] as $qNum => $statement)
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $qNum }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select x-model="answers.q{{ $qNum }}" name="q{{ $qNum }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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
                <div class="mt-8 mb-4">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Questions 14–18: Matching Paragraphs --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–18</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 2 has six paragraphs, <strong>A–F</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Which paragraph contains the following information?</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct letter, <strong>A–F</strong>, in boxes 14–18 on your answer sheet.</p>
                    <p class="mb-5 font-bold uppercase italic text-sm text-gray-700">NB You may use any letter more than once.</p>

                    <div class="overflow-x-auto mt-2">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-32 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    14 => 'reference to two chemical compounds which impact on performance',
                                    15 => 'examples of strategies for minimising the effects of stress',
                                    16 => 'how a sportsperson accounted for their own experience of stress',
                                    17 => 'study results indicating links between stress responses and performance',
                                    18 => 'mention of people who can influence how athletes perceive their stress responses'
                                ] as $qNum => $statement)
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $qNum }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select x-model="answers.q{{ $qNum }}" name="q{{ $qNum }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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

                {{-- Questions 19–22: Notes Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 19–22</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the sentences below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <span class="font-bold uppercase">ONE WORD ONLY</span> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 19–22 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <ul class="list-disc ml-5 space-y-4 mb-4">
                            <li class="text-gray-800 leading-relaxed">
                                Performance stress involves many demands on the athlete, for example, coping with the possible risk of <span class="font-bold">19</span>
                                <input type="text" x-model="answers.q19" name="q19" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                .
                            </li>
                            <li class="text-gray-800 leading-relaxed">
                                Cortisol can cause tennis players to produce fewer good <span class="font-bold">20</span>
                                <input type="text" x-model="answers.q20" name="q20" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                .
                            </li>
                            <li class="text-gray-800 leading-relaxed">
                                Psychologists can help athletes to view their physiological responses as the effect of a positive feeling such as <span class="font-bold">21</span>
                                <input type="text" x-model="answers.q21" name="q21" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                .
                            </li>
                            <li class="text-gray-800 leading-relaxed">
                                <span class="font-bold">22</span>
                                <input type="text" x-model="answers.q22" name="q22" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">
                                is an example of a psychological technique which can reduce an athlete's stress responses.
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Questions 23 and 24: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6" x-init="answers.q23_24 = answers.q23_24 || []">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 23 and 24</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct letters in boxes 23 and 24 on your answer sheet.</p>
                    <p class="text-sm text-gray-800 mb-4">Which <strong>TWO</strong> facts about Emma Raducanu's withdrawal from the Wimbledon tournament are mentioned in the text?</p>

                    <div class="space-y-3">
                        @foreach([
                            'A' => 'the stage at which she dropped out of the tournament',
                            'B' => 'symptoms of her performance stress at the tournament',
                            'C' => 'measures which she had taken to manage her stress levels',
                            'D' => 'aspects of the Wimbledon tournament which increased her stress levels',
                            'E' => 'reactions to her social media posts about her experience at Wimbledon'
                        ] as $letter => $optionText)
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="answers.q23_24" value="{{ $letter }}" 
                                   class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none"
                                   @change="if (answers.q23_24.length > 2) answers.q23_24.shift()">
                            <span class="text-sm text-gray-800 group-hover:text-blue-700 transition-colors">
                                <strong>{{ $letter }}</strong>&nbsp; {{ $optionText }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Questions 25 and 26: Multiple Choice --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6" x-init="answers.q25_26 = answers.q25_26 || []">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 25 and 26</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>TWO</strong> letters, <strong>A–E</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-4">Write the correct letters in boxes 25 and 26 on your answer sheet.</p>
                    <p class="text-sm text-gray-800 mb-4">Which <strong>TWO</strong> facts about anxiety are mentioned in Paragraph E of the text?</p>

                    <div class="space-y-3">
                        @foreach([
                            'A' => 'the factors which determine how severe it may be',
                            'B' => 'how long it takes for its effects to become apparent',
                            'C' => 'which of its symptoms is most frequently encountered',
                            'D' => 'the types of athletes who are most likely to suffer from it',
                            'E' => 'the harm that can result if athletes experience it too often'
                        ] as $letter => $optionText)
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" x-model="answers.q25_26" value="{{ $letter }}" 
                                   class="mt-0.5 w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-none"
                                   @change="if (answers.q25_26.length > 2) answers.q25_26.shift()">
                            <span class="text-sm text-gray-800 group-hover:text-blue-700 transition-colors">
                                <strong>{{ $letter }}</strong>&nbsp; {{ $optionText }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Questions 27–32: Summary completion with options --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 27–32</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Complete the summary using the list of phrases, <strong>A–K</strong>, below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter, <strong>A–K</strong>, in boxes 27–32 on your answer sheet.</p>

                    <div class="border border-gray-300 p-5 rounded-lg bg-gray-50 text-sm mb-5">
                        <h4 class="text-base font-bold text-center mb-4">Maryam Mirzakhani</h4>
                        <p class="text-gray-800 leading-loose mb-2">
                            Maryam Mirzakhani is regarded as 
                            <strong>27</strong>
                            <select x-model="answers.q27" name="q27" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J','K'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            in the field of mathematics because she was the only female holder of the prestigious Fields Medal – a record that she retained at the time of her death. However, maths held little 
                            <strong>28</strong>
                            <select x-model="answers.q28" name="q28" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J','K'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            for her as a child and in fact her performance was below average until she was 
                            <strong>29</strong>
                            <select x-model="answers.q29" name="q29" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J','K'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            by a difficult puzzle that one of her siblings showed her.
                        </p>
                        <p class="text-gray-800 leading-loose mb-2 mt-4">
                            Later, as a professional mathematician, she had an inquiring mind and proved herself to be 
                            <strong>30</strong>
                            <select x-model="answers.q30" name="q30" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J','K'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            when things did not go smoothly. She said she got the greatest 
                            <strong>31</strong>
                            <select x-model="answers.q31" name="q31" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J','K'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            from making ground-breaking discoveries and in fact she was responsible for some extremely 
                            <strong>32</strong>
                            <select x-model="answers.q32" name="q32" class="border border-gray-300 rounded bg-white text-gray-700 py-1 px-2 text-sm font-semibold focus:outline-none focus:border-blue-500 cursor-pointer mx-1" style="width:auto">
                                <option value="" disabled selected>............</option>
                                @foreach(['A','B','C','D','E','F','G','H','I','J','K'] as $l)
                                <option value="{{ $l }}">{{ $l }}</option>
                                @endforeach
                            </select>
                            mathematical studies.
                        </p>
                    </div>

                    {{-- Word bank --}}
                    <div class="border border-gray-400 p-5 bg-white text-sm mx-auto w-full mb-2">
                        <div class="grid gap-x-6 gap-y-3" style="grid-template-columns: repeat(3, minmax(0, 1fr));">
                            @foreach([
                                'A' => 'appeal', 'B' => 'determined', 'C' => 'intrigued',
                                'D' => 'single', 'E' => 'achievement', 'F' => 'devoted',
                                'G' => 'involved', 'H' => 'unique', 'I' => 'innovative',
                                'J' => 'satisfaction', 'K' => 'intent'
                            ] as $l => $w)
                            <div class="flex gap-4"><span class="font-bold text-gray-900 w-4">{{ $l }}</span> <span class="text-gray-800">{{ $w }}</span></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Questions 33–37: Yes/No/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 33–37</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the claims of the writer in Reading Passage 3?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 33–37 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic">YES</span></div><div class="italic">if the statement agrees with the claims of the writer</div>
                            <div><span class="font-bold italic">NO</span></div><div class="italic">if the statement contradicts the claims of the writer</div>
                            <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if it is impossible to say what the writer thinks about this</div>
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
                                    33 => 'Many people who ended up winning prestigious intellectual prizes only reached an average standard when young.',
                                    34 => 'Einstein\'s failures as a young man were due to his lack of confidence.',
                                    35 => 'It is difficult to reach agreement on whether some children are actually born gifted.',
                                    36 => 'Einstein was upset by the public\'s view of his life\'s work.',
                                    37 => 'Einstein put his success down to the speed at which he dealt with scientific questions.'
                                ] as $qNum => $statement)
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $qNum }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select x-model="answers.q{{ $qNum }}" name="q{{ $qNum }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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

                {{-- Questions 38–40: Multiple Choice (A,B,C,D) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 38–40</strong></p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose the correct letter, <strong>A</strong>, <strong>B</strong>, <strong>C</strong> or <strong>D</strong>.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write the correct letter in boxes 38–40 on your answer sheet.</p>

                    <div class="space-y-6">
                        @foreach([
                            [38, 'What does Eyre believe is needed for children to equal \'gifted\' standards?', [
                                'A' => 'strict discipline from the teaching staff',
                                'B' => 'assistance from their peers in the classroom',
                                'C' => 'the development of a spirit of inquiry towards their studies',
                                'D' => 'the determination to surpass everyone else\'s achievements'
                            ]],
                            [39, 'What is the result of Ericsson\'s research?', [
                                'A' => 'Very gifted students do not need to work on improving memory skills.',
                                'B' => 'Being born with a special gift is not the key factor in becoming expert.',
                                'C' => 'Including time for physical exercise is crucial in raising performance.',
                                'D' => '10,000 hours of relevant and demanding work will create a genius.'
                            ]],
                            [40, 'In the penultimate paragraph, it is stated the key to some deprived children\'s success is', [
                                'A' => 'a regular and nourishing diet at home.',
                                'B' => 'the loving support of more than one parent.',
                                'C' => 'a community which has well-funded facilities for learning.',
                                'D' => 'the guidance of someone who recognises the benefits of learning.'
                            ]]
                        ] as [$num, $question, $opts])
                        <div>
                            <p class="text-sm font-semibold text-gray-800 mb-2"><span class="text-blue-600 font-bold mr-1">{{ $num }}</span> {{ $question }}</p>
                            <div class="space-y-2 ml-4">
                                @foreach($opts as $letter => $text)
                                <label class="flex items-start gap-4 cursor-pointer group">
                                    <input type="radio" x-model="answers.q{{ $num }}" name="q{{ $num }}" value="{{ $letter }}" class="mt-0.5 w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer flex-none">
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

                {{-- Final Submit --}}
                <div class="mt-8 flex justify-end">
                    <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                        Submit All Answers
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Admin Key --}}
@if(Auth::check() && Auth::user()->isAdmin())
    <div id="uploadAnswerKeyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4" onclick="if(event.target===this)this.classList.add('hidden')">
        <div class="bg-white rounded-xl shadow-2xl p-6 max-w-md w-full mx-auto">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Upload Answer Key</h3>
                <button onclick="document.getElementById('uploadAnswerKeyModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <form action="{{ route('assignments.ielts-academic.mockup.cambridge.upload-answer-key', ['edition' => $edition, 'id' => $testId]) }}" method="POST" class="space-y-4">
                @csrf
                <div><label class="block text-sm font-semibold text-gray-700 mb-2">Answer Key Content</label><textarea name="answer_key" rows="6" required class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg font-mono text-sm" placeholder="1. TRUE&#10;2. FALSE..."></textarea></div>
                <div class="flex gap-3 pt-4"><button type="button" onclick="document.getElementById('uploadAnswerKeyModal').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg">Cancel</button><button type="submit" class="flex-1 px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg">Save Key</button></div>
            </form>
        </div>
    </div>
@endif

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>IELTS Listening Mock Up - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .answer-box {
            border: 1px solid #6b7280;
            background: #f3f4f6;
            min-width: 92px;
            height: 30px;
            padding: 2px 10px;
            font-size: 13px;
            text-align: center;
            color: #6b7280;
            border-radius: 0;
            vertical-align: middle;
        }

        .mcq-group {
            margin-bottom: 14px;
        }

        .mcq-option {
            margin-top: 4px;
        }

        .notes-list li {
            margin-bottom: 8px;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')

    <div class="flex min-h-screen">
        <main class="flex-1 w-full max-w-6xl mx-auto p-8 pb-56" x-data="{ step: 1 }">
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">IELTS Listening Mock Up</h1>
                            <p class="text-gray-600 mt-1">Full Listening Test</p>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="step === 1">
                <div class="max-w-4xl mx-auto bg-white p-8 shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 1 <span class="ml-8">Questions 1-10</span></h3>
                        <p class="italic mb-4">Complete the notes below.</p>
                        <p class="italic">Write <span class="font-bold">ONE WORD AND/OR A NUMBER</span> for each answer.</p>
                    </div>

                    <div class="border border-black p-6">
                        <h2 class="text-2xl font-bold text-center mb-6">Lifeguard Application</h2>

                        <div class="space-y-5 text-[16px] leading-8">
                            <div>
                                <p class="font-bold">Personal information</p>
                                <p>Name: Peter Smith</p>
                                <p>Address: 130 South Main Street, Lake <span class="font-bold">1</span> <input name="q1" class="answer-box" placeholder="Answer"></p>
                                <p>Contact number: <span class="font-bold">2</span> <input name="q2" class="answer-box" placeholder="Answer"> (cellphone)</p>
                            </div>

                            <div>
                                <p class="font-bold">Work experience:</p>
                                <ul class="list-disc ml-6">
                                    <li>has a part-time job as a <span class="font-bold">3</span> <input name="q3" class="answer-box" placeholder="Answer"></li>
                                    <li>is studying PE now</li>
                                    <li>hope to work in a high school as a <span class="font-bold">4</span> <input name="q4" class="answer-box" placeholder="Answer"> coach</li>
                                </ul>
                                <p><span class="font-bold">Other relevant work experience:</span> worked at the <span class="font-bold">5</span> <input name="q5" class="answer-box" placeholder="Answer"> as a lifeguard</p>
                            </div>

                            <div>
                                <p class="font-bold">Qualification for water safety:</p>
                                <ul class="list-disc ml-6">
                                    <li>Good level of concentration</li>
                                    <li>Good vision</li>
                                    <li>Other relevant skills: <span class="font-bold">6</span> <input name="q6" class="answer-box" placeholder="Answer"></li>
                                    <li>need a certificate: it expires in <span class="font-bold">7</span> <input name="q7" class="answer-box" placeholder="Answer"></li>
                                </ul>
                            </div>

                            <div>
                                <p class="font-bold">Other information</p>
                                <ul class="list-disc ml-6">
                                    <li>Preferred working time: <span class="font-bold">8</span> <input name="q8" class="answer-box" placeholder="Answer"> mornings</li>
                                    <li>He can start to work at <span class="font-bold">9</span> <input name="q9" class="answer-box" placeholder="Answer"> o'clock</li>
                                    <li>Source of information: <span class="font-bold">10</span> <input name="q10" class="answer-box" placeholder="Answer"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="max-w-4xl mx-auto mt-8 flex justify-end">
                    <button @click="step = 2" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all">Next Part</button>
                </div>
            </div>

            <div x-show="step === 2" x-cloak>
                <div class="max-w-4xl mx-auto bg-white p-8 shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 2 <span class="ml-8">Questions 11-20</span></h3>
                        <h4 class="font-bold text-md mb-2">Questions 11-14</h4>
                        <p class="italic">Label the map below.</p>
                        <p class="italic">Write the correct letter, <span class="font-bold">A-I</span>, next to Questions 11-14.</p>
                    </div>

                    <div class="border border-gray-200 bg-gray-50 rounded-lg p-4 mb-6">
                        <img
                            src="{{ asset('images/ielts/test/paket1/listening/paket1-elmsden-way-map.png') }}"
                            alt="The Elmsden Way map"
                            class="w-full h-auto max-w-4xl mx-auto"
                            onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
                        >
                        <p class="hidden text-center text-sm text-gray-500 py-8">
                            Map belum ditemukan. Simpan file map ke
                            <code>public/images/ielts/test/paket1/listening/paket1-elmsden-way-map.png</code>.
                        </p>
                    </div>

                    <div class="text-sm space-y-3 mb-8">
                        <p><span class="font-bold mr-2">11</span>rocks <input name="q11" class="answer-box" placeholder="Answer"></p>
                        <p><span class="font-bold mr-2">12</span>Corley nature reserve <input name="q12" class="answer-box" placeholder="Answer"></p>
                        <p><span class="font-bold mr-2">13</span>Ashington china factory <input name="q13" class="answer-box" placeholder="Answer"></p>
                        <p><span class="font-bold mr-2">14</span>Langton forest <input name="q14" class="answer-box" placeholder="Answer"></p>
                    </div>

                    <h4 class="font-bold text-md mb-2">Questions 15-20</h4>
                    <p class="italic mb-4">Choose the correct letter, <span class="font-bold">A, B or C</span>.</p>
                    <div class="space-y-6 text-sm leading-7">
                        <div class="mcq-group">
                            <p><span class="font-bold mr-2">15</span>What warning does the speaker give about cycling on the Elmsden Way?</p>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q15" value="A" class="mt-1"> <span><span class="font-semibold">A</span> The roads usually have heavy traffic.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q15" value="B" class="mt-1"> <span><span class="font-semibold">B</span> Bad weather can cause problems.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q15" value="C" class="mt-1"> <span><span class="font-semibold">C</span> There may be animals on the cycle path.</span></label>
                        </div>
                        <div class="mcq-group">
                            <p><span class="font-bold mr-2">16</span>What does the speaker say about Elmsden Station?</p>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q16" value="A" class="mt-1"> <span><span class="font-semibold">A</span> It is a very busy station.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q16" value="B" class="mt-1"> <span><span class="font-semibold">B</span> It has been modernized.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q16" value="C" class="mt-1"> <span><span class="font-semibold">C</span> It reopened recently.</span></label>
                        </div>
                        <div class="mcq-group">
                            <p><span class="font-bold mr-2">17</span>In the Visitors' Centre, people can</p>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q17" value="A" class="mt-1"> <span><span class="font-semibold">A</span> hire a bicycle.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q17" value="B" class="mt-1"> <span><span class="font-semibold">B</span> buy refreshments.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q17" value="C" class="mt-1"> <span><span class="font-semibold">C</span> learn about local history.</span></label>
                        </div>
                        <div class="mcq-group">
                            <p><span class="font-bold mr-2">18</span>If cyclists want to travel between Elmsden and Langton by train,</p>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q18" value="A" class="mt-1"> <span><span class="font-semibold">A</span> they need to book in advance.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q18" value="B" class="mt-1"> <span><span class="font-semibold">B</span> they have to travel at the weekend.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q18" value="C" class="mt-1"> <span><span class="font-semibold">C</span> they must pay an additional charge for their bicycle.</span></label>
                        </div>
                        <div class="mcq-group">
                            <p><span class="font-bold mr-2">19</span>What warning does the speaker give about walking to the River Elm?</p>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q19" value="A" class="mt-1"> <span><span class="font-semibold">A</span> It can take a long time to get back.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q19" value="B" class="mt-1"> <span><span class="font-semibold">B</span> There is nowhere to leave bicycles.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q19" value="C" class="mt-1"> <span><span class="font-semibold">C</span> The waterfall is inaccessible on foot.</span></label>
                        </div>
                        <div class="mcq-group">
                            <p><span class="font-bold mr-2">20</span>To find out about other cycle paths in the region, you can</p>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q20" value="A" class="mt-1"> <span><span class="font-semibold">A</span> look in the local newspaper.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q20" value="B" class="mt-1"> <span><span class="font-semibold">B</span> check the radio station website.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q20" value="C" class="mt-1"> <span><span class="font-semibold">C</span> ring up the national cycle network.</span></label>
                        </div>
                    </div>
                </div>

                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                    <button @click="step = 1" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all">Previous</button>
                    <button @click="step = 3" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all">Next Part</button>
                </div>
            </div>

            <div x-show="step === 3" x-cloak>
                <div class="max-w-4xl mx-auto bg-white p-8 shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 3 <span class="ml-8">Questions 21-30</span></h3>
                        <h4 class="font-bold text-md mb-2">Questions 21-25</h4>
                        <p class="italic">Choose <span class="font-bold">FIVE</span> answers from the box and write the correct letter, <span class="font-bold">A-G</span>, next to Questions 21-25.</p>
                    </div>

                    <div class="border border-black p-4 mb-6 max-w-sm">
                        <p class="font-bold text-center mb-2">Comment</p>
                        <p>A need more photos to support</p>
                        <p>B repeat other people's studies</p>
                        <p>C inaccurate information</p>
                        <p>D need first-hand material</p>
                        <p>E need more details</p>
                        <p>F no need to talk about it</p>
                        <p>G check again</p>
                    </div>

                    <div class="space-y-3 text-sm mb-8">
                        <div class="flex items-center gap-2">
                            <span class="font-bold mr-1">21</span>
                            <span>shield volcanoes</span>
                            <select name="q21" class="answer-box">
                                <option value="">Answer</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold mr-1">22</span>
                            <span>stratovolcanoes</span>
                            <select name="q22" class="answer-box">
                                <option value="">Answer</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold mr-1">23</span>
                            <span>rhyolite caldera complexes</span>
                            <select name="q23" class="answer-box">
                                <option value="">Answer</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold mr-1">24</span>
                            <span>monogenetic fields</span>
                            <select name="q24" class="answer-box">
                                <option value="">Answer</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="font-bold mr-1">25</span>
                            <span>cinder cones</span>
                            <select name="q25" class="answer-box">
                                <option value="">Answer</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                            </select>
                        </div>
                    </div>

                    <h4 class="font-bold text-md mb-2">Questions 26-30</h4>
                    <p class="italic mb-4">Choose the correct letter, <span class="font-bold">A, B or C</span>.</p>
                    <div class="space-y-6 text-sm leading-7">
                        <div class="mcq-group">
                            <p><span class="font-bold mr-2">26</span>In Erica's view, what is wrong with Ian's last presentation?</p>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q26" value="A" class="mt-1"> <span><span class="font-semibold">A</span> He did not read loud enough.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q26" value="B" class="mt-1"> <span><span class="font-semibold">B</span> He did not understand the main reason.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q26" value="C" class="mt-1"> <span><span class="font-semibold">C</span> He did not provide enough evidence.</span></label>
                        </div>
                        <div class="mcq-group">
                            <p><span class="font-bold mr-2">27</span>What materials do the students agree to add to their presentation?</p>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q27" value="A" class="mt-1"> <span><span class="font-semibold">A</span> a complete documentary</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q27" value="B" class="mt-1"> <span><span class="font-semibold">B</span> photographs included in the handouts</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q27" value="C" class="mt-1"> <span><span class="font-semibold">C</span> Internet video clips</span></label>
                        </div>
                        <div class="mcq-group">
                            <p><span class="font-bold mr-2">28</span>By using extinct and dormant volcanoes, the students try to</p>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q28" value="A" class="mt-1"> <span><span class="font-semibold">A</span> distinguish between scientific and popular terms.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q28" value="B" class="mt-1"> <span><span class="font-semibold">B</span> distinguish between two different types of volcanoes.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q28" value="C" class="mt-1"> <span><span class="font-semibold">C</span> distinguish whether an eruption is about to happen.</span></label>
                        </div>
                        <div class="mcq-group">
                            <p><span class="font-bold mr-2">29</span>What did the professor say about Erica's last presentation?</p>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q29" value="A" class="mt-1"> <span><span class="font-semibold">A</span> She carried out an in-depth discussion with other students.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q29" value="B" class="mt-1"> <span><span class="font-semibold">B</span> She did not provide sufficient data.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q29" value="C" class="mt-1"> <span><span class="font-semibold">C</span> She did not fully develop a personal point.</span></label>
                        </div>
                        <div class="mcq-group">
                            <p><span class="font-bold mr-2">30</span>The students both agree that volcanoes</p>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q30" value="A" class="mt-1"> <span><span class="font-semibold">A</span> haven't caused disastrous outcomes.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q30" value="B" class="mt-1"> <span><span class="font-semibold">B</span> cannot help to reshape the landscape.</span></label>
                            <label class="pl-6 flex items-start gap-2 cursor-pointer mcq-option"><input type="radio" name="q30" value="C" class="mt-1"> <span><span class="font-semibold">C</span> are not fully recognised for their values.</span></label>
                        </div>
                    </div>
                </div>

                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                    <button @click="step = 2" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all">Previous</button>
                    <button @click="step = 4" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all">Next Part</button>
                </div>
            </div>

            <div x-show="step === 4" x-cloak>
                <div class="max-w-4xl mx-auto bg-white p-8 shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 4 <span class="ml-8">Questions 31-40</span></h3>
                        <p class="italic mb-4">Complete the notes below.</p>
                        <p class="italic">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>
                    </div>

                    <div class="border-4 border-gray-300 rounded-3xl p-6">
                        <h2 class="text-2xl font-bold text-center mb-6">Dolphin Intelligence</h2>
                        <div class="space-y-7 text-sm leading-8">
                            <div>
                                <p class="font-bold">Point 1: Not highly intelligent</p>
                                <p>Research on the size of dolphin brains</p>
                                <ul class="list-disc ml-6 notes-list">
                                    <li>Dolphins cannot find a way of escaping barriers such as fishing <span class="font-bold">31</span> <input name="q31" class="answer-box" placeholder="Answer"> for catching tuna.</li>
                                    <li>People wrongly thought dolphins to be smart and happy as they often have a <span class="font-bold">32</span> <input name="q32" class="answer-box" placeholder="Answer">.</li>
                                    <li>Small-brained animals such as pigeons and <span class="font-bold">33</span> <input name="q33" class="answer-box" placeholder="Answer"> can perform various complex tasks.</li>
                                </ul>
                                <p class="ml-8 mt-2">- Pigeons are <span class="font-bold">34</span> <input name="q34" class="answer-box" placeholder="Answer"> of themselves.</p>
                                <p class="ml-8 mt-2">- Pigeons are trained to conditional responses and <span class="font-bold">35</span> <input name="q35" class="answer-box" placeholder="Answer"> reactions.</p>
                            </div>
                            <div>
                                <p class="font-bold">Counter argument</p>
                                <ul class="list-disc ml-6 notes-list">
                                    <li>Fatty cells in dolphin brains are linked to protective function and problem-solving skills.</li>
                                </ul>
                            </div>
                            <div>
                                <p class="font-bold">Point 2: highly intelligent</p>
                                <p>Research on dolphin behaviour</p>
                                <ul class="list-disc ml-6 notes-list">
                                    <li>Billy can imitate the keepers' <span class="font-bold">36</span> <input name="q36" class="answer-box" placeholder="Answer"> through other dolphins.</li>
                                    <li>Karen hides a <span class="font-bold">37</span> <input name="q37" class="answer-box" placeholder="Answer"> for more food.</li>
                                    <li>For the past century, dolphins have been seen as <span class="font-bold">38</span> <input name="q38" class="answer-box" placeholder="Answer"> animals.</li>
                                    <li>Each dolphin produces a unique sound, like the <span class="font-bold">39</span> <input name="q39" class="answer-box" placeholder="Answer">.</li>
                                    <li>They touch each other to make up after a <span class="font-bold">40</span> <input name="q40" class="answer-box" placeholder="Answer">.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                    <button @click="step = 3" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all">Previous</button>
                    <button id="submitListeningAnswersBtn" type="button" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition-all">Submit All Answers</button>
                </div>

                <div id="listeningResultPanel" class="hidden max-w-4xl mx-auto mt-4 rounded-xl border p-4 text-sm"></div>

                @php
                    $latestListeningEval = is_array($latestPackageSectionResult->evaluation_data ?? null) ? $latestPackageSectionResult->evaluation_data : [];
                    $latestListeningCorrect = $latestListeningEval['score_correct'] ?? null;
                    $latestListeningTotal = $latestListeningEval['score_total'] ?? null;
                    $latestListeningPercent = $latestListeningEval['score_percent'] ?? ($latestPackageSectionResult->score ?? null);
                @endphp
                <div id="latestListeningAttemptPanel" class="max-w-4xl mx-auto mt-4 rounded-xl border border-gray-200 bg-white p-4 text-sm text-gray-700">
                    @if($latestPackageSectionResult)
                        <p class="font-semibold text-gray-900">Hasil Tersimpan Terakhir</p>
                        <p class="mt-1">Skor: <span class="font-bold">{{ $latestListeningPercent }}%</span>
                            @if($latestListeningCorrect !== null && $latestListeningTotal !== null)
                                ({{ $latestListeningCorrect }}/{{ $latestListeningTotal }})
                            @endif
                        </p>
                        <p class="mt-1 text-xs text-gray-500">Disimpan: {{ optional($latestPackageSectionResult->completed_at)->format('d M Y H:i') ?? '-' }}</p>
                    @else
                        <p class="font-semibold text-gray-900">Belum Ada Hasil Tersimpan</p>
                        <p class="mt-1 text-xs text-gray-500">Submit jawaban untuk menyimpan attempt pertama section listening ini.</p>
                    @endif
                </div>
            </div>
        </main>
    </div>

    @include('assignments.ielts.listening.partials.audio-player', [
        'set' => 'Paket ' . ($test['package_number'] ?? 1),
        'material' => $material ?? null,
        'section' => $material ?? null,
        'audio_url' => (isset($material) && !empty($material->audio_file)) ? asset($material->audio_file) : null,
    ])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const audio = document.getElementById('mainAudio');
            const playIcon = document.getElementById('playIcon');
            const pauseIcon = document.getElementById('pauseIcon');
            const progressBar = document.getElementById('progressBar');
            const progressHandle = document.getElementById('progressHandle');
            const progressContainer = document.getElementById('progressContainer');
            const currentTimeDisplay = document.getElementById('currentTime');
            const durationDisplay = document.getElementById('duration');

            if (!audio || !progressContainer) return;

            let isDragging = false;

            function formatTime(seconds) {
                if (isNaN(seconds)) return '0:00';
                const mins = Math.floor(seconds / 60);
                const secs = Math.floor(seconds % 60);
                return `${mins}:${secs.toString().padStart(2, '0')}`;
            }

            window.togglePlayPause = function() {
                if (audio.paused) {
                    audio.play();
                    playIcon.classList.add('hidden');
                    pauseIcon.classList.remove('hidden');
                } else {
                    audio.pause();
                    playIcon.classList.remove('hidden');
                    pauseIcon.classList.add('hidden');
                }
            };

            window.skipAudio = function(seconds) {
                if (audio && audio.duration) {
                    audio.currentTime = Math.max(0, Math.min(audio.duration, audio.currentTime + seconds));
                }
            };

            function seekAudio(event) {
                if (!audio.duration) return;
                const rect = progressContainer.getBoundingClientRect();
                const clientX = event.clientX || (event.touches ? event.touches[0].clientX : 0);
                const percentage = Math.max(0, Math.min(1, (clientX - rect.left) / rect.width));
                audio.currentTime = percentage * audio.duration;
            }

            progressContainer.addEventListener('mousedown', (e) => { isDragging = true; seekAudio(e); e.preventDefault(); });
            document.addEventListener('mousemove', (e) => { if (isDragging) seekAudio(e); });
            document.addEventListener('mouseup', () => { isDragging = false; });

            progressContainer.addEventListener('touchstart', (e) => { isDragging = true; seekAudio(e.touches[0]); e.preventDefault(); });
            document.addEventListener('touchmove', (e) => { if (isDragging) seekAudio(e.touches[0]); });
            document.addEventListener('touchend', () => { isDragging = false; });

            audio.addEventListener('timeupdate', () => {
                if (audio.duration && !isDragging) {
                    const percentage = (audio.currentTime / audio.duration) * 100;
                    progressBar.style.width = percentage + '%';
                    progressHandle.style.left = percentage + '%';
                    currentTimeDisplay.textContent = formatTime(audio.currentTime);
                }
            });

            audio.addEventListener('loadedmetadata', () => {
                durationDisplay.textContent = formatTime(audio.duration);
            });

            audio.addEventListener('ended', () => {
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
            });

            window.toggleTranscriptDrawer = function() {
                const transcriptDrawer = document.getElementById('transcriptDrawer');
                if (transcriptDrawer) transcriptDrawer.classList.toggle('hidden');
            };
        });

        /* ── Listening answer key scoring (paket 1) ── */
        window.listeningPaket1AnswerKey = {
            q1: 'elsinore',
            q2: '077896245',
            q3: 'waiter',
            q4: 'baseball',
            q5: 'beach',
            q6: 'diving',
            q7: 'october',
            q8: 'saturday',
            q9: ['6', 'six', '6/six'],
            q10: 'radio',
            q11: 'B', q12: 'E', q13: 'F', q14: 'I', q15: 'C', q16: 'C', q17: 'A', q18: 'B', q19: 'A', q20: 'A',
            q21: 'B', q22: 'E', q23: 'C', q24: 'G', q25: 'F', q26: 'B', q27: 'C', q28: 'A', q29: 'C', q30: 'C',
            q31: 'nets', q32: 'smile', q33: 'rats', q34: 'aware', q35: 'instinctive', q36: 'walking', q37: 'newspaper', q38: 'social', q39: 'whistle', q40: 'fight'
        };

        const customListeningAnswerKey = @json($packageAnswerKey ?? []);
        if (customListeningAnswerKey && typeof customListeningAnswerKey === 'object' && Object.keys(customListeningAnswerKey).length > 0) {
            window.listeningPaket1AnswerKey = customListeningAnswerKey;
        }

        window.normalizeListeningAnswer = function(value) {
            return String(value || '')
                .trim()
                .toLowerCase()
                .replace(/[.,;:!?]/g, '')
                .replace(/\s+/g, ' ');
        };

        window.readListeningAnswerRaw = function(questionNumber) {
            const field = document.querySelector(`[name="q${questionNumber}"]`);
            if (!field) return '';
            return field.value ?? '';
        };

        window.readListeningAnswerDisplay = function(questionNumber) {
            const raw = window.readListeningAnswerRaw(questionNumber);
            return String(raw || '').trim() || '-';
        };

        window.getListeningExpectedAnswerDisplay = function(questionNumber) {
            const expected = window.listeningPaket1AnswerKey[`q${questionNumber}`];
            if (Array.isArray(expected)) {
                return expected.join(' / ');
            }
            return String(expected ?? '');
        };

        window.isListeningAnswerCorrect = function(questionNumber) {
            const key = window.listeningPaket1AnswerKey;
            const expected = key[`q${questionNumber}`];
            const userRaw = window.readListeningAnswerRaw(questionNumber);

            // Option-based answers should match token exactly (case-insensitive).
            if (questionNumber >= 11 && questionNumber <= 30) {
                return String(userRaw || '').trim().toUpperCase() === String(expected).toUpperCase();
            }

            const user = window.normalizeListeningAnswer(userRaw);

            if (Array.isArray(expected)) {
                return expected.some(item => window.normalizeListeningAnswer(item) === user);
            }

            return user === window.normalizeListeningAnswer(expected);
        };

        window.collectListeningAnswersPayload = function() {
            const payload = {};
            for (let q = 1; q <= 40; q++) {
                payload[`q${q}`] = window.readListeningAnswerDisplay(q);
            }
            return payload;
        };

        window.getListeningQuestionElements = function(questionNumber) {
            const field = document.querySelector(`[name="q${questionNumber}"]`);
            return field ? [field] : [];
        };

        window.resetListeningAnswerHighlights = function() {
            const fields = document.querySelectorAll('input[name^="q"], select[name^="q"]');
            fields.forEach((el) => {
                el.classList.remove('ring-2', 'ring-red-400', 'border-red-400', 'bg-red-50');
                el.classList.remove('ring-2', 'ring-green-400', 'border-green-400', 'bg-green-50');
            });
        };

        window.paintListeningQuestionResult = function(questionNumber, isCorrect) {
            const targets = window.getListeningQuestionElements(questionNumber);
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
            const submitBtn = document.getElementById('submitListeningAnswersBtn');
            const resultPanel = document.getElementById('listeningResultPanel');
            const latestAttemptPanel = document.getElementById('latestListeningAttemptPanel');
            if (!submitBtn || !resultPanel) return;

            const submitUrl = @json($packageSectionSubmitUrl ?? null);
            const redirectUrl = @json(route('online-test.show', ['slug' => 'ielts_academic']));
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            submitBtn.addEventListener('click', async function() {
                let correct = 0;
                const wrong = [];

                window.resetListeningAnswerHighlights();

                for (let q = 1; q <= 40; q++) {
                    const ok = window.isListeningAnswerCorrect(q);
                    if (ok) {
                        correct += 1;
                    } else {
                        wrong.push(q);
                    }

                    window.paintListeningQuestionResult(q, ok);
                }

                resultPanel.classList.remove('hidden', 'border-red-200', 'bg-red-50', 'text-red-800', 'border-green-200', 'bg-green-50', 'text-green-800');

                if (wrong.length === 0) {
                    resultPanel.classList.add('border-green-200', 'bg-green-50', 'text-green-800');
                    resultPanel.innerHTML = `<p class="font-bold">Skor: ${correct}/40</p><p class="mt-1">Semua jawaban benar.</p>`;
                } else {
                    resultPanel.classList.add('border-red-200', 'bg-red-50', 'text-red-800');
                    const details = wrong.map((q) => {
                        const userAnswer = window.readListeningAnswerDisplay(q);
                        const expectedAnswer = window.getListeningExpectedAnswerDisplay(q);
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
                    resultPanel.classList.remove('hidden');
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
                            answers: window.collectListeningAnswersPayload(),
                        }),
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }

                    const data = await response.json();
                    resultPanel.innerHTML += `<p class="mt-3 text-xs">Status simpan: ${data.message || 'Berhasil'} (ID: ${data.result_id ?? '-'})</p>`;

                    if (latestAttemptPanel) {
                        latestAttemptPanel.innerHTML = `
                            <p class="font-semibold text-gray-900">Hasil Tersimpan Terakhir</p>
                            <p class="mt-1">Skor: <span class="font-bold">${data.score_percent ?? '-'}%</span> (${correct}/40)</p>
                            <p class="mt-1 text-xs text-gray-500">Disimpan: baru saja</p>
                        `;
                    }

                    resultPanel.innerHTML += `<p class="mt-3 text-xs">Mengalihkan ke halaman Online Test IELTS Academic untuk lanjut ke Reading...</p>`;
                    setTimeout(() => {
                        window.location.href = redirectUrl;
                    }, 900);
                } catch (error) {
                    resultPanel.innerHTML += `<p class="mt-3 text-xs">Status simpan: gagal (${error?.message || 'unknown error'})</p>`;
                }

                resultPanel.classList.remove('hidden');
                resultPanel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            });
        });
    </script>
</body>
</html>

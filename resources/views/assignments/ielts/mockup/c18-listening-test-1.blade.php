<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Listening Mock Up - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')
<div class="flex min-h-screen">
    <main class="flex-1 w-full max-w-6xl mx-auto p-8">
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
                        <p class="text-gray-600 mt-1">Cambridge {{ $edition }} Test {{ $testId }}</p>
                    </div>
                </div>
                <a href="{{ route('assignments.ielts-academic.mockup.cambridge.skills', ['edition' => $edition, 'id' => $testId ?? 1]) }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back
                </a>
            </div>
        </div>

        <div x-data="{ step: 1 }" x-init="$watch('step', value => $dispatch('part-changed', value))">

            {{-- PART 1 --}}
            <div x-show="step === 1">
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 1 <span class="ml-8">Questions 1–10</span></h3>
                        <p class="italic mb-2">Complete the notes below.</p>
                        <p class="italic">Write <span class="font-bold">ONE WORD AND/OR A NUMBER</span> for each answer.</p>
                    </div>
                    <div class="border border-black p-6">
                        <h2 class="text-2xl font-bold text-center mb-6">Transport survey</h2>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-3 mb-6">
                            <div class="font-bold">Name:</div><div>Sadie Jones</div>
                            <div class="font-bold">Year of birth:</div><div>1991</div>
                            <div class="font-bold">Postcode:</div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold">1</span>
                                <input type="text" class="border-b border-black outline-none px-2 w-48 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                            </div>
                        </div>
                        <div class="mb-5">
                            <p class="font-bold mb-3">Travelling by bus</p>
                            <div class="space-y-3 ml-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="w-60">Date of bus journey:</span>
                                    <span class="font-bold">2</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="w-60">Reason for trip:</span>
                                    <span>shopping and visit to the</span>
                                    <span class="font-bold">3</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="w-60">Travelled by bus because cost of</span>
                                    <span class="font-bold">4</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>too high</span>
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="w-60">Got on bus at</span>
                                    <span class="font-bold">5</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                    <span>Street</span>
                                </div>
                                <div>
                                    <p class="mb-2">Complaints about bus service:</p>
                                    <div class="ml-4 space-y-2">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span>–  bus today was</span>
                                            <span class="font-bold">6</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                        </div>
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span>–  frequency of buses in the</span>
                                            <span class="font-bold">7</span>
                                            <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-5">
                            <p class="font-bold mb-3">Travelling by car</p>
                            <div class="flex items-center gap-2 flex-wrap ml-2">
                                <span class="w-60">Goes to the</span>
                                <span class="font-bold">8</span>
                                <input type="text" class="border-b border-black outline-none px-2 w-40 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                <span>by car</span>
                            </div>
                        </div>
                        <div>
                            <p class="font-bold mb-3">Travelling by bicycle</p>
                            <div class="space-y-3 ml-2">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>Dislikes travelling by bike in the city centre because of the</span>
                                    <span class="font-bold">9</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                </div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span>Doesn't own a bike because of a lack of</span>
                                    <span class="font-bold">10</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400" placeholder="Answer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-end">
                    <button @click="step = 2" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
                </div>
            </div>

            {{-- PART 2 --}}
            <div x-show="step === 2" x-cloak>
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 2 <span class="ml-8">Questions 11–20</span></h3>
                        <h4 class="font-bold text-md mb-2">Questions 11–13</h4>
                        <p class="italic">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
                    </div>
                    <h2 class="text-xl font-bold text-center mb-6">Becoming a volunteer for ACE</h2>
                    <div class="pl-4 space-y-6">
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">11</span> Why does the speaker apologise about the seats?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q11" value="A" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">A</span><span class="group-hover:text-blue-600 transition">They are too small.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q11" value="B" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">B</span><span class="group-hover:text-blue-600 transition">There are not enough of them.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q11" value="C" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">C</span><span class="group-hover:text-blue-600 transition">Some of them are very close together.</span></label>
                            </div>
                        </div>
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">12</span> What does the speaker say about the age of volunteers?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q12" value="A" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">A</span><span class="group-hover:text-blue-600 transition">The age of volunteers is less important than other factors.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q12" value="B" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">B</span><span class="group-hover:text-blue-600 transition">Young volunteers are less reliable than older ones.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q12" value="C" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">C</span><span class="group-hover:text-blue-600 transition">Most volunteers are about 60 years old.</span></label>
                            </div>
                        </div>
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">13</span> What does the speaker say about training?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q13" value="A" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">A</span><span class="group-hover:text-blue-600 transition">It is continuous.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q13" value="B" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">B</span><span class="group-hover:text-blue-600 transition">It is conducted by a manager.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q13" value="C" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">C</span><span class="group-hover:text-blue-600 transition">It takes place online.</span></label>
                            </div>
                        </div>
                        <div class="border-b border-gray-200 pb-5">
                            <h4 class="font-bold text-md mb-1">Questions 14 and 15</h4>
                            <p class="italic mb-2">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                            <p class="font-semibold mb-3">Which <span class="font-bold">TWO</span> issues does the speaker ask the audience to consider before they apply to be volunteers?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q14_15[]" value="A" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">A</span><span class="group-hover:text-blue-600 transition">their financial situation</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q14_15[]" value="B" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">B</span><span class="group-hover:text-blue-600 transition">their level of commitment</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q14_15[]" value="C" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">C</span><span class="group-hover:text-blue-600 transition">their work experience</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q14_15[]" value="D" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">D</span><span class="group-hover:text-blue-600 transition">their ambition</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q14_15[]" value="E" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">E</span><span class="group-hover:text-blue-600 transition">their availability</span></label>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-bold text-md mb-1">Questions 16–20</h4>
                            <p class="italic mb-2">What does the speaker suggest would be helpful for each of the following areas of voluntary work?</p>
                            <p class="italic mb-6">Choose <span class="font-bold">FIVE</span> answers from the box and write the correct letter, <span class="font-bold">A–G</span>, next to Questions 16–20.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="border border-gray-400 p-5 rounded-lg bg-gray-50">
                                    <h5 class="font-bold text-center mb-4 text-base border-b border-gray-300 pb-2">Helpful things volunteers might offer</h5>
                                    <div class="space-y-2">
                                        <div class="flex gap-3"><span class="font-bold">A</span><span>experience on stage</span></div>
                                        <div class="flex gap-3"><span class="font-bold">B</span><span>original, new ideas</span></div>
                                        <div class="flex gap-3"><span class="font-bold">C</span><span>parenting skills</span></div>
                                        <div class="flex gap-3"><span class="font-bold">D</span><span>an understanding of food and diet</span></div>
                                        <div class="flex gap-3"><span class="font-bold">E</span><span>retail experience</span></div>
                                        <div class="flex gap-3"><span class="font-bold">F</span><span>a good memory</span></div>
                                        <div class="flex gap-3"><span class="font-bold">G</span><span>a good level of fitness</span></div>
                                    </div>
                                </div>
                                <div>
                                    <h5 class="font-bold mb-4 text-base">Area of voluntary work</h5>
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-4"><span class="font-bold w-6">16</span><span class="flex-1">Fundraising</span><input type="text" class="border-b border-black outline-none px-2 w-20 bg-transparent focus:border-blue-500 text-center uppercase font-bold" maxlength="1" placeholder="A-G"></div>
                                        <div class="flex items-center gap-4"><span class="font-bold w-6">17</span><span class="flex-1">Litter collection</span><input type="text" class="border-b border-black outline-none px-2 w-20 bg-transparent focus:border-blue-500 text-center uppercase font-bold" maxlength="1" placeholder="A-G"></div>
                                        <div class="flex items-center gap-4"><span class="font-bold w-6">18</span><span class="flex-1">'Playmates'</span><input type="text" class="border-b border-black outline-none px-2 w-20 bg-transparent focus:border-blue-500 text-center uppercase font-bold" maxlength="1" placeholder="A-G"></div>
                                        <div class="flex items-center gap-4"><span class="font-bold w-6">19</span><span class="flex-1">Story club</span><input type="text" class="border-b border-black outline-none px-2 w-20 bg-transparent focus:border-blue-500 text-center uppercase font-bold" maxlength="1" placeholder="A-G"></div>
                                        <div class="flex items-center gap-4"><span class="font-bold w-6">20</span><span class="flex-1">First aid</span><input type="text" class="border-b border-black outline-none px-2 w-20 bg-transparent focus:border-blue-500 text-center uppercase font-bold" maxlength="1" placeholder="A-G"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                    <button @click="step = 1" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Previous Part</button>
                    <button @click="step = 3" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
                </div>
            </div>

            {{-- PART 3 --}}
            <div x-show="step === 3" x-cloak>
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 3 <span class="ml-8">Questions 21–30</span></h3>
                        <h4 class="font-bold text-md mb-2">Questions 21–26</h4>
                        <p class="italic">Choose the correct letter, <span class="font-bold">A</span>, <span class="font-bold">B</span> or <span class="font-bold">C</span>.</p>
                    </div>
                    <h2 class="text-xl font-bold text-center mb-6">Talk on jobs in fashion design</h2>
                    <div class="pl-4 space-y-6">
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">21</span> What problem did Chantal have at the start of the talk?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q21" value="A" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">A</span><span class="group-hover:text-blue-600 transition">Her view of the speaker was blocked.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q21" value="B" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">B</span><span class="group-hover:text-blue-600 transition">She was unable to find an empty seat.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q21" value="C" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">C</span><span class="group-hover:text-blue-600 transition">The students next to her were talking.</span></label>
                            </div>
                        </div>
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">22</span> What were Hugo and Chantal surprised to hear about the job market?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q22" value="A" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">A</span><span class="group-hover:text-blue-600 transition">It has become more competitive than it used to be.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q22" value="B" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">B</span><span class="group-hover:text-blue-600 transition">There is more variety in it than they had realised.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q22" value="C" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">C</span><span class="group-hover:text-blue-600 transition">Some areas of it are more exciting than others.</span></label>
                            </div>
                        </div>
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">23</span> Hugo and Chantal agree that the speaker's message was</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q23" value="A" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">A</span><span class="group-hover:text-blue-600 transition">unfair to them at times.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q23" value="B" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">B</span><span class="group-hover:text-blue-600 transition">hard for them to follow.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q23" value="C" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">C</span><span class="group-hover:text-blue-600 transition">critical of the industry.</span></label>
                            </div>
                        </div>
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">24</span> What do Hugo and Chantal criticise about their school careers advice?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q24" value="A" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">A</span><span class="group-hover:text-blue-600 transition">when they received the advice</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q24" value="B" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">B</span><span class="group-hover:text-blue-600 transition">how much advice was given</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q24" value="C" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">C</span><span class="group-hover:text-blue-600 transition">who gave the advice</span></label>
                            </div>
                        </div>
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">25</span> When discussing their future, Hugo and Chantal disagree on</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q25" value="A" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">A</span><span class="group-hover:text-blue-600 transition">which is the best career in fashion.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q25" value="B" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">B</span><span class="group-hover:text-blue-600 transition">when to choose a career in fashion.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q25" value="C" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">C</span><span class="group-hover:text-blue-600 transition">why they would like a career in fashion.</span></label>
                            </div>
                        </div>
                        <div class="border-b border-gray-200 pb-5">
                            <p class="font-semibold mb-3"><span class="font-bold mr-2">26</span> How does Hugo feel about being an unpaid assistant?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q26" value="A" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">A</span><span class="group-hover:text-blue-600 transition">He is realistic about the practice.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q26" value="B" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">B</span><span class="group-hover:text-blue-600 transition">He feels the practice is dishonest.</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="radio" name="q26" value="C" class="w-5 h-5 text-blue-600"><span class="font-bold w-4">C</span><span class="group-hover:text-blue-600 transition">He thinks others want to change the practice.</span></label>
                            </div>
                        </div>
                        <div class="border-b border-gray-200 pb-5">
                            <h4 class="font-bold text-md mb-1">Questions 27 and 28</h4>
                            <p class="italic mb-2">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                            <p class="font-semibold mb-3">Which <span class="font-bold">TWO</span> mistakes did the speaker admit she made in her first job?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q27_28[]" value="A" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">A</span><span class="group-hover:text-blue-600 transition">being dishonest to her employer</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q27_28[]" value="B" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">B</span><span class="group-hover:text-blue-600 transition">paying too much attention to how she looked</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q27_28[]" value="C" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">C</span><span class="group-hover:text-blue-600 transition">expecting to become well known</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q27_28[]" value="D" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">D</span><span class="group-hover:text-blue-600 transition">trying to earn a lot of money</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q27_28[]" value="E" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">E</span><span class="group-hover:text-blue-600 transition">openly disliking her client</span></label>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-bold text-md mb-1">Questions 29 and 30</h4>
                            <p class="italic mb-2">Choose <span class="font-bold">TWO</span> letters, <span class="font-bold">A–E</span>.</p>
                            <p class="font-semibold mb-3">Which <span class="font-bold">TWO</span> pieces of retail information do Hugo and Chantal agree would be useful?</p>
                            <div class="space-y-2 ml-8">
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q29_30[]" value="A" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">A</span><span class="group-hover:text-blue-600 transition">the reasons people return fashion items</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q29_30[]" value="B" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">B</span><span class="group-hover:text-blue-600 transition">how much time people have to shop for clothes</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q29_30[]" value="C" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">C</span><span class="group-hover:text-blue-600 transition">fashion designs people want but can't find</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q29_30[]" value="D" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">D</span><span class="group-hover:text-blue-600 transition">the best time of year for fashion buying</span></label>
                                <label class="flex items-center gap-3 cursor-pointer group"><input type="checkbox" name="q29_30[]" value="E" class="w-5 h-5 text-blue-600 rounded"><span class="font-bold w-4">E</span><span class="group-hover:text-blue-600 transition">the most popular fashion sizes</span></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                    <button @click="step = 2" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Previous Part</button>
                    <button @click="step = 4" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Next Part</button>
                </div>
            </div>

            {{-- PART 4 --}}
            <div x-show="step === 4" x-cloak>
                <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>
                    <div class="mb-6">
                        <h3 class="font-bold text-lg mb-2">PART 4 <span class="ml-8">Questions 31–40</span></h3>
                        <p class="italic mb-2">Complete the notes below.</p>
                        <p class="italic">Write <span class="font-bold">ONE WORD ONLY</span> for each answer.</p>
                    </div>
                    <div class="border border-black p-6">
                        <h2 class="text-2xl font-bold text-center mb-6">Elephant translocation</h2>
                        <div class="mb-5">
                            <h4 class="font-bold text-base mb-3">Reasons for overpopulation at Majete National Park</h4>
                            <ul class="list-disc ml-5 space-y-2">
                                <li class="pl-2">strict enforcement of anti-poaching laws</li>
                                <li class="pl-2">successful breeding</li>
                            </ul>
                        </div>
                        <div class="mb-5">
                            <h4 class="font-bold text-base mb-3">Problems caused by elephant overpopulation</h4>
                            <ul class="list-disc ml-5 space-y-3">
                                <li class="pl-2">greater competition, causing hunger for elephants</li>
                                <li class="pl-2 flex items-center gap-2 flex-wrap">
                                    damage to <span class="font-bold ml-1">31</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400 text-center" placeholder="Answer">
                                    in the park
                                </li>
                            </ul>
                        </div>
                        <div class="mb-5">
                            <h4 class="font-bold text-base mb-3">The translocation process</h4>
                            <ul class="list-disc ml-5 space-y-3">
                                <li class="pl-2 flex items-center gap-2 flex-wrap">
                                    a suitable group of elephants from the same <span class="font-bold ml-1">32</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400 text-center" placeholder="Answer">
                                    was selected
                                </li>
                                <li class="pl-2 flex items-center gap-2 flex-wrap">
                                    vets and park staff made use of <span class="font-bold ml-1">33</span>
                                    <input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400 text-center" placeholder="Answer">
                                    to help guide the elephants into an open plain
                                </li>
                                <li class="pl-2">elephants were immobilised with tranquilisers
                                    <ul class="list-none ml-4 mt-2 space-y-2">
                                        <li class="flex items-center gap-2 flex-wrap">– this process had to be completed quickly to reduce <span class="font-bold">34</span><input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400 text-center" placeholder="Answer"></li>
                                        <li class="flex items-center gap-2 flex-wrap">– elephants had to be turned on their <span class="font-bold">35</span><input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400 text-center" placeholder="Answer"> to avoid damage to their lungs</li>
                                        <li class="flex items-center gap-2 flex-wrap">– elephants' <span class="font-bold">36</span><input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400 text-center" placeholder="Answer"> had to be monitored constantly</li>
                                        <li>– tracking devices were fitted to the matriarchs</li>
                                        <li class="flex items-center gap-2 flex-wrap">– data including the size of their tusks and <span class="font-bold">37</span><input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400 text-center" placeholder="Answer"> was taken</li>
                                    </ul>
                                </li>
                                <li class="pl-2">elephants were taken by truck to their new reserve</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-bold text-base mb-3">Advantages of translocation at Nkhotakota Wildlife Park</h4>
                            <ul class="list-disc ml-5 space-y-3">
                                <li class="pl-2 flex items-center gap-2 flex-wrap">
                                    <span class="font-bold">38</span><input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400 text-center" placeholder="Answer"> opportunities
                                </li>
                                <li class="pl-2 flex items-center gap-2 flex-wrap">
                                    a reduction in the number of poachers and <span class="font-bold ml-1">39</span><input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400 text-center" placeholder="Answer">
                                </li>
                                <li class="pl-2">an example of conservation that other parks can follow</li>
                                <li class="pl-2 flex items-center gap-2 flex-wrap">
                                    an increase in <span class="font-bold">40</span><input type="text" class="border-b border-black outline-none px-2 w-36 bg-transparent focus:border-blue-500 placeholder-gray-400 text-center" placeholder="Answer"> as a contributor to GDP
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="max-w-4xl mx-auto mt-8 flex justify-between">
                    <button @click="step = 3" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Previous Part</button>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all">Submit Answers</button>
                </div>
            </div>

        </div>
    </main>
</div>

@include('assignments.ielts.listening.partials.audio-player', ['set' => 'Mock Up ' . $testId, 'section' => $material])

<script>
document.addEventListener('DOMContentLoaded', function() {    // Limit "Choose TWO" checkboxes to max 2 per group (FIFO auto-uncheck)
    const choiceTwoGroups = ['q14_15[]', 'q27_28[]', 'q29_30[]'];
    choiceTwoGroups.forEach(function(groupName) {
        const order = []; // tracks check order
        document.querySelectorAll(`input[type="checkbox"][name="${groupName}"]`).forEach(function(cb) {
            cb.addEventListener('change', function() {
                if (this.checked) {
                    order.push(this);
                    if (order.length > 2) {
                        const oldest = order.shift();
                        oldest.checked = false;
                    }
                } else {
                    const idx = order.indexOf(this);
                    if (idx > -1) order.splice(idx, 1);
                }
            });
        });
    });
});
</script>
<style>main{padding-bottom:250px!important;}</style>
</body>
</html>

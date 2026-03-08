@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8 p-6 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">{{ strtoupper(str_replace('_', ' ', $type)) }} Free Simulation</h1>
                <p class="mt-2 text-gray-500">Answer these quick questions to see your estimated score and receive customized recommendations.</p>
            </div>
            <div class="hidden sm:block">
                @if($type == 'toefl_itp')
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center text-3xl">🏛️</div>
                @elseif($type == 'ielts_academic')
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center text-3xl">🎓</div>
                @elseif($type == 'ielts_general')
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center text-3xl">💼</div>
                @elseif($type == 'pte_academic')
                    <div class="w-16 h-16 bg-orange-100 rounded-2xl flex items-center justify-center text-3xl">💻</div>
                @endif
            </div>
        </div>

        <!-- Simulation Questions Form -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
            <form action="{{ route('free-test.submit', $type) }}" method="POST" class="p-6 sm:p-10">
                @csrf
                
                <div class="space-y-10">
                    
                    <!-- Question 1 -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-blue-600 text-white font-bold text-sm">1</span>
                            <h3 class="text-lg font-medium text-gray-900">Grammar & Structure Check</h3>
                        </div>
                        <p class="text-gray-700 mb-4 bg-white p-4 rounded-lg border border-gray-200">The committee ______ expected to reach a decision by tomorrow afternoon.</p>
                        
                        <div class="space-y-3 pl-11">
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition">
                                <input type="radio" name="q1" value="A" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-700 font-medium">A) is</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition">
                                <input type="radio" name="q1" value="B" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-700 font-medium">B) are</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition">
                                <input type="radio" name="q1" value="C" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-700 font-medium">C) has</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition">
                                <input type="radio" name="q1" value="D" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-700 font-medium">D) have</span>
                            </label>
                        </div>
                    </div>

                    <!-- Question 2 -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-blue-600 text-white font-bold text-sm">2</span>
                            <h3 class="text-lg font-medium text-gray-900">Vocabulary in Context</h3>
                        </div>
                        <p class="text-gray-700 mb-4 bg-white p-4 rounded-lg border border-gray-200">The swift action of the emergency responders helped to ______ the damage caused by the storm.</p>
                        
                        <div class="space-y-3 pl-11">
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition">
                                <input type="radio" name="q2" value="A" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-700 font-medium">A) mitigate</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition">
                                <input type="radio" name="q2" value="B" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-700 font-medium">B) aggravate</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition">
                                <input type="radio" name="q2" value="C" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-700 font-medium">C) emulate</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition">
                                <input type="radio" name="q2" value="D" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-700 font-medium">D) initiate</span>
                            </label>
                        </div>
                    </div>

                    <!-- Question 3 -->
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-blue-600 text-white font-bold text-sm">3</span>
                            <h3 class="text-lg font-medium text-gray-900">Reading Comprehension</h3>
                        </div>
                        <div class="text-gray-700 mb-4 bg-white p-4 rounded-lg border border-gray-200 space-y-2">
                            <p class="text-sm italic text-gray-500 border-b border-gray-100 pb-2 mb-2">Read the following short excerpt:</p>
                            <p>"Despite initial skepticism, the transition to renewable energy sources has proven to be an economic boon for the coastal town. New industries have emerged, providing employment opportunities that previously relied exclusively on fossil fuel extraction."</p>
                            <br>
                            <p class="font-medium">What is the main idea of the passage?</p>
                        </div>
                        
                        <div class="space-y-3 pl-11">
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition">
                                <input type="radio" name="q3" value="A" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-700 font-medium">A) The town is still struggling economically due to the transition.</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition">
                                <input type="radio" name="q3" value="B" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-700 font-medium">B) Residents prefer fossil fuel jobs over renewable energy jobs.</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition">
                                <input type="radio" name="q3" value="C" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-700 font-medium">C) Renewable energy has brought financial and employment benefits.</span>
                            </label>
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-white cursor-pointer transition">
                                <input type="radio" name="q3" value="D" class="w-4 h-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                <span class="ml-3 text-gray-700 font-medium">D) The coastal town previously had no employment opportunities at all.</span>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Submit Button -->
                <div class="mt-10 pt-6 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        Submit Simulation
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

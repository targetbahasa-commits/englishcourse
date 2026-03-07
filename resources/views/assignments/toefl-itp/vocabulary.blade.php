<x-app-layout>
<div class="py-12 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <a href="{{ route('assignments.toefl-itp') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 mb-2 transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to TOEFL ITP
                </a>
                <h1 class="text-4xl font-extrabold bg-gradient-to-r from-orange-500 to-red-500 bg-clip-text text-transparent drop-shadow-sm">
                    TOEFL ITP Vocabulary
                </h1>
                <p class="mt-2 text-gray-600 text-lg">Master these 300 essential words to boost your TOEFL ITP score.</p>
            </div>
            
            <div class="bg-white px-6 py-4 rounded-2xl shadow-sm border border-orange-100 flex items-center gap-4">
                <div class="bg-orange-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Vocabulary</p>
                    <p class="text-2xl font-bold text-gray-800">300 Words</p>
                </div>
            </div>
        </div>

        <?php
            // We load the 300 words generated in parts
            $cat1 = include storage_path('app/toefl_vocab_1.php');
            $cat2 = include storage_path('app/toefl_vocab_2.php');
            $cat3 = include storage_path('app/toefl_vocab_3.php');
            
            // Combine all categories into one array
            $vocabularyCategories = array_merge($cat1, $cat2, $cat3);
        ?>

        <!-- Vocabulary Categories -->
        <div class="space-y-12">
            @foreach($vocabularyCategories as $categoryName => $words)
            <div>
                <div class="mb-6 flex items-center border-b border-gray-200 pb-4">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $categoryName }}</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($words as $index => $item)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-gray-100 overflow-hidden group">
                        <div class="h-2 w-full bg-gradient-to-r from-orange-400 to-orange-500"></div>
                        <div class="p-5 flex flex-col h-full">
                            <div class="flex items-start justify-between mb-4">
                                <h3 class="text-xl font-bold text-gray-800 group-hover:text-orange-600 transition-colors">{{ $item['word'] }}</h3>
                                <span class="bg-indigo-50 text-indigo-600 text-xs font-bold px-2 py-1 rounded-lg">#{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="mb-4 flex-grow">
                                <p class="text-gray-700 text-sm font-medium mb-1">{{ $item['meaning'] }}</p>
                                <p class="text-gray-500 text-sm italic">{{ $item['meaning_id'] }}</p>
                            </div>
                            <div class="mt-auto pt-3 border-t border-gray-100 bg-orange-50/30 rounded-lg p-3">
                                <p class="text-gray-600 text-sm leading-relaxed"><span class="font-semibold text-gray-800 mix-blend-multiply">Example:</span> "{{ $item['example'] }}"</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Call to Action -->
        <div class="mt-16 mb-8 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-8 md:p-12 text-center shadow-xl">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to test your vocabulary?</h2>
            <p class="text-indigo-100 mb-8 max-w-2xl mx-auto">Practice using these 300 essential words in context. Try our TOEFL ITP listening and structure practices to see them in action!</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('assignments.toefl-itp.structure') }}" class="px-8 py-4 bg-white text-indigo-600 font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                    Go to Structure Practice
                </a>
                <a href="{{ route('assignments.toefl-itp.reading') }}" class="px-8 py-4 bg-indigo-500 text-white font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-1 hover:bg-indigo-400 transition-all duration-300">
                    Go to Reading Practice
                </a>
            </div>
        </div>

    </div>
</div>
</x-app-layout>

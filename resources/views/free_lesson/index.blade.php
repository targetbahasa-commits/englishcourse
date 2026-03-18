@component('layouts.dashboard')
    @slot('header')@endslot

    <div class="px-4 py-8 w-full max-w-7xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Free Lessons</h1>
                    <p class="text-gray-600 mt-1">Explore our free content and start learning today! 🚀</p>
                </div>
            </div>
        </div>

        <!-- Free Lessons Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($freeLessons as $lesson)
                @php
                    $colorClasses = [
                        'blue'   => ['gradient' => 'from-blue-400 to-blue-600',   'btn' => 'bg-blue-500 hover:bg-blue-600'],
                        'green'  => ['gradient' => 'from-green-400 to-green-600',  'btn' => 'bg-green-500 hover:bg-green-600'],
                        'purple' => ['gradient' => 'from-purple-400 to-purple-600','btn' => 'bg-purple-500 hover:bg-purple-600'],
                        'orange' => ['gradient' => 'from-orange-400 to-orange-600','btn' => 'bg-orange-500 hover:bg-orange-600'],
                        'red'    => ['gradient' => 'from-red-400 to-red-600',      'btn' => 'bg-red-500 hover:bg-red-600'],
                        'teal'   => ['gradient' => 'from-teal-400 to-teal-600',    'btn' => 'bg-teal-500 hover:bg-teal-600'],
                        'indigo' => ['gradient' => 'from-indigo-400 to-indigo-600','btn' => 'bg-indigo-500 hover:bg-indigo-600'],
                        'pink'   => ['gradient' => 'from-pink-400 to-pink-600',    'btn' => 'bg-pink-500 hover:bg-pink-600'],
                        'yellow' => ['gradient' => 'from-yellow-400 to-yellow-600','btn' => 'bg-yellow-500 hover:bg-yellow-600 text-white'],
                        'cyan'   => ['gradient' => 'from-cyan-400 to-cyan-600',    'btn' => 'bg-cyan-500 hover:bg-cyan-600'],
                    ];
                    $colors = $colorClasses[$lesson['color']] ?? $colorClasses['blue'];
                @endphp

                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col h-full">
                    <div class="h-32 bg-gradient-to-br {{ $colors['gradient'] }} relative p-6 flex flex-col justify-end">
                        <h3 class="text-2xl font-bold text-white shadow-sm">{{ $lesson['title'] }}</h3>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <p class="text-gray-600 mb-6 leading-relaxed">{{ $lesson['description'] }}</p>
                        <a href="{{ $lesson['route'] }}" class="block w-full text-center {{ $colors['btn'] }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                            Start Lesson
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @if(count($freeLessons) === 0)
            <div class="text-center py-20">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">No free lessons available yet</h3>
                <p class="mt-1 text-gray-500">Check back soon for new content!</p>
            </div>
        @endif
    </div>
@endcomponent

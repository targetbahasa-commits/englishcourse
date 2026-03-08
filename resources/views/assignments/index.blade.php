<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Assignments</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Header -->
            <div class="mb-8" x-data="{ showAddModal: false, showDeleteModal: false }">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Assignment Programs</h1>
                            <p class="text-gray-600 mt-1">Choose your program and start your learning journey! 📚</p>
                        </div>
                    </div>
                    
                    @if(Auth::user()->isAdmin())
                    <!-- Admin Action Buttons -->
                    <div class="flex gap-3">
                        <button @click="showAddModal = true" class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Program
                        </button>
                        <button @click="showDeleteModal = true" class="flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Delete Program
                        </button>
                    </div>
                    @endif
                </div>

            <!-- Programs Grid -->
            <div class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $isStudent = !Auth::user()->isAdmin() && !Auth::user()->isTeacher();
                    @endphp

                    <!-- Dynamic Programs -->
                    @foreach($programs as $program)
                        @php
                            $colorClasses = [
                                'blue' => ['bg' => 'bg-blue-500', 'hover' => 'hover:bg-blue-600', 'text' => 'text-blue-600', 'light' => 'bg-blue-50', 'gradient' => 'from-blue-400 to-blue-600'],
                                'green' => ['bg' => 'bg-green-500', 'hover' => 'hover:bg-green-600', 'text' => 'text-green-600', 'light' => 'bg-green-50', 'gradient' => 'from-green-400 to-green-600'],
                                'purple' => ['bg' => 'bg-purple-500', 'hover' => 'hover:bg-purple-600', 'text' => 'text-purple-600', 'light' => 'bg-purple-50', 'gradient' => 'from-purple-400 to-purple-600'],
                                'orange' => ['bg' => 'bg-orange-500', 'hover' => 'hover:bg-orange-600', 'text' => 'text-orange-600', 'light' => 'bg-orange-50', 'gradient' => 'from-orange-400 to-orange-600'],
                                'red' => ['bg' => 'bg-red-500', 'hover' => 'hover:bg-red-600', 'text' => 'text-red-600', 'light' => 'bg-red-50', 'gradient' => 'from-red-400 to-red-600'],
                                'yellow' => ['bg' => 'bg-yellow-500', 'hover' => 'hover:bg-yellow-600', 'text' => 'text-yellow-600', 'light' => 'bg-yellow-50', 'gradient' => 'from-yellow-400 to-yellow-600']
                            ];
                            $colors = $colorClasses[$program->color] ?? $colorClasses['blue'];
                            
                            // Determine route based on program name
                            $routeName = '#';
                            if ($program->name === 'Grammar for Writing') {
                                $routeName = route('assignments.grammar-writing');
                            } elseif ($program->name === 'TOEFL ITP') {
                                $routeName = route('assignments.toefl-itp');
                            } elseif ($program->name === 'IELTS Academic') {
                                $routeName = route('assignments.ielts-academic');
                            }
                        @endphp
                        
                        <a href="{{ $routeName }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:scale-105 hover:-translate-y-1">
                            <!-- Gradient Header -->
                            <div class="h-32 bg-gradient-to-br {{ $colors['gradient'] }} relative overflow-hidden">
                                <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                                <div class="absolute bottom-4 left-6">
                                    <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center transform group-hover:rotate-6 transition-transform duration-300">
                                        <svg class="w-8 h-8 {{ $colors['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $program->icon ?? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>' !!}
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-6 pt-8">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $program->name }}</h3>
                                <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ $program->description }}</p>
                                
                                <!-- CTA Button -->
                                <div class="block w-full text-center {{ $colors['bg'] }} {{ $colors['hover'] }} text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105">
                                    Start Learning
                                    <svg class="w-4 h-4 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </div>
                            </div>

                            <!-- Decorative Element -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br {{ $colors['gradient'] }} opacity-5 rounded-full -mr-16 -mt-16 group-hover:opacity-10 transition-opacity duration-300"></div>
                        </a>
                    @endforeach
                    
                    @if(Auth::user()->isAdmin())

                    <!-- Add Modal -->
                    <div x-show="showAddModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                    <form action="{{ route('programs.store') }}" method="POST">
                                        {{-- @csrf --}}
                                        {{-- 222: <form action="{{ route('programs.store') }}" method="POST"> --}}
                                        {{-- 280: <form action="{{ route('programs.destroy', $program->id) }}" method="POST" onsubmit="return confirm('Are you sure?');"> --}}
                                        {{-- Disabling temporarily as routes do not exist --}}
                                    @csrf
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Add New Program</h3>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
                                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" type="text" placeholder="Program Name" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description" placeholder="Program Description"></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="color">Color</label>
                                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="color" name="color">
                                                <option value="blue">Blue</option>
                                                <option value="green">Green</option>
                                                <option value="purple">Purple</option>
                                                <option value="orange">Orange</option>
                                                <option value="red">Red</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-gray-700 text-sm font-bold mb-2" for="icon">Icon (Optional, SVG Path)</label>
                                             <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="icon" name="icon" placeholder="<path d='...'></path>"></textarea>
                                        </div>
                                    </div>
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Create
                                        </button>
                                        <button @click="showAddModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div x-show="showDeleteModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Delete Program</h3>
                                    <p class="text-sm text-gray-500 mb-4">Select a program to delete. This action cannot be undone.</p>
                                    <ul class="divide-y divide-gray-200">
                                        @foreach($programs as $program)
                                        <li class="py-4 flex justify-between items-center">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $program->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $program->description }}</p>
                                            </div>
                                            <form action="{{ route('programs.destroy', $program->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button @click="showDeleteModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </main>
    </div>
</body>
</html>

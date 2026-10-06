@extends('layouts.admin')

@section('title', 'IELTS Speaking')

@section('content')
<!-- Force Alpine.js Load -->
<script src="//unpkg.com/alpinejs" defer></script>
<script>
    // Pass PHP data to JS safely
    window.speakingLessons = {{ \Illuminate\Support\Js::from($lessons) }};
    
    document.addEventListener('alpine:init', () => {
        console.log('Alpine initialized');
        Alpine.data('speakingTopics', () => ({
            showModal: false, 
            editingTopic: null,
            lessons: window.speakingLessons,
            formData: {
                id: null,
                title: '',
                slug: '',
                icon: '',
                color: '',
                order: 0,
                is_free_tier: 0,
                test_type: '',
                system_prompt_override: ''
            },
            init() {
                console.log('Component mounted', this.lessons);
            },
            edit(topicId) {
                console.log('Edit clicked for ID:', topicId);
                const topic = this.lessons.find(t => t.id == topicId);
                if (!topic) {
                    console.error('Topic not found');
                    return;
                }
                
                this.editingTopic = topic;
                this.formData = {
                    id: topic.id,
                    title: topic.title,
                    slug: topic.slug,
                    icon: topic.icon,
                    color: topic.color ?? 'blue',
                    order: topic.order ?? 0,
                    is_free_tier: topic.is_free_tier ?? 0,
                    test_type: topic.test_type ?? '',
                    system_prompt_override: topic.system_prompt_override ?? ''
                };
                this.showModal = true;
            },
            create() {
                this.editingTopic = null;
                this.formData = {
                    id: null,
                    title: '',
                    slug: '',
                    icon: '',
                    color: 'blue',
                    order: 0,
                    is_free_tier: 0,
                    test_type: '',
                    system_prompt_override: ''
                };
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
                this.editingTopic = null;
            }
        }));
    });
</script>

<div class="w-full px-8 py-8 pb-24" x-data="speakingTopics()">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl shadow-lg">
                     <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-yellow-500 bg-clip-text text-transparent">IELTS Academic Speaking</h1>
                    <p class="text-gray-600 mt-1">Practice your speaking fluency for IELTS! 🗣️</p>
                </div>
            </div>
            
            <a href="{{ route('assignments.ielts-academic') }}" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to IELTS
            </a>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-white text-orange-700 font-semibold border border-orange-100 text-xs">
                Active Batch: {{ $selectedClassPeriod->name ?? ($batchProgram->period ?? 'Not selected') }}
            </span>

            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <form action="{{ route('assignments.batch-period') }}" method="POST" class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                    @csrf
                    <input type="hidden" name="program_id" value="{{ $batchProgram?->id }}">
                    <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                    <select name="period" class="border-none bg-white rounded-lg text-sm focus:ring-2 focus:ring-orange-500 min-w-[220px]" {{ !$batchProgram ? 'disabled' : '' }}>
                        @if(!$batchProgram)
                            <option value="" selected>No program found</option>
                        @elseif($batchProgram->classPeriods->isEmpty())
                            <option value="{{ $batchProgram->period }}" selected>{{ $batchProgram->period ?: 'No batch available' }}</option>
                        @else
                            @foreach($batchProgram->classPeriods->sortByDesc('start_date') as $classPeriod)
                                <option value="{{ $classPeriod->name }}" {{ $batchProgram->period === $classPeriod->name ? 'selected' : '' }}>
                                    {{ $classPeriod->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <button type="submit" class="p-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition disabled:opacity-50 disabled:cursor-not-allowed" title="Apply batch" {{ !$batchProgram ? 'disabled' : '' }}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </form>
            @else
                <div class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                    <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                    <span class="text-sm text-gray-800 px-2 py-1 bg-white rounded-lg">
                        {{ $selectedClassPeriod->name ?? ($batchProgram->period ?? 'Not selected') }}
                    </span>
                </div>
            @endif

            @php
                $calendarClassPeriodId = $selectedClassPeriod->id ?? Auth::user()->class_period_id ?? $batchProgram?->classPeriods?->first()?->id ?? '';
                $calendarBatchName = addslashes($batchProgram->name ?? 'Assignments');
            @endphp
            @if($calendarClassPeriodId)
                <button type="button" onclick="event.preventDefault(); (function(){ const cp='{{ $calendarClassPeriodId }}'; if(!cp){ alert('Batch kelas tidak tersedia.'); return; } window.dispatchEvent(new CustomEvent('open-batch-calendar',{detail:{classPeriodId:cp,batchName:{!! json_encode($calendarBatchName) !!}}})); })()" class="px-4 py-2 bg-white border border-gray-200 rounded-xl hover:bg-white text-sm text-gray-600">
                    Lihat Kalender
                </button>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Lessons</h2>
            <button @click="create()" class="flex items-center gap-2 px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg shadow-md transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Lesson
            </button>
        </div>

        <div id="ielts-speaking-lessons" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-24">
            @if(isset($lessons) && $lessons->isNotEmpty())
                @foreach($lessons as $topic)
                <div class="group relative bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                    <div class="p-6 flex flex-col h-full">
                        <div class="flex justify-between items-start mb-4">
                            <!-- Pill -->
                            @php
                                $lessonNum = ucfirst(str_replace('-', ' ', $topic['slug']));
                                $pillColor = $topic['color'] ?? 'orange'; 
                                $isLocked = $topic['is_locked'] ?? false;
                                $canAccess = !$isLocked || Auth::user()->isAdmin() || Auth::user()->isTeacher();
                            @endphp
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 bg-{{ $pillColor }}-100 text-{{ $pillColor }}-600 rounded-full text-xs font-semibold">{{ $lessonNum }}</span>
                                <span class="px-3 py-1 {{ $isLocked ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }} rounded-full text-xs font-bold uppercase tracking-wide">
                                    {{ $isLocked ? 'LOCKED' : 'OPEN' }}
                                </span>
                            </div>
                            
                            <!-- Icons -->
                            @if(isset($topic['id']))
                            <div class="absolute top-2 right-2 z-50 flex gap-2 items-center bg-white/80 backdrop-blur-sm rounded-lg p-1 shadow-sm border border-gray-100">
                                <form action="{{ route('admin.ielts.speaking.topics.toggle-lock', $topic['id']) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" @click.stop class="text-gray-400 hover:text-gray-600 transition-colors cursor-pointer p-1 rounded-md hover:bg-white" title="Toggle Lock">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($isLocked)
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                            @endif
                                        </svg>
                                    </button>
                                </form>
                                <button type="button" 
                                    @click.stop="edit({{ $topic['id'] }})"
                                    class="text-gray-400 hover:text-blue-600 transition-colors cursor-pointer p-1 rounded-md hover:bg-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form action="{{ route('admin.ielts.speaking.topics.delete', $topic['id']) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this topic?');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" @click.stop class="text-gray-400 hover:text-red-600 transition-colors cursor-pointer p-1 rounded-md hover:bg-red-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-{{ $pillColor }}-600 transition-colors">
                            {{ $topic['title'] }}
                        </h3>
                        
                        <p class="text-gray-500 text-sm mb-8 line-clamp-2">
                            Topic: {{ $topic['title'] }} (Speaking Practice Part 1)
                        </p>
                        
                        @if($canAccess)
                            <a href="{{ route('assignments.ielts-academic.speaking.practice', ['topic' => $topic['slug']]) }}" class="flex items-center text-{{ $pillColor }}-600 text-base font-semibold mt-auto hover:underline w-fit">
                                <span>Start Lesson</span>
                                <svg class="w-5 h-5 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @else
                            <button disabled class="flex items-center text-gray-400 text-base font-semibold mt-auto cursor-not-allowed w-fit">
                                <span>Locked</span>
                                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            @endif
        </div>


    </div>
    <!-- Modal -->
    <template x-teleport="body">
        <div x-show="showModal" 
             class="fixed inset-0 z-[9999] overflow-y-auto" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="closeModal()"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                     @click.stop
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4" x-text="editingTopic ? 'Edit Lesson' : 'Add New Lesson'"></h3>

                    <form :action="editingTopic ? '{{ route('admin.ielts.speaking.topics.update', 'PLACEHOLDER_ID') }}'.replace('PLACEHOLDER_ID', formData.id) : '{{ route('admin.ielts.speaking.topics.store') }}'" method="POST">
                        @csrf
                        <template x-if="editingTopic">
                            <input type="hidden" name="_method" value="PUT">
                        </template>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Title</label>
                                <input type="text" name="title" x-model="formData.title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Slug (URL Identifier)</label>
                                <input type="text" name="slug" x-model="formData.slug" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">SVG Icon Path (d attribute)</label>
                                <input type="text" name="icon" x-model="formData.icon" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm" placeholder="M12 6.253v13m0..." required>
                                <p class="text-xs text-gray-400 mt-1">Copy the 'd' attribute from a Heroicon SVG.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Color</label>
                                <select name="color" x-model="formData.color" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                                    <option value="red">Red</option>
                                    <option value="blue">Blue</option>
                                    <option value="green">Green</option>
                                    <option value="purple">Purple</option>
                                    <option value="yellow">Yellow</option>
                                    <option value="indigo">Indigo</option>
                                    <option value="pink">Pink</option>
                                    <option value="orange">Orange</option>
                                    <option value="teal">Teal</option>
                                    <option value="emerald">Emerald</option>
                                    <option value="slate">Slate</option>
                                    <option value="cyan">Cyan</option>
                                    <option value="rose">Rose</option>
                                    <option value="amber">Amber</option>
                                    <option value="lime">Lime</option>
                                    <option value="fuchsia">Fuchsia</option>
                                    <option value="violet">Violet</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Order</label>
                                <input type="number" name="order" x-model="formData.order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm">
                            </div>

                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-200 rounded-lg transition-colors" @click="closeModal()">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-lg shadow-sm transition-colors">
                                <span x-text="editingTopic ? 'Update Lesson' : 'Create Lesson'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
    @include('components.meetings-calendar-modal')
    <x-meeting-progress-bar program-slug="ielts-academic-speaking" :total-meetings="count($lessons ?? []) ?: 10" />
</div>
@endsection

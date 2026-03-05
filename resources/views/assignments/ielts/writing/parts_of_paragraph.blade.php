@extends('layouts.admin')

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-8 h-screen flex flex-col">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('assignments.ielts-academic.writing.index', ['task' => $task ?? 2]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                 <span class="text-sm font-semibold text-orange-600 tracking-wider uppercase">IELTS Writing Task 2</span>
                <h1 class="text-2xl font-bold text-gray-800">{{ $meeting->title ?? 'Parts of a Paragraph' }}</h1>
            </div>
        </div>
    </div>

    <!-- Content Wrapper -->
    <div class="flex-1 overflow-y-auto pb-8" x-data="partsApp({{ $meeting->id }})">
        <div class="max-w-4xl mx-auto w-full space-y-8">
            
            <!-- Card 1: Explanation -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 border-b pb-4">BAGIAN-BAGIAN KALIMAT DALAM PARAGRAF</h2>
                
                <div class="space-y-10">
                    <!-- 1. Topic Sentence -->
                    <div class="bg-blue-50 rounded-xl p-6 border-l-4 border-blue-500">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="bg-blue-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">1</span>
                            <h3 class="text-xl font-bold text-blue-900">Topic Sentence</h3>
                        </div>
                        <div class="space-y-3 text-gray-700 ml-11">
                            <p><strong class="text-blue-700">Fungsi:</strong> Menyampaikan gagasan utama dari paragraf.</p>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>Biasanya kalimat pertama di paragraf body.</li>
                                <li>Harus jelas dan langsung ke poin utama.</li>
                            </ul>
                            <div class="bg-white p-4 rounded-lg border border-blue-100 mt-2">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide block mb-1">Contoh:</span>
                                <p class="font-medium text-gray-800">"One major reason why people prefer online education is its flexibility."</p>
                                <p class="text-gray-500 italic text-sm mt-1">(Salah satu alasan utama orang lebih memilih pendidikan online adalah fleksibilitasnya.)</p>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Explanation / Reason Sentence -->
                    <div class="bg-indigo-50 rounded-xl p-6 border-l-4 border-indigo-500">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="bg-indigo-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">2</span>
                            <h3 class="text-xl font-bold text-indigo-900">Explanation / Reason Sentence</h3>
                        </div>
                        <div class="space-y-3 text-gray-700 ml-11">
                            <p><strong class="text-indigo-700">Fungsi:</strong> Menjelaskan mengapa ide utama itu benar atau penting.</p>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>Menambahkan detail atau logika yang mendukung topic sentence.</li>
                            </ul>
                            <div class="bg-white p-4 rounded-lg border border-indigo-100 mt-2">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide block mb-1">Contoh:</span>
                                <p class="font-medium text-gray-800">"Students can attend classes at any time and from any place, which allows them to balance study with work or family responsibilities."</p>
                                <p class="text-gray-500 italic text-sm mt-1">(Siswa dapat menghadiri kelas kapan pun dan dari mana pun, sehingga mereka bisa menyeimbangkan belajar dengan pekerjaan atau tanggung jawab keluarga.)</p>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Example Sentence -->
                    <div class="bg-purple-50 rounded-xl p-6 border-l-4 border-purple-500">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="bg-purple-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">3</span>
                            <h3 class="text-xl font-bold text-purple-900">Example Sentence</h3>
                        </div>
                        <div class="space-y-3 text-gray-700 ml-11">
                            <p><strong class="text-purple-700">Fungsi:</strong> Memberikan contoh konkret untuk memperkuat argumen.</p>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>Contoh bisa berupa fakta, situasi umum, atau studi kasus sederhana.</li>
                            </ul>
                            <div class="bg-white p-4 rounded-lg border border-purple-100 mt-2">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide block mb-1">Contoh:</span>
                                <p class="font-medium text-gray-800">"For instance, many working adults take online courses to improve their qualifications without quitting their jobs."</p>
                                <p class="text-gray-500 italic text-sm mt-1">(Misalnya, banyak orang dewasa yang bekerja mengambil kursus online untuk meningkatkan kualifikasi tanpa harus berhenti dari pekerjaan mereka.)</p>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Result / Consequence Sentence -->
                    <div class="bg-pink-50 rounded-xl p-6 border-l-4 border-pink-500">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="bg-pink-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">4</span>
                            <h3 class="text-xl font-bold text-pink-900">Result / Consequence Sentence <span class="text-sm font-normal opacity-75">(Optional)</span></h3>
                        </div>
                        <div class="space-y-3 text-gray-700 ml-11">
                            <p><strong class="text-pink-700">Fungsi:</strong> Menjelaskan dampak atau hasil dari ide sebelumnya.</p>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>Biasanya muncul setelah explanation atau example.</li>
                            </ul>
                            <div class="bg-white p-4 rounded-lg border border-pink-100 mt-2">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide block mb-1">Contoh:</span>
                                <p class="font-medium text-gray-800">"As a result, online learning has become an increasingly popular alternative to traditional education."</p>
                                <p class="text-gray-500 italic text-sm mt-1">(Akibatnya, pembelajaran online menjadi alternatif yang semakin populer dibandingkan pendidikan tradisional.)</p>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Concluding Sentence -->
                    <div class="bg-orange-50 rounded-xl p-6 border-l-4 border-orange-500">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="bg-orange-500 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold">5</span>
                            <h3 class="text-xl font-bold text-orange-900">Concluding Sentence <span class="text-sm font-normal opacity-75">(Optional)</span></h3>
                        </div>
                        <div class="space-y-3 text-gray-700 ml-11">
                            <p><strong class="text-orange-700">Fungsi:</strong> Menutup paragraf dengan merangkum atau menegaskan kembali poin utama.</p>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                <li>Bisa juga menjadi transisi ke paragraf berikutnya.</li>
                            </ul>
                            <div class="bg-white p-4 rounded-lg border border-orange-100 mt-2">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide block mb-1">Contoh:</span>
                                <p class="font-medium text-gray-800">"Therefore, flexibility is one of the key advantages that make online education appealing to many learners."</p>
                                <p class="text-gray-500 italic text-sm mt-1">(Oleh karena itu, fleksibilitas adalah salah satu keunggulan utama yang membuat pendidikan online menarik bagi banyak pelajar.)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dynamic Questions Loop -->
            @foreach($meeting->questions as $question)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-8 relative group" x-data>
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $question->title }}</h2>
                        <p class="text-gray-600">{!! $question->instruction !!}</p>
                    </div>
                    
                    @if(Auth::user()->role === 'admin')
                    <div class="flex gap-2">
                        <button @click="$dispatch('open-edit-modal', {id: {{ $question->id }}, title: '{{ addslashes($question->title) }}', instruction: '{{ addslashes($question->instruction) }}'})" 
                                class="p-2 bg-yellow-100 text-yellow-600 rounded hover:bg-yellow-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <form action="{{ route('assignments.ielts.writing.question.destroy', $question->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-100 text-red-600 rounded hover:bg-red-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
                
                <div class="space-y-6">
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">1. Topic Sentence</label>
                        <textarea name="q{{ $question->id }}_topic" x-model="answers['q{{ $question->id }}_topic']" class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-200 focus:border-blue-400 focus:outline-none transition-all resize-y font-serif" rows="2" placeholder="Mulailah dengan ide utama yang jelas..."></textarea>
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">2. Explanation / Reason</label>
                        <textarea name="q{{ $question->id }}_explanation" x-model="answers['q{{ $question->id }}_explanation']" class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-400 focus:outline-none transition-all resize-y font-serif" rows="3" placeholder="Jelaskan mengapa ide utama Anda benar..."></textarea>
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">3. Example</label>
                        <textarea name="q{{ $question->id }}_example" x-model="answers['q{{ $question->id }}_example']" class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-200 focus:border-purple-400 focus:outline-none transition-all resize-y font-serif" rows="3" placeholder="Berikan contoh konkret..."></textarea>
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">4. Result / Consequence (Optional)</label>
                        <textarea name="q{{ $question->id }}_result" x-model="answers['q{{ $question->id }}_result']" class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-pink-200 focus:border-pink-400 focus:outline-none transition-all resize-y font-serif" rows="2" placeholder="Apa hasilnya?"></textarea>
                    </div>
                    <div>
                        <label class="block font-bold text-gray-700 mb-2">5. Concluding Sentence (Optional)</label>
                        <textarea name="q{{ $question->id }}_conclusion" x-model="answers['q{{ $question->id }}_conclusion']" class="w-full p-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:outline-none transition-all resize-y font-serif" rows="2" placeholder="Rangkum paragraf tersebut..."></textarea>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Admin Add Button -->
            @if(Auth::user()->role === 'admin')
            <div class="flex justify-center py-4">
                <button @click="$dispatch('open-add-modal')" class="px-6 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-700 font-bold flex items-center gap-2 shadow-lg transition-transform transform hover:-translate-y-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Practice Question
                </button>
            </div>
            @endif
        </div>
    </div>

    <!-- Modals -->
    @if(Auth::user()->role === 'admin')
    <div x-data="{ 
        showAddModal: false, 
        showEditModal: false,
        editId: null,
        editTitle: '',
        editInstruction: '',
        editAction: '',
        
        init() {
            window.addEventListener('open-add-modal', () => { this.showAddModal = true });
            window.addEventListener('open-edit-modal', (e) => { 
                this.showEditModal = true;
                this.editId = e.detail.id;
                this.editTitle = e.detail.title;
                this.editInstruction = e.detail.instruction;
                this.editAction = '/assignments/ielts-academic/writing/questions/' + this.editId;
            });
        }
    }">
        <!-- Add Modal -->
        <div x-show="showAddModal" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-lg shadow-2xl" @click.away="showAddModal = false">
                <h3 class="text-xl font-bold mb-4">Add New Practice Question</h3>
                <form action="{{ route('assignments.ielts.writing.question.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="ielts_writing_meeting_id" value="{{ $meeting->id }}">
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Title</label>
                        <input type="text" name="title" class="w-full border p-2 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Instruction</label>
                        <textarea name="instruction" class="w-full border p-2 rounded" rows="3"></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showAddModal = false" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="showEditModal" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl p-6 w-full max-w-lg shadow-2xl" @click.away="showEditModal = false">
                <h3 class="text-xl font-bold mb-4">Edit Practice Question</h3>
                <form :action="editAction" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Title</label>
                        <input type="text" name="title" x-model="editTitle" class="w-full border p-2 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label class="block font-bold mb-1">Instruction</label>
                        <textarea name="instruction" x-model="editInstruction" class="w-full border p-2 rounded" rows="3"></textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
@include('assignments.ielts.writing.practice_toolbar')
@endsection
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('partsApp', (meetingId) => ({
            answers: {},
            init() {
                if (window.AutoSave) {
                    window.AutoSave.init(meetingId, '{{ Auth::id() }}');
                }
                
                setTimeout(() => {
                    const textareas = document.querySelectorAll('textarea[name^="q"]');
                    textareas.forEach(el => {
                        if (el.value) {
                             this.answers[el.name] = el.value;
                        }
                    });
                }, 500);

                this.$watch('answers', (val) => {
                    // removing local storage sync to avoid conflict? Or keep it?
                    // AutoSave handles storage.
                });
            }
        }));
    });
</script>

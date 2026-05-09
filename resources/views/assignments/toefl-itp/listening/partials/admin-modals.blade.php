
{{-- Edit/Upload Audio Modals --}}
@if(Auth::user()->isAdmin())
    @php
        $resolvedUpdateTranscriptRoute = $updateTranscriptRoute ?? route('assignments.toefl-itp.listening.meeting.update-transcript', ['number' => $number ?? 0, 'set' => $set ?? 0]);
        $resolvedUploadSrtRoute = $uploadSrtRoute ?? route('assignments.toefl-itp.listening.meeting.upload-srt', ['number' => $number ?? 0, 'set' => $set ?? 0]);
        $resolvedUploadAudioRoute = $uploadAudioRoute ?? route('assignments.toefl-itp.listening.meeting.upload-audio', ['number' => $number ?? 0, 'set' => $set ?? 0]);
        $transcriptSourceQuestions = collect($questions ?? $listeningQuestions ?? []);
        $firstTranscriptItem = $transcriptSourceQuestions->first();
        $firstTranscriptEn = data_get($firstTranscriptItem, 'transcript_en', '');
        $firstTranscriptId = data_get($firstTranscriptItem, 'transcript_id', '');
        $firstAudioFile = data_get($firstTranscriptItem, 'audio_file');
    @endphp
    <div id="editTranscriptModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Edit Transcript (Set {{ $set ?? '' }})</h3>
                <form action="{{ $resolvedUpdateTranscriptRoute }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">English Script</label>
                        <textarea name="transcript_en" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $firstTranscriptEn }}</textarea>
                        <p class="text-gray-500 text-xs mt-1">Use newline for paragraphs.</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Indonesian Translation</label>
                        <textarea name="transcript_id" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $firstTranscriptId }}</textarea>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="document.getElementById('editTranscriptModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Upload SRT Modal --}}
    <div id="uploadSrtModal" class="hidden fixed inset-0  items-center justify-center"
            onclick="if(event.target === this) this.classList.add('hidden')">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4 relative transform transition-all">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Upload Transcript (.srt)</h3>
                <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ $resolvedUploadSrtRoute }}" 
                    method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Target Language</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="language" value="en" checked class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-gray-700">English Script 🇺🇸</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="language" value="id" class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-gray-700">Indonesian 🇮🇩</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        SRT File (.srt - Max 2MB)
                    </label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-indigo-500 transition-colors text-center cursor-pointer" onclick="document.getElementById('srtFileInput').click()">
                        <input type="file" id="srtFileInput" name="srt_file" accept=".srt"
                                class="hidden" onchange="document.getElementById('srtFileName').textContent = this.files[0].name">
                        <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span class="text-sm text-gray-500" id="srtFileName">Click to select file</span>
                    </div>
                </div>

                <div class="relative py-2">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-2 bg-white text-sm text-gray-500 font-semibold">OR PASTE TEXT</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Paste SRT Content Directly
                    </label>
                    <textarea name="srt_content" rows="4" 
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none placeholder-gray-400 text-sm font-mono"
                                placeholder="1
00:00:10,000 --> 00:00:15,000
Start translating here..."></textarea>
                </div>

                <div class="bg-yellow-50 p-3 rounded-lg border border-yellow-200">
                    <p class="text-xs text-yellow-800">
                        <strong>Note:</strong> Auto-parsing will remove timestamps (<code>00:00:10 --> ...</code>) and keep only the text dialog.
                    </p>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('uploadSrtModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 px-4 py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors">
                        Upload & Parse
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Upload Audio Modal --}}
    <div id="uploadAudioModal" class="hidden fixed inset-0  items-center justify-center"
            onclick="if(event.target === this) this.classList.add('hidden')">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Upload Audio File</h3>
                <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="uploadAudioForm" action="{{ $resolvedUploadAudioRoute }}" 
                    method="POST" enctype="multipart/form-data" class="space-y-4" onsubmit="handleAudioUploadSubmit()">
                @csrf
                <input type="hidden" name="question_id" id="uploadAudioQuestionId" value="">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Audio File (MP3, WAV, OGG - Max 10MB)
                    </label>
                    <input type="file" name="audio_file" accept=".mp3,.wav,.ogg,audio/*" required
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>

                @if($firstAudioFile)
                    <div class="p-3 bg-blue-50 rounded-lg border border-blue-200 break-words">
                        <p class="text-sm text-blue-800">
                            <span class="font-semibold">Current file:</span> 
                            {{ basename($firstAudioFile) }}
                        </p>
                    </div>
                @endif

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('uploadAudioModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" id="uploadAudioSubmitBtn"
                            class="flex-1 flex items-center justify-center px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors disabled:opacity-70 disabled:cursor-not-allowed">
                        <span id="uploadAudioBtnText">Upload</span>
                        <svg id="uploadAudioSpinner" class="hidden animate-spin ml-2 w-5 h-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
    function handleAudioUploadSubmit() {
        const btn = document.getElementById('uploadAudioSubmitBtn');
        const text = document.getElementById('uploadAudioBtnText');
        const spinner = document.getElementById('uploadAudioSpinner');
        
        // Prevent double click
        btn.disabled = true;
        text.innerText = 'Uploading...';
        spinner.classList.remove('hidden');
        
        return true; 
    }

    window.openMockupQuestionAudioModal = function(questionId) {
        const uploadModal = document.getElementById('uploadAudioModal');
        const uploadModalQuestionInput = document.getElementById('uploadAudioQuestionId');
        const chooseModalQuestionInput = document.getElementById('chooseAudioQuestionId');

        if (uploadModalQuestionInput) {
            uploadModalQuestionInput.value = questionId || '';
        }
        if (chooseModalQuestionInput) {
            chooseModalQuestionInput.value = questionId || '';
        }
        if (uploadModal) {
            uploadModal.classList.remove('hidden');
            uploadModal.classList.add('flex');
        }
    }
    </script>

    {{-- Choose Audio From Folder Modal (File Manager) --}}
    <div id="chooseAudioModal" class="hidden fixed inset-0 z-50 items-center justify-center"
         onclick="if(event.target === this) this.classList.add('hidden')">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-2xl w-full mx-4 my-8 overflow-y-auto max-h-screen">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Choose Audio File</h3>
                    <p class="text-sm text-gray-500 mt-1">Navigate and select from available audio files</p>
                </div>
                <button type="button" onclick="document.getElementById('chooseAudioModal').classList.add('hidden')"
                        class="text-gray-400 hover:text-gray-600 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ $resolvedUploadAudioRoute }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="question_id" id="chooseAudioQuestionId" value="">

                {{-- Breadcrumb Navigation --}}
                <div class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center gap-2 text-sm font-medium flex-wrap">
                        <button type="button" class="text-blue-600 hover:text-blue-800 flex-shrink-0" onclick="audioFileManager.goToRoot(event)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2.83-2.83a1 1 0 011.41 0L12 12m0 0l5.76-5.76a1 1 0 011.41 0L21 12"></path></svg>
                        </button>
                        <span id="audioBreadcrumb" class="text-gray-700">Root</span>
                    </div>
                </div>

                {{-- File Manager List --}}
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Available Files & Folders</label>
                    <div id="audioFileList" class="w-full border-2 border-gray-300 rounded-lg max-h-80 overflow-y-auto bg-white">
                        <div class="p-4 text-center text-gray-400 text-sm italic">Klik "Choose Audio" untuk memuat daftar file...</div>
                    </div>
                </div>

                {{-- Selected File Display --}}
                <div class="p-3 bg-emerald-50 rounded-lg border border-emerald-200">
                    <p class="text-sm font-medium text-emerald-800">Selected:</p>
                    <p id="audioSelectedFile" class="text-sm text-emerald-700 mt-1 break-words">
                        <span class="italic text-gray-500">None selected</span>
                    </p>
                </div>

                {{-- Hidden input for selected file path --}}
                <input type="hidden" name="existing_audio_path" id="selectedAudioPath" value="">

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('chooseAudioModal').classList.add('hidden')"
                            class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" id="useSelectedAudioBtn"
                            class="flex-1 px-4 py-2 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                        Use Selected
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    const audioFileManager = {
        allFiles: [],
        currentPath: '',
        selectedFile: null,
        loaded: false,
        loading: false,

        init() {
            if (this.loaded) {
                this.render();
                return;
            }
            this.fetchFiles();
        },

        fetchFiles() {
            if (this.loading) return;
            this.loading = true;
            const listContainer = document.getElementById('audioFileList');
            listContainer.innerHTML = '<div class="p-4 text-center text-gray-500 text-sm"><svg class="animate-spin w-5 h-5 mx-auto mb-2 text-indigo-500" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memuat file audio...</div>';

            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

            fetch('{{ route("api.audio.files") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(function(response) {
                if (!response.ok) throw new Error('HTTP ' + response.status);
                return response.json();
            })
            .then(function(data) {
                audioFileManager.allFiles = Array.isArray(data) ? data : [];
                audioFileManager.loaded = true;
                audioFileManager.loading = false;
                audioFileManager.render();
            })
            .catch(function(err) {
                audioFileManager.loading = false;
                const el = document.getElementById('audioFileList');
                el.innerHTML = '<div class="p-4 text-center text-red-500 text-sm">Gagal memuat file: ' + err.message + '</div>';
            });
        },

        goToRoot(e) {
            if (e) e.preventDefault();
            this.currentPath = '';
            this.render();
        },

        selectFile(filePath) {
            this.selectedFile = filePath;
            document.getElementById('selectedAudioPath').value = filePath;
            
            const fileName = filePath.split('/').pop();
            document.getElementById('audioSelectedFile').innerHTML = `<span class="text-green-700 font-medium">${fileName}</span>`;
            document.getElementById('useSelectedAudioBtn').disabled = false;
            
            this.render();
        },

        goToFolder(folderPath) {
            this.currentPath = folderPath;
            this.render();
        },

        render() {
            const listContainer = document.getElementById('audioFileList');
            const breadcrumb = document.getElementById('audioBreadcrumb');
            
            if (!this.allFiles.length) {
                listContainer.innerHTML = '<div class="p-4 text-center text-gray-500">No files available</div>';
                return;
            }

            // Build folder structure using label for display, keeping value for submission
            const items = {};
            this.allFiles.forEach(audio => {
                const label = audio.label || audio.value;
                const value = audio.value;
                const parts = label.split('/');
                let current = items;
                
                for (let i = 0; i < parts.length; i++) {
                    const part = parts[i];
                    const labelPath = parts.slice(0, i + 1).join('/');
                    const isFile = i === parts.length - 1;
                    
                    if (!current[part]) {
                        current[part] = {
                            _labelPath: labelPath,
                            _isFile: isFile,
                            _value: isFile ? value : null
                        };
                    }
                    current = current[part];
                }
            });

            // Get current folder contents
            let current = items;
            if (this.currentPath) {
                const pathParts = this.currentPath.split('/');
                breadcrumb.innerHTML = '<button type="button" class="text-blue-600 hover:text-blue-800" data-action="goto-root">Root</button>' +
                    pathParts.map((p, i) => {
                        const p2 = pathParts.slice(0, i + 1).join('/');
                        return ` <span class="text-gray-400">/</span> <button type="button" class="text-blue-600 hover:text-blue-800" data-action="goto-folder" data-path="${p2}">${p}</button>`;
                    }).join('');

                for (const part of pathParts) {
                    if (current[part] === undefined) {
                        // Safety: path no longer valid, go back to root
                        this.currentPath = '';
                        this.render();
                        return;
                    }
                    current = current[part];
                }
            } else {
                breadcrumb.innerHTML = 'Root';
            }

            // Render folder contents
            const contents = Object.keys(current).filter(k => !k.startsWith('_')).sort();
            
            if (!contents.length) {
                listContainer.innerHTML = '<div class="p-4 text-center text-gray-500 text-sm">Folder is empty</div>';
                return;
            }

            let html = '';
            contents.forEach(name => {
                const item = current[name];
                const isFile = item._isFile;
                const labelPath = item._labelPath;
                const fileValue = item._value;  // Full path for submission (e.g. audio/toefl/listening/test/file.mp3)
                const isSelected = isFile && fileValue && this.selectedFile === fileValue;
                
                if (isFile) {
                    html += `<div class="flex items-center p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-100 ${isSelected ? 'bg-blue-100' : ''}" data-action="select-file" data-path="${fileValue}">
                        <svg class="w-5 h-5 text-red-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path></svg>
                        <span class="text-sm text-gray-800 flex-1 break-words pointer-events-none">${name}</span>
                        ${isSelected ? '<svg class="w-5 h-5 text-green-600 ml-2 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"></path></svg>' : ''}
                    </div>`;
                } else {
                    html += `<div class="flex items-center p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-100" data-action="goto-folder" data-path="${labelPath}">
                        <svg class="w-5 h-5 text-yellow-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M10 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"></path></svg>
                        <span class="text-sm font-medium text-gray-800 flex-1 pointer-events-none">${name}</span>
                        <svg class="w-4 h-4 text-gray-400 ml-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>`;
                }
            });
            
            listContainer.innerHTML = html;
        }
    };

    // Delegated event listener for file manager - handles folder navigation and file selection
    // Using data-attributes instead of inline onclick to avoid HTML escaping issues
    document.addEventListener('click', function(e) {
        const el = e.target.closest('[data-action]');
        if (el) {
            e.preventDefault();
            e.stopPropagation();
            const action = el.getAttribute('data-action');
            const path   = el.getAttribute('data-path');
            if (action === 'goto-folder') {
                audioFileManager.goToFolder(path || '');
            } else if (action === 'select-file') {
                audioFileManager.selectFile(path);
            } else if (action === 'goto-root') {
                audioFileManager.goToRoot(null);
            }
            return;
        }

        // Initialize when modal is opened
        const chooseBtn = e.target.closest('[onclick*="chooseAudioModal"]');
        if (chooseBtn) {
            const onclickVal = chooseBtn.getAttribute('onclick') || '';
            if (onclickVal.includes("remove('hidden')") || onclickVal.includes('classList.remove')) {
                setTimeout(function() { audioFileManager.init(); }, 150);
            }
        }
    });
    </script>
@endif

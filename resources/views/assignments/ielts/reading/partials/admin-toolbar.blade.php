<script>
    // Admin CRUD Functions
    const materialContent = @json($sections);

    function openPassageModal(index = null) {
        const modal = document.getElementById('passageModal');
        const form = document.getElementById('passageForm');
        
        if (index !== null) {
            const passage = materialContent[index];
            document.getElementById('passage_id').value = passage.id;
            document.getElementById('passage_title').value = passage.passage_title;
            document.getElementById('passage_content').value = passage.passage_text;
            document.getElementById('passageModalTitle').innerText = 'Edit Passage';
            form.action = `/admin/ielts-reading/passage/${passage.id}`;
            document.getElementById('passage_method').value = 'PUT';
        } else {
            // New Passage
            document.getElementById('passage_id').value = '';
            document.getElementById('passage_title').value = '';
            document.getElementById('passage_content').value = '';
            document.getElementById('passageModalTitle').innerText = 'Add Passage';
            form.action = `{{ route('admin.ielts.reading.passage.store') }}`;
            document.getElementById('passage_method').value = 'POST';
        }
        
        modal.classList.remove('hidden');
    }

    function closePassageModal() {
        document.getElementById('passageModal').classList.add('hidden');
    }

    function deletePassage(id) {
        if (!confirm('Are you sure you want to delete this passage? This will delete all associated questions.')) return;
        
        fetch(`/admin/ielts-reading/passage/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function openQuestionModal(passageIndex, questionIndex = null) {
        const modal = document.getElementById('questionModal');
        const form = document.getElementById('questionForm');
        const passage = materialContent[passageIndex];
        
        document.getElementById('q_passage_id').value = passage.id; 
        
        if (questionIndex !== null) {
            const question = passage.questions[questionIndex];
            document.getElementById('question_id').value = question.db_id;
            document.getElementById('question_number').value = question.id;
            document.getElementById('question_text').value = question.text || '';
            document.getElementById('question_explanation').value = question.explanation || '';
            document.getElementById('question_type').value = question.type;
            
            console.log('Opened Question:', question); // DEBUG: Check if data is present
            console.log('Question Data:', question.data); // DEBUG: Check if data object exists

            // Reconstruct data object for JSON field
            // Use existing data as base to preserve fields like 'image'
            const dataObj = question.data ? JSON.parse(JSON.stringify(question.data)) : {};
            
            // Ensure core fields are synced if they differ (though usually they are in data too or handled separately)
            if(question.options) dataObj.options = question.options;
            if(question.correct_answer) dataObj.correct_answer = question.correct_answer;

            // We don't need to manually check for sub_questions etc if we copy data
            // But let's keep the explicit checks just in case data was null but sub_questions existed on top level (unlikely)
            if(question.sub_questions && !dataObj.sub_questions) dataObj.sub_questions = question.sub_questions;
            if(question.box_title && !dataObj.box_title) dataObj.box_title = question.box_title;
            if(question.summary_text && !dataObj.summary_text) dataObj.summary_text = question.summary_text;
            if(question.placeholders && !dataObj.placeholders) dataObj.placeholders = question.placeholders;
            if(question.box_options && !dataObj.box_options) dataObj.box_options = question.box_options;

            document.getElementById('question_data').value = JSON.stringify(dataObj, null, 2);
            
            // Visual Editor Handling
            const editorContainer = document.getElementById('diagramEditor');
            const editorImage = document.getElementById('diagramImage');
            
            if (question.type === 'diagram_labelling') {
                editorContainer.classList.remove('hidden');
                editorContainer.style.display = 'block'; 

                const imgSrc = question.image || (question.data && question.data.image) || '';
                const errorMsg = document.getElementById('diagramError');
                const toolbar = document.getElementById('editorToolbar');
                const canvas = document.getElementById('diagramCanvas');

                if(imgSrc) {
                    // Success Case
                    if(errorMsg) errorMsg.classList.add('hidden');
                    if(toolbar) toolbar.classList.remove('hidden');
                    if(canvas) canvas.classList.remove('hidden');

                    if(editorImage) {
                         editorImage.src = imgSrc;
                         if (editorImage.complete && editorImage.naturalHeight !== 0) {
                             initDiagramEditor(dataObj);
                         } else {
                             editorImage.onload = () => initDiagramEditor(dataObj);
                         }
                    }
                } else {
                    // Error Case
                    if(errorMsg) errorMsg.classList.remove('hidden');
                    if(toolbar) toolbar.classList.add('hidden');
                    if(canvas) canvas.classList.add('hidden');
                }
            } else {
                editorContainer.classList.add('hidden');
                editorContainer.style.display = 'none';
            }
            
            document.getElementById('questionModalTitle').innerText = 'Edit Question';
            form.action = `/admin/ielts-reading/question/${question.db_id}`;
            document.getElementById('question_method').value = 'PUT';
        } else {
            // New Question
            document.getElementById('question_id').value = '';
            document.getElementById('question_number').value = (passage.questions.length + 1);
            document.getElementById('question_text').value = '';
            document.getElementById('question_explanation').value = '';
            document.getElementById('question_type').value = 'matching_headings';
            document.getElementById('question_data').value = '{\n  "options": [],\n  "correct_answer": [],\n  "sub_questions": []\n}';
            
            document.getElementById('questionModalTitle').innerText = 'Add Question';
            form.action = `{{ route('admin.ielts.reading.question.store') }}`;
            document.getElementById('question_method').value = 'POST';
        }
        
        modal.classList.remove('hidden');
    }

    function closeQuestionModal() {
        document.getElementById('questionModal').classList.add('hidden');
    }

    function deleteQuestion(id) {
        if (!confirm('Are you sure you want to delete this question block?')) return;
        
        fetch(`/admin/ielts-reading/question/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Form Submissions
    // Form Submissions
    document.addEventListener('DOMContentLoaded', function() {
        const passageForm = document.getElementById('passageForm');
        if (passageForm) {
            passageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                data.material_id = {{ $id }}; // Current Material ID

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'X-HTTP-Method-Override': data._method || 'POST'
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) location.reload();
                    else alert(data.message);
                });
            });
        }

        const questionDataTextarea = document.getElementById('question_data');
        if (questionDataTextarea) {
            questionDataTextarea.addEventListener('paste', function(e) {
                const items = (e.clipboardData || e.originalEvent.clipboardData).items;
                for (let index in items) {
                    const item = items[index];
                    if (item.kind === 'file' && item.type.startsWith('image/')) {
                        const blob = item.getAsFile();
                        const formData = new FormData();
                        formData.append('image', blob);

                        // Show uploading indicator
                        const syncMsg = document.getElementById('jsonSyncMsg');
                        syncMsg.textContent = 'Uploading image...';
                        syncMsg.classList.remove('hidden');
                        syncMsg.classList.remove('text-blue-600');
                        syncMsg.classList.add('text-yellow-600');

                        fetch('/admin/ielts-reading/upload-diagram', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                try {
                                    let currentJson = JSON.parse(questionDataTextarea.value || '{}');
                                    currentJson.image = data.url;
                                    questionDataTextarea.value = JSON.stringify(currentJson, null, 2);
                                    
                                    syncMsg.textContent = 'Image uploaded and JSON updated!';
                                    syncMsg.classList.remove('text-yellow-600');
                                    syncMsg.classList.add('text-green-600');
                                    
                                    // Trigger diagram update
                                    document.getElementById('diagramImage').src = data.url;
                                    document.getElementById('diagramError').classList.add('hidden');
                                    document.getElementById('diagramCanvas').classList.remove('hidden');
                                    document.getElementById('editorToolbar').classList.remove('hidden');

                                    setTimeout(() => {
                                        syncMsg.classList.add('hidden');
                                        syncMsg.classList.remove('text-green-600');
                                        syncMsg.classList.add('text-blue-600');
                                        syncMsg.textContent = 'Updated from Visual Editor.';
                                    }, 3000);
                                } catch (e) {
                                    alert('Failed to update JSON. Image uploaded successfully to: ' + data.url);
                                }
                            } else {
                                alert('Upload failed: ' + data.message);
                                syncMsg.classList.add('hidden');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Upload error');
                            syncMsg.classList.add('hidden');
                        });
                        break; // Only handle one image
                    }
                }
            });
        }

        const questionForm = document.getElementById('questionForm');
        if (questionForm) {
            questionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());
                
                function appendFormData(formData, data, parentKey) {
                    if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File)) {
                        Object.keys(data).forEach(key => {
                            appendFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
                        });
                    } else {
                        const value = data == null ? '' : data;
                        formData.append(parentKey, value);
                    }
                }

                const finalFormData = new FormData(form);
                
                // Parse "data" field from JSON string to object and flatten it for FormData
                try {
                    console.log('Submitting form...');
                    console.log('Raw JSON:', data.data_json);
                    const rawData = JSON.parse(data.data_json); 
                    // Controller expects 'data' as array
                    appendFormData(finalFormData, rawData, 'data');
                    
                    // Controller also validates specific fields like 'options' and 'correct_answer' at top level
                    if(rawData.options) appendFormData(finalFormData, rawData.options, 'options');
                    if(rawData.correct_answer) appendFormData(finalFormData, rawData.correct_answer, 'correct_answer');
                    
                } catch (err) {
                    alert('Invalid JSON in Data field');
                    return;
                }

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: finalFormData
                })
                .then(async res => {
                    if (!res.ok) {
                        const contentType = res.headers.get("content-type");
                        if (contentType && contentType.indexOf("application/json") !== -1) {
                            const errorData = await res.json();
                            throw new Error(errorData.message || 'Validation Error');
                        } else {
                            const text = await res.text();
                            console.error('Server Error:', text);
                            throw new Error('Server responded with ' + res.status);
                        }
                    }
                    return res.json();
                })
                .then(data => {
                    if(data.success) location.reload();
                    else alert('Save Failed: ' + data.message);
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    alert('Error saving question: ' + error.message);
                });
            });
        }
    });
    // Visual Diagram Editor Logic
    let currentDiagramTags = [];
    let activeDrag = null;
    let activeResize = null;

    function initDiagramEditor(dataObj) {
        const editor = document.getElementById('diagramEditor');
        const img = document.getElementById('diagramImage');
        const overlay = document.getElementById('diagramOverlay');
        
        // Reset state
        currentDiagramTags = dataObj.sub_questions || [];
        
        // Load Image
        // If image is in root object (legacy) or data object
        // The modal logic populates dataObj from question.sub_questions etc.
        // We need to find the image URL. It might be in the main question object/data. 
        // We need to pass the full question object or image path to this init function.
        // For now, let's look for 'image' property in the JSON or assume it's passed differently.
        // Quick fix: The image path isn't in sub_questions. It's usually question.image or question.data.image.
        // The openQuestionModal function handles setting the image src on the DOM element.
        
        renderDiagramLabels();
    }

    function renderDiagramLabels() {
        const overlay = document.getElementById('diagramOverlay');
        overlay.innerHTML = ''; // Clear existing

        currentDiagramTags.forEach(tag => {
            const el = document.createElement('div');
            el.className = 'absolute bg-white border border-blue-500 rounded flex items-center shadow-sm group';
            // Default width 120px if not set, convert to percentage or keep px?
            // Existing data uses % for x,y. Let's assume width is px for now or we add width support.
            // If width is missing, default to some reasonable value relative to container or fixed.
            const width = tag.width ? tag.width + 'px' : '100px'; 
            
            el.style.left = tag.x + '%';
            el.style.top = tag.y + '%';
            el.style.width = width;
            el.style.transform = 'translate(0, -50%)'; // Vertically center on the point like the view does
            el.style.cursor = 'move';
            
            el.innerHTML = `
                <span class="font-bold text-blue-700 px-2 select-none">${tag.label}</span>
                <div class="flex-grow h-6 bg-white border-l border-gray-300"></div>
                <!-- Delete Handle -->
                <button onclick="deleteDiagramLabel('${tag.id}')" class="bg-red-500 text-white w-5 h-5 flex items-center justify-center rounded-full absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity text-xs" title="Delete">×</button>
                <!-- Resize Handle -->
                <div class="absolute right-0 top-0 bottom-0 w-2 cursor-e-resize hover:bg-blue-300" onmousedown="startResize(event, '${tag.id}')"></div>
            `;

            el.onmousedown = (e) => startDrag(e, tag.id);
            overlay.appendChild(el);
        });
    }

    function startDrag(e, id) {
        if (e.target.tagName === 'BUTTON' || e.target.classList.contains('cursor-e-resize')) return; // Ignore if clicking delete or resize
        e.preventDefault();
        e.stopPropagation();
        
        const tag = currentDiagramTags.find(t => t.id == id);
        const overlay = document.getElementById('diagramOverlay');
        const rect = overlay.getBoundingClientRect();
        
        activeDrag = {
            id: id,
            startX: e.clientX,
            startY: e.clientY,
            initialLeft: parseFloat(tag.x), // Ensure it's number
            initialTop: parseFloat(tag.y),   // Ensure it's number
            containerWidth: rect.width,
            containerHeight: rect.height
        };
        
        document.addEventListener('mousemove', handleDrag);
        document.addEventListener('mouseup', stopDrag);
    }

    function handleDrag(e) {
        if (!activeDrag) return;
        
        const dxPx = e.clientX - activeDrag.startX;
        const dyPx = e.clientY - activeDrag.startY;
        
        // Convert px delta to %
        const dxPct = (dxPx / activeDrag.containerWidth) * 100;
        const dyPct = (dyPx / activeDrag.containerHeight) * 100;
        
        let newX = activeDrag.initialLeft + dxPct;
        let newY = activeDrag.initialTop + dyPct;
        
        // Clamp
        newX = Math.max(0, Math.min(100, newX));
        newY = Math.max(0, Math.min(100, newY));
        
        // Update state
        const tag = currentDiagramTags.find(t => t.id == activeDrag.id);
        tag.x = Math.round(newX * 100) / 100;
        tag.y = Math.round(newY * 100) / 100;
        
        renderDiagramLabels();
    }

    function stopDrag() {
        if(activeDrag) {
            syncDiagramData();
            activeDrag = null;
        }
        document.removeEventListener('mousemove', handleDrag);
        document.removeEventListener('mouseup', stopDrag);
    }

    function startResize(e, id) {
        e.preventDefault();
        e.stopPropagation();
        
        const tag = currentDiagramTags.find(t => t.id == id);
        const el = e.target.parentElement;
        
        activeResize = {
            id: id,
            startX: e.clientX,
            initialWidth: parseFloat(el.style.width) // px
        };
        
        document.addEventListener('mousemove', handleResize);
        document.addEventListener('mouseup', stopResize);
    }

    function handleResize(e) {
        if (!activeResize) return;
        const dx = e.clientX - activeResize.startX;
        let newWidth = Math.max(50, activeResize.initialWidth + dx); // Min 50px
        
        const tag = currentDiagramTags.find(t => t.id == activeResize.id);
        tag.width = Math.round(newWidth);
        
        renderDiagramLabels();
    }

    function stopResize() {
        if (activeResize) {
            syncDiagramData();
            activeResize = null;
        }
        document.removeEventListener('mousemove', handleResize);
        document.removeEventListener('mouseup', stopResize);
    }

    function addDiagramLabel() {
        const id = (currentDiagramTags.length + 1).toString();
        currentDiagramTags.push({
            id: id,
            label: id,
            x: 50,
            y: 50,
            width: 100
        });
        renderDiagramLabels();
        syncDiagramData();
    }

    function deleteDiagramLabel(id) {
        if(!confirm('Delete this label?')) return;
        currentDiagramTags = currentDiagramTags.filter(t => t.id != id);
        renderDiagramLabels();
        syncDiagramData();
    }

    function syncDiagramData() {
        const jsonField = document.getElementById('question_data');
        try {
            const currentData = JSON.parse(jsonField.value || '{}');
            currentData.sub_questions = currentDiagramTags;
            jsonField.value = JSON.stringify(currentData, null, 2);
            document.getElementById('jsonSyncMsg').classList.remove('hidden');
            setTimeout(() => document.getElementById('jsonSyncMsg').classList.add('hidden'), 2000);
        } catch(e) {
            console.error("Cannot sync diagram data, invalid JSON in textarea", e);
        }
    }
</script>

<!-- Modals -->
<div id="passageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-8 max-w-6xl w-full">
        <h3 id="passageModalTitle" class="text-2xl font-bold mb-4">Edit Passage</h3>
        <form id="passageForm">
            <input type="hidden" name="_method" id="passage_method" value="POST">
            <input type="hidden" name="id" id="passage_id">
            
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Title</label>
                <input type="text" name="title" id="passage_title" class="w-full border p-2 rounded">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Content (HTML)</label>
                <textarea name="content" id="passage_content" class="w-full border p-2 rounded h-96 font-mono text-sm"></textarea>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closePassageModal()" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>

<div id="questionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-8 max-w-4xl w-full max-h-[90vh] overflow-y-auto">
        <h3 id="questionModalTitle" class="text-2xl font-bold mb-4">Edit Question</h3>
        <form id="questionForm">
            <input type="hidden" name="_method" id="question_method" value="POST">
            @csrf
            <input type="hidden" name="passage_id" id="q_passage_id">
            <input type="hidden" name="id" id="question_id">
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-bold mb-2">Number (ID)</label>
                    <input type="text" name="question_number" id="question_number" class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-2">Type</label>
                    <select name="type" id="question_type" class="w-full border p-2 rounded">
                        <option value="matching_headings">Matching Headings</option>
                        <option value="summary_completion">Summary Completion</option>
                        <option value="multiple_choice">Multiple Choice</option>
                        <option value="multiple_choice_multiple">Multiple Choice (Multiple Answers)</option>
                        <option value="true_false">True/False</option>
                        <option value="short_answer">Short Answer</option>
                        <option value="sentence_completion">Sentence Completion</option>
                        <option value="diagram_labelling">Diagram Labelling</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Instruction / Text</label>
                <textarea name="question_text" id="question_text" class="w-full border p-2 rounded h-20"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Answer Key & Explanation</label>
                <textarea name="explanation" id="question_explanation" class="w-full border p-2 rounded h-32"></textarea>
            </div>
            
            <!-- Visual Editor for Diagram Labelling -->
            <div id="diagramEditor" class="mb-4 hidden border rounded p-4 bg-white overflow-x-auto">
                <label class="block text-sm font-bold mb-2">Visual Diagram Editor</label>
                <!-- Image path is retrieved from question.image or data.image in JS -->
                <p id="diagramError" class="hidden text-red-500 mb-2 font-bold">Error: No image path found. Please add "image" to the JSON.</p>
                <div id="editorToolbar" class="mb-2 flex items-center gap-4 bg-white p-2 rounded border border-blue-100 min-w-[900px]">
                    <button type="button" onclick="addDiagramLabel()" class="px-4 py-2 bg-green-600 text-white rounded text-sm hover:bg-green-700 shadow-sm font-bold">
                        + Add Label
                    </button>
                    <div class="text-xs text-blue-800 flex flex-col">
                        <span><strong>Move:</strong> Click and drag any blue box.</span>
                        <span><strong>Resize:</strong> Drag the right edge of a box.</span>
                        <span><strong>Delete:</strong> Click the red 'X' on a box.</span>
                    </div>
                </div>
                
                <div id="diagramCanvas" class="relative overflow-hidden border border-gray-300 bg-white select-none shadow-inner" style="min-height: 400px; background-color: #f3f4f6; min-width: 900px;">
                    <!-- Image and Labels will be injected here -->
                    <img id="diagramImage" src="" class="w-full h-auto pointer-events-none block" style="user-select: none; pointer-events: none;">
                    <div id="diagramOverlay" class="absolute inset-0 z-10"></div>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Data Configuration (JSON)</label>
                <p class="text-xs text-gray-500 mb-1">Includes options, correct_answer, sub_questions, placeholders. <span id="jsonSyncMsg" class="text-blue-600 hidden">Updated from Visual Editor.</span></p>
                <textarea name="data_json" id="question_data" class="w-full border p-2 rounded h-80 font-mono text-xs"></textarea>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeQuestionModal()" class="px-4 py-2 bg-gray-200 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>
</div>



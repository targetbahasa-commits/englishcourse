import re

with open('resources/views/assignments/ielts/listening/partials/audio-player.blade.php', 'r') as f:
    content = f.read()

answer_key_modal = """
    {{-- Upload Answer Key Modal --}}
    <div id="uploadAnswerKeyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[9999] flex items-center justify-center p-4 transition-opacity" onclick="if(event.target === this) this.classList.add('hidden')">
        <div class="bg-white rounded-xl shadow-2xl p-6 md:p-8 max-w-md w-full mx-auto relative overflow-y-auto max-h-[90vh]">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl md:text-2xl font-bold text-gray-900">Upload Answer Key</h3>
                <button type="button" onclick="document.getElementById('uploadAnswerKeyModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form action="{{ route('assignments.ielts-academic.mockup.cambridge.upload-answer-key', ['edition' => $edition ?? 1, 'id' => $testId ?? 1]) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Answer Key Content</label>
                    <textarea name="answer_key" rows="6" required class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-teal-500 focus:outline-none placeholder-gray-400 text-sm font-mono" placeholder="1. A\\n2. B..."></textarea>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('uploadAnswerKeyModal').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition-colors">Cancel</button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-teal-600 text-white font-semibold rounded-lg hover:bg-teal-700 transition-colors shadow-sm">Save Key</button>
                </div>
            </form>
        </div>
    </div>
"""

# Insert before @endif\n@endif\n\n<script>
content = content.replace("@endif\n@endif\n\n<script>", answer_key_modal + "\n@endif\n@endif\n\n<script>")

with open('resources/views/assignments/ielts/listening/partials/audio-player.blade.php', 'w') as f:
    f.write(content)

print("done")

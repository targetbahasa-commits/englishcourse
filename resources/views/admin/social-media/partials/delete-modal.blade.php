{{-- Delete Confirmation Modal --}}
<div x-show="showDelete" x-transition.opacity style="display:none"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[110] flex items-center justify-center p-4">
    <div @click.stop x-show="showDelete" x-transition
         class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8 text-center">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-5">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Delete Post?</h3>
        <p class="text-gray-500 text-sm mb-1">You are about to permanently delete:</p>
        <p class="font-semibold text-gray-800 mb-6" x-text="`"${deletingTitle}"`"></p>
        <p class="text-xs text-red-500 mb-6">This action cannot be undone.</p>
        <div class="flex gap-3">
            <button @click="showDelete = false"
                class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                Cancel
            </button>
            <button @click="confirmDelete()"
                class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-xl transition">
                Yes, Delete
            </button>
        </div>
    </div>
</div>

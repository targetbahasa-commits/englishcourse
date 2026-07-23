@if (session('success') || session('error') || session('status') || $errors->any())
    <div
        x-data="{
            items: [
                @if (session('success')) { type: 'success', text: @js(session('success')) }, @endif
                @if (session('status')) { type: 'success', text: @js(session('status')) }, @endif
                @if (session('error')) { type: 'error', text: @js(session('error')) }, @endif
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        { type: 'error', text: @js($error) },
                    @endforeach
                @endif
            ].map((item, i) => ({ ...item, id: i, show: true }))
        }"
        x-cloak
        class="fixed top-4 right-4 z-[9999] flex flex-col gap-2 w-full max-w-sm"
    >
        <template x-for="item in items" :key="item.id">
            <div
                x-show="item.show"
                x-init="setTimeout(() => item.show = false, 6000)"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="flex items-start gap-3 rounded-xl shadow-lg p-4 border"
                :class="item.type === 'success' ? 'bg-green-50 border-green-200 text-green-800' : 'bg-red-50 border-red-200 text-red-800'"
            >
                <svg x-show="item.type === 'success'" class="w-5 h-5 flex-shrink-0 mt-0.5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <svg x-show="item.type === 'error'" class="w-5 h-5 flex-shrink-0 mt-0.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86l-8.18 14.14A2 2 0 004 21h16a2 2 0 001.89-2.99L13.71 3.86a2 2 0 00-3.42 0z"></path>
                </svg>
                <p class="text-sm font-medium flex-1" x-text="item.text"></p>
                <button type="button" @click="item.show = false" class="flex-shrink-0 opacity-60 hover:opacity-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </template>
    </div>
@endif

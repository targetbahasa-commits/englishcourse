<!-- Idioms Slide-over/Panel -->
<template x-if="isIdiomsOpen">
    <div class="fixed inset-y-0 left-0 w-80 z-[60] flex pointer-events-none">
        <div class="w-full h-full pointer-events-auto transition-transform transform bg-white shadow-2xl flex flex-col items-start"
             x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">
                 
                 <!-- Header -->
                 <div class="flex-shrink-0 px-6 py-4 border-b border-gray-200 w-full flex items-center justify-between bg-white">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                         <span class="text-2xl"></span> Useful Idioms
                    </h2>
                    <button @click="isIdiomsOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <span class="sr-only">Close panel</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                 </div>
                 
                 <!-- Content -->
                 <div class="flex-1 overflow-y-auto w-full p-6 bg-white">
                     <template x-if="idioms && idioms.length > 0">
                         <div class="space-y-6">
                             <template x-for="(idiom, index) in idioms" :key="index">
                                 <div class="bg-white border rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow border-orange-100">
                                     <h3 class="text-lg font-bold text-orange-600 mb-1" x-text="idiom.phrase"></h3>
                                     <p class="text-gray-700 italic mb-1" x-text="idiom.meaning"></p>
                                     <div class="bg-white p-2 rounded text-sm text-gray-600 border-l-2 border-gray-300">
                                         <span class="font-semibold text-gray-400 text-xs uppercase tracking-wide">Example:</span><br>
                                         <span x-text="idiom.example"></span>
                                     </div>
                                 </div>
                             </template>
                         </div>
                     </template>
                     <template x-if="!idioms || idioms.length === 0">
                         <div class="flex flex-col items-center justify-center h-full text-center text-gray-500">
                             <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                             </svg>
                             <p>No specific idioms found for this topic.</p>
                         </div>
                     </template>
                 </div>
            </div>
        </div>
</template>

<!-- Collocations Slide-over/Panel -->
<template x-if="isCollocationsOpen">
    <div class="fixed inset-y-0 left-0 w-80 z-[60] flex pointer-events-none">
        <div class="w-full h-full pointer-events-auto transition-transform transform bg-white shadow-2xl flex flex-col items-start"
             x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">
                 
                 <!-- Header -->
                 <div class="flex-shrink-0 px-6 py-4 border-b border-gray-200 w-full flex items-center justify-between bg-white">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                         <span class="text-2xl">🔗</span> Useful Collocations
                    </h2>
                    <button @click="isCollocationsOpen = false" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <span class="sr-only">Close panel</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                 </div>
                 
                 <!-- Content -->
                 <div class="flex-1 overflow-y-auto w-full p-6 bg-white">
                     
                     <!-- Show collocations if any exist -->
                     <template x-if="collocations && collocations.length > 0">
                         <div class="space-y-4">
                             <template x-for="(collocation, index) in collocations" :key="index">
                                 <div class="bg-white border rounded-xl p-3 shadow-sm hover:shadow-md transition-shadow border-teal-100 group">
                                     <!-- Category badge -->
                                     <span x-show="collocation.category" x-text="collocation.category"
                                           class="inline-block text-[10px] font-bold text-teal-600 uppercase tracking-wider bg-white px-2 py-0.5 rounded mb-1"></span>
                                     <h4 class="text-base font-bold text-teal-700 mb-1 group-hover:text-teal-600 transition-colors" x-text="collocation.phrase || collocation.word"></h4>
                                     <p class="text-sm text-gray-600 mb-2 leading-relaxed" x-text="collocation.meaning"></p>
                                     <div class="bg-white p-2 rounded-lg text-xs text-gray-600 italic border-l-2 border-teal-400">
                                         <span x-text="collocation.example"></span>
                                     </div>
                                 </div>
                             </template>
                         </div>
                     </template>

                     <!-- Empty state -->
                     <template x-if="!collocations || collocations.length === 0">
                         <div class="flex flex-col items-center justify-center h-full text-center text-gray-500 py-12">
                             <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                             </svg>
                             <p>No specific collocations found for this topic.</p>
                         </div>
                     </template>
                 </div>
            </div>
        </div>
</template>

<x-app-layout>
    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-blue-900 tracking-tight">Evaluate Teacher</h1>
            <p class="mt-2 text-lg text-gray-600">Please provide honest feedback about your teacher to help us maintain a high quality of learning.</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-gray-800">
            <!-- Form Card Header -->
            <div class="p-6 sm:p-8 bg-gradient-to-br from-blue-50 to-indigo-50 border-b border-indigo-100 flex items-center gap-6">
                @if($teacher->profile_photo)
                    <img src="{{ Storage::url($teacher->profile_photo) }}" alt="Teacher Profile" class="w-20 h-20 rounded-full object-cover shadow-sm bg-white p-1">
                @else
                    <div class="w-20 h-20 rounded-full shadow-sm bg-indigo-100 flex items-center justify-center text-indigo-500 font-bold text-2xl border-4 border-white">
                        {{ substr($teacher->name, 0, 1) }}
                    </div>
                @endif
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $teacher->name }}</h2>
                    <p class="text-sm text-indigo-600 font-medium tracking-wide uppercase mt-1">Your Assigned Teacher</p>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-6 sm:p-8">
                <form action="{{ route('student.evaluations.store') }}" method="POST">
                    @csrf
                    
                    <!-- Rating System -->
                    <div class="mb-8">
                        <label class="block text-base font-semibold text-gray-800 mb-3">Overall Rating <span class="text-red-500">*</span></label>
                        <div class="flex flex-row-reverse justify-end items-center" id="star-rating">
                            <!-- Radio buttons in reverse order for CSS sibling selector -->
                            <input type="radio" id="star5" name="rating" value="5" class="hidden peer" required />
                            <label for="star5" class="cursor-pointer text-gray-300 peer-hover:text-amber-400 peer-checked:text-amber-400 text-4xl mx-1 transition-colors">★</label>
                            
                            <input type="radio" id="star4" name="rating" value="4" class="hidden peer" required />
                            <label for="star4" class="cursor-pointer text-gray-300 peer-hover:text-amber-400 peer-checked:text-amber-400 peer-hover:~label:text-amber-400 text-4xl mx-1 transition-colors">★</label>
                            
                            <input type="radio" id="star3" name="rating" value="3" class="hidden peer" required />
                            <label for="star3" class="cursor-pointer text-gray-300 peer-hover:text-amber-400 peer-checked:text-amber-400 peer-hover:~label:text-amber-400 text-4xl mx-1 transition-colors">★</label>
                            
                            <input type="radio" id="star2" name="rating" value="2" class="hidden peer" required />
                            <label for="star2" class="cursor-pointer text-gray-300 peer-hover:text-amber-400 peer-checked:text-amber-400 peer-hover:~label:text-amber-400 text-4xl mx-1 transition-colors">★</label>
                            
                            <input type="radio" id="star1" name="rating" value="1" class="hidden peer" required />
                            <label for="star1" class="cursor-pointer text-gray-300 peer-hover:text-amber-400 peer-checked:text-amber-400 peer-hover:~label:text-amber-400 text-4xl mx-1 transition-colors">★</label>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Tap a star to rate your experience.</p>
                        @error('rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Comment Section -->
                    <div class="mb-8">
                        <label for="comment" class="block text-base font-semibold text-gray-800 mb-3">Additional Comments (Optional)</label>
                        <textarea id="comment" name="comment" rows="4" 
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition duration-150 ease-in-out p-4 text-gray-700 placeholder-gray-400 bg-gray-50 focus:bg-white" 
                            placeholder="What did you think of the teaching methods, clarity, and overall support?"></textarea>
                        @error('comment')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 font-medium rounded-xl mr-4 transition duration-150 ease-in-out">
                            Cancel
                        </a>
                        <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-sm hover:shadow-md transition duration-150 ease-in-out active:transform active:scale-95">
                            Submit Evaluation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <style>
        /* CSS trick to make hover state affect previous siblings */
        #star-rating > label:hover,
        #star-rating > label:hover ~ label,
        #star-rating > input:checked ~ label {
            color: #fbbf24; /* Tailwind amber-400 */
        }
    </style>
</x-app-layout>

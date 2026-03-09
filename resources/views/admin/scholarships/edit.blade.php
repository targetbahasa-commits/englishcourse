@extends('layouts.admin')

@section('title', 'Edit Scholarship')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto">

    <!-- Page header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Edit Scholarship</h1>
        <p class="text-sm text-gray-500 mt-1">Update details for {{ $scholarship->title }}.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.scholarships.update', $scholarship) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                
                <!-- Scholarship Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Scholarship Image / Logo</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md bg-gray-50 hover:bg-white transition relative group">
                        <div class="space-y-1 text-center" x-data="{ fileName: null, previewUrl: '{{ $scholarship->image_path ? asset('storage/' . $scholarship->image_path) : '' }}' }" x-on:drop.prevent="
                            // Handle drop
                            if($event.dataTransfer.files.length) {
                                $refs.fileInput.files = $event.dataTransfer.files;
                                fileName = $event.dataTransfer.files[0].name;
                                previewUrl = URL.createObjectURL($event.dataTransfer.files[0]);
                            }
                        " x-on:dragover.prevent="" x-on:dragenter.prevent="">
                            
                            <template x-if="previewUrl">
                                <div class="mb-4 flex flex-col items-center">
                                    <img :src="previewUrl" class="h-32 object-contain rounded-md" />
                                    <button type="button" @click="previewUrl = null; fileName = null; $refs.fileInput.value = ''" class="mt-2 text-xs text-red-500 hover:text-red-700">Remove/Replace image</button>
                                </div>
                            </template>

                            <template x-if="!previewUrl">
                                <div>
                                    <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-indigo-500 transition" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex justify-center text-sm text-gray-600 mt-2">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a new file</span>
                                            <input id="image" name="image" x-ref="fileInput" type="file" class="sr-only" accept="image/*" @change="fileName = $event.target.files[0].name; previewUrl = URL.createObjectURL($event.target.files[0])">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 pt-1" x-text="fileName || 'PNG, JPG, GIF up to 2MB'"></p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Scholarship Title <span class="text-red-500">*</span></label>
                        <input id="title" name="title" type="text" value="{{ old('title', $scholarship->title) }}" required class="form-input w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="e.g., LPDP, Chevening, Fulbright">
                    </div>
                    
                    <!-- Provider -->
                    <div>
                        <label for="provider" class="block text-sm font-medium text-gray-700 mb-1">Provider/Organization <span class="text-red-500">*</span></label>
                        <input id="provider" name="provider" type="text" value="{{ old('provider', $scholarship->provider) }}" required class="form-input w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="e.g., Ministry of Finance">
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Country Category</label>
                        <select id="country" name="country" class="form-select w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <option value="">Select Region/Country</option>
                            <option value="Indonesia" {{ old('country', $scholarship->country) == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                            <option value="UK" {{ old('country', $scholarship->country) == 'UK' ? 'selected' : '' }}>UK</option>
                            <option value="USA" {{ old('country', $scholarship->country) == 'USA' ? 'selected' : '' }}>USA</option>
                            <option value="Japan" {{ old('country', $scholarship->country) == 'Japan' ? 'selected' : '' }}>Japan</option>
                            <option value="Australia" {{ old('country', $scholarship->country) == 'Australia' ? 'selected' : '' }}>Australia</option>
                            <option value="Europe" {{ old('country', $scholarship->country) == 'Europe' ? 'selected' : '' }}>Europe (Other)</option>
                            <option value="Asia" {{ old('country', $scholarship->country) == 'Asia' ? 'selected' : '' }}>Asia (Other)</option>
                            <option value="Global/Online" {{ old('country', $scholarship->country) == 'Global/Online' ? 'selected' : '' }}>Global / Online</option>
                            <option value="Others" {{ old('country', $scholarship->country) == 'Others' ? 'selected' : '' }}>Others</option>
                        </select>
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Study Location (Country/Region) <span class="text-red-500">*</span></label>
                        <input id="location" name="location" type="text" value="{{ old('location', $scholarship->location) }}" required class="form-input w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="e.g., Indonesia, UK, Global">
                    </div>

                    <!-- Level of Study -->
                    <div>
                        <label for="level_of_study" class="block text-sm font-medium text-gray-700 mb-1">Level of Study <span class="text-red-500">*</span></label>
                        <input id="level_of_study" name="level_of_study" type="text" value="{{ old('level_of_study', $scholarship->level_of_study) }}" required class="form-input w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="e.g., S1, S2, S3, Short Course">
                    </div>

                    <!-- Opening Date -->
                    <div>
                        <label for="opening_date" class="block text-sm font-medium text-gray-700 mb-1">Opening Date <span class="text-gray-400">(Optional)</span></label>
                        <input id="opening_date" name="opening_date" type="date" value="{{ old('opening_date', $scholarship->opening_date ? $scholarship->opening_date->format('Y-m-d') : '') }}" class="form-input w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>

                    <!-- Deadline -->
                    <div>
                        <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Application Deadline <span class="text-red-500">*</span></label>
                        <input id="deadline" name="deadline" type="date" value="{{ old('deadline', $scholarship->deadline->format('Y-m-d')) }}" required class="form-input w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                    </div>

                    <!-- Application Link -->
                    <div>
                        <label for="apply_link" class="block text-sm font-medium text-gray-700 mb-1">Official Application Link <span class="text-red-500">*</span></label>
                        <input id="apply_link" name="apply_link" type="url" value="{{ old('apply_link', $scholarship->apply_link) }}" required class="form-input w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="https://...">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">General Description <span class="text-red-500">*</span></label>
                    <textarea id="description" name="description" rows="4" required class="form-textarea w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="Provide a brief overview of the scholarship...">{{ old('description', $scholarship->description) }}</textarea>
                </div>

                <!-- Requirements -->
                <div>
                    <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">Eligibility Requirements <span class="text-red-500">*</span></label>
                    <textarea id="requirements" name="requirements" rows="4" required class="form-textarea w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="List the requirements (e.g., GPA > 3.0, IELTS > 6.5)...">{{ old('requirements', $scholarship->requirements) }}</textarea>
                </div>

                <!-- Benefits -->
                <div>
                    <label for="benefits" class="block text-sm font-medium text-gray-700 mb-1">Scholarship Benefits <span class="text-red-500">*</span></label>
                    <textarea id="benefits" name="benefits" rows="4" required class="form-textarea w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="What does it cover? (e.g., Tuition, Living Allowance)...">{{ old('benefits', $scholarship->benefits) }}</textarea>
                </div>

                <div class="space-y-4 mt-6 p-6 bg-gray-50 rounded-xl border border-gray-200">
                    <h4 class="text-base font-bold text-gray-800 mb-4 border-b border-gray-200 pb-2">Academic & System Settings</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <!-- Min IELTS -->
                        <div>
                            <label for="min_ielts" class="block text-sm font-medium text-gray-700 mb-1">Min. IELTS Score</label>
                            <input id="min_ielts" name="min_ielts" type="number" step="0.5" min="0" max="9" value="{{ old('min_ielts', (float)$scholarship->min_ielts ?: '') }}" class="form-input w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="e.g., 6.5">
                            <p class="text-xs text-gray-500 mt-1">Used for Smart Matching with students.</p>
                        </div>
                        
                        <!-- Min. TOEFL -->
                        <div>
                            <label for="min_toefl" class="block text-sm font-medium text-gray-700 mb-1">Min. TOEFL ITP Score</label>
                            <input id="min_toefl" name="min_toefl" type="number" step="1" min="0" max="677" value="{{ old('min_toefl', $scholarship->min_toefl) }}" class="form-input w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" placeholder="e.g., 550">
                            <p class="text-xs text-gray-500 mt-1">Used for Smart Matching with students.</p>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200 space-y-3">
                        <!-- Requires Certification -->
                    <div class="flex items-center">
                        <input id="requires_certification" name="requires_certification" type="checkbox" value="1" {{ old('requires_certification', $scholarship->requires_certification) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="requires_certification" class="ml-2 block text-sm text-gray-900 font-medium">
                            Requires English Certification (IELTS, TOEFL, etc.)
                        </label>
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center">
                        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $scholarship->is_active) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900 font-medium">
                            Publish immediately (Visible to students)
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('admin.scholarships.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-lg text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition shadow-sm">
                    Update Scholarship
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

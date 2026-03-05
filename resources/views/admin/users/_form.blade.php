<div class="p-8 space-y-8">
    
    <!-- Section 1: Personal Information -->
    <div>
        <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Personal Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required
                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required
                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Number -->
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp / Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number ?? '') }}" placeholder="+62..."
                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('phone_number') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                @error('phone_number')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Profile Photo -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Profile Photo</label>
                <div class="flex items-center gap-4">
                    @if(isset($user) && $user->profile_photo)
                        <img src="{{ asset($user->profile_photo) }}" alt="Current Photo" class="w-12 h-12 object-cover rounded-full shadow-sm border border-gray-200">
                    @endif
                    <div class="flex-1">
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors @error('profile_photo') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Max size 2MB (JPEG, PNG, JPG, GIF)</p>
                    </div>
                </div>
                @error('profile_photo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
    
    <!-- Section 2: Authentication & Access -->
    <div>
        <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Authentication & Access</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Account Role <span class="text-red-500">*</span></label>
                <select id="role" name="role" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('role') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                    <option value="">-- Select Role --</option>
                    <option value="student" {{ old('role', $user->role ?? '') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="teacher" {{ old('role', $user->role ?? '') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="guest" {{ old('role', $user->role ?? '') == 'guest' ? 'selected' : '' }}>Guest</option>
                    <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Learning Mode -->
            <div>
                <label for="learning_mode" class="block text-sm font-medium text-gray-700 mb-1">Learning Mode <span class="text-red-500">*</span></label>
                <select id="learning_mode" name="learning_mode" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('learning_mode') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                    <option value="online" {{ old('learning_mode', $user->learning_mode ?? 'online') == 'online' ? 'selected' : '' }}>Online</option>
                    <option value="offline" {{ old('learning_mode', $user->learning_mode ?? '') == 'offline' ? 'selected' : '' }}>Offline</option>
                    <option value="both" {{ old('learning_mode', $user->learning_mode ?? '') == 'both' ? 'selected' : '' }}>Both (Hybrid/Flexible)</option>
                </select>
                @error('learning_mode')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Account Status <span class="text-red-500">*</span></label>
                <select id="status" name="status" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('status') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                    <option value="active" {{ old('status', $user->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $user->status ?? 'active') == 'inactive' ? 'selected' : '' }}>Inactive / Suspended</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Password 
                    @if(!isset($user))
                        <span class="text-red-500">*</span>
                    @endif
                </label>
                <input type="password" id="password" name="password" {{ !isset($user) ? 'required' : '' }}
                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('password') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                @if(isset($user))
                    <p class="mt-1 text-xs text-gray-500">Leave blank to keep the current password.</p>
                @endif
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Confirm Password
                    @if(!isset($user))
                        <span class="text-red-500">*</span>
                    @endif
                </label>
                <input type="password" id="password_confirmation" name="password_confirmation" {{ !isset($user) ? 'required' : '' }}
                       class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow">
            </div>
        </div>
    </div>
    
    <!-- Section 3: Academic Linking & Bio -->
    <div>
        <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Academic & Bio</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Assigned Program -->
            <div>
                <label for="program_id" class="block text-sm font-medium text-gray-700 mb-1">Enrolled Program</label>
                <select id="program_id" name="program_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('program_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                    <option value="">-- No Assigned Program --</option>
                    @foreach($programs ?? [] as $program)
                        <option value="{{ $program->id }}" {{ old('program_id', $user->program_id ?? '') == $program->id ? 'selected' : '' }}>
                            {{ $program->name }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500">Assign this user to a primary course program.</p>
                @error('program_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Assigned Teacher -->
            <div>
                <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-1">Assigned Teacher</label>
                <select id="teacher_id" name="teacher_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('teacher_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                    <option value="">-- No Assigned Teacher --</option>
                    @foreach($teachers ?? [] as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id', $user->teacher_id ?? '') == $teacher->id ? 'selected' : '' }}>
                            {{ $teacher->name }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500">Link a specific student to their responsible teacher.</p>
                @error('teacher_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Bio / Specialization -->
            <div class="md:col-span-2">
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio / Instructor Specialization</label>
                <textarea id="bio" name="bio" rows="4" placeholder="Brief biography or expertise for Teachers..."
                          class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('bio') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">{{ old('bio', $user->bio ?? '') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Provide any relevant background details.</p>
                @error('bio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>

<!-- Form Actions / Submit Button Footer -->
<div class="px-8 py-5 bg-gray-50/80 border-t border-gray-100 flex items-center justify-end gap-3 rounded-b-2xl">
    <a href="{{ route('users.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 bg-white hover:bg-gray-50 border border-gray-300 rounded-xl transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        Cancel
    </a>
    <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ $submitText }}
    </button>
</div>

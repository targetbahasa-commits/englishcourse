@php
    $rawPeriods = isset($classPeriods) && count($classPeriods) > 0 ? $classPeriods : \App\Models\ClassPeriod::with('program')->latest()->get();
    $formattedPeriods = $rawPeriods->map(function($p) {
        return [
            'id' => (string) $p->id,
            'name' => $p->name,
            'program_id' => (string) $p->program_id,
            'program_name' => $p->program?->name ?? 'Program',
            'learning_mode' => ucfirst($p->learning_mode ?? 'online'),
            'start_date_formatted' => $p->start_date ? \Carbon\Carbon::parse($p->start_date)->format('d M Y') : '',
        ];
    })->values();
@endphp

<div class="p-8 space-y-8" x-data="{
    role: '{{ old('role', request('role', $user->role ?? '')) }}',
    learningMode: '{{ old('learning_mode', $user->learning_mode ?? 'online') }}',
    programId: '{{ old('program_id', $user->program_id ?? '') }}',
    classPeriodId: '{{ old('class_period_id', $user->class_period_id ?? '') }}',
    campId: '{{ old('camp_id', $user->camp_id ?? '') }}',
    campsData: {{ Js::from($camps ?? []) }},
    classPeriodsData: {{ Js::from($formattedPeriods) }},
    showCamp: false,
    
    init() {
        this.updateVisibility();
        $watch('role', () => this.updateVisibility());
        $watch('learningMode', () => this.updateVisibility());
        $watch('campId', () => {
            if(!this.campId) document.getElementById('camp_room_id').value = '';
        });
    },
    updateVisibility() {
        if (this.role === 'teacher') {
            this.showCamp = true;
        } else if (this.role === 'student' && (this.learningMode === 'offline' || this.learningMode === 'both')) {
            this.showCamp = true;
        } else {
            this.showCamp = false;
            // Clear selections when hiding
            this.campId = '';
        }
        if (this.role !== 'student') {
            this.classPeriodId = '';
            let tSelect = document.getElementById('teacher_id');
            if (tSelect) tSelect.value = '';
        }
    },
    availableRooms() {
        if (!this.campId) return [];
        let camp = this.campsData.find(c => c.id == this.campId);
        return camp ? camp.rooms : [];
    },
    availableBatches() {
        if (!this.programId) return this.classPeriodsData;
        return this.classPeriodsData.filter(p => String(p.program_id) === String(this.programId));
    },
    formatBatchText(p) {
        return `${p.name} (${p.program_name} - ${p.learning_mode}${p.start_date_formatted ? ' | ' + p.start_date_formatted : ''})`;
    },
    onProgramChange() {
        let validIds = this.availableBatches().map(p => String(p.id));
        if (this.classPeriodId && !validIds.includes(String(this.classPeriodId))) {
            this.classPeriodId = '';
        }
    }
}">
    
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
                <select id="role" name="role" x-model="role" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('role') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                    <option value="">-- Select Role --</option>
                    <option value="student" {{ old('role', request('role', $user->role ?? '')) == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="teacher" {{ old('role', request('role', $user->role ?? '')) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="guest" {{ old('role', request('role', $user->role ?? '')) == 'guest' ? 'selected' : '' }}>Guest</option>
                    <option value="test-taker" {{ old('role', request('role', $user->role ?? '')) == 'test-taker' ? 'selected' : '' }}>Test Taker</option>
                    <option value="admin" {{ old('role', request('role', $user->role ?? '')) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="intern" {{ old('role', request('role', $user->role ?? '')) == 'intern' ? 'selected' : '' }}>Intern</option>
                </select>
                @error('role')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Learning Mode -->
            <div>
                <label for="learning_mode" class="block text-sm font-medium text-gray-700 mb-1">Learning Mode <span class="text-red-500">*</span></label>
                <select id="learning_mode" name="learning_mode" x-model="learningMode" required class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('learning_mode') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
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
            
            <!-- Password & Security Reset (Admin) -->
            <div class="md:col-span-2 bg-amber-50/50 p-4 rounded-xl border border-amber-200/80">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                    <h4 class="text-sm font-bold text-amber-900">
                        @if(isset($user)) Change Account Password / Reset Password @else Set Initial Password @endif
                    </h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            New Password 
                            @if(!isset($user))
                                <span class="text-red-500">*</span>
                            @endif
                        </label>
                        <input type="password" id="password" name="password" {{ !isset($user) ? 'required' : '' }} placeholder="{{ isset($user) ? 'Kosongkan jika tidak ingin diubah' : 'Minimal 6 karakter' }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 transition-shadow @error('password') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror text-sm">
                        @if(isset($user))
                            <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password user ini.</p>
                        @endif
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Confirm New Password
                            @if(!isset($user))
                                <span class="text-red-500">*</span>
                            @endif
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" {{ !isset($user) ? 'required' : '' }} placeholder="{{ isset($user) ? 'Ulangi password baru' : 'Ulangi password baru' }}"
                               class="w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 transition-shadow text-sm">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Section 3: Academic Linking & Bio -->
    <div>
        <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Academic & Bio</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Enrolled Programs (Support Multiple Programs) -->
            <div class="md:col-span-2 bg-blue-50/40 p-5 rounded-2xl border border-blue-100/80 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-sm font-bold text-gray-900" x-text="role === 'teacher' ? 'Teaching Programs / Program yang Diampu' : 'Enrolled Programs / Kursus Terdaftar'">
                            {{ (old('role', request('role', $user->role ?? '')) === 'teacher') ? 'Teaching Programs / Program yang Diampu' : 'Enrolled Programs / Kursus Terdaftar' }}
                        </label>
                        <p class="text-xs text-gray-500 mt-0.5" x-text="role === 'teacher' ? 'Pilih program atau mata kursus yang diampu oleh pengajar ini:' : 'Student dapat mengikuti lebih dari 1 program secara bersamaan. Centang program yang diambil:'">
                            {{ (old('role', request('role', $user->role ?? '')) === 'teacher') ? 'Pilih program atau mata kursus yang diampu oleh pengajar ini:' : 'Student dapat mengikuti lebih dari 1 program secara bersamaan. Centang program yang diambil:' }}
                        </p>
                    </div>
                    <span class="text-xs font-semibold text-blue-700 bg-blue-100 px-3 py-1 rounded-full border border-blue-200" x-text="role === 'teacher' ? 'Teacher Specialization' : 'Multi-Program Support'">
                        {{ (old('role', request('role', $user->role ?? '')) === 'teacher') ? 'Teacher Specialization' : 'Multi-Program Support' }}
                    </span>
                </div>

                @php
                    $userEnrolledIds = old('program_ids', isset($user) ? $user->enrolled_program_ids : []);
                    if (!is_array($userEnrolledIds)) $userEnrolledIds = [$userEnrolledIds];
                    if (old('program_id')) $userEnrolledIds[] = (int)old('program_id');
                    $userEnrolledIds = array_map('intval', array_unique(array_filter($userEnrolledIds)));
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($programs ?? [] as $program)
                        <label class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-xl hover:border-blue-400 hover:bg-blue-50/40 cursor-pointer transition-all shadow-sm">
                            <input type="checkbox" name="program_ids[]" value="{{ $program->id }}"
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                   {{ in_array((int)$program->id, $userEnrolledIds, true) ? 'checked' : '' }}>
                            <span class="text-sm font-semibold text-gray-800">{{ $program->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('program_ids')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Assigned Teacher (Student Only) -->
            <div x-show="role === 'student'" x-transition style="{{ (old('role', request('role', $user->role ?? '')) !== 'student') ? 'display: none;' : '' }}">
                <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-1">Assigned Teacher</label>
                <select id="teacher_id" name="teacher_id" :disabled="role !== 'student'" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('teacher_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
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

            <!-- Assigned Batch / Class Period (Student Only) -->
            <div x-show="role === 'student'" x-transition style="{{ (old('role', request('role', $user->role ?? '')) !== 'student') ? 'display: none;' : '' }}">
                <label for="class_period_id" class="block text-sm font-medium text-gray-700 mb-1">Batch Kelas / Class Period</label>
                <select id="class_period_id" name="class_period_id" x-model="classPeriodId" :disabled="role !== 'student'" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('class_period_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                    <option value="">-- No Assigned Batch --</option>
                    <template x-for="period in availableBatches()" :key="period.id">
                        <option :value="period.id" :selected="String(period.id) === String(classPeriodId)" x-text="formatBatchText(period)"></option>
                    </template>
                </select>
                <p class="mt-1 text-xs text-gray-500">Link student to a specific class period / batch taken from the class.</p>
                @error('class_period_id')
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
    
    <!-- Section 4: Camp Management (Conditional) -->
    <div x-show="showCamp" x-transition.opacity style="display: none;">
        <h3 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-2 mb-4">Camp Assignment</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Assigned Camp -->
            <div>
                <label for="camp_id" class="block text-sm font-medium text-gray-700 mb-1">Camp Location</label>
                <select id="camp_id" name="camp_id" x-model="campId" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('camp_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                    <option value="">-- Tidak tinggal di camp --</option>
                    <template x-for="camp in campsData" :key="camp.id">
                        <option :value="camp.id" x-text="camp.nama_camp + ' (' + camp.gender_khusus + ')'" :selected="camp.id == '{{ old('camp_id', $user->camp_id ?? '') }}'"></option>
                    </template>
                </select>
                <p class="mt-1 text-xs text-gray-500">Select the camp if they are staying in one.</p>
                @error('camp_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Assigned Room -->
            <div>
                <label for="camp_room_id" class="block text-sm font-medium text-gray-700 mb-1">Camp Room</label>
                <select id="camp_room_id" name="camp_room_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-shadow @error('camp_room_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                    <option value="">-- Select Room (Optional) --</option>
                    <template x-for="room in availableRooms()" :key="room.id">
                        <option :value="room.id" x-text="room.nama_kamar + ' (' + room.jumlah_penghuni + '/' + room.kapasitas_per_kamar + ')'" :selected="room.id == '{{ old('camp_room_id', $user->camp_room_id ?? '') }}'"></option>
                    </template>
                </select>
                <p class="mt-1 text-xs text-gray-500">Assign to a specific room if known.</p>
                @error('camp_room_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>

<!-- Form Actions / Submit Button Footer -->
<div class="px-8 py-5 bg-gray-50/80 border-t border-gray-100 flex items-center justify-end gap-3 rounded-b-2xl">
    @php
        $currentRole = old('role', request('role', $user->role ?? ''));
        $cancelRoute = route('users.index');
        if ($currentRole === 'student') {
            $cancelRoute = route('students.index');
        } elseif ($currentRole === 'teacher') {
            $cancelRoute = route('teachers.index');
        }
    @endphp
    <a href="{{ $cancelRoute }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 bg-white hover:bg-gray-50 border border-gray-300 rounded-xl transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        Cancel
    </a>
    <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        {{ $submitText }}
    </button>
</div>

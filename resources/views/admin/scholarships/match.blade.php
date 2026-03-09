@extends('layouts.admin')

@section('title', 'Smart Match – ' . $scholarship->title)

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-5xl mx-auto">

    <!-- Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Smart Match</h1>
            <p class="text-sm text-gray-500 mt-1">Eligible students for <span class="font-semibold text-indigo-600">{{ $scholarship->title }}</span></p>
        </div>
        <a href="{{ route('admin.scholarships.index') }}" class="shrink-0 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
            ← Back to List
        </a>
    </div>

    <!-- Scholarship criteria card -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 text-center">
            <p class="text-xs text-indigo-500 uppercase font-semibold tracking-wide mb-1">Min. IELTS</p>
            <p class="text-2xl font-bold text-indigo-700">{{ $scholarship->min_ielts ?? '—' }}</p>
        </div>
        <div class="bg-purple-50 border border-purple-100 rounded-xl p-4 text-center">
            <p class="text-xs text-purple-500 uppercase font-semibold tracking-wide mb-1">Min. TOEFL</p>
            <p class="text-2xl font-bold text-purple-700">{{ $scholarship->min_toefl ?? '—' }}</p>
        </div>
        <div class="bg-green-50 border border-green-100 rounded-xl p-4 text-center">
            <p class="text-xs text-green-500 uppercase font-semibold tracking-wide mb-1">Eligible Students</p>
            <p class="text-2xl font-bold text-green-700">{{ $matchedUsers->count() }}</p>
        </div>
        <div class="bg-orange-50 border border-orange-100 rounded-xl p-4 text-center">
            <p class="text-xs text-orange-500 uppercase font-semibold tracking-wide mb-1">Deadline</p>
            <p class="text-lg font-bold text-orange-700">{{ $scholarship->deadline ? $scholarship->deadline->format('d M Y') : '—' }}</p>
        </div>
    </div>

    @if($matchedUsers->isEmpty())
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h3 class="text-lg font-semibold text-gray-600 mb-1">No Eligible Students Found</h3>
            <p class="text-sm text-gray-400">
                @if(is_null($scholarship->min_ielts) && is_null($scholarship->min_toefl))
                    This scholarship has no minimum IELTS or TOEFL score set. Edit the scholarship to enable Smart Matching.
                @else
                    No students have achieved the required score in a free test yet.
                @endif
            </p>
        </div>
    @else
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800">Matched Students</h2>
                <!-- WhatsApp Broadcast hint -->
                <a href="{{ route('admin.outreach-messages.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-lg transition shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.117 1.533 5.847L.073 23.927l6.243-1.437A11.945 11.945 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.794 9.794 0 01-5.003-1.373l-.359-.213-3.707.853.88-3.605-.233-.37A9.784 9.784 0 012.182 12C2.182 6.57 6.57 2.182 12 2.182S21.818 6.57 21.818 12 17.43 21.818 12 21.818z"/></svg>
                    Create Outreach Message
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wide">
                        <tr>
                            <th class="px-6 py-3">Student</th>
                            <th class="px-6 py-3">Role / Program</th>
                            <th class="px-6 py-3">Best IELTS</th>
                            <th class="px-6 py-3">Best TOEFL</th>
                            <th class="px-6 py-3">Match Reason</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($matchedUsers as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <span class="capitalize font-medium">{{ $user->role }}</span>
                                @if($user->program)
                                    <span class="block text-xs text-gray-400">{{ $user->program->name ?? '' }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->best_ielts !== null)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                                        {{ $scholarship->min_ielts && $user->best_ielts >= $scholarship->min_ielts ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ number_format($user->best_ielts, 1) }}
                                    </span>
                                @else
                                    <span class="text-gray-300 text-sm">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->best_toefl !== null)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold
                                        {{ $scholarship->min_toefl && $user->best_toefl >= $scholarship->min_toefl ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $user->best_toefl }}
                                    </span>
                                @else
                                    <span class="text-gray-300 text-sm">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs">
                                @if($scholarship->min_ielts && $user->best_ielts >= $scholarship->min_ielts)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-50 text-green-700 rounded-md font-medium">
                                        ✓ IELTS ≥ {{ $scholarship->min_ielts }}
                                    </span>
                                @endif
                                @if($scholarship->min_toefl && $user->best_toefl >= $scholarship->min_toefl)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-purple-50 text-purple-700 rounded-md font-medium">
                                        ✓ TOEFL ≥ {{ $scholarship->min_toefl }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('students.show', $user->id) }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition">
                                    View Profile
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50 text-xs text-gray-400">
                Showing {{ $matchedUsers->count() }} eligible student(s) based on their best free test score.
            </div>
        </div>
    @endif
</div>
@endsection

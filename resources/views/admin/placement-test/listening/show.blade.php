@extends('layouts.admin')

@section('title', 'Tes Kompetensi - Listening - ' . $bank->title)

@section('content')
<div class="p-8">
    <div class="flex justify-between items-start mb-6">
        <div>
            <a href="{{ route('admin.placement-test.listening.index', ['package_id' => $bank->placement_test_package_id]) }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Listening Bank</a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight mt-1">{{ $bank->title }}</h2>
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800 mt-1">{{ $bank->level ?? '—' }}</span>
        </div>
        <div class="flex gap-2">
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-bank')" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500 text-sm">Edit Bank</button>
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-question')" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500 text-sm">+ Add Question</button>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r shadow-sm">
            <ul class="list-disc pl-5 text-sm">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm mb-6">
        @if($bank->audio_url)
            <audio controls src="{{ $bank->audio_url }}" class="w-full mb-4"></audio>
        @endif
        <h3 class="text-sm font-semibold text-gray-500 mb-2">Transcript</h3>
        <p class="text-gray-800 whitespace-pre-line">{{ $bank->transcript }}</p>
    </div>

    <h3 class="font-semibold text-lg text-gray-800 mb-3">Questions ({{ $bank->questions->count() }})</h3>
    <div class="space-y-4">
        @forelse ($bank->questions as $question)
            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start">
                    <p class="font-medium text-gray-900 mb-3">{{ $question->question_text }}</p>
                    <div class="flex gap-2 shrink-0 ml-4">
                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-question-{{ $question->id }}')" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Edit</button>
                        <form action="{{ route('admin.placement-test.listening.questions.destroy', [$bank, $question]) }}" method="POST" onsubmit="return confirm('Hapus soal ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium">Delete</button>
                        </form>
                    </div>
                </div>
                <ul class="space-y-1 text-sm">
                    @foreach (['A','B','C','D'] as $i => $letter)
                        <li class="flex gap-2 {{ $question->correct_answer === $letter ? 'text-green-700 font-semibold' : 'text-gray-600' }}">
                            <span>{{ $letter }}.</span> <span>{{ $question->options[$i] ?? '' }}</span>
                            @if($question->correct_answer === $letter)<span class="text-xs">(correct)</span>@endif
                        </li>
                    @endforeach
                </ul>
                @if($question->explanation)
                    <p class="text-xs text-gray-500 mt-2 italic">{{ $question->explanation }}</p>
                @endif
            </div>

            <x-modal name="edit-question-{{ $question->id }}" focusable>
                <div class="p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-4">Edit Question</h2>
                    <form method="POST" action="{{ route('admin.placement-test.listening.questions.update', [$bank, $question]) }}" class="space-y-4">
                        @csrf @method('PUT')
                        @include('admin.placement-test.reading._question-fields', ['question' => $question])
                        <div class="mt-6 flex justify-end gap-3">
                            <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Cancel</button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Save</button>
                        </div>
                    </form>
                </div>
            </x-modal>
        @empty
            <p class="text-gray-500 text-sm">Belum ada soal untuk bank ini.</p>
        @endforelse
    </div>
</div>
@endsection

@section('modals')
    <x-modal name="edit-bank" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Edit Listening Bank</h2>
            <form method="POST" action="{{ route('admin.placement-test.listening.update', $bank) }}" class="space-y-4" enctype="multipart/form-data">
                @csrf @method('PUT')
                @include('admin.placement-test.listening._bank-fields', ['bank' => $bank])
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Save</button>
                </div>
            </form>
        </div>
    </x-modal>

    <x-modal name="add-question" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Add Question</h2>
            <form method="POST" action="{{ route('admin.placement-test.listening.questions.store', $bank) }}" class="space-y-4">
                @csrf
                @include('admin.placement-test.reading._question-fields')
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Add Question</button>
                </div>
            </form>
        </div>
    </x-modal>
@endsection

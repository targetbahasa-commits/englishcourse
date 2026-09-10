@php
    $data = $data ?? [];
    $isLeaf = is_array($data)
        && array_key_exists('user_answer', $data)
        && (array_key_exists('is_correct', $data) || array_key_exists('score', $data));
@endphp

@if($isLeaf)
    <div class="border rounded-lg p-3 mb-2 {{ array_key_exists('is_correct', $data) ? (!empty($data['is_correct']) ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200') : 'bg-gray-50 border-gray-200' }}">
        <div class="text-xs text-gray-500 mb-1">Jawaban Siswa</div>
        <div class="font-medium text-gray-800 mb-2">{{ $data['user_answer'] !== '' ? $data['user_answer'] : '(kosong)' }}</div>

        @if(array_key_exists('correct_answer', $data) && $data['correct_answer'] !== '')
            <div class="text-xs text-gray-500 mb-1">Jawaban Benar</div>
            <div class="text-gray-700 mb-2">{{ $data['correct_answer'] }}</div>
        @endif

        @if(!empty($data['formatted_answer']))
            <div class="text-xs text-gray-500 mb-1">Perbandingan Kata</div>
            <div class="text-gray-700 mb-2 leading-relaxed word-diff">{!! $data['formatted_answer'] !!}</div>
        @endif

        <div class="flex items-center gap-2 flex-wrap">
            @if(array_key_exists('is_correct', $data))
                <span class="inline-block text-xs font-semibold px-2 py-0.5 rounded-full {{ !empty($data['is_correct']) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ !empty($data['is_correct']) ? 'Benar' : 'Salah' }}
                </span>
            @endif
            @if(array_key_exists('score', $data))
                <span class="inline-block text-xs font-semibold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700">
                    Skor: {{ $data['score'] }}
                </span>
            @endif
        </div>

        @if(!empty($data['feedback']))
            <div class="text-xs text-gray-500 italic mt-2">💬 {{ $data['feedback'] }}</div>
        @endif
    </div>
@elseif(is_array($data))
    @foreach($data as $key => $value)
        @if(is_array($value) && !empty($value))
            <div class="mb-4">
                @if(!is_int($key))
                    <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">
                        {{ ucwords(str_replace('_', ' ', preg_replace('/^meeting\d+_/', '', $key))) }}
                    </h4>
                @endif
                <div class="pl-3 border-l-2 border-gray-100">
                    @include('partials.grammar-writing-answers-tree', ['data' => $value])
                </div>
            </div>
        @endif
    @endforeach
@endif

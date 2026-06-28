<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 5</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .word-correct { color: #2ecc71; font-weight: bold; }
        .word-extra { color: #3498db; font-weight: bold; text-decoration: line-through; }
        .word-missing { color: #f1c40f; font-weight: bold; }
        .word-wrong { color: #e74c3c; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F3F4FF] p-8">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ $backRoute ?? route('assignments.grammar-writing') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm font-medium">
                &laquo; Kembali
            </a>
        </div>

        <h1 class="text-3xl font-bold text-center text-purple-600 mb-8">Gerund, To Infinitive, and Complex Ditransitive Verb (Pertemuan 5)</h1>
        <p class="text-center text-gray-600 mb-8">Translate kalimat berikut ke dalam bahasa Inggris.</p>

        @if($submitted)
            <div class="bg-purple-600 text-white p-6 rounded-xl text-center mb-8 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-purple-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('assignments.grammar-writing.meeting5.submit') }}">
            @csrf
            
            <!-- Section A -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-2xl font-bold text-gray-800">A. Gerund, To Infinitive, and Complex Ditransitive Verb</h3>
                </div>
                <div class="space-y-6">
                    @foreach($gerundInfinitiveComplex as $idx => $data)
                        <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-purple-500 shadow-sm">
                            <div class="flex items-center gap-2 mb-4">
                                <label class="font-bold text-lg text-gray-800">{{ $idx }}. {{ $data['id'] }}</label>
                            </div>
                            
                            <div class="mb-2">
                                <input type="text"
                                       name="userAnswers[gerundInfinitiveComplex][{{ $idx }}]"
                                       value="{{ old('userAnswers.gerundInfinitiveComplex.'.$idx, $userAnswers['gerundInfinitiveComplex'][$idx] ?? '') }}"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:border-purple-500 focus:ring-1 focus:ring-purple-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                       placeholder="Translate to English..."
                                       {{ $submitted ? 'readonly' : '' }}
                                       autocomplete="off">
                                
                                @if($submitted)
                                    @if($results['gerundInfinitiveComplex'][$idx]['score'] == 100)
                                        <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                            ✓ Sempurna!
                                        </div>
                                    @else
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                            <strong>Nilai: {{ $results['gerundInfinitiveComplex'][$idx]['score'] }}</strong><br>
                                            Koreksi: {!! $results['gerundInfinitiveComplex'][$idx]['formatted_answer'] !!}<br>
                                            <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section B -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-2xl font-bold text-gray-800">B. To Infinitive</h3>
                </div>
                <div class="space-y-6">
                    @foreach($toInfinitive as $idx => $data)
                        <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-blue-500 shadow-sm">
                            <div class="flex items-center gap-2 mb-4">
                                <label class="font-bold text-lg text-gray-800">{{ $idx }}. {{ $data['id'] }}</label>
                            </div>
                            
                            <div class="mb-2">
                                <input type="text"
                                       name="userAnswers[toInfinitive][{{ $idx }}]"
                                       value="{{ old('userAnswers.toInfinitive.'.$idx, $userAnswers['toInfinitive'][$idx] ?? '') }}"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                       placeholder="Translate to English..."
                                       {{ $submitted ? 'readonly' : '' }}
                                       autocomplete="off">
                                
                                @if($submitted)
                                    @if($results['toInfinitive'][$idx]['score'] == 100)
                                        <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                            ✓ Sempurna!
                                        </div>
                                    @else
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                            <strong>Nilai: {{ $results['toInfinitive'][$idx]['score'] }}</strong><br>
                                            Koreksi: {!! $results['toInfinitive'][$idx]['formatted_answer'] !!}<br>
                                            <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section C -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-2xl font-bold text-gray-800">C. Gerund</h3>
                </div>
                <div class="space-y-6">
                    @foreach($gerund as $idx => $data)
                        <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-green-500 shadow-sm">
                            <div class="flex items-center gap-2 mb-4">
                                <label class="font-bold text-lg text-gray-800">{{ $idx }}. {{ $data['id'] }}</label>
                            </div>
                            
                            <div class="mb-2">
                                <input type="text"
                                       name="userAnswers[gerund][{{ $idx }}]"
                                       value="{{ old('userAnswers.gerund.'.$idx, $userAnswers['gerund'][$idx] ?? '') }}"
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                       placeholder="Translate to English..."
                                       {{ $submitted ? 'readonly' : '' }}
                                       autocomplete="off">
                                
                                @if($submitted)
                                    @if($results['gerund'][$idx]['score'] == 100)
                                        <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                            ✓ Sempurna!
                                        </div>
                                    @else
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                            <strong>Nilai: {{ $results['gerund'][$idx]['score'] }}</strong><br>
                                            Koreksi: {!! $results['gerund'][$idx]['formatted_answer'] !!}<br>
                                            <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Section D: Paragraph Translation -->
            @if(isset($paragraph))
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-2xl font-bold text-gray-800">D. Paragraph Translation</h3>
                </div>
                <div class="bg-orange-50 border border-orange-200 p-4 rounded-lg mb-6">
                    <p class="text-sm text-orange-800"><strong>Petunjuk:</strong> Translate paragraf berikut ke dalam bahasa Inggris.</p>
                </div>
                
                <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-orange-500 shadow-sm">
                    <!-- Indonesian Paragraph -->
                    <div class="mb-4 p-4 bg-white rounded-lg border border-gray-200">
                        <p class="text-gray-800 leading-relaxed">{!! $paragraph['id'] !!}</p>
                    </div>

                    <!-- Translation Input -->
                    <div class="mb-2">
                        <textarea
                            name="userAnswers[paragraph]"
                            rows="8"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:border-orange-500 focus:ring-1 focus:ring-orange-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                            placeholder="Translate the paragraph to English..."
                            {{ $submitted ? 'readonly' : '' }}
                            autocomplete="off">{{ old('userAnswers.paragraph', $userAnswers['paragraph'] ?? '') }}</textarea>
                        
                        @if($submitted && isset($results['paragraph']))
                            @if($results['paragraph']['score'] == 100)
                                <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                    ✓ Sempurna!
                                </div>
                            @else
                                <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                    <strong>Nilai: {{ $results['paragraph']['score'] }}</strong><br>
                                    Koreksi: {!! $results['paragraph']['formatted_answer'] !!}<br>
                                    <small class="text-gray-600">Jawaban Benar: {{ $paragraph['en'] }}</small>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <div class="mt-8">
                @if(!$submitted)
                    <button type="submit" class="w-full py-4 bg-purple-600 text-white rounded-xl font-bold text-lg hover:bg-purple-700 transition-colors shadow-lg">
                        Cek Jawaban
                    </button>
                @endif
            </div>
        </form>
        
        @if($submitted)
            <form method="POST" action="{{ route('assignments.grammar-writing.meeting5.reset') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg">
                    Coba Lagi
                </button>
            </form>
        @endif
    </div>
</body>
</html>

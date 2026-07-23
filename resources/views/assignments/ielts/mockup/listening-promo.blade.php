<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IELTS Listening Promo Test - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .paper-shadow {
            box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        }
        .dotted-line {
            border-bottom: 1px dotted #000;
            display: inline-block;
            width: 150px;
        }
        /* Override standard input styles to look like mockup boxes */
        .promo-questions-container input[type="text"] {
            border: 1px solid black !important;
            border-bottom: 1px solid black !important;
            border-radius: 0;
            background-color: transparent;
        }
        /* Wrap the content in a black border if it's not already */
        .promo-questions-container > div {
            border: 1px solid black;
            padding: 1.5rem;
            margin-top: 1rem;
        }
        /* Make fonts smaller to look like paper */
        .promo-questions-container .text-lg { font-size: 15px; }
        .promo-questions-container .text-xl { font-size: 1.125rem; }
        .promo-questions-container .text-2xl { font-size: 1.25rem; font-weight: bold; text-align: center; }
        .promo-questions-container .text-3xl { font-size: 1.5rem; }
        .promo-questions-container table { font-size: 15px; border-color: black !important; border: 1px solid black; }
        .promo-questions-container table th, .promo-questions-container table td { border-bottom: 1px solid black; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('components.impersonation-banner')
    @include('components.cambridge-guest-signup-modal')
    <div class="flex min-h-screen">
        {{-- Main Content --}}
        <main class="flex-1 w-full max-w-6xl mx-auto p-8">
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                         <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">IELTS Listening Promo Test</h1>
                             <p class="text-gray-600 mt-1">Part {{ $meetingNumber }} - {{ $title }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto bg-white p-8 rounded-none shadow-md border border-gray-300">
                <form id="listeningForm" method="POST" action="{{ route('promo.test.ielts_listening.submit', ['meeting' => $meetingNumber, 'test' => $testId]) }}" class="w-full">
                    @csrf
                    
                    <div class="flex justify-center mb-6">
                        <h2 class="text-xl font-bold bg-black text-white px-4 py-1 uppercase tracking-wider">Listening</h2>
                    </div>

                    <div class="mb-8 promo-questions-container">
                        @if(view()->exists('assignments.ielts.listening.questions.part' . $meetingNumber . '.test' . $testId))
                            @include('assignments.ielts.listening.questions.part' . $meetingNumber . '.test' . $testId)
                        @else
                            <div class="flex flex-col items-center justify-center h-48 text-gray-400">
                                <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z"></path></svg>
                                <p class="text-lg font-medium">Question content not available yet.</p>
                                <p class="text-sm mt-2 text-center text-gray-500">The text for this specific test has not been added to the system.</p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-12 flex justify-center pb-32">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition-colors">
                            Submit Answers
                        </button>
                    </div>
                    @if(session('success'))
                        <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 font-medium text-center">
                            ✓ {{ session('success') }}
                        </div>
                    @endif
                </form>
            </div>
        </main>
    </div>

    @include('assignments.ielts.listening.partials.audio-player', ['set' => 'Part ' . $meetingNumber, 'section' => $section])

</body>
</html>

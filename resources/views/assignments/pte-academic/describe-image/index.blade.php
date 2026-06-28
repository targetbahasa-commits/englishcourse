<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PTE Academic - Describe Image Topics | {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50 flex flex-col min-h-screen">

    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-8">
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-gray-600 to-gray-800 rounded-2xl shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                                <a href="{{ route('assignments.pte-academic.speaking-writing.index') }}"
                                    class="hover:text-gray-700 transition">Speaking & Writing</a>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                                <span class="text-gray-600 font-medium">Describe Image</span>
                            </div>
                            <h1 class="text-3xl font-bold text-gray-800">50 Describe Image Topics</h1>
                            <p class="text-gray-600 mt-1">Pilih topik untuk memulai latihan speaking Describe Image
                                Anda.</p>
                        </div>
                    </div>
                    <a href="{{ route('assignments.pte-academic.speaking-writing.index') }}"
                        class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back
                    </a>
                </div>
            </div>


            {{-- Tips & Strategy Box --}}
            <div class="mb-8 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden"
                x-data="{ open: true }">
                <div class="p-6 cursor-pointer bg-gray-50 hover:bg-gray-100 transition flex justify-between items-center"
                    @click="open = !open">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Strategi & Tips Describe Image (DI)</h2>
                            <p class="text-gray-600 text-sm">Panduan dan template untuk memaksimalkan skor speaking
                                Anda.</p>
                        </div>
                    </div>
                    <svg class="w-6 h-6 text-gray-500 transform transition-transform" :class="{'rotate-180': open}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>

                <div x-show="open" x-collapse>
                    <div class="p-6 md:p-8 border-t border-gray-200">

                        <div class="mb-8">
                            <h3 class="font-bold text-gray-800 text-lg mb-2 flex items-center gap-2">
                                <span
                                    class="bg-gray-200 text-gray-600 w-6 h-6 rounded flex items-center justify-center text-xs">!</span>
                                Strategi Utama
                            </h3>
                            <p class="text-gray-600 bg-gray-50 p-4 rounded-xl border border-gray-200">Baca
                                <strong>hanya clue saja</strong>. Begitu timer mencapai <strong>detik ke-25 ke
                                    atas</strong>, langsung tutup dengan conclusion.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                            {{-- Opsi 1 --}}
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                    <h4 class="font-bold text-gray-800">OPSI 1 <span
                                            class="text-sm font-normal text-gray-500">(Umum/Gambar)</span></h4>
                                </div>
                                <div class="p-4 space-y-4 text-sm">
                                    <div
                                        class="text-gray-600 font-medium italic bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        "From the following picture I know information about [title]. According to the
                                        picture I notice with [clues]. furthermore it explains about [clues] moreover it
                                        has [clues] additionally it addresses about [clues], to sum up the picture shows
                                        good essential information of [title]."
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-600 uppercase mb-1">Example (Supermarket):
                                        </p>
                                        <p class="text-gray-600 leading-relaxed">
                                            "From the following picture I know information about <span
                                                class="font-semibold text-gray-800">Supermarket</span>. According to the
                                            picture I notice <span class="font-semibold text-gray-800">a lot of produce
                                                in this supermarket</span>. furthermore it explain about <span
                                                class="font-semibold text-gray-800">several sections</span> moreover it
                                            has <span class="font-semibold text-gray-800">fruit sections and vegetable
                                                sections with variety samples</span> additionally it addresses about
                                            <span class="font-semibold text-gray-800">peach, apple, plum, oranges,
                                                watermelon, cabbage, eggplant, lettuce, and others</span>, to sum up the
                                            picture shows good essential information of <span
                                                class="font-semibold text-gray-800">the best Supermarket in
                                                town</span>."
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Opsi 2 --}}
                            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                                <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                                    <h4 class="font-bold text-gray-800">OPSI 2 <span
                                            class="text-sm font-normal text-gray-500">(Chart/Graph)</span></h4>
                                </div>
                                <div class="p-4 space-y-4 text-sm">
                                    <div
                                        class="text-gray-600 font-medium italic bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        "From the following [chart/topic/graph/image] I know this information is about
                                        [title]. According to the graph, the percentage of [option items] from about
                                        [percentage] in [year] to about [percentage] in [year]. What's more, there are
                                        many percentages from the lowest until the highest. The lowest is [percentage]
                                        and the highest [percentage]. To sum up, the picture is about [title]."
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-600 uppercase mb-1">Example (Trend):</p>
                                        <p class="text-gray-600 leading-relaxed">
                                            "The provided chart illustrates the growth of <span
                                                class="font-semibold text-gray-800">Online purchase Trend</span>.
                                            According to the graph, the percentage of <span
                                                class="font-semibold text-gray-800">China</span> increased from about
                                            <span class="font-semibold text-gray-800">12%</span> in <span
                                                class="font-semibold text-gray-800">2016</span> to about <span
                                                class="font-semibold text-gray-800">23%</span> in <span
                                                class="font-semibold text-gray-800">2026</span>. What's more, there is a
                                            wide range of percentages from the lowest until the highest; the lowest is
                                            <span class="font-semibold text-gray-800">6%</span> recorded in the early
                                            stages, and the highest reaches <span
                                                class="font-semibold text-gray-800">38%</span> in the most recent
                                            projection. To sum up, the picture is about the significant upward <span
                                                class="font-semibold text-gray-800">trend of Online purchase
                                                Trend</span>."
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                                <span
                                    class="bg-gray-200 text-gray-600 w-6 h-6 rounded flex items-center justify-center text-xs">💡</span>
                                Tips Describe Image
                            </h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                {{-- Tip 1 & 2 --}}
                                <div class="space-y-4">
                                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">1. Manajemen Waktu (Time Management)
                                        </h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Durasi Ideal:</strong> Waktu terbaik untuk menjawab adalah
                                                sekitar <strong>35 - 38 detik</strong>.</li>
                                            <li><strong>Segera Klik "Next":</strong> Jangan menunggu sampai progress bar
                                                habis (40 detik). Segera klik tombol "Next" tepat setelah Anda
                                                mengucapkan kesimpulan untuk menghindari AI merekam keheningan (dead
                                                air) atau suara napas yang bisa merusak skor kelancaran.</li>
                                        </ul>
                                    </div>
                                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">2. Kelancaran & Intonasi</h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Kestabilan Suara:</strong> Jaga fluency (kelancaran) dan
                                                intonasi agar tetap stabil.</li>
                                            <li><strong>Haram Hukumnya Berjeda:</strong> Usahakan tidak membuat jeda
                                                yang tidak wajar (seperti umm, ahh, atau terdiam mikir) di tengah
                                                kalimat. Algoritma AI sangat sensitif terhadap keraguan (hesitation);
                                                skor akan turun drastis jika Anda terputus-putus.</li>
                                            <li><strong class="text-red-600">Jangan Koreksi Diri Sendiri
                                                    (PENTING):</strong> Jika Anda salah mengucapkan sebuah kata, JANGAN
                                                diulangi atau diperbaiki. Teruslah berbicara seolah-olah tidak terjadi
                                                kesalahan. Bagi AI PTE: <strong>Fluency > Content</strong>.</li>
                                            <li><strong>Tempo Bicara:</strong> Kelancaran bukan berarti berbicara
                                                secepat kilat. Bicaralah dengan tempo normal yang jelas artikulasinya.
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                {{-- Tip 3, 4, 5 --}}
                                <div class="space-y-4">
                                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">3. Variasi Kosakata & Transisi</h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Gunakan Conjunction Variatif:</strong> Gunakan kata hubung yang
                                                kaya untuk merangkai ide, seperti: <em>Firstly, Moreover, Additionally,
                                                    Furthermore, Subsequently, In contrast,</em> dan <em>Lastly/To
                                                    conclude</em>.</li>
                                            <li><strong>Hindari Repetisi:</strong> Jangan menggunakan conjunction atau
                                                kosakata yang sama berulang-ulang secara berdekatan (misal:
                                                terus-terusan memakai kata <em>And then, I can see, we can see, in front
                                                    of,</em> atau <em>Also</em>).</li>
                                        </ul>
                                    </div>
                                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">4. Pengembangan Konten Grafik</h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Analisis Komprehensif:</strong> Jangan hanya menyebutkan titik
                                                tertinggi dan terendah.</li>
                                            <li><strong>Jelaskan Pergerakan Data:</strong> Tambahkan penjelasan terkait:
                                                Tren kenaikan, Tren penurunan, Fluktuasi, atau Rata-rata/Kesetaraan
                                                data.</li>
                                        </ul>
                                    </div>
                                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                        <h4 class="font-bold text-slate-800 mb-2">5. Improvisasi & Darurat</h4>
                                        <ul class="list-disc list-outside ml-5 text-sm text-slate-600 space-y-1">
                                            <li><strong>Kembangkan Kalimat:</strong> Improvisasikan kalimat turunan
                                                untuk menunjang nilai Konten. Gabungkan beberapa elemen gambar menjadi
                                                satu kalimat utuh.</li>
                                            <li><strong>Taktik Jika Nge-blank:</strong> Jika di detik ke-20 Anda
                                                kehabisan ide, jangan diam! Sebutkan saja warna yang ada di gambar,
                                                bentuk objek, atau baca teks apa pun yang terlihat di layar untuk
                                                menjaga mulut tetap bergerak sampai mendekati detik ke-35.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- 50 Topics Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
                @for ($i = 1; $i <= 50; $i++)
                    <a href="{{ route('assignments.pte-academic.speaking-writing.describe-image.practice', ['id' => $i]) }}"
                        class="group relative bg-white border border-gray-100 rounded-2xl p-5 hover:border-gray-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-50 overflow-hidden flex flex-col">
                        {{-- Decorative background element --}}
                        <div
                            class="absolute -right-6 -top-6 w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500 ease-out">
                        </div>

                        <div class="relative flex items-center justify-between w-full mb-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-gray-500 to-gray-700 text-white rounded-xl shadow-md flex items-center justify-center font-bold text-lg group-hover:shadow-lg group-hover:from-gray-600 group-hover:to-gray-800 transition-all duration-50">
                                {{ $i }}
                            </div>
                            <div
                                class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-50 group-hover:bg-gray-100 group-hover:text-gray-600 transition-all duration-50">
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </div>
                        </div>

                        <div class="relative mt-auto">
                            <h3 class="text-gray-800 font-bold text-lg mb-1 group-hover:text-gray-600 transition-colors">
                                {{ $topics[$i]['title'] }}</h3>
                            <p class="text-gray-500 text-xs flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                    </path>
                                </svg>
                                Describe Image Practice
                            </p>
                        </div>
                    </a>
                @endfor
            </div>

        </main>
    </div>

</body>

</html>
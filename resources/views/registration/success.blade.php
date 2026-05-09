<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Berhasil – Target Bahasa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen flex items-center justify-center px-4 py-10">

<div class="max-w-md mx-auto text-center w-full">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Pendaftaran Berhasil!</h1>
        <p class="text-gray-500 text-sm mb-6 leading-relaxed">
            Silakan selesaikan pembayaran untuk mengamankan kursimu di kelas.
        </p>

        {{-- Rincian Biaya --}}
        @if($paymentDetails)
        @php $pd = $paymentDetails; @endphp
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-4 text-left mb-5 text-white shadow-lg shadow-blue-500/20">
            <div class="mb-3 border-b border-white/20 pb-3">
                <p class="text-xs font-semibold uppercase tracking-widest text-blue-100 mb-1">Rincian Pembayaran</p>
                <p class="text-base font-bold">{{ $pd['program_name'] }}</p>
                @if(!empty($pd['batch_name']))
                <p class="text-sm font-medium text-blue-200 mt-0.5">Batch: {{ $pd['batch_name'] }}</p>
                @endif
                @if(!empty($pd['batch_dates']))
                <p class="text-xs text-blue-200/80 mt-1 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ $pd['batch_dates'] }}
                </p>
                @endif
            </div>
            @if($pd['base_amount'] > 0)
                <div class="flex justify-between text-sm mb-1 opacity-90">
                    <span>Harga normal</span>
                    <span>Rp {{ number_format($pd['base_amount'], 0, ',', '.') }}</span>
                </div>
                @if($pd['discount_amount'] > 0)
                <div class="flex justify-between text-sm mb-2 text-yellow-300 font-semibold">
                    <span>🎉 Diskon pendaftar baru</span>
                    <span>– Rp {{ number_format($pd['discount_amount'], 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="border-t border-white/30 pt-2 mt-1 flex justify-between font-bold text-lg">
                    <span>Total Transfer</span>
                    <span>Rp {{ number_format($pd['net_amount'], 0, ',', '.') }}</span>
                </div>
            @else
                <p class="text-sm opacity-90 mt-1">Biaya program ini akan dikonfirmasi oleh tim kami via WhatsApp.</p>
            @endif
        </div>
        @endif

        {{-- Rekening Bank --}}
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 text-left mb-5">
            <h3 class="font-bold text-blue-800 text-sm mb-3 flex items-center gap-2 uppercase tracking-wide">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                Rekening Tujuan Transfer
            </h3>
            <div class="bg-white rounded-lg p-4 border border-blue-100">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="text-xs text-gray-500">Bank</p>
                        <p class="font-bold text-gray-900 text-lg">{{ setting('bank_name', 'BCA') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">a.n.</p>
                        <p class="font-semibold text-gray-700 text-sm">{{ setting('bank_account_holder', 'Target Bahasa Course') }}</p>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg px-4 py-3 flex items-center justify-between">
                    <p class="font-mono font-bold text-gray-900 text-xl tracking-widest">{{ setting('bank_account_number', '1234567890') }}</p>
                </div>
            </div>
        </div>

        {{-- Langkah --}}
        <div class="text-left mb-6">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Langkah selanjutnya:</p>
            <ol class="space-y-2">
                <li class="flex items-start gap-3 text-sm text-gray-700">
                    <span class="w-6 h-6 bg-blue-100 text-blue-700 font-bold rounded-full flex items-center justify-center flex-shrink-0 text-xs">1</span>
                    <span>Transfer sejumlah <strong>total di atas</strong> ke rekening {{ setting('bank_name', 'BCA') }}.</span>
                </li>
                <li class="flex items-start gap-3 text-sm text-gray-700">
                    <span class="w-6 h-6 bg-blue-100 text-blue-700 font-bold rounded-full flex items-center justify-center flex-shrink-0 text-xs">2</span>
                    <span><strong>Screenshot / foto</strong> bukti transfer dari aplikasi m-banking kamu.</span>
                </li>
                <li class="flex items-start gap-3 text-sm text-gray-700">
                    <span class="w-6 h-6 bg-blue-100 text-blue-700 font-bold rounded-full flex items-center justify-center flex-shrink-0 text-xs">3</span>
                    <span>Kirim bukti transfer ke nomor WhatsApp admin kami di bawah ini.</span>
                </li>
            </ol>
        </div>

        @php
            $adminWa = '6285706615607';
            if ($paymentDetails) {
                $netFormatted = 'Rp ' . number_format($paymentDetails['net_amount'], 0, ',', '.');
                $waText = "Halo Kak, saya baru saja mendaftar program *{$paymentDetails['program_name']}* dan sudah transfer sebesar *{$netFormatted}*. Berikut bukti transfernya:";
            } else {
                $waText = "Halo Kak, saya baru saja mendaftar dan sudah melakukan transfer. Berikut bukti transfernya:";
            }
            $waLink = "https://wa.me/{$adminWa}?text=" . rawurlencode($waText);
        @endphp

        <div class="flex flex-col gap-3">
            <a href="{{ $waLink }}" target="_blank"
               class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-xl transition text-sm flex items-center justify-center gap-2 shadow-md shadow-green-200">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.573-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.129.332.202.043.073.043.423-.101.827z"/>
                </svg>
                Kirim Bukti Transfer ke WhatsApp Admin
            </a>
            <p class="text-sm text-red-600 font-bold text-center mt-1">No. Admin: 0857-0661-5607</p>
        </div>
    </div>
    <p class="text-xs text-gray-400 mt-6">© {{ date('Y') }} Target Bahasa Course</p>
</div>

</body>
</html>

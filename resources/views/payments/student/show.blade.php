<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - Payment Detail</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-blue-50 to-cyan-50">
    @include('components.impersonation-banner')

    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-6 md:p-8">
            <div class="max-w-4xl mx-auto space-y-6">
                @if(session('success'))
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 text-emerald-700 px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="rounded-xl border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                        {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
                        <ul class="list-disc ml-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">Detail Pembayaran</h1>
                        <p class="text-sm text-slate-500 mt-1">{{ $payment->invoice_number }}</p>
                    </div>
                    <a href="{{ route('student.payments.index') }}" class="inline-flex items-center rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-100 px-4 py-2 text-sm font-semibold transition">
                        Kembali
                    </a>
                </div>

                <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                    @php
                        $netAmount = max(0, (int) $payment->amount - (int) $payment->discount_amount);
                        $appliedDiscount = $payment->meta['applied_discount'] ?? null;
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-700">
                        <div>
                            <p class="text-slate-500">Program</p>
                            <p class="font-semibold">{{ $payment->program->name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500">Total Tagihan</p>
                            <p class="font-semibold">Rp{{ number_format($netAmount, 0, ',', '.') }}</p>
                            @if((int) $payment->discount_amount > 0)
                                <p class="text-xs text-emerald-600 mt-1">Diskon: Rp{{ number_format((int) $payment->discount_amount, 0, ',', '.') }}{{ !empty($appliedDiscount['label']) ? ' (' . $appliedDiscount['label'] . ')' : '' }}</p>
                            @endif
                        </div>
                        <div>
                            <p class="text-slate-500">Metode</p>
                            <p class="font-semibold">{{ $payment->payment_channel === 'bank_transfer' ? 'Transfer Bank' : ($payment->payment_channel === 'qris' ? 'QRIS' : 'Cash') }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500">Status</p>
                            <p class="font-semibold uppercase">{{ $payment->status }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500">Batas Pembayaran</p>
                            <p class="font-semibold">{{ optional($payment->due_at)->format('d M Y H:i') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-slate-500">Catatan</p>
                            <p class="font-semibold">{{ $payment->notes ?: '-' }}</p>
                        </div>
                    </div>
                </section>

                @if(in_array($payment->payment_channel, ['bank_transfer', 'qris']))
                    @php
                        $instruction = $payment->meta['instructions'] ?? [];
                        $proofPath = $payment->proof_file ?? ($payment->meta['transfer_proof_path'] ?? null);
                    @endphp
                    <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-4">
                        @if($payment->payment_channel === 'bank_transfer')
                            <h2 class="text-lg font-semibold text-slate-800">Instruksi Transfer</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm mb-4">
                                <div class="rounded-xl bg-slate-50 border border-slate-200 p-3">
                                    <p class="text-slate-500">Bank</p>
                                    <p class="font-semibold text-slate-800">{{ $instruction['bank_name'] ?? 'BCA' }}</p>
                                </div>
                                <div class="rounded-xl bg-slate-50 border border-slate-200 p-3">
                                    <p class="text-slate-500">No. Rekening</p>
                                    <p class="font-semibold text-slate-800">{{ $instruction['account_number'] ?? '1234567890' }}</p>
                                </div>
                                <div class="rounded-xl bg-slate-50 border border-slate-200 p-3">
                                    <p class="text-slate-500">Atas Nama</p>
                                    <p class="font-semibold text-slate-800">{{ $instruction['account_holder'] ?? 'Target Bahasa Course' }}</p>
                                </div>
                            </div>
                        @else
                            <h2 class="text-lg font-semibold text-slate-800">Pembayaran QRIS</h2>
                            <div class="mb-4 text-center">
                                <p class="text-sm text-slate-600 mb-2">Silakan scan kode QRIS berikut menggunakan aplikasi m-banking atau e-wallet Anda:</p>
                                <img src="{{ asset('images/qris.jpeg') }}?v=1.1" alt="QRIS Code" class="w-64 max-w-full h-auto mx-auto border border-slate-200 rounded-lg shadow-sm">
                                <div class="mt-3">
                                    <a href="{{ asset('images/qris.jpeg') }}?v=1.1" download="qris_target_bahasa.jpeg" class="inline-flex items-center justify-center gap-2 text-sm font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200 px-4 py-2 rounded-xl transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Download QRIS
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($proofPath)
                            <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800">
                                Bukti transfer sudah diunggah.
                                <a href="{{ asset('storage/' . $proofPath) }}" target="_blank" class="font-semibold underline ml-1">Lihat file</a>
                            </div>
                        @endif

                        @if(in_array($payment->status, ['pending', 'waiting_verification']))
                            <form method="POST" action="{{ route('student.payments.upload-proof', $payment) }}" enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                <div>
                                    <label for="proof_file" class="block text-sm font-medium text-slate-700 mb-1">Upload Bukti Transfer</label>
                                    <input id="proof_file" type="file" name="proof_file" accept=".jpg,.jpeg,.png,.pdf" required class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-white hover:file:bg-blue-700">
                                </div>
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-slate-700 mb-1">Catatan (Opsional)</label>
                                    <textarea id="notes" name="notes" rows="2" class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: transfer via m-banking"></textarea>
                                </div>
                                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 transition w-full md:w-auto">
                                    Kirim Bukti Transfer
                                </button>
                                
                                @php
                                    $waNumber = setting('support_phone') ?: '6281234567890';
                                    $waMessage = urlencode("Halo Admin Target Bahasa, saya ingin mengirimkan bukti pembayaran untuk Invoice: {$payment->invoice_number}.");
                                @endphp
                                <a href="https://wa.me/{{ $waNumber }}?text={{ $waMessage }}" target="_blank" class="inline-flex items-center justify-center rounded-xl bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 transition w-full md:w-auto md:ml-3 mt-3 md:mt-0">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.082 21.157c-1.551 0-3.053-.412-4.38-1.196l-4.945 1.306 1.325-4.815c-.86-1.378-1.314-2.973-1.314-4.636 0-4.869 3.96-8.829 8.829-8.829 4.869 0 8.829 3.96 8.829 8.829s-3.96 8.829-8.829 8.829z"/></svg>
                                    Kirim Bukti via WhatsApp
                                </a>
                            </form>
                        @endif
                    </section>
                @endif

                @if($payment->payment_channel === 'cash')
                    <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 text-sm text-slate-700">
                        <p class="font-semibold">Pembayaran Cash</p>
                        <p class="mt-1">Silakan datang ke kantor untuk pembayaran cash. Admin akan mengubah status invoice setelah pembayaran diterima.</p>
                    </section>
                @endif
            </div>
        </main>
    </div>
</body>

</html>

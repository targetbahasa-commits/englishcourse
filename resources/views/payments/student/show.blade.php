<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - Payment Detail</title>
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
                            <p class="font-semibold">{{ $payment->payment_channel === 'bank_transfer' ? 'Transfer Bank' : 'Cash' }}</p>
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

                @if($payment->payment_channel === 'bank_transfer')
                    @php
                        $instruction = $payment->meta['instructions'] ?? [];
                        $proofPath = $payment->meta['transfer_proof_path'] ?? null;
                    @endphp
                    <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 space-y-4">
                        <h2 class="text-lg font-semibold text-slate-800">Instruksi Transfer</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
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

                        @if($proofPath)
                            <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800">
                                Bukti transfer sudah diunggah.
                                <a href="{{ asset('storage/' . $proofPath) }}" target="_blank" class="font-semibold underline ml-1">Lihat file</a>
                            </div>
                        @endif

                        @if($payment->status === 'pending')
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
                                <button type="submit" class="inline-flex items-center rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 transition">
                                    Kirim Bukti Transfer
                                </button>
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

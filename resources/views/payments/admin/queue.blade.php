<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - Payment Verifications</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-blue-50 to-cyan-50">
    @include('components.impersonation-banner')

    <div class="flex min-h-screen">
        @include('components.sidebar-admin')

        <main class="flex-1 md:ml-64 p-6 md:p-8">
            <div class="max-w-7xl mx-auto space-y-6">
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

                <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                    <h1 class="text-2xl font-bold text-slate-800">Verifikasi Pembayaran</h1>
                    <p class="text-sm text-slate-500 mt-1">Review invoice pending, approve untuk aktivasi enrollment, atau reject dengan alasan.</p>
                </section>




                <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                    <form method="GET" action="{{ route('admin.payments.queue') }}" class="flex gap-3 items-end">
                        <div class="flex-1">
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Cari Invoice / Student</label>
                            <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="INV atau nama/email" class="w-full rounded-lg border-slate-300 text-sm">
                        </div>
                        <div class="w-48">
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Status</label>
                            <select name="status" class="w-full rounded-lg border-slate-300 text-sm">
                                <option value="all" @selected($filters['status'] === 'all')>All</option>
                                <option value="pending" @selected($filters['status'] === 'pending')>Pending</option>
                                <option value="waiting_verification" @selected($filters['status'] === 'waiting_verification')>Waiting Verification</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="inline-flex items-center rounded-lg bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 text-sm font-semibold transition">Cari</button>
                            <a href="{{ route('admin.payments.queue') }}" class="inline-flex items-center rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 px-4 py-2 text-sm font-semibold transition">Reset</a>
                        </div>
                    </form>
                </section>
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Payment Queue</h2>

                    <div class="space-y-4">
                        @forelse($paymentQueue as $payment)
                            @php
                                $leadMapKey = $payment->user_id . '_' . $payment->program_id;
                                $paymentLead = $leadMap[$leadMapKey] ?? null;
                                $proofPath = $payment->meta['transfer_proof_path'] ?? null;
                                $netAmount = max(0, (int) $payment->amount - (int) $payment->discount_amount);
                                $paidAmount = $payment->paid_amount !== null ? (int) $payment->paid_amount : null;
                                $varianceAmount = $paidAmount !== null ? $paidAmount - $netAmount : null;
                                $overrideUsed = (bool) ($payment->meta['override_underpayment'] ?? false);
                                $settlementType = null;

                                if ($paidAmount !== null) {
                                    if ($paidAmount < $netAmount) {
                                        $settlementType = 'underpaid';
                                    } elseif ($paidAmount > $netAmount) {
                                        $settlementType = 'overpaid';
                                    } else {
                                        $settlementType = 'exact';
                                    }
                                }
                            @endphp
                            <div class="rounded-xl border border-slate-200 p-4">
                                <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 text-sm text-slate-700">
                                    <div>
                                        <p class="text-slate-500">Invoice</p>
                                        <p class="font-semibold">{{ $payment->invoice_number }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-500">Student</p>
                                        <p class="font-semibold">{{ $payment->user->name ?? '-' }}</p>
                                        <p class="text-xs text-slate-500">{{ $payment->user->email ?? '-' }}</p>
                                        @if($paymentLead)
                                            <a href="{{ route('admin.registration-leads.show', $paymentLead) }}"
                                               class="mt-1 inline-flex items-center gap-1 text-xs text-indigo-600 hover:underline">
                                                📋 Lihat Registration Lead →
                                            </a>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-slate-500">Program</p>
                                        <p class="font-semibold">{{ $payment->program->name ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-500">Amount</p>
                                        <p class="font-semibold">Rp{{ number_format($netAmount, 0, ',', '.') }}</p>
                                        @if((int) $payment->discount_amount > 0)
                                            <p class="text-xs text-emerald-600">Diskon Rp{{ number_format((int) $payment->discount_amount, 0, ',', '.') }}</p>
                                        @endif
                                        @if($varianceAmount !== null)
                                            <p class="text-xs {{ $varianceAmount < 0 ? 'text-rose-600' : ($varianceAmount > 0 ? 'text-sky-600' : 'text-slate-500') }}">
                                                Selisih: {{ $varianceAmount > 0 ? '+' : '' }}Rp{{ number_format($varianceAmount, 0, ',', '.') }}
                                            </p>
                                        @endif
                                        <p class="text-xs text-slate-500">{{ $payment->payment_channel === 'bank_transfer' ? 'Transfer Bank' : ($payment->payment_channel === 'qris' ? 'QRIS' : 'Cash') }}</p>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    @if($payment->status === 'paid')
                                        <span class="inline-flex items-center rounded-full bg-emerald-100 text-emerald-700 px-2.5 py-1 text-xs font-semibold uppercase">Paid</span>
                                    @elseif($payment->status === 'failed')
                                        <span class="inline-flex items-center rounded-full bg-red-100 text-red-700 px-2.5 py-1 text-xs font-semibold uppercase">Failed</span>
                                    @elseif($payment->status === 'cancelled')
                                        <span class="inline-flex items-center rounded-full bg-slate-100 text-slate-700 px-2.5 py-1 text-xs font-semibold uppercase">Cancelled</span>
                                    @elseif($payment->status === 'expired')
                                        <span class="inline-flex items-center rounded-full bg-slate-100 text-slate-700 px-2.5 py-1 text-xs font-semibold uppercase">Expired</span>
                                    @elseif($payment->status === 'refunded')
                                        <span class="inline-flex items-center rounded-full bg-blue-100 text-blue-700 px-2.5 py-1 text-xs font-semibold uppercase">Refunded</span>
                                    @elseif($payment->status === 'pending')
                                        @if(!empty($proofPath))
                                            <span class="inline-flex items-center rounded-full bg-orange-100 text-orange-700 px-2.5 py-1 text-xs font-semibold uppercase">Pending Verification</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-amber-100 text-amber-700 px-2.5 py-1 text-xs font-semibold uppercase">Pending Payment</span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-slate-100 text-slate-700 px-2.5 py-1 text-xs font-semibold uppercase">{{ $payment->status }}</span>
                                    @endif

                                    @if($settlementType === 'underpaid')
                                        <span class="inline-flex items-center rounded-full bg-rose-100 text-rose-700 px-2.5 py-1 text-xs font-semibold uppercase ml-1">Underpaid</span>
                                    @elseif($settlementType === 'overpaid')
                                        <span class="inline-flex items-center rounded-full bg-sky-100 text-sky-700 px-2.5 py-1 text-xs font-semibold uppercase ml-1">Overpaid</span>
                                    @elseif($settlementType === 'exact')
                                        <span class="inline-flex items-center rounded-full bg-emerald-100 text-emerald-700 px-2.5 py-1 text-xs font-semibold uppercase ml-1">Exact</span>
                                    @endif

                                    @if($overrideUsed)
                                        <span class="inline-flex items-center rounded-full bg-fuchsia-100 text-fuchsia-700 px-2.5 py-1 text-xs font-semibold uppercase ml-1">Override Used</span>
                                    @endif
                                </div>

                                @if($proofPath)
                                    <div class="mt-3 text-sm">
                                        <a href="{{ asset('storage/' . $proofPath) }}" target="_blank" class="inline-flex items-center rounded-lg bg-blue-100 text-blue-700 px-3 py-1.5 font-semibold hover:bg-blue-200 transition">
                                            Lihat Bukti Transfer
                                        </a>
                                    </div>
                                @endif

                                @if($overrideUsed && !empty($payment->meta['override_underpayment_reason']))
                                    <p class="mt-3 text-xs text-fuchsia-700 bg-fuchsia-50 border border-fuchsia-200 rounded-lg px-3 py-2">
                                        Alasan override: {{ $payment->meta['override_underpayment_reason'] }}
                                    </p>
                                @endif
                                @if(!empty($payment->meta['receiver_name']))
                                    <p class="mt-3 text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg px-3 py-2">
                                        Diterima oleh: {{ $payment->meta['receiver_name'] }}
                                    </p>
                                @endif

                                @if($payment->status === 'pending')
                                    <div class="mt-4 grid grid-cols-1 lg:grid-cols-2 gap-3">
                                        <form method="POST" action="{{ route('admin.payments.approve', $payment) }}" class="rounded-xl bg-emerald-50 border border-emerald-200 p-3 space-y-2" x-data="{ override: false, paidAmount: {{ (int) ($payment->amount - $payment->discount_amount) }}, netAmount: {{ (int) ($payment->amount - $payment->discount_amount) }} }">
                                            @csrf
                                            <label class="block text-xs font-semibold text-emerald-800">Approve</label>
                                            <input type="number" min="0" name="paid_amount" value="{{ (int) ($payment->amount - $payment->discount_amount) }}" x-model.number="paidAmount" class="w-full rounded-lg border-emerald-200 text-sm" placeholder="Paid amount">
                                            <p class="text-xs text-emerald-700">Minimal normal: Rp{{ number_format((int) ($payment->amount - $payment->discount_amount), 0, ',', '.') }}</p>
                                            <label class="inline-flex items-center gap-2 text-xs text-emerald-800">
                                                <input type="checkbox" name="override_underpayment" value="1" x-model="override" class="rounded border-emerald-300">
                                                Izinkan paid amount di bawah tagihan
                                            </label>
                                            <p x-cloak x-show="override && paidAmount < netAmount" class="text-xs text-rose-700">Override underpayment aktif. Alasan wajib diisi.</p>
                                            <input type="text" name="notes" x-bind:required="override && paidAmount < netAmount" class="w-full rounded-lg border-emerald-200 text-sm" placeholder="Catatan admin (opsional, wajib jika underpayment override)">
                                            @if($payment->payment_channel === 'cash')
                                                <input type="text" name="receiver_name" required class="w-full rounded-lg border-emerald-200 text-sm" placeholder="Nama admin penerima cash (wajib)">
                                            @endif
                                            
                                            @php
                                                $availablePeriods = $activeClassPeriods->where('program_id', $payment->program_id);
                                            @endphp
                                            <label class="block text-xs font-semibold text-emerald-800 mt-2">Periode Kelas / Batch</label>
                                            <select name="class_period_id" required class="w-full rounded-lg border-emerald-200 text-sm">
                                                <option value="">Pilih periode kelas (wajib)...</option>
                                                @foreach($availablePeriods as $period)
                                                    <option value="{{ $period->id }}" @selected(isset($payment->user->class_period_id) && $payment->user->class_period_id == $period->id)>{{ $period->name }} ({{ ucfirst($period->status) }})</option>
                                                @endforeach
                                            </select>

                                            <button type="submit" class="inline-flex items-center rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 text-sm font-semibold transition mt-2">Approve & Activate</button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="rounded-xl bg-red-50 border border-red-200 p-3 space-y-2">
                                            @csrf
                                            <label class="block text-xs font-semibold text-red-800">Reject</label>
                                            <input type="text" name="notes" required class="w-full rounded-lg border-red-200 text-sm" placeholder="Alasan penolakan (wajib)">
                                            <button type="submit" class="inline-flex items-center rounded-lg bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 text-sm font-semibold transition">Reject</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="rounded-xl border border-dashed border-slate-300 p-6 text-center text-slate-500 text-sm">
                                Tidak ada data pembayaran untuk filter ini.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $paymentQueue->links() }}
                    </div>
                </section>

            </div>
        </main>
    </div>

</html>

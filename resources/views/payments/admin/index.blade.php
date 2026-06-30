<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - Payment Verifications</title>
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
                    <form method="GET" action="{{ route('admin.payments.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Cari Invoice / Student</label>
                            <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="INV atau nama/email" class="w-full rounded-lg border-slate-300 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Status</label>
                            <select name="status" class="w-full rounded-lg border-slate-300 text-sm">
                                <option value="all" @selected($filters['status'] === 'all')>All</option>
                                <option value="pending" @selected($filters['status'] === 'pending')>Pending</option>
                                <option value="paid" @selected($filters['status'] === 'paid')>Paid</option>
                                <option value="failed" @selected($filters['status'] === 'failed')>Failed</option>
                                <option value="cancelled" @selected($filters['status'] === 'cancelled')>Cancelled</option>
                                <option value="expired" @selected($filters['status'] === 'expired')>Expired</option>
                                <option value="refunded" @selected($filters['status'] === 'refunded')>Refunded</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Channel</label>
                            <select name="channel" class="w-full rounded-lg border-slate-300 text-sm">
                                <option value="all" @selected($filters['channel'] === 'all')>All</option>
                                <option value="bank_transfer" @selected($filters['channel'] === 'bank_transfer')>Transfer Bank</option>
                                <option value="cash" @selected($filters['channel'] === 'cash')>Cash</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Bukti Transfer</label>
                            <select name="proof" class="w-full rounded-lg border-slate-300 text-sm">
                                <option value="all" @selected($filters['proof'] === 'all')>All</option>
                                <option value="yes" @selected($filters['proof'] === 'yes')>Ada</option>
                                <option value="no" @selected($filters['proof'] === 'no')>Belum ada</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Settlement</label>
                            <select name="settlement" class="w-full rounded-lg border-slate-300 text-sm">
                                <option value="all" @selected($filters['settlement'] === 'all')>All</option>
                                <option value="underpaid" @selected($filters['settlement'] === 'underpaid')>Underpaid</option>
                                <option value="exact" @selected($filters['settlement'] === 'exact')>Exact</option>
                                <option value="overpaid" @selected($filters['settlement'] === 'overpaid')>Overpaid</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Override</label>
                            <select name="override" class="w-full rounded-lg border-slate-300 text-sm">
                                <option value="all" @selected($filters['override'] === 'all')>All</option>
                                <option value="yes" @selected($filters['override'] === 'yes')>Override Used</option>
                                <option value="no" @selected($filters['override'] === 'no')>No Override</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Selisih</label>
                            <select name="variance" class="w-full rounded-lg border-slate-300 text-sm">
                                <option value="all" @selected($filters['variance'] === 'all')>All</option>
                                <option value="negative" @selected($filters['variance'] === 'negative')>Negatif</option>
                                <option value="zero" @selected($filters['variance'] === 'zero')>Nol</option>
                                <option value="positive" @selected($filters['variance'] === 'positive')>Positif</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Dari Tanggal</label>
                            <input type="date" name="date_from" value="{{ $filters['date_from'] }}" class="w-full rounded-lg border-slate-300 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Sampai Tanggal</label>
                            <input type="date" name="date_to" value="{{ $filters['date_to'] }}" class="w-full rounded-lg border-slate-300 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1">Threshold Underpaid %</label>
                            <input type="number" name="trend_threshold" min="1" max="100" step="0.1" value="{{ $filters['trend_threshold'] }}" class="w-full rounded-lg border-slate-300 text-sm" placeholder="10">
                        </div>
                        <div class="md:col-span-6 flex items-center gap-2">
                            <button type="submit" class="inline-flex items-center rounded-lg bg-slate-900 hover:bg-slate-800 text-white px-3 py-2 text-sm font-semibold transition">Apply Filter</button>
                            <button type="submit" formaction="{{ route('admin.payments.export-csv') }}" formmethod="GET" class="inline-flex items-center rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 text-sm font-semibold transition">Export CSV</button>
                            <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 px-3 py-2 text-sm font-semibold transition">Reset</a>
                        </div>
                    </form>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('admin.payments.index', array_merge($filters, ['status' => 'pending', 'settlement' => 'all', 'override' => 'all', 'variance' => 'all'])) }}" class="inline-flex items-center rounded-full border border-indigo-300 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 px-3 py-1.5 text-xs font-semibold transition">
                            Preset: Daily Pending
                        </a>
                        <a href="{{ route('admin.payments.index', array_merge($filters, ['status' => 'all', 'settlement' => 'underpaid', 'override' => 'all', 'variance' => 'negative'])) }}" class="inline-flex items-center rounded-full border border-amber-300 bg-amber-50 text-amber-700 hover:bg-amber-100 px-3 py-1.5 text-xs font-semibold transition">
                            Preset: Audit Underpaid
                        </a>
                        <a href="{{ route('admin.payments.index', array_merge($filters, ['status' => 'all', 'settlement' => 'all', 'override' => 'yes', 'variance' => 'negative'])) }}" class="inline-flex items-center rounded-full border border-fuchsia-300 bg-fuchsia-50 text-fuchsia-700 hover:bg-fuchsia-100 px-3 py-1.5 text-xs font-semibold transition">
                            Preset: Override Risk
                        </a>
                    </div>

                    <div class="mt-3 flex flex-wrap gap-2">
                        <a href="{{ route('admin.payments.index', array_merge($filters, ['status' => 'all', 'settlement' => 'all', 'override' => 'all', 'variance' => 'all'])) }}" class="inline-flex items-center rounded-full border border-slate-300 bg-white text-slate-700 hover:bg-slate-100 px-3 py-1.5 text-xs font-semibold transition">
                            Clear Quick Filters
                        </a>
                        <a href="{{ route('admin.payments.index', array_merge($filters, ['settlement' => 'underpaid'])) }}" class="inline-flex items-center rounded-full border px-3 py-1.5 text-xs font-semibold transition {{ $filters['settlement'] === 'underpaid' ? 'border-rose-300 bg-rose-100 text-rose-700' : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-100' }}">
                            Underpaid
                        </a>
                        <a href="{{ route('admin.payments.index', array_merge($filters, ['override' => 'yes'])) }}" class="inline-flex items-center rounded-full border px-3 py-1.5 text-xs font-semibold transition {{ $filters['override'] === 'yes' ? 'border-fuchsia-300 bg-fuchsia-100 text-fuchsia-700' : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-100' }}">
                            Override Used
                        </a>
                        <a href="{{ route('admin.payments.index', array_merge($filters, ['variance' => 'negative'])) }}" class="inline-flex items-center rounded-full border px-3 py-1.5 text-xs font-semibold transition {{ $filters['variance'] === 'negative' ? 'border-amber-300 bg-amber-100 text-amber-700' : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-100' }}">
                            Selisih Negatif
                        </a>
                        <a href="{{ route('admin.payments.index', array_merge($filters, ['status' => 'pending'])) }}" class="inline-flex items-center rounded-full border px-3 py-1.5 text-xs font-semibold transition {{ $filters['status'] === 'pending' ? 'border-blue-300 bg-blue-100 text-blue-700' : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-100' }}">
                            Pending
                        </a>
                    </div>
                </section>

                <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                    @php
                        $threshold = (float) $trendAlert['threshold'];
                        $criticalDays = collect($trendStats)->filter(function ($trend) use ($threshold) {
                            return (float) $trend['underpaid_percentage'] > ($threshold * 1.5);
                        })->count();
                        $warningDays = collect($trendStats)->filter(function ($trend) use ($threshold) {
                            $underpaid = (float) $trend['underpaid_percentage'];
                            return $underpaid > $threshold && $underpaid <= ($threshold * 1.5);
                        })->count();
                        $safeDays = max(0, count($trendStats) - $criticalDays - $warningDays);
                    @endphp

                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-slate-800">Trend 7 Hari</h2>
                        <div class="flex items-center gap-2">
                            <p class="text-xs text-slate-500">Mengikuti filter aktif (kecuali rentang tanggal).</p>
                            <button id="trend-alert-restore" type="button" class="hidden items-center rounded-lg border border-slate-300 bg-white hover:bg-slate-100 text-slate-700 px-3 py-1.5 text-xs font-semibold transition">
                                Show Alert Again
                            </button>
                            <label class="inline-flex items-center gap-1 rounded-lg border border-slate-300 bg-white px-2 py-1 text-xs text-slate-700">
                                <input id="trend-autofocus-toggle" type="checkbox" class="rounded border-slate-300 text-slate-900 focus:ring-slate-500" checked>
                                Auto-focus
                            </label>
                            <a href="{{ route('admin.payments.export-trend-csv', $filters) }}" class="inline-flex items-center rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 text-xs font-semibold transition">
                                Export Trend CSV
                            </a>
                        </div>
                    </div>

                    @if($trendAlert['is_triggered'])
                        @php
                            $alertSignature = md5((string) $trendAlert['threshold'] . '|' . (string) $trendAlert['peak_underpaid_percentage'] . '|' . (string) $trendAlert['severity']);
                        @endphp
                        <div id="trend-alert-banner" data-alert-signature="{{ $alertSignature }}" class="mb-4 rounded-xl border px-4 py-3 text-sm {{ $trendAlert['severity'] === 'critical' ? 'border-red-200 bg-red-50 text-red-700' : 'border-rose-200 bg-rose-50 text-rose-700' }}">
                            <div class="flex items-start justify-between gap-3">
                                <p>
                                    Alert {{ $trendAlert['severity'] === 'critical' ? 'Kritis' : 'Peringatan' }}: puncak Underpaid % 7 hari terakhir mencapai {{ number_format((float) $trendAlert['peak_underpaid_percentage'], 2, ',', '.') }}%, melewati threshold {{ number_format((float) $trendAlert['threshold'], 2, ',', '.') }}%.
                                </p>
                                <button id="trend-alert-dismiss" type="button" class="shrink-0 inline-flex items-center rounded-md border border-current/30 px-2 py-1 text-xs font-semibold hover:bg-white/40 transition">
                                    Dismiss
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="mb-4 flex flex-wrap gap-2 text-xs font-semibold">
                        <span class="inline-flex items-center rounded-full bg-emerald-100 text-emerald-700 px-2.5 py-1">Aman: {{ $safeDays }} hari</span>
                        <span class="inline-flex items-center rounded-full bg-amber-100 text-amber-700 px-2.5 py-1">Peringatan: {{ $warningDays }} hari</span>
                        <span class="inline-flex items-center rounded-full bg-red-100 text-red-700 px-2.5 py-1">Kritis: {{ $criticalDays }} hari</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-slate-500 border-b border-slate-200">
                                    <th class="py-2 pr-4">Tanggal</th>
                                    <th class="py-2 pr-4">Invoices</th>
                                    <th class="py-2 pr-4">Paid Coverage %</th>
                                    <th class="py-2 pr-4">Underpaid %</th>
                                    <th class="py-2 pr-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trendStats as $trend)
                                    @php
                                        $coverage = (float) $trend['paid_coverage_percentage'];
                                        $underpaid = (float) $trend['underpaid_percentage'];
                                        $coverageBar = max(0, min(100, $coverage));
                                        $underpaidBar = max(0, min(100, $underpaid));
                                        $statusLabel = 'Aman';
                                        $statusClass = 'bg-emerald-100 text-emerald-700';
                                        $statusCode = 'OK';
                                        $statusIconClass = 'bg-emerald-600';
                                        $rowClass = 'border-b border-slate-100 text-slate-700';

                                        if ($underpaid > ($threshold * 1.5)) {
                                            $statusLabel = 'Kritis';
                                            $statusClass = 'bg-red-100 text-red-700';
                                            $statusCode = 'KRT';
                                            $statusIconClass = 'bg-red-600';
                                            $rowClass = 'border-b border-red-100 bg-red-50/40 text-slate-700';
                                        } elseif ($underpaid > $threshold) {
                                            $statusLabel = 'Peringatan';
                                            $statusClass = 'bg-amber-100 text-amber-700';
                                            $statusCode = 'WRN';
                                            $statusIconClass = 'bg-amber-500';
                                            $rowClass = 'border-b border-amber-100 bg-amber-50/30 text-slate-700';
                                        }
                                    @endphp
                                    <tr class="{{ $rowClass }}" data-trend-row data-trend-status="{{ strtolower($statusLabel) }}">
                                        <td class="py-2 pr-4 font-medium">{{ $trend['date_label'] }}</td>
                                        <td class="py-2 pr-4">{{ number_format((int) $trend['invoices'], 0, ',', '.') }}</td>
                                        <td class="py-2 pr-4">
                                            <div class="w-36 h-2 bg-slate-100 rounded-full overflow-hidden mb-1">
                                                <div class="h-2 bg-emerald-500" style="width: {{ $coverageBar }}%"></div>
                                            </div>
                                            <span class="text-emerald-700 font-semibold">{{ number_format($coverage, 2, ',', '.') }}%</span>
                                        </td>
                                        <td class="py-2 pr-4">
                                            <div class="w-36 h-2 bg-slate-100 rounded-full overflow-hidden mb-1">
                                                <div class="h-2 bg-rose-500" style="width: {{ $underpaidBar }}%"></div>
                                            </div>
                                            <span class="text-rose-700 font-semibold">{{ number_format($underpaid, 2, ',', '.') }}%</span>
                                        </td>
                                        <td class="py-2 pr-4">
                                            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-semibold uppercase {{ $statusClass }}">
                                                <span class="inline-block h-2 w-2 rounded-full {{ $statusIconClass }}"></span>
                                                <span>{{ $statusCode }}</span>
                                                <span>{{ $statusLabel }}</span>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-7 gap-4">
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Invoice</p>
                        <p class="mt-2 text-2xl font-bold text-slate-800">{{ number_format((int) $summaryStats['total_invoices'], 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Net</p>
                        <p class="mt-2 text-2xl font-bold text-slate-800">Rp{{ number_format((int) $summaryStats['total_net_amount'], 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Paid</p>
                        <p class="mt-2 text-2xl font-bold text-emerald-700">Rp{{ number_format((int) $summaryStats['total_paid_amount'], 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Selisih</p>
                        <p class="mt-2 text-2xl font-bold {{ (int) $summaryStats['total_variance_amount'] < 0 ? 'text-rose-700' : ((int) $summaryStats['total_variance_amount'] > 0 ? 'text-sky-700' : 'text-slate-700') }}">
                            {{ (int) $summaryStats['total_variance_amount'] > 0 ? '+' : '' }}Rp{{ number_format((int) $summaryStats['total_variance_amount'], 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Underpaid</p>
                        <p class="mt-2 text-2xl font-bold text-rose-700">{{ number_format((int) $summaryStats['underpaid_count'], 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Underpaid %</p>
                        <p class="mt-2 text-2xl font-bold text-rose-700">{{ number_format((float) $summaryStats['underpaid_percentage'], 2, ',', '.') }}%</p>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-4">
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Paid Coverage %</p>
                        <p class="mt-2 text-2xl font-bold text-emerald-700">{{ number_format((float) $summaryStats['paid_coverage_percentage'], 2, ',', '.') }}%</p>
                    </div>
                </section>

                <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
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
                                                    <option value="{{ $period->id }}">{{ $period->name }} ({{ ucfirst($period->status) }})</option>
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

                <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Recent Paid</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-slate-500 border-b border-slate-200">
                                    <th class="py-2 pr-4">Invoice</th>
                                    <th class="py-2 pr-4">Student</th>
                                    <th class="py-2 pr-4">Program</th>
                                    <th class="py-2 pr-4">Paid Amount</th>
                                    <th class="py-2 pr-4">Selisih</th>
                                    <th class="py-2 pr-4">Settlement</th>
                                    <th class="py-2 pr-4">Paid At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPaidPayments as $payment)
                                    @php
                                        $netAmount = max(0, (int) $payment->amount - (int) $payment->discount_amount);
                                        $paidAmount = (int) ($payment->paid_amount ?? $netAmount);
                                        $varianceAmount = $paidAmount - $netAmount;
                                        $overrideUsed = (bool) ($payment->meta['override_underpayment'] ?? false);
                                        $leadMapKey = $payment->user_id . '_' . $payment->program_id;
                                        $paymentLead = $leadMap[$leadMapKey] ?? null;
                                    @endphp
                                    <tr class="border-b border-slate-100 text-slate-700">
                                        <td class="py-2 pr-4">{{ $payment->invoice_number }}</td>
                                        <td class="py-2 pr-4">
                                            {{ $payment->user->name ?? '-' }}<br>
                                            <span class="text-xs text-slate-500">{{ $payment->user->email ?? '-' }}</span>
                                            @if($paymentLead)
                                                <br>
                                                <a href="{{ route('admin.registration-leads.show', $paymentLead) }}"
                                                   class="mt-1 inline-flex items-center gap-1 text-xs text-indigo-600 hover:underline">
                                                    📋 Lihat Registration Lead →
                                                </a>
                                            @endif
                                        </td>
                                        <td class="py-2 pr-4">{{ $payment->program->name ?? '-' }}</td>
                                        <td class="py-2 pr-4">Rp{{ number_format($paidAmount, 0, ',', '.') }}</td>
                                        <td class="py-2 pr-4 {{ $varianceAmount < 0 ? 'text-rose-700' : ($varianceAmount > 0 ? 'text-sky-700' : 'text-slate-600') }}">
                                            {{ $varianceAmount > 0 ? '+' : '' }}Rp{{ number_format($varianceAmount, 0, ',', '.') }}
                                        </td>
                                        <td class="py-2 pr-4">
                                            @if($paidAmount < $netAmount)
                                                <span class="inline-flex items-center rounded-full bg-rose-100 text-rose-700 px-2.5 py-1 text-xs font-semibold uppercase">Underpaid</span>
                                            @elseif($paidAmount > $netAmount)
                                                <span class="inline-flex items-center rounded-full bg-sky-100 text-sky-700 px-2.5 py-1 text-xs font-semibold uppercase">Overpaid</span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-emerald-100 text-emerald-700 px-2.5 py-1 text-xs font-semibold uppercase">Exact</span>
                                            @endif
                                            @if($overrideUsed)
                                                <span class="inline-flex items-center rounded-full bg-fuchsia-100 text-fuchsia-700 px-2.5 py-1 text-xs font-semibold uppercase ml-1">Override Used</span>
                                            @endif
                                        </td>
                                        <td class="py-2 pr-4">{{ optional($payment->paid_at)->format('d M Y H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-6 text-center text-slate-500">Belum ada pembayaran paid.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $recentPaidPayments->links() }}
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('trend-autofocus-toggle');
            const storageKey = 'adminPaymentsTrendAutoFocus';
            const toastId = 'trend-autofocus-toast';
            let shouldRunAutoFocus = @json($trendAlert['is_triggered']);
            const saved = localStorage.getItem(storageKey);
            const autoFocusEnabled = saved !== 'off';
            const alertBanner = document.getElementById('trend-alert-banner');
            const dismissButton = document.getElementById('trend-alert-dismiss');
            const restoreButton = document.getElementById('trend-alert-restore');

            function showToast(message) {
                const existing = document.getElementById(toastId);
                if (existing) {
                    existing.remove();
                }

                const toast = document.createElement('div');
                toast.id = toastId;
                toast.className = 'fixed bottom-4 right-4 z-50 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-lg';
                toast.textContent = message;
                document.body.appendChild(toast);

                window.setTimeout(function () {
                    toast.remove();
                }, 1800);
            }

            if (toggle) {
                toggle.checked = autoFocusEnabled;
                toggle.addEventListener('change', function () {
                    localStorage.setItem(storageKey, toggle.checked ? 'on' : 'off');
                    showToast(toggle.checked ? 'Auto-focus diaktifkan' : 'Auto-focus dimatikan');
                });
            }

            if (alertBanner && dismissButton) {
                const signature = alertBanner.dataset.alertSignature || 'default';
                const dismissKey = 'adminPaymentsTrendAlertDismissed:' + signature;

                if (sessionStorage.getItem(dismissKey) === '1') {
                    alertBanner.classList.add('hidden');
                    shouldRunAutoFocus = false;
                    if (restoreButton) {
                        restoreButton.classList.remove('hidden');
                        restoreButton.classList.add('inline-flex');
                    }
                }

                dismissButton.addEventListener('click', function () {
                    sessionStorage.setItem(dismissKey, '1');
                    alertBanner.classList.add('hidden');
                    if (restoreButton) {
                        restoreButton.classList.remove('hidden');
                        restoreButton.classList.add('inline-flex');
                    }
                    showToast('Alert trend disembunyikan untuk sesi ini');
                });

                if (restoreButton) {
                    restoreButton.addEventListener('click', function () {
                        sessionStorage.removeItem(dismissKey);
                        alertBanner.classList.remove('hidden');
                        restoreButton.classList.add('hidden');
                        restoreButton.classList.remove('inline-flex');
                        showToast('Alert trend ditampilkan kembali');
                    });
                }
            }

            if (!shouldRunAutoFocus || !autoFocusEnabled) {
                return;
            }

            const criticalRows = document.querySelectorAll('[data-trend-row][data-trend-status="kritis"]');
            const latestCritical = criticalRows.length ? criticalRows[criticalRows.length - 1] : null;

            if (!latestCritical) {
                return;
            }

            latestCritical.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            latestCritical.classList.add('ring-2', 'ring-red-300');
        });
    </script>
</body>

</html>

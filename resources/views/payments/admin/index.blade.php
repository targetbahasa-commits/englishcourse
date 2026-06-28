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
                    <h1 class="text-2xl font-bold text-slate-800">Dashboard Pembayaran</h1>
                    <p class="text-sm text-slate-500 mt-1">Lihat statistik, tren, dan histori pembayaran terbaru.</p>
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

</html>

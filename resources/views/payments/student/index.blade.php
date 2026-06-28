<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - My Payments</title>
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
            <div class="max-w-6xl mx-auto space-y-6">
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
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
                        <div>
                            <h1 class="text-2xl font-bold text-slate-800">Pembayaran Kelas</h1>
                            <p class="text-sm text-slate-500 mt-1">Buat invoice baru dan upload bukti transfer untuk verifikasi admin.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('student.payments.initiate') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4" id="payment-initiate-form">
                        @csrf
                        <div>
                            <label for="program_id" class="block text-sm font-medium text-slate-700 mb-1">Program</label>
                            <select id="program_id" name="program_id" class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="">Pilih program</option>
                                @foreach($programs as $program)
                                    @php
                                        $alreadyActive = in_array($program->id, $activeEnrollmentProgramIds, true);
                                    @endphp
                                    <option value="{{ $program->id }}" @selected((int) ($prefillProgramId ?? 0) === (int) $program->id) @disabled($alreadyActive)>
                                        {{ $program->name }} - Rp{{ number_format((int) $program->price, 0, ',', '.') }}
                                        {{ $alreadyActive ? '(Sudah aktif)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="class_type" class="block text-sm font-medium text-slate-700 mb-1">Jenis Kelas</label>
                            <select id="class_type" name="class_type" class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="regular" @selected(($prefillClassType ?? 'regular') === 'regular')>Regular</option>
                                <option value="semi_private" @selected(($prefillClassType ?? 'regular') === 'semi_private')>Semi Private</option>
                                <option value="private" @selected(($prefillClassType ?? 'regular') === 'private')>Private</option>
                            </select>
                        </div>

                        <div>
                            <label for="payment_channel" class="block text-sm font-medium text-slate-700 mb-1">Metode Pembayaran</label>
                            <select id="payment_channel" name="payment_channel" class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="bank_transfer" @selected(($prefillPaymentChannel ?? 'bank_transfer') === 'bank_transfer')>Transfer Bank</option>
                                <option value="cash" @selected(($prefillPaymentChannel ?? '') === 'cash')>Cash (Bayar di kantor)</option>
                            </select>
                        </div>

                        <div class="flex items-end">
                            <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 transition">
                                Buat Invoice
                            </button>
                        </div>

                        <div class="md:col-span-3">
                            <div id="price-preview-box" class="hidden rounded-xl border border-blue-100 bg-blue-50 p-4">
                                <p class="text-sm font-semibold text-slate-800">Ringkasan Tagihan</p>
                                <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-3 text-sm text-slate-700">
                                    <div>
                                        <p class="text-slate-500">Harga Dasar</p>
                                        <p id="preview-base" class="font-semibold">Rp0</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-500">Diskon</p>
                                        <p id="preview-discount" class="font-semibold text-emerald-600">Rp0</p>
                                        <p id="preview-discount-label" class="text-xs text-emerald-700 mt-1"></p>
                                    </div>
                                    <div>
                                        <p class="text-slate-500">Total Bayar</p>
                                        <p id="preview-net" class="font-semibold text-blue-700">Rp0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </section>

                <section class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Riwayat Pembayaran</h2>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-slate-500 border-b border-slate-200">
                                    <th class="py-3 pr-4">Invoice</th>
                                    <th class="py-3 pr-4">Program</th>
                                    <th class="py-3 pr-4">Total</th>
                                    <th class="py-3 pr-4">Metode</th>
                                    <th class="py-3 pr-4">Status</th>
                                    <th class="py-3 pr-4">Tanggal</th>
                                    <th class="py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    @php
                                        $netAmount = max(0, (int) $payment->amount - (int) $payment->discount_amount);
                                    @endphp
                                    <tr class="border-b border-slate-100 text-slate-700">
                                        <td class="py-3 pr-4 font-medium">{{ $payment->invoice_number }}</td>
                                        <td class="py-3 pr-4">
                                            <div class="font-medium text-slate-800">{{ $payment->program->name ?? '-' }}</div>
                                            <div class="text-xs text-slate-500 mt-0.5 capitalize">{{ str_replace('_', ' ', $payment->meta['class_type'] ?? 'regular') }}</div>
                                        </td>
                                        <td class="py-3 pr-4">
                                            <div class="font-semibold">Rp{{ number_format($netAmount, 0, ',', '.') }}</div>
                                            @if((int) $payment->discount_amount > 0)
                                                <div class="text-xs text-emerald-600">Diskon Rp{{ number_format((int) $payment->discount_amount, 0, ',', '.') }}</div>
                                            @endif
                                        </td>
                                        <td class="py-3 pr-4">{{ $payment->payment_channel === 'bank_transfer' ? 'Transfer Bank' : 'Cash' }}</td>
                                        <td class="py-3 pr-4">
                                            @if($payment->status === 'paid')
                                                <span class="inline-flex items-center rounded-full bg-emerald-100 text-emerald-700 px-2.5 py-1 text-xs font-semibold">Paid</span>
                                            @elseif($payment->status === 'failed')
                                                <span class="inline-flex items-center rounded-full bg-red-100 text-red-700 px-2.5 py-1 text-xs font-semibold">Failed</span>
                                            @else
                                                <span class="inline-flex items-center rounded-full bg-amber-100 text-amber-700 px-2.5 py-1 text-xs font-semibold">Pending</span>
                                            @endif
                                        </td>
                                        <td class="py-3 pr-4">{{ optional($payment->created_at)->format('d M Y H:i') }}</td>
                                        <td class="py-3">
                                            <a href="{{ route('student.payments.show', $payment) }}" class="inline-flex items-center rounded-lg bg-slate-900 hover:bg-slate-800 text-white px-3 py-1.5 text-xs font-semibold transition">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-6 text-center text-slate-500">Belum ada transaksi pembayaran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $payments->links() }}
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script>
        (function () {
            const priceMap = @json($programPricingPreview ?? []);
            const programSelect = document.getElementById('program_id');
            const previewBox = document.getElementById('price-preview-box');
            const previewBase = document.getElementById('preview-base');
            const previewDiscount = document.getElementById('preview-discount');
            const previewDiscountLabel = document.getElementById('preview-discount-label');
            const previewNet = document.getElementById('preview-net');

            const classTypeSelect = document.getElementById('class_type');

            if (!programSelect || !classTypeSelect || !previewBox || !previewBase || !previewDiscount || !previewDiscountLabel || !previewNet) {
                return;
            }

            const formatIdr = (amount) => {
                const parsed = Number.isFinite(Number(amount)) ? Number(amount) : 0;
                return 'Rp' + parsed.toLocaleString('id-ID');
            };

            const renderPreview = () => {
                const selectedId = String(programSelect.value || '');
                const selectedClassType = classTypeSelect.value || 'regular';
                const programInfo = priceMap[selectedId];

                if (!selectedId || !programInfo || !programInfo[selectedClassType]) {
                    previewBox.classList.add('hidden');
                    return;
                }
                
                const info = programInfo[selectedClassType];

                previewBox.classList.remove('hidden');
                previewBase.textContent = formatIdr(info.base_amount || 0);
                previewDiscount.textContent = '- ' + formatIdr(info.discount_amount || 0);
                previewNet.textContent = formatIdr(info.net_amount || 0);
                previewDiscountLabel.textContent = info.discount_label
                    ? 'Promo: ' + info.discount_label
                    : '';
            };

            programSelect.addEventListener('change', renderPreview);
            classTypeSelect.addEventListener('change', renderPreview);
            renderPreview();
        })();
    </script>
</body>

</html>

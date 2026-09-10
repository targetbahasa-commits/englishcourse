@extends('layouts.admin')
@section('title', 'Bukti Transfer')

@section('content')
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-bold text-2xl text-gray-800 mb-6">Bukti Transfer</h2>

            <div class="mb-6 flex items-center justify-between">
                <p class="text-sm text-gray-600">Daftar semua bukti transfer yang telah diunggah oleh student.</p>
                <a href="{{ route('admin.payments.index') }}" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                    &larr; Kembali ke Verifikasi Pembayaran
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('admin.payments.proofs') }}" class="mb-6 flex items-center gap-4">
                        <div>
                            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="waiting_verification" {{ request('status', 'waiting_verification') === 'waiting_verification' ? 'selected' : '' }}>Waiting Verification</option>
                                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                    </form>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @forelse($payments as $payment)
                            <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition bg-white flex flex-col">
                                <div class="h-48 bg-gray-100 relative group">
                                    @php
                                        $extension = strtolower(pathinfo($payment->proof_file, PATHINFO_EXTENSION));
                                    @endphp
                                    @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                                        <a href="{{ asset('storage/' . $payment->proof_file) }}" target="_blank" class="block h-full w-full">
                                            <img src="{{ asset('storage/' . $payment->proof_file) }}" alt="Bukti Transfer" class="w-full h-full object-cover">
                                        </a>
                                    @elseif($extension === 'pdf')
                                        <a href="{{ asset('storage/' . $payment->proof_file) }}" target="_blank" class="flex items-center justify-center h-full w-full bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                                            <div class="text-center">
                                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                <span class="font-semibold text-sm">Lihat PDF</span>
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $payment->proof_file) }}" target="_blank" class="flex items-center justify-center h-full w-full bg-gray-50 text-gray-600 hover:bg-gray-100 transition">
                                            <span class="font-semibold text-sm">Download File</span>
                                        </a>
                                    @endif

                                    <div class="absolute top-2 right-2 flex flex-col gap-1">
                                        @if($payment->status === 'paid')
                                            <span class="bg-green-100 text-green-800 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase">PAID</span>
                                        @elseif($payment->status === 'failed')
                                            <span class="bg-red-100 text-red-800 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase">REJECTED</span>
                                        @elseif(in_array($payment->status, ['pending', 'waiting_verification']))
                                            <span class="bg-yellow-100 text-yellow-800 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase">WAITING</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="p-4 flex-1 flex flex-col">
                                    <div class="flex justify-between items-start mb-2">
                                        <p class="text-xs font-mono text-gray-500">{{ $payment->invoice_number }}</p>
                                        <p class="text-xs text-gray-400">{{ $payment->created_at->format('d M Y') }}</p>
                                    </div>
                                    <p class="font-semibold text-sm text-gray-900 truncate" title="{{ optional($payment->user)->name }}">{{ optional($payment->user)->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-500 truncate mt-0.5" title="{{ optional($payment->program)->name }}">{{ optional($payment->program)->name ?? '-' }}</p>
                                    <p class="text-sm font-bold text-gray-900 mt-2">Rp{{ number_format($payment->amount, 0, ',', '.') }}</p>

                                    <div class="mt-auto pt-4 flex gap-2">
                                        <a href="{{ asset('storage/' . $payment->proof_file) }}" download class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold py-1.5 rounded transition">
                                            Download
                                        </a>
                                        @if(in_array($payment->status, ['pending', 'waiting_verification']))
                                            <a href="{{ route('admin.payments.index', ['search' => $payment->invoice_number]) }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold py-1.5 rounded transition">
                                                Review
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center text-gray-500">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p>Tidak ada bukti transfer yang ditemukan.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

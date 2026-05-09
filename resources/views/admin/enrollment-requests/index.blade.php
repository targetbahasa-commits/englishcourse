@extends('layouts.admin')

@section('title', 'Enrollment Requests')

@section('content')
<div class="p-8 pb-24 max-w-7xl mx-auto">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-3">
                <span class="p-2 bg-blue-100 text-blue-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </span>
                Enrollment Requests
            </h2>
            <p class="text-sm text-gray-500 mt-1">Daftar student yang mendaftar dan menunggu konfirmasi kelas.</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
        <form method="GET" action="{{ route('admin.enrollment-requests.index') }}" class="flex gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" onchange="this.form.submit()">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $status === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-semibold text-gray-600">Student</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Program Terpilih</th>
                    <th class="px-6 py-4 font-semibold text-gray-600">Status & Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($requests as $req)
                    @php
                        $mapKey = $req->user_id . '_' . $req->program_id;
                        $reqPayment = $paymentMap[$mapKey] ?? null;
                        $reqLead = $leadMap[$mapKey] ?? null;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $req->user->name }}</div>
                            <div class="text-gray-500 text-xs">{{ $req->user->email }}</div>
                            <div class="text-gray-500 text-xs mt-1">Daftar pada: {{ $req->created_at->format('d M Y H:i') }}</div>
                            <div class="mt-2 flex flex-wrap gap-2">
                                <a href="{{ route('students.show', $req->user) }}" target="_blank" class="text-xs text-blue-600 hover:underline">Lihat Detail Student →</a>
                                @if($reqLead)
                                    <a href="{{ route('admin.registration-leads.show', $reqLead) }}" class="text-xs text-indigo-600 hover:underline">📋 Lihat Registration Lead →</a>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-medium border border-blue-100">
                                {{ $req->program->name }}
                            </span>
                            {{-- Payment Status Badge --}}
                            <div class="mt-2">
                                @if($reqPayment)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $reqPayment->status === 'paid' ? 'bg-green-100 text-green-700' :
                                           ($reqPayment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' :
                                           'bg-red-100 text-red-700') }}">
                                        💳 {{ strtoupper($reqPayment->status) }}
                                        @if($reqPayment->invoice_number)
                                            · {{ $reqPayment->invoice_number }}
                                        @endif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">
                                        💳 Belum Ada Invoice
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($req->status === 'pending')
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">Pending</span>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" onclick="openApproveModal({{ $req->id }}, {{ $req->program_id }})" class="px-3 py-1.5 bg-green-600 text-white text-xs font-semibold rounded hover:bg-green-700">Approve &amp; Assign Class</button>
                                    <button type="button" onclick="openRejectModal({{ $req->id }})" class="px-3 py-1.5 bg-red-100 text-red-700 text-xs font-semibold rounded hover:bg-red-200">Reject</button>
                                </div>
                            @elseif($req->status === 'approved')
                                <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">Approved</span>
                                <div class="text-xs text-gray-500 mt-1">oleh {{ $req->approver?->name ?? 'Admin' }}</div>
                                <div class="text-xs text-gray-500 mt-1">Class: {{ $req->classPeriod?->name ?? 'N/A' }}</div>
                            @else
                                <span class="inline-block bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">Rejected</span>
                                <div class="text-xs text-gray-500 mt-1">oleh {{ $req->approver?->name ?? 'Admin' }}</div>
                                @if($req->notes)
                                    <div class="text-xs text-gray-500 mt-1 italic">Catatan: {{ $req->notes }}</div>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-500">Belum ada request pendaftaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $requests->links() }}
        </div>
    </div>

</div>

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 z-50 hidden bg-gray-900/50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Konfirmasi Pendaftaran</h3>
        <p class="text-sm text-gray-600 mb-4">Pilih kelas yang akan diberikan untuk student ini.</p>
        
        <form id="approveForm" method="POST" action="">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Batch Kelas</label>
                <select name="class_period_id" id="class_period_select" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach(\App\Models\ClassPeriod::whereIn('status', ['active', 'upcoming'])->get() as $period)
                        <option value="{{ $period->id }}" data-program="{{ $period->program_id }}">{{ $period->name }} ({{ $period->program?->name }})</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Hanya menampilkan batch yang aktif/upcoming sesuai program.</p>
            </div>
            
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Admin (Opsional)</label>
                <textarea name="notes" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeApproveModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">Konfirmasi</button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 z-50 hidden bg-gray-900/50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Tolak Pendaftaran</h3>
        <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menolak pendaftaran ini?</p>
        
        <form id="rejectForm" method="POST" action="">
            @csrf
            
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan (Opsional)</label>
                <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-red-500 focus:border-red-500" placeholder="Misal: Bukti pembayaran tidak valid"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeRejectModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">Tolak Pendaftaran</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openApproveModal(id, programId) {
        document.getElementById('approveForm').action = `/admin/enrollment-requests/${id}/approve`;
        
        // Filter classes by program
        const select = document.getElementById('class_period_select');
        const options = select.querySelectorAll('option[data-program]');
        
        options.forEach(opt => {
            if (opt.getAttribute('data-program') == programId) {
                opt.style.display = '';
            } else {
                opt.style.display = 'none';
            }
        });
        select.value = ''; // Reset selection
        
        document.getElementById('approveModal').classList.remove('hidden');
    }
    
    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
    }
    
    function openRejectModal(id) {
        document.getElementById('rejectForm').action = `/admin/enrollment-requests/${id}/reject`;
        document.getElementById('rejectModal').classList.remove('hidden');
    }
    
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>

@endsection

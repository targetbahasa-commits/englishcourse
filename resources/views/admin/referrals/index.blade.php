@extends('layouts.admin')

@section('title', 'Referral Management')

@section('content')
<div class="p-8">
<div class="space-y-6">

    <!-- Title & Actions -->
    <div class="flex justify-between items-center mb-6">
         <div>
            <h3 class="text-2xl font-bold text-gray-900">Reward Claims</h3>
            <p class="text-gray-500 text-sm mt-1">Manage student requests to redeem referral points.</p>
         </div>
         <div class="flex gap-2">
            <button onclick="document.getElementById('addRewardModal').classList.remove('hidden')" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition-colors text-sm shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Reward
            </button>
         </div>
    </div>
    
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-800 border-l-4 border-green-500 rounded-r-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 text-red-800 border-l-4 border-red-500 rounded-r-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Claims Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($claims->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reward</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat Pengiriman</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($claims as $claim)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $claim->created_at->format('d M Y') }}
                                <div class="text-xs text-gray-400">{{ $claim->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $claim->user->name ?? 'Unknown' }}</div>
                                <div class="text-xs text-gray-500">{{ $claim->user->email ?? '' }}</div>
                                <div class="mt-1 flex flex-wrap gap-1">
                                    @php
                                        $claimLead = $leadMap[$claim->user_id] ?? null;
                                        $claimPayment = $paymentMap[$claim->user_id] ?? null;
                                    @endphp
                                    @if($claimLead)
                                        <a href="{{ route('admin.registration-leads.show', $claimLead) }}" class="text-[10px] text-indigo-600 hover:underline">📋 Lead</a>
                                    @endif
                                    @if($claimPayment)
                                        <a href="{{ route('admin.payments.index', ['q' => $claimPayment->invoice_number]) }}" class="text-[10px] text-blue-600 hover:underline">💳 Payment</a>
                                    @endif
                                    @if($claim->user?->email)
                                        <a href="{{ route('admin.email-logs.index', ['search' => $claim->user->email]) }}" class="text-[10px] text-purple-600 hover:underline">✉️ Email</a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                {{ $claim->reward->name ?? 'Reward Dihapus' }}
                                <div class="text-xs text-yellow-600">{{ $claim->reward->points_required ?? 0 }} Pts</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $claim->shipping_address }}">
                                {{ $claim->shipping_address ?: '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($claim->status === 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($claim->status === 'processed')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Diproses</span>
                                @elseif($claim->status === 'shipped')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai/Dikirim</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ ucfirst($claim->status) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button onclick="openProcessModal({{ $claim->id }}, '{{ $claim->status }}', '{{ addslashes($claim->admin_notes) }}')" class="text-indigo-600 hover:text-indigo-900 font-medium">Update Status</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $claims->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <p class="text-gray-500 text-sm">Belum ada klaim reward dari student.</p>
            </div>
        @endif
    </div>

    <!-- Social Media Validation Section -->
    <div class="mt-8 mb-4">
        <h3 class="text-xl font-bold text-gray-900">Validasi Misi Sosial Media</h3>
        <p class="text-sm text-gray-500 mt-1">Review dan berikan poin ekstra untuk student yang men-share link mereka.</p>
    </div>
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        @if($socialSubmissions->count() > 0)
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Platform & Link</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($socialSubmissions as $submission)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $submission->created_at->format('d M Y') }}
                                <div class="text-xs text-gray-400">{{ $submission->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $submission->user->name ?? 'Unknown' }}</div>
                                <div class="text-xs text-gray-500">{{ $submission->user->email ?? '' }}</div>
                                @php
                                    $subEnrollment = $enrollmentMap[$submission->user_id] ?? null;
                                @endphp
                                @if($subEnrollment)
                                    <div class="mt-1 text-[10px] text-emerald-700 bg-emerald-50 px-1 py-0.5 rounded inline-block">
                                        🎓 {{ $subEnrollment->program->name ?? 'Enrolled' }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize bg-purple-100 text-purple-800 mb-1">
                                    {{ $submission->platform }}
                                </span>
                                <div class="truncate max-w-[200px] sm:max-w-xs">
                                    <a href="{{ $submission->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline">{{ $submission->url }}</a>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($submission->status === 'pending')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                @elseif($submission->status === 'approved')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Disetujui (+{{ $submission->points_awarded }})</span>
                                @elseif($submission->status === 'rejected')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 tooltip-trigger" title="{{ $submission->admin_note }}">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button onclick="openSocialModal({{ $submission->id }}, '{{ $submission->status }}', '{{ $submission->points_awarded }}', '{{ addslashes($submission->admin_note) }}')" class="text-indigo-600 hover:text-indigo-900 font-medium">Review</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $socialSubmissions->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <p class="text-gray-500 text-sm">Belum ada kiriman misi social media.</p>
            </div>
        @endif
    </div>

    <!-- Rewards Catalog Section -->
    <div class="mt-8 mb-4">
        <h3 class="text-xl font-bold text-gray-900">Katalog Reward Aktif</h3>
        <p class="text-sm text-gray-500 mt-1">Reward yang tersedia untuk ditukar student dengan poin referral mereka.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @foreach($rewards as $reward)
            <div class="bg-white rounded-2xl shadow border border-gray-100/50 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full group">
                <!-- Reward Image -->
                <div class="h-40 w-full bg-gradient-to-br from-indigo-50 to-blue-50 flex-shrink-0 relative overflow-hidden">
                    @if($reward->image)
                        <img src="{{ asset('storage/' . $reward->image) }}" alt="{{ $reward->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="w-12 h-12 text-indigo-300/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    
                    <!-- Points Badge (Overlay) -->
                    <div class="absolute top-3 right-3">
                        <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-indigo-700 text-sm font-black rounded-full shadow-sm">
                            {{ $reward->points_required }} Pts
                        </span>
                    </div>
                </div>

                <!-- Reward Info -->
                <div class="p-5 flex-1 flex flex-col">
                    <h4 class="font-bold text-gray-900 text-lg mb-2 leading-tight">{{ $reward->name }}</h4>
                    <p class="text-sm text-gray-500 mb-5 leading-relaxed flex-1">{{ $reward->description }}</p>
                    
                    <div class="flex items-center justify-between pt-4 mt-auto border-t border-gray-50">
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-md {{ $reward->is_active ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $reward->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            {{ $reward->is_active ? 'Status: Aktif' : 'Status: Nonaktif' }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
</div>
@endsection

@yield('modals')

@section('modals')
<!-- Process Modal -->
<div id="processModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeProcessModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="processForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-6 pt-5 pb-4">
                    <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4">Update Status Klaim</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" name="status" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg">
                                <option value="pending">Pending</option>
                                <option value="processed">Diproses (Sedang disiapkan)</option>
                                <option value="shipped">Selesai / Dikirim</option>
                                <option value="rejected">Ditolak (Poin dikembalikan)</option>
                            </select>
                        </div>

                        <div>
                            <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-1">Catatan Admin (Tidak terlihat student)</label>
                            <textarea id="admin_notes" name="admin_notes" rows="3" class="block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Nomor resi, catatan internal, dll..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 flex flex-row-reverse gap-2 border-t border-gray-100">
                    <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none">
                        Simpan
                    </button>
                    <button type="button" onclick="closeProcessModal()" class="inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Reward Modal -->
<div id="addRewardModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('addRewardModal').classList.add('hidden')"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('admin.referrals.rewards.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white px-6 pt-5 pb-4">
                    <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4">Tambah Reward Baru</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="reward_image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Reward (Opsional)</label>
                            <input type="file" name="image" id="reward_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                        
                        <div>
                            <label for="reward_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Reward</label>
                            <input type="text" name="name" id="reward_name" required class="block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="e.g. Kaos Target Bahasa">
                        </div>
                        
                        <div>
                            <label for="reward_points" class="block text-sm font-medium text-gray-700 mb-1">Poin yang Dibutuhkan</label>
                            <input type="number" name="points_required" id="reward_points" required min="10" class="block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="e.g. 100">
                        </div>

                        <div>
                            <label for="reward_description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea id="reward_description" name="description" rows="3" class="block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Jelaskan reward ini..."></textarea>
                        </div>
                        
                        <div class="flex items-center">
                            <input id="is_active" name="is_active" type="checkbox" checked value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 block text-sm text-gray-900">
                              Aktifkan (Tampilkan ke student)
                            </label>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 flex flex-row-reverse gap-2 border-t border-gray-100">
                    <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none">
                        Tambah Reward
                    </button>
                    <button type="button" onclick="document.getElementById('addRewardModal').classList.add('hidden')" class="inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Social Modal -->
<div id="socialModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeSocialModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="socialForm" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white px-6 pt-5 pb-4">
                    <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4">Review Misi Sosmed</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="social_status" class="block text-sm font-medium text-gray-700 mb-1">Status Validasi</label>
                            <select id="social_status" name="status" class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg" onchange="togglePointsInput()">
                                <option value="pending">Pending</option>
                                <option value="approved">Disetujui (Beri Poin Ekstra)</option>
                                <option value="rejected">Ditolak</option>
                            </select>
                        </div>

                        <div id="pointsContainer" class="hidden">
                            <label for="points_awarded" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Poin yang Diberikan</label>
                            <input type="number" id="points_awarded" name="points_awarded" min="0" value="100" class="block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="e.g. 100">
                            <p class="text-xs text-gray-500 mt-1">Standar bonus poin adalah 100 pts.</p>
                        </div>

                        <div>
                            <label for="social_admin_notes" class="block text-sm font-medium text-gray-700 mb-1">Pesan untuk Student / Alasan (Opsional)</label>
                            <textarea id="social_admin_notes" name="admin_note" rows="3" class="block w-full border border-gray-300 rounded-lg shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Contoh: Link tidak bisa dibuka, tolong kirim ulang URL yang benar."></textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-3 flex flex-row-reverse gap-2 border-t border-gray-100">
                    <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none">
                        Simpan Keputusan
                    </button>
                    <button type="button" onclick="closeSocialModal()" class="inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openProcessModal(id, status, notes) {
        document.getElementById('status').value = status;
        document.getElementById('admin_notes').value = notes || '';
        document.getElementById('processForm').action = '{{ url("/admin/referrals/claims") }}/' + id;
        document.getElementById('processModal').classList.remove('hidden');
    }

    function closeProcessModal() {
        document.getElementById('processModal').classList.add('hidden');
    }

    function openSocialModal(id, status, points, notes) {
        document.getElementById('social_status').value = status;
        document.getElementById('social_admin_notes').value = notes || '';
        document.getElementById('points_awarded').value = points || 100;
        document.getElementById('socialForm').action = '{{ url("/admin/referrals/social") }}/' + id;
        togglePointsInput();
        document.getElementById('socialModal').classList.remove('hidden');
    }

    function closeSocialModal() {
        document.getElementById('socialModal').classList.add('hidden');
    }

    function togglePointsInput() {
        const val = document.getElementById('social_status').value;
        const container = document.getElementById('pointsContainer');
        if (val === 'approved') {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }
</script>
@endpush

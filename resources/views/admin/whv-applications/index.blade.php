@extends('layouts.admin')

@section('title', 'WHV Applications Management')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">WHV Australia Desk</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola konten program Working Holiday Visa yang ditampilkan sebagai dedicated landing page di area publik.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('whv-applications.index') }}" target="_blank" class="btn bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg px-4 py-2 inline-flex items-center justify-center transition">
                <svg class="w-4 h-4 shrink-0 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 5v14h14v-5"></path></svg>
                Lihat Halaman Publik
            </a>
            <a href="{{ route('admin.whv-applications.create') }}" class="btn bg-amber-600 hover:bg-amber-700 text-white rounded-lg px-4 py-2 inline-flex items-center justify-center transition">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0 mr-2" viewBox="0 0 16 16">
                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"/>
                </svg>
                Add WHV Program
            </a>
        </div>
    </div>



            <!-- Campaign Pulse -->
            <div class="mt-8 mb-8 rounded-3xl border border-amber-100 bg-white p-6 shadow-sm">
                @include('admin.partials.campaign-pulse-header')

                <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5">
                        <div class="text-xs font-bold uppercase tracking-[0.16em] text-blue-600/70">Tracked Signups</div>
                        <div class="mt-2 text-3xl font-black text-blue-900">{{ $trackedSignupsLast30Days ?? 0 }}</div>
                        <p class="mt-2 text-sm text-blue-800/80">User guest + student dengan UTM atau source page tersimpan pada window aktif.</p>
                    </div>
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-5">
                        <div class="text-xs font-bold uppercase tracking-[0.16em] text-emerald-600/70">Tracked 7 Days</div>
                        <div class="mt-2 text-3xl font-black text-emerald-900">{{ $trackedSignupsLast7Days ?? 0 }}</div>
                        <p class="mt-2 text-sm text-emerald-800/80">Momentum recent acquisition untuk lihat campaign yang masih jalan.</p>
                    </div>
                    <div class="rounded-2xl border border-amber-100 bg-amber-50 p-5">
                        <div class="text-xs font-bold uppercase tracking-[0.16em] text-amber-700/70">WHV Attributed</div>
                        <div class="mt-2 text-3xl font-black text-amber-900">{{ $whvAttributedUsers ?? 0 }}</div>
                        <p class="mt-2 text-sm text-amber-900/75">Signup yang membawa source page `whv_applications`.</p>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="rounded-2xl border border-slate-100 bg-slate-50 p-5">
                        <div class="text-xs font-bold uppercase tracking-[0.16em] text-slate-700/70">Tracked Leads</div>
                        <div class="mt-2 text-3xl font-black text-slate-900">{{ $trackedLeadsTotal ?? 0 }}</div>
                        <p class="mt-2 text-sm text-slate-700/80">Jumlah lead attribution pada window aktif.</p>
                    </div>
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-5">
                        <div class="text-xs font-bold uppercase tracking-[0.16em] text-emerald-700/70">Converted Leads</div>
                        <div class="mt-2 text-3xl font-black text-emerald-900">{{ $trackedLeadsConverted ?? 0 }}</div>
                        <p class="mt-2 text-sm text-emerald-800/80">Lead attribution dengan status converted.</p>
                    </div>
                    <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5">
                        <div class="text-xs font-bold uppercase tracking-[0.16em] text-blue-700/70">Lead CVR</div>
                        <div class="mt-2 text-3xl font-black text-blue-900">
                            {{ ($trackedLeadsTotal ?? 0) > 0 ? number_format((($trackedLeadsConverted ?? 0) / $trackedLeadsTotal) * 100, 1) : '0.0' }}%
                        </div>
                        <p class="mt-2 text-sm text-blue-800/80">Conversion rate lead attribution ke status converted.</p>
                    </div>
                </div>



                <div class="mt-6 grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
                    <div class="overflow-hidden rounded-2xl border border-gray-100">
                        <div class="border-b border-gray-100 bg-gray-50 px-5 py-4">
                            <h3 class="text-sm font-bold text-gray-800">Top campaign sources</h3>
                        </div>
                        @if(isset($campaignSignups) && $campaignSignups->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm">
                                    <thead class="bg-white text-xs uppercase tracking-[0.12em] text-gray-400">
                                        <tr>
                                            <th class="px-5 py-3 font-semibold">Campaign</th>
                                            <th class="px-5 py-3 font-semibold">Source Page</th>
                                            <th class="px-5 py-3 font-semibold">Guest</th>
                                            <th class="px-5 py-3 font-semibold">Student</th>
                                            <th class="px-5 py-3 font-semibold">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        @foreach($campaignSignups as $campaignRow)
                                            <tr>
                                                <td class="px-5 py-4 font-semibold text-gray-800">{{ $campaignRow->campaign_label }}</td>
                                                <td class="px-5 py-4 text-gray-500">{{ $campaignRow->source_page }}</td>
                                                <td class="px-5 py-4 text-gray-600">{{ $campaignRow->guest_signups }}</td>
                                                <td class="px-5 py-4 text-gray-600">{{ $campaignRow->student_signups }}</td>
                                                <td class="px-5 py-4 font-bold text-gray-900">{{ $campaignRow->total_signups }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="px-5 py-10 text-sm text-gray-400">Belum ada signup dengan attribution campaign yang tersimpan.</div>
                        @endif
                    </div>

                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5">
                        <h3 class="text-sm font-bold text-gray-800">WHV CTA copy variants</h3>
                        <div class="mt-4 space-y-3">
                            @forelse(($whvVariantBreakdown ?? collect()) as $variantRow)
                                <div class="flex items-center justify-between rounded-xl bg-white px-4 py-3 border border-gray-100">
                                    <div>
                                        <div class="text-xs font-bold uppercase tracking-[0.12em] text-gray-400">Variant</div>
                                        <div class="mt-1 font-semibold text-gray-900">{{ $variantRow->variant_label }}</div>
                                    </div>
                                    <div class="text-2xl font-black text-gray-900">{{ $variantRow->total }}</div>
                                </div>
                            @empty
                                <div class="rounded-xl bg-white px-4 py-6 text-sm text-gray-400 border border-gray-100">Belum ada signup WHV yang membawa label variant.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                @include('admin.partials.lead-campaign-conversion-panel')

                @include('admin.partials.export-activity-panel')
            </div>

</div>
@endsection

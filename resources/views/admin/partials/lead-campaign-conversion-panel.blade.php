<div class="mt-6 overflow-hidden rounded-2xl border border-gray-100">
    <div class="border-b border-gray-100 bg-gray-50 px-5 py-4">
        <h3 class="text-sm font-bold text-gray-800">Lead conversion by campaign/source</h3>
    </div>
    @if(isset($leadCampaignPerformance) && $leadCampaignPerformance->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-white text-xs uppercase tracking-[0.12em] text-gray-400">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Campaign</th>
                        <th class="px-5 py-3 font-semibold">Source Page</th>
                        <th class="px-5 py-3 font-semibold">Leads</th>
                        <th class="px-5 py-3 font-semibold">Converted</th>
                        <th class="px-5 py-3 font-semibold">CVR</th>
                        <th class="px-5 py-3 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @foreach($leadCampaignPerformance as $leadRow)
                        @php
                            $leadFilterParams = [
                                'date_window' => $campaignWindowDays ?? 30,
                                'utm_campaign' => $leadRow->campaign_label === 'Organic / Direct' ? '' : $leadRow->campaign_label,
                                'acquisition_source_page' => $leadRow->source_page === 'general_site' ? '' : $leadRow->source_page,
                                'sort_by' => 'converted_at',
                                'sort_dir' => 'desc',
                            ];
                            $convertedOnlyLeadFilterParams = array_merge($leadFilterParams, [
                                'converted_only' => 1,
                            ]);
                        @endphp
                        <tr>
                            <td class="px-5 py-4 font-semibold text-gray-800">{{ $leadRow->campaign_label }}</td>
                            <td class="px-5 py-4 text-gray-500">{{ $leadRow->source_page }}</td>
                            <td class="px-5 py-4 text-gray-700">{{ $leadRow->total_leads }}</td>
                            <td class="px-5 py-4 text-gray-700">{{ $leadRow->converted_leads }}</td>
                            <td class="px-5 py-4 font-bold text-gray-900">
                                {{ number_format((float) ($leadRow->cvr_percent ?? 0), 1) }}%
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.registration-leads.index', $leadFilterParams) }}" class="inline-flex items-center gap-1 rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:bg-gray-50">
                                        Semua Leads
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                    @if((int) $leadRow->converted_leads > 0)
                                        <a href="{{ route('admin.registration-leads.index', $convertedOnlyLeadFilterParams) }}" class="inline-flex items-center gap-1 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-emerald-700">
                                            Converted Only ({{ $leadRow->converted_leads }})
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-lg bg-emerald-100 px-3 py-1.5 text-xs font-semibold text-emerald-500 cursor-not-allowed">
                                            Converted Only (0)
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="px-5 py-10 text-sm text-gray-400">Belum ada lead attribution pada window aktif.</div>
    @endif
</div>

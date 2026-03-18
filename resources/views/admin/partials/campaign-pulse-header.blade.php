<div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
    <div>
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-700/70">Campaign Pulse</p>
        <h2 class="mt-2 text-2xl font-bold text-gray-900">WHV / acquisition tracking snapshot</h2>
        <p class="mt-2 text-sm text-gray-500">Ringkasan ini membaca user baru yang datang dengan attribution campaign dan source page yang sudah tersimpan di backend.</p>
    </div>
    <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap items-center gap-3">
        <label for="campaign_window" class="text-xs font-semibold uppercase tracking-[0.12em] text-gray-400">Window</label>
        <select id="campaign_window" name="campaign_window" onchange="this.form.submit()" class="rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm text-gray-700">
            @foreach([7, 14, 30, 90] as $windowOption)
                <option value="{{ $windowOption }}" {{ (int) ($campaignWindowDays ?? 30) === $windowOption ? 'selected' : '' }}>Last {{ $windowOption }} days</option>
            @endforeach
        </select>
        <a href="{{ route('admin.campaign-signups.export', ['campaign_window' => $campaignWindowDays ?? 30, 'export_preset' => 'campaign_signups']) }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0 0l-3-3m3 3l3-3M5 20h14"></path></svg>
            Export CSV
        </a>
        <a href="{{ route('admin.registration-leads.export', ['date_window' => $campaignWindowDays ?? 30, 'converted_only' => 1, 'sort_by' => 'converted_at', 'sort_dir' => 'desc', 'export_preset' => 'converted_leads_window']) }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0 0l-3-3m3 3l3-3M5 20h14"></path></svg>
            Export Converted Leads
        </a>
        <a href="{{ route('admin.registration-leads.export', ['hot' => 1, 'sort_by' => 'created_at', 'sort_dir' => 'desc', 'export_preset' => 'hot_leads_24h']) }}" class="inline-flex items-center gap-2 rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-rose-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0 0l-3-3m3 3l3-3M5 20h14"></path></svg>
            Export Hot Leads 24 Jam
        </a>
        <a href="{{ route('admin.registration-leads.export', ['converted_today' => 1, 'sort_by' => 'converted_at', 'sort_dir' => 'desc', 'export_preset' => 'converted_today']) }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0 0l-3-3m3 3l3-3M5 20h14"></path></svg>
            Export Converted Today
        </a>
    </form>
</div>

@if(!empty($lastExportActivity))
    <p class="mt-3 text-xs text-gray-500">
        Last export: {{ $lastExportActivity->preset ?? $lastExportActivity->action }} by {{ $lastExportActivity->user_name ?? 'Unknown Admin' }} at {{ \Illuminate\Support\Carbon::parse($lastExportActivity->created_at)->format('d M Y H:i') }}
    </p>
@endif

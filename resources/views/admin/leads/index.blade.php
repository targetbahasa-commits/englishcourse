<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Lead Tracker - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar-admin')

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ viewRawJson: null }">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Lead Tracker</h1>
            <p class="mt-2 text-sm text-gray-500">Manage submissions from Free Promotional Tests.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-4 mb-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Leads</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalLeads }}</dd>
            </div>
        </div>
        <div class="bg-yellow-50 overflow-hidden shadow-sm rounded-lg border border-yellow-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-yellow-800 truncate">Pending Follow-up</dt>
                <dd class="mt-1 text-3xl font-semibold text-yellow-900">{{ $pendingLeads }}</dd>
            </div>
        </div>
        <div class="bg-blue-50 overflow-hidden shadow-sm rounded-lg border border-blue-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-blue-800 truncate">Contacted</dt>
                <dd class="mt-1 text-3xl font-semibold text-blue-900">{{ $contactedLeads }}</dd>
            </div>
        </div>
        <div class="bg-green-50 overflow-hidden shadow-sm rounded-lg border border-green-200">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-green-800 truncate">Enrolled</dt>
                <dd class="mt-1 text-3xl font-semibold text-green-900">{{ $enrolledLeads }}</dd>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6 flex flex-wrap gap-4 items-center justify-between">
        <form method="GET" action="{{ route('admin.leads.index') }}" class="flex gap-4 items-center w-full md:w-auto">
            <div>
                <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                    <option value="enrolled" {{ request('status') == 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                </select>
            </div>
            <div class="flex-grow">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, or WA..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
            </div>
            <div>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Filter
                </button>
            </div>
            @if(request('status') || request('search'))
                <div>
                    <a href="{{ route('admin.leads.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Clear</a>
                </div>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prospect</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Details</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Est. Band</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AI JSON</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($leads as $lead)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($lead->created_at)->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $lead->name }}</div>
                                <div class="text-sm text-gray-500">{{ $lead->email }}</div>
                                <div class="text-sm text-gray-500">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->whatsapp_number) }}" target="_blank" class="text-green-600 hover:text-green-800 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.573-.187-.981-.342-1.714-.651-2.836-2.42-2.92-2.532-.084-.112-.697-.927-.697-1.769s.434-1.261.587-1.423c.153-.162.336-.202.448-.202.112 0 .223.004.321.009.106.005.249-.041.385.285.14.337.476 1.161.518 1.246.042.085.069.184.014.296-.055.112-.084.183-.168.283l-.224.225c-.083.085-.171.178-.075.343.097.166.434.717.935 1.166.65.583 1.196.764 1.36.85.165.085.262.069.359-.041.098-.112.422-.493.535-.662.112-.17.223-.142.373-.085.15.056.949.448 1.111.528.161.08.269.121.309.189.039.068.039.395-.105.801z"/></svg>
                                        {{ $lead->whatsapp_number }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ strtoupper($lead->test_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($lead->estimated_band_score)
                                    <span class="px-2 inline-flex text-sm leading-5 font-bold rounded-full bg-blue-100 text-blue-800">
                                        {{ $lead->estimated_band_score }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button type="button" data-json="{{ json_encode($lead->ai_raw_json_feedback) }}" @click="viewRawJson = $el.dataset.json" class="text-blue-600 hover:text-blue-900 underline">View JSON</button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <form method="POST" action="{{ route('admin.leads.status.update', $lead->id) }}" class="flex items-center gap-2">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 font-medium
                                        {{ $lead->follow_up_status == 'pending' ? 'text-yellow-800 bg-yellow-50' : '' }}
                                        {{ $lead->follow_up_status == 'contacted' ? 'text-blue-800 bg-blue-50' : '' }}
                                        {{ $lead->follow_up_status == 'enrolled' ? 'text-green-800 bg-green-50' : '' }}
                                    ">
                                        <option value="pending" {{ $lead->follow_up_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="contacted" {{ $lead->follow_up_status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                        <option value="enrolled" {{ $lead->follow_up_status == 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                No leads found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($leads->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $leads->links() }}
            </div>
        @endif
    </div>

    <!-- JSON Viewer Modal -->
    <div x-show="viewRawJson" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="viewRawJson" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="viewRawJson = null"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="viewRawJson" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                AI Raw Feedback JSON
                            </h3>
                            <div class="mt-4">
                                <pre class="bg-gray-800 text-green-400 p-4 rounded-md overflow-x-auto text-xs font-mono" x-text="
                                    (() => {
                                        let obj = viewRawJson;
                                        let limit = 5;
                                        while (typeof obj === 'string' && limit > 0) {
                                            try {
                                                let parsed = JSON.parse(obj);
                                                if (obj === parsed) break;
                                                obj = parsed;
                                                limit--;
                                            } catch (e) {
                                                break;
                                            }
                                        }
                                        return JSON.stringify(obj, null, 2);
                                    })()
                                "></pre>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="viewRawJson = null" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
</main>
    </div>
</body>
</html>
